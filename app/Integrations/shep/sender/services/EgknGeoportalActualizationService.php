<?php

namespace App\Integrations\shep\sender\services;

use App\Integrations\shep\sender\XmlBuilderInterface;
use App\Integrations\shep\ShepUtil;
use App\Integrations\shep\ShepXmlUtil;

class EgknGeoportalActualizationService extends ShepService implements XmlBuilderInterface
{
    const SERVICE_TYPE = 'sync';
    const SERVICE_ID = 'EgknGeoportalActualization';

    public function __construct($sShepUrl = null)
    {
        parent::__construct(self::SERVICE_TYPE, $sShepUrl);
    }

    public function buildXml(array $aArguments)
    {
        include_once app_path('Integrations/shep/arrays/egkn-status.php');
        $sUnsignedXml = ShepUtil::arrayToXML($aData);
        $sUnsignedXml = str_replace('<Request>', '<ns3:Request>', $sUnsignedXml);
        $sUnsignedXml = str_replace('</Request>', '</ns3:Request>', $sUnsignedXml);
        $sUnsignedXml = str_replace('<ns3:Request>', '<ns3:Request xmlns:ns3="http://tamur.kz/schemes/egkn/egkngeoportalactualization">', $sUnsignedXml);
        $sSignedBusinessDataXml = ShepUtil::signXmlJar($sUnsignedXml);
        $sSignedBusinessDataXml = str_replace('<', '&lt;', $sSignedBusinessDataXml);
        $sRequestXml = ShepXmlUtil::getSoapRequest(self::SERVICE_ID, $sSignedBusinessDataXml);
        $sRequestXml = str_replace('<data>', '<data xmlns:xs="http://www.w3.org/2001/XMLSchema" xsi:type="xs:string">', $sRequestXml);

        return $sRequestXml;
    }
}