<?php

namespace App\Integrations\shep\receiver\services;


use App\Integrations\shep\ShepUtil;
use App\Integrations\shep\ShepXmlUtil;
use App\Integrations\shep\receiver\ShepServiceStrategyInterface;

class EgknGeoportalActualizationStrategy implements ShepServiceStrategyInterface
{
    private $aRequestData = array();

    public function __construct(array $aRequestData)
    {
        $this->aRequestData = $aRequestData;
    }

    public function receive()
    {
        //TODO: save data to DB from EGKN
        $aResponse = array(
            'Response' => array(
                'BusinessData' => array(
                    'Result' => array(
                        'ResultCode' => '310',
                        'ResultMessageRu' => 'Успешно выполнено'
                    )
                )
            )
        );
        $sResponseXml = ShepUtil::arrayToXML($aResponse);
        $sResponseXml = str_replace('<Response>', '<ns3:Response>', $sResponseXml);
        $sResponseXml = str_replace('</Response>', '</ns3:Response>', $sResponseXml);
        $sResponseXml = str_replace('<ns3:Response>', '<ns3:Response xmlns:ns3="http://tamur.kz/schemes/egkn/egkngeoportalactualization">', $sResponseXml);
        $sResponseXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . $sResponseXml;
        $sResponseXml = str_replace('<', '&lt;', $sResponseXml);
        $sResponseXml = ShepXmlUtil::getSoapResponse('SCSS001', 'Запрос выполнен успешно', $sResponseXml);
        $sResponseXml = str_replace('<data>', '<data xmlns:xs="http://www.w3.org/2001/XMLSchema" xsi:type="xs:string">', $sResponseXml);
        return $sResponseXml;
    }
}
