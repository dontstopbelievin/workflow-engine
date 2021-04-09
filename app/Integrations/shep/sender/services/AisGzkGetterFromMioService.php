<?php

namespace App\Integrations\shep\sender\services;

use App\Integrations\shep\sender\XmlBuilderInterface;
use App\Integrations\shep\ShepUtil;
use App\Integrations\shep\ShepXmlUtil;


class AisGzkGetterFromMioService extends ShepService implements XmlBuilderInterface
{
    const SERVICE_TYPE = 'sync';
    const SERVICE_ID = 'GzkGetterFromMio';

    public function __construct($sShepUrl = null)
    {
        parent::__construct(self::SERVICE_TYPE, $sShepUrl);
    }

    public function buildXml(array $aArguments)
    {
        include_once app_path('Integrations/shep/arrays/gzk-getter-from-mio.php');
        $sUnsignedXml = ShepUtil::arrayToXML($aData);
        $sSignedBusinessDataXml = ShepUtil::signXmlJar($sUnsignedXml);
        $sRequestXml = ShepXmlUtil::getSoapRequest(self::SERVICE_ID, $sSignedBusinessDataXml);
        $sRequestXml = str_replace('<data>', '<data xmlns:gzk="http://aisgzk.kz/integrations/v2019" xsi:type="gzk:GISendDataRequest">', $sRequestXml);

        return $sRequestXml;
    }
}
