<?php

namespace App\Integrations\shep\receiver\services;


use App\Integrations\shep\receiver\ShepServiceStrategyInterface;
use App\Integrations\shep\sender\services\GeoportalPEPAsyncService;

class GeoportalPEPAsyncRequestStrategy implements ShepServiceStrategyInterface
{
    private $aRequestData = array();

    public function __construct(array $aRequestData)
    {
        $this->aRequestData = $aRequestData;
    }

    public function receive()
    {
        if (!isset($this->aRequestData['request'])) {
            throw new \SoapFault('Unknown request type');
        }

        //TODO: сделать логику
        //сохранить заявку с ПЭПа в базу
        $sCorrelationId = $this->aRequestData['request']['messageInfo']['correlationId'];
        //TODO: вставить реальные данные
        $aData = array(
            'responseMessage' => array(
                'SystemInfo' => array(
                    'RequestNumber' => '10000000000000005764',
                    'ChainId' => '10000000000000005764',
                    'RequestDate' => '2020-06-23T14:22:54.719+06:00'
                ),
                'ResponseData' => array(
                    'RequestNumber' => 'request number here',
                    'CurrentStatus' => '001',
                    'CurrentStatusText' => 'Заявка успешно создана'
                )
            )
        );
        $aPreparedData = array(
            'correlationId' => $sCorrelationId,
            'data' => $aData,
            'messageType' => 'RESPONSE'
        );
        $sXml = (new GeoportalPEPAsyncService())->buildXml($aPreparedData);

        return $sXml;
    }
}
