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
        // include_once app_path('Integrations/shep/arrays/egkn-geoportal-free.php');
        $sUnsignedXml = ShepUtil::arrayToXML($aPreparedData);
        $sUnsignedXml = str_replace('<Request>', '<Request xmlns="http://newshep.geoportal.free.gbdrn.tamur.kz" xmlns:ns2="http://www.w3.org/2000/09/xmldsig#">', $sUnsignedXml);
        $sSignedBusinessDataXml = ShepUtil::signXmlJar($sUnsignedXml);
        $sSignedBusinessDataXml = str_replace('<', '&lt;', $sSignedBusinessDataXml);
        $sRequestXml = ShepXmlUtil::getSoapRequest_egkn_rec_layer(self::SERVICE_ID, $sSignedBusinessDataXml);
        $sRequestXml = str_replace('<data>', '<data xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="xs:string">', $sRequestXml);
        return $sRequestXml;
    }
}
