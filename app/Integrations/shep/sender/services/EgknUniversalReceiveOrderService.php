<?php

namespace App\Integrations\shep\sender\services;

use App\Integrations\shep\sender\XmlBuilderInterface;
use App\Integrations\shep\ShepUtil;
use App\Integrations\shep\ShepXmlUtil;

class EgknUniversalReceiveOrderService extends ShepService implements XmlBuilderInterface
{
    const SERVICE_TYPE = 'async';
    const SERVICE_ID = 'EgknUniversalReceiveOrder';

    public function __construct($sShepUrl = null)
    {
        parent::__construct(self::SERVICE_TYPE, $sShepUrl);
    }

    public function buildXml(array $aArguments)
    {
        include_once app_path('Integrations/shep/arrays/egkn_order_test.php');
        // $sUnsignedXml = ShepUtil::arrayToXML($aData);
        $sUnsignedXml = ShepUtil::arrayToXML($aArguments['xml']);
        $sUnsignedXml = str_replace('<request>', '<request xmlns="http://newshep.EgknUniversalReceiveOrder.egkn.tamur.kz">', $sUnsignedXml);
        // $sSignedBusinessDataXml = ShepUtil::signXmlJar($sUnsignedXml);
        $sSignedBusinessDataXml = str_replace('<', '&lt;', $sSignedBusinessDataXml);
        $sRequestXml = ShepXmlUtil::getSoapAsyncRequest(self::SERVICE_ID, $sSignedBusinessDataXml, 'REQUEST',
            $aArguments['correlationId'] ?? '');
        $sRequestXml = str_replace('<data>', '<data xmlns:xs="http://www.w3.org/2001/XMLSchema" xsi:type="xs:string">', $sRequestXml);

        return $sRequestXml;
    }
}
