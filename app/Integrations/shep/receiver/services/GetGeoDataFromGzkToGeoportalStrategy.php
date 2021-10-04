<?php

namespace App\Integrations\shep\receiver\services;


use App\Integrations\shep\ShepUtil;
use App\Integrations\shep\ShepXmlUtil;
use App\Integrations\shep\receiver\ShepServiceStrategyInterface;

class GetGeoDataFromGzkToGeoportalStrategy implements ShepServiceStrategyInterface
{
    private $aRequestData = array();

    public function __construct(array $aRequestData)
    {
        $this->aRequestData = $aRequestData;
    }

    public function receive()
    {
        $aResponse = array(
            'Result' => 1
        );
        $sResponseXml = ShepUtil::arrayToXML($aResponse);
        $sResponseXml = ShepUtil::signXmlJar($sResponseXml);
        $sResponseXml = ShepXmlUtil::getSoapResponse('SCSS001', 'Запрос выполнен успешно', $sResponseXml);
        return $sResponseXml;
    }
}
