<?php

namespace App\Integrations\shep\receiver\services;


use App\Integrations\shep\ShepUtil;
use App\Integrations\shep\ShepXmlUtil;
use App\Integrations\shep\receiver\ShepServiceStrategyInterface;

class EgknUniversalReceiveOrder implements ShepServiceStrategyInterface
{
    private $aRequestData = array();

    public function __construct(array $aRequestData)
    {
        $this->aRequestData = $aRequestData;
    }

    public function receive()
    {
        //TODO: save data to DB from EGKN
        $sResponseXml = ShepXmlUtil::getSoapAsyncResponse2($this->aRequestData['request']['messageInfo']['correlationId']);
        $sResponseXml = str_replace('<data>', '<data xmlns:xs="http://www.w3.org/2001/XMLSchema" xsi:type="xs:string">', $sResponseXml);
        return $sResponseXml;
    }
}
