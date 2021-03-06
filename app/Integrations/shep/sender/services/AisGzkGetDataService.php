<?php

namespace App\Integrations\shep\sender\services;

use App\Integrations\shep\sender\XmlBuilderInterface;
use App\Integrations\shep\ShepUtil;
use App\Integrations\shep\ShepXmlUtil;


class AisGzkGetDataService extends ShepService implements XmlBuilderInterface
{
    const SERVICE_TYPE = 'sync';
    const SERVICE_ID = 'GeoportalGzkGetData';

    public function __construct($sShepUrl = null)
    {
        parent::__construct(self::SERVICE_TYPE, $sShepUrl);
    }

    public function buildXml(array $aArguments)
    {
        $aData = array(
            'RequestUser' => 'gp_astana',
            'LayerName' => 'U_21_324'
        );
        $sUnsignedXml = ShepUtil::arrayToXML($aData);
        $sRequestXml = ShepXmlUtil::getSoapRequest(self::SERVICE_ID, $sUnsignedXml);
        $sRequestXml = str_replace('<data>', '<data xmlns:gzk="http://aisgzk.kz/integrations/v2019" xsi:type="gzk:GIDataRequest">', $sRequestXml);

        return $sRequestXml;
    }
}
