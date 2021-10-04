<?php

namespace App\Integrations\shep\sender\services;

use App\Integrations\shep\sender\XmlBuilderInterface;
use App\Integrations\shep\ShepUtil;
use App\Integrations\shep\ShepXmlUtil;

class GeoportalPEPAsyncService extends ShepService implements XmlBuilderInterface
{
    const SERVICE_TYPE = 'async';
    const SERVICE_ID = 'get_ZU_RGIS_UniversalService';

    public function __construct($sShepUrl = null)
    {
        parent::__construct(self::SERVICE_TYPE, $sShepUrl);
    }

    public function buildXml(array $aPreparedData)
    {
        if (!isset($aPreparedData['correlationId'])) {
            throw new \Exception('CorrelationId is not set');
        }
        if (!isset($aPreparedData['messageType'])) {
            throw new \Exception('MessageType is not set');
        }
        if (!isset($aPreparedData['data'])) {
            throw new \Exception('Data is not set');
        }

        $sXml = ShepUtil::arrayToXML($aPreparedData['data']);
        $sXml = str_replace('<', '<ns3:', $sXml);
        $sXml = str_replace('<ns3:/', '</ns3:', $sXml);
        $sType = 'responseMessage';
        if ($aPreparedData['messageType'] == 'REQUEST') {
            $sType = 'requestMessage';
        }
        $sXml = str_replace('<ns3:' . $sType . '>', '<' . $sType . ' xmlns:ns3="http://newshep.get_app_ZU_egov_Aktobe.egov.kz">', $sXml);
        $sXml = str_replace('</ns3:' . $sType . '>', '</' . $sType . '>', $sXml);
        $sXml = '<?xml version="1.0" ?>' . $sXml;
        $sXml = str_replace('<', '&lt;', $sXml);
        if($aPreparedData['messageType'] == 'RESPONSE'){
            $sRequestXml = ShepXmlUtil::getSoapAsyncResponse2($aPreparedData['correlationId']);
        }else{
            $sRequestXml = ShepXmlUtil::getSoapAsyncRequest_pep(self::SERVICE_ID, $sXml, $aPreparedData['messageType'], $aPreparedData['correlationId']);
        }
        $sRequestXml = str_replace('<data>', '<data xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="xs:string">', $sRequestXml);

        return $sRequestXml;
    }
}
