<?php

namespace App\Integrations\shep\receiver\services;


use App\Integrations\shep\ShepUtil;
use App\Integrations\shep\ShepXmlUtil;
use App\Integrations\shep\receiver\ShepServiceStrategyInterface;

class GeoportalGzkGetRelevanceStrategy implements ShepServiceStrategyInterface
{
    private $aRequestData = array();

    public function __construct(array $aRequestData)
    {
        $this->aRequestData = $aRequestData;
    }

    public function receive()
    {
        $aResponse = [
            [
                'AvailableInfo' => [
                    'Code' => 'U_05_085',
                    'Name' => [
                        'Ru' => 'Земельный участок',
                        'Kz' => 'Земельный участок каз'
                    ],
                    'DateAct' => '2020-10-22T07:02:25',
                    'GeometryType' => 'polygon',
                    'Territory' => [
                        'Code' => '05_085',
                        'Name' => [
                            'Ru' => 'город Нур-Султан',
                            'Kz' => 'Нур-Султан каласы'
                        ]
                    ]
                ]
            ],
            [
                'AvailableInfo' => [
                    'Code' => 'UK_05_085',
                    'Name' => [
                        'Ru' => 'Учетный квартал рус',
                        'Kz' => 'Учетный квартал каз'
                    ],
                    'DateAct' => '2020-10-24T00:55:29',
                    'GeometryType' => 'polygon',
                    'Territory' => [
                        'Code' => '05_085',
                        'Name' => [
                            'Ru' => 'город Нур-Султан',
                            'Kz' => 'Нур-Султан каласы'
                        ]
                    ]
                ]
            ],
            [
                'AvailableInfo' => [
                    'Code' => 'R_05_085',
                    'Name' => [
                        'Ru' => 'Граница района рус',
                        'Kz' => 'Граница района каз'
                    ],
                    'DateAct' => '2020-10-24T00:38:42',
                    'GeometryType' => 'polygon',
                    'Territory' => [
                        'Code' => '05_085',
                        'Name' => [
                            'Ru' => 'город Нур-Султан',
                            'Kz' => 'Нур-Султан каласы'
                        ]
                    ]
                ]
            ]
        ];
        $sResponseXml = ShepUtil::arrayToXML($aResponse);
        $sResponseXml = ShepXmlUtil::getSoapResponse('SCSS001', 'Запрос выполнен успешно', $sResponseXml);
        $sResponseXml = str_replace('<data>', '<data xmlns:gzk="http://aisgzk.kz/integrations/v2019" xsi:type="gzk:GIRelevanceResponse">', $sResponseXml);
        return $sResponseXml;
    }
}
