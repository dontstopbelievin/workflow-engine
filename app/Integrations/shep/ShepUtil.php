<?php

namespace App\Integrations\shep;

use Illuminate\Support\Facades\Storage;

class ShepUtil
{
    public static function arrayToXML($array) {
        $xml = new \XMLWriter();
        $xml->openMemory();
        self::write_xml($xml, $array);
        return $xml->outputMemory(true);
    }

    private static function write_xml(\XMLWriter &$xml, $data) {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if ($key === 'attachments') {
                    foreach ($value AS $fileidentifier) {
                        $xml->startElement($key);
                        $xml->writeElement(key($fileidentifier), current($fileidentifier));
                        $xml->endElement();
                    }
                    continue;
                } elseif($key === 'performers') {
                    foreach ($value AS $fileidentifier) {
                        $xml->writeElement('performers', $fileidentifier);
                    }
                    continue;
                } else {
                    if (is_integer($key)) {
                        self::write_xml($xml, $value);
                        continue;
                    }
                    $xml->startElement($key);
                    self::write_xml($xml, $value);
                    $xml->endElement();
                    continue;
                }
            }
            if (is_integer($key)) {
                $key = 'xsd:string';
            }
            $xml->writeElement($key, $value);
        }
    }

    public static function clearNulls($aFields) {
        foreach ($aFields as $sKey => $aV) {
            if(is_array($aV)) {
                $aFields[$sKey] = self::clearNulls($aV);
            } else if ($aV === null) {
                unset($aFields[$sKey]);
            }
        }
        return $aFields;
    }

    public static function isNotEmpty($aArray, $sValue){
        if(isset($aArray[$sValue]) && $aArray[$sValue] != ''){
            return true;
        }
        return false;
    }

    public static function sendShepXmlRequest($sSignedXML, $sShepUrl = null)
    {
        $sPostData = $sSignedXML;
        $sProcessId = self::randomString(6);
        $oCurl = curl_init();
        curl_setopt($oCurl, CURLOPT_URL, $sShepUrl);
        $sFolder = storage_path('app/tmp/'.date('Y/md'));
        if(!file_exists($sFolder)) {
            mkdir($sFolder, 0775, true);
        }
        curl_setopt($oCurl, CURLOPT_CONNECTTIMEOUT, 300);
        curl_setopt($oCurl, CURLOPT_TIMEOUT, 300);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($oCurl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($oCurl, CURLOPT_POST, true);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, $sPostData);
        curl_setopt($oCurl, CURLOPT_POSTREDIR, 3);
        $aHeaders = array(
            'Content-type: text/xml;charset="utf-8"',
            'Accept: text/xml',
            'Cache-Control: no-cache',
            'Pragma: no-cache',
            'SOAPAction: ""',
            'Content-length: ' . strlen($sPostData),
        );
        curl_setopt($oCurl, CURLOPT_HTTPHEADER,     $aHeaders);
        $sResult = curl_exec($oCurl);
        $iHttpCode = curl_getinfo($oCurl, CURLINFO_HTTP_CODE);
        if ($sResult === false) {
            echo json_encode(array('status' => 0, 'data' => 'shep send error: ' . curl_error($oCurl)));
        } elseif ($iHttpCode === 200) {
            file_put_contents(sprintf('%s/file_out_%s.request', $sFolder, $sProcessId), $sPostData);
            file_put_contents(sprintf('%s/file_out_%s.response', $sFolder, $sProcessId), $sResult);
            return array('status' => 1, 'data' => $sResult);
        } else {
            if(isset($aInfo)) {
                file_put_contents(sprintf('%s/%s_%s_out_%s.response', $sFolder, $aInfo['href'], $aInfo['document_type'], $sProcessId), 'shep internal error: http-' . $iHttpCode);
            } else {
                file_put_contents(sprintf('%s/file_out_%s.request', $sFolder, $sProcessId), $sPostData);
                file_put_contents(sprintf('%s/file_out_%s.response', $sFolder, $sProcessId), $sResult);
            }
            echo json_encode(array('status' => 0, 'data' => 'shep internal error: http-' . $iHttpCode,
                'response' => json_encode(curl_getinfo($oCurl), JSON_UNESCAPED_UNICODE)));
        }
        curl_close($oCurl);
    }

    public static function xmlToArray($sXml)
    {
        $sXml = preg_replace('/(<\/?)(\w+):([^>]*>)/', '$1$2-----$3', $sXml);
        return json_decode(json_encode(simplexml_load_string($sXml)),true);
    }

    public static function getSoapBody($sXml)
    {
        $a = self::xmlToArray($sXml);
        $a = self::removeNamespaces($a);
        foreach ($a AS $sKey => $aVal) {
            switch (mb_strtolower($sKey)) {
                case 'header':

                    break;
                case 'body':
                    foreach ($aVal AS $sKey2 => $aVal2) {
                        return $aVal2;
                    }
                    break;
                default:
                    break;
            }
        }
    }

    public static function removeNamespaces($a)
    {
        $aRes = array();
        foreach ($a AS $sKey => $aVal) {
            if(mb_strpos($sKey, '-----') !== false) {
                $aKeys = explode('-----', $sKey);
                $sKey = $aKeys[1];
            }
            $aRes[$sKey] = is_array($aVal) ? self::removeNamespaces($aVal) : $aVal;
        }
        return $aRes;
    }

    public static function getTimestampWithTimeZone()
    {
        return date('Y-m-d').'T'. date('H:i:sP');
    }

    public static function signXml($sXml)
    {
        $sFilePath = 'tmp/' . Uuid::generateV4();
        Storage::disk('local')->put($sFilePath, $sXml);
        exec(sprintf(
            'java -jar -Dfile.encoding=UTF-8 %s/XmlSigner.jar sign %s %s %s',
            app_path('Integrations/shep/lib/java/xml_signer2'),
            storage_path('app/' . $sFilePath),
            app_path('Integrations/shep/cert/company_key_gost.p12'),
            'Aa123456'
        ), $aOutput);
        Storage::disk('local')->delete($sFilePath);
        $aExecRes = json_decode($aOutput[0], true);
        unset($aOutput);
        if($aExecRes['status']) {
            $sXml = file_get_contents($aExecRes['data']);
            unlink($aExecRes['data']);
            return $sXml;
        } else {
            return null;
        }
    }

    public static function signXmlJar($sXml)
    {
        $sFilePath = 'tmp/' . Uuid::generateV4();
        if(trim($sXml) == ''){
            $sXml = '<request>Empty request</request>';
        }
        Storage::disk('local')->put($sFilePath, $sXml);
        exec(sprintf(
            'java -jar -Dfile.encoding=UTF-8 %s/XmlSigner.jar %s %s %s',
            app_path('Integrations/shep/lib/java/xml_signer'),
            storage_path('app/' . $sFilePath),
            app_path('Integrations/shep/cert/company_key_gost.p12'),
            'Aa123456'
        ));
        Storage::disk('local')->delete($sFilePath);
        $sXml = Storage::disk('local')->get($sFilePath . '_sign');
        Storage::disk('local')->delete($sFilePath . '_sign');
        return $sXml;
    }

    public static function randomString($iLength)
    {
        static $i = 0;
        if ($i > 9) {
            $i = 0;
        }

        $i++;

        list($t1, $t2) = explode(' ', microtime());
        $iRand = (int)((float) $t1 + ((float) $t2 * 100000));
        mt_srand($iRand);
        $sHash = md5($t1 . $t2 . mt_rand()) . md5($i . $t2);

        return substr(substr($sHash, 0, 1) . $i . substr($sHash, 2), 0, $iLength);

    }
}
