<?php

namespace App\Integrations\shep\sender;

use App\Integrations\shep\ShepUtil;

class ShepRequestSender
{
    private static $sShepUrl;

    public static function send($sServiceName, $aRequestData)
    {
        $oService = ShepServiceFactory::create($sServiceName);
        $sShepRequestXML = (new ShepRequestXmlBuilder($oService))->build($aRequestData);
        $sSignedXML = ShepUtil::signXml($sShepRequestXML);
        return ShepUtil::sendShepXmlRequest($sSignedXML, $oService->sShepUrl);
    }
}
