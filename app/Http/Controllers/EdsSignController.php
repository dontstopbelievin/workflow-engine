<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\File;
use App\FileCategory;
use App\Libs\PhpNCANode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class EdsSignController extends Controller
{
    public function loginByCert(Request $request)
    {
//        dd($request->all());
        $data = $request->data;
        $oDate = new \DateTime('now');
        preg_match('|<ds\:X509Certificate[^>]*?>(.*?)</ds\:X509Certificate>|si', $data, $x509Info);

        $replacedXml = str_replace("\r\n", '', $x509Info[1]);

        $oNca = new PhpNCANode\NCANodeClient('http://95.59.124.162:14579'); //95.59.124.162 когда локально
        $oPkcs12Info = $oNca->x509Info($replacedXml);

        if ($oPkcs12Info->isLegalFix() === true) {
            if ($oPkcs12Info->isExpiredFix($oDate) === false) {
                $aCertRaws = $oPkcs12Info->getRaw();
                if (isset($aCertRaws['subject']['iin'])) {
                    $sIin = $aCertRaws['subject']['iin'];
                    $aUser = User::where('iin', $sIin)->first();
                } else if (isset($aCertRaws['subject']['bin'])) {
                    $sBin = $aCertRaws['subject']['bin'];
                    $aUser = User::where('bin', $sBin)->first();
                }
                if (isset($aUser)) {
                    Auth::login($aUser);
                    return Redirect::to('docs');
                } else {
                    return response(['message'=>'Пользователь не существует в системе! Обратитесь администратору!'], 409);
                }
            } else {
                return response(['message'=>'Ваш сертификат просрочен! Пожалуйста обновите сертификат!'], 401);
            }
        } else {
            return response(['message'=>'Ваш сертификат не актуален! Пожалуйста обновите сертификат!'], 400);
        }
    }

    public function get_include_contents($filename) {
        if (is_file($filename)) {
            ob_start();
            include $filename;
            $contents = ob_get_contents();
            ob_end_clean();
            return $contents;
        }
        return false;
    }

    public function example($wsdl)
    {
        switch ($wsdl) {
            case 'shep':
                header('Content-Type: text/xml');
                $bodyContent  = file_get_contents(base_path('app/wsdl/result_wsdl.xml'));
                echo $bodyContent;
                break;
            default:
                echo 'no route for integration';
                break;
        }
    }

    public function receive()
    {
        header('Content-Type: text/xml');
        $bodyContent  = file_get_contents(base_path('app/wsdl/responce_wsdl.xml'));
        echo $bodyContent;
        exit;
    }

    public function getEgknRaws($id)
    {
        $query = \DB::table('egkn_services')
                    ->select('*')
                    ->where('id',$id)
                    ->get()
                    ->first();
        return json_decode(json_encode($query), true);
    }

    public function viewsign(Request $request)
    {
        $aEgknRaws = $this->getEgknRaws($request->id);
        $aEgknXmlRows = $this->xmlGenerator($aEgknRaws);
        return view('test.testpage', compact('aEgknRaws', 'aEgknXmlRows'));
    }

    public function signVerify(Request $request)
    {
        $oNca = new PhpNCANode\NCANodeClient('http://95.59.124.162:14579');
        $signedXml = $request->signedXml;
        $xmlVerification = $oNca->xmlVerify($signedXml);
        $doc_id = $request->doc_id;
        if ($xmlVerification->isValid() === true) {
            $oCertInfo = $xmlVerification->getCert();
            if (!empty($oCertInfo)) {
                if ($oCertInfo->isLegal() === true) {
                    if ($oCertInfo->isExpired() === false) {
                        $signSave = $this->signSave($request);
                    } else {
                        return response(['message' => 'Ваш сертификат просрочен! Пожалуйста обновите сертификат!'], 403);
                    }
                } else {
                    return response(['message' => 'Ваш сертификат не актуален! Пожалуйста обновите сертификат!'], 402);
                }
            } else {
                return response(['message'=>'Не найден сертификат!'], 401);
            }
        } else {
            return response(['message'=>'Не валидный подпись!'], 400);
        }
    }

    public function signSave(Request $request)
    {
        $input = $request->all();

        $file = File::addXmlItem('example_xml', FileCategory::XML, 'sign_files/' . $input['doc_id'], $input['signedXml']);

        if (!$file) {
            throw new \Exception('Не удалось сохранить модель File');
        }
        return response (['message'=>'Документ подписан!'], 200);
    }

    public function xmlGenerator($aData)
    {
        $xmlstr = "<?xml version='1.0' encoding='UTF-8' standalone='no'?><root><dataToSign>";
        if (isset($aData) && count($aData)) {
            foreach ($aData as $sKey => $sData) {
                $xmlstr .= "<".$sKey.">".$sData."</".$sKey.">";
            }
        }
        $xmlstr .= "</dataToSign></root>";
        return $xmlstr;
    }

}
