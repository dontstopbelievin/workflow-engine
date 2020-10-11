<?php

namespace App\Integrations\shep\sender\services;

use App\Integrations\shep\sender\XmlBuilderInterface;
use App\Integrations\shep\ShepUtil;
use App\Integrations\shep\ShepXmlUtil;

class GeoportalEgknReceiveLayerService extends ShepService implements XmlBuilderInterface
{
    const SERVICE_TYPE = 'sync';
    const SERVICE_ID = 'GeoportalEgknReceiveLayer';

    public function __construct($sShepUrl = null)
    {
        parent::__construct(self::SERVICE_TYPE, $sShepUrl);
    }

    public function buildXml(array $aPreparedData)
    {
        $sUnsignedXml = ShepUtil::arrayToXML($aPreparedData);
        $sUnsignedXml = str_replace('<Request>', '<ns3:Request>', $sUnsignedXml);
        $sUnsignedXml = str_replace('</Request>', '</ns3:Request>', $sUnsignedXml);
        $sUnsignedXml = str_replace('<ns3:Request>', '<ns3:Request xmlns:ns3="http://newshep.geoportal.free.gbdrn.tamur.kz">', $sUnsignedXml);
        $sSignedBusinessDataXml = ShepUtil::signXmlJar($sUnsignedXml);
        $sSignedBusinessDataXml = str_replace('<', '&lt;', $sSignedBusinessDataXml);
        $sRequestXml = ShepXmlUtil::getSoapRequest(self::SERVICE_ID, $sSignedBusinessDataXml);
        $sRequestXml = str_replace('<data>', '<data xmlns:xs="http://www.w3.org/2001/XMLSchema" xsi:type="xs:string">', $sRequestXml);

        return $sRequestXml;
    }
}
