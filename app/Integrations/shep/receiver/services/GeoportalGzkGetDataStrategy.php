<?php

namespace App\Integrations\shep\receiver\services;


use App\Integrations\shep\ShepUtil;
use App\Integrations\shep\ShepXmlUtil;
use App\Integrations\shep\receiver\ShepServiceStrategyInterface;

class GeoportalGzkGetDataStrategy implements ShepServiceStrategyInterface
{
    private $aRequestData = array();

    public function __construct(array $aRequestData)
    {
        $this->aRequestData = $aRequestData;
    }

    public function receive()
    {
        $aResponse = array(
            'PushId' => '221',
            'DataCount' => '',
            [
                'DataStructure' => [
                    'Code' => 'CADNUMBER',
                    'Name' => [
                        'Ru' => 'Кадастровый номер',
                        'Kz' => 'Кадастрлық нөмір'
                    ],
                    'Type' => 'text',
                    'Size' => '15'
                ]
            ],
            [
                'DataStructure' => [
                    'Code' => 'CATEGORY_CODE',
                    'Name' => [
                        'Ru' => 'Классификационный код (Категория земель)',
                        'Kz' => 'Сыныптамалық код (Жерлердің категориялары)'
                    ],
                    'Type' => 'text',
                    'Size' => '1000'
                ]
            ],
            [
                'DataStructure' => [
                    'Code' => 'CATEGORY_KAZ',
                    'Name' => [
                        'Ru' => 'Наименование на казахском языке (Категория земель)',
                        'Kz' => 'Қазақ тіліндегі атауы (Жерлердің категориялары)'
                    ],
                    'Type' => 'text',
                    'Size' => '1000'
                ]
            ],
            [
                'DataStructure' => [
                    'Code' => 'CATEGORY_RUS',
                    'Name' => [
                        'Ru' => 'Наименование на русском языке (Категория земель)',
                        'Kz' => 'Орыс тіліндегі атауы (Жерлердің категориялары)'
                    ],
                    'Type' => 'text',
                    'Size' => '1000'
                ]
            ],
            [
                'DataStructure' => [
                    'Code' => 'PRAVO_CODE',
                    'Name' => [
                        'Ru' => 'Классификационный код (Вид предоставленного государством права)',
                        'Kz' => 'Сыныптамалық код (Мемлекетпен берген құқықтың түрі)'
                    ],
                    'Type' => 'text',
                    'Size' => '1000'
                ]
            ],
            [
                'DataStructure' => [
                    'Code' => 'PRAVO_KAZ',
                    'Name' => [
                        'Ru' => 'Наименование на казахском языке (Вид предоставленного государством права)',
                        'Kz' => 'Қазақ тіліндегі атауы (Мемлекетпен берген құқықтың түрі)'
                    ],
                    'Type' => 'text',
                    'Size' => '1000'
                ]
            ],
            [
                'DataStructure' => [
                    'Code' => 'PRAVO_RUS',
                    'Name' => [
                        'Ru' => 'Наименование на русском языке (Вид предоставленного государством права)',
                        'Kz' => 'Орыс тіліндегі атауы (Мемлекетпен берген құқықтың түрі)'
                    ],
                    'Type' => 'text',
                    'Size' => '1000'
                ]
            ],
            [
                'DataStructure' => [
                    'Code' => 'DELIM',
                    'Name' => [
                        'Ru' => 'Признак делимости',
                        'Kz' => 'Бөлінгіштік белгісі'
                    ],
                    'Type' => 'number',
                    'Size' => '1'
                ]
            ],
            [
                'DataStructure' => [
                    'Code' => 'OGROBR_KAZ',
                    'Name' => [
                        'Ru' => 'Формулировка на казахском языке (Ограничения и обременения)',
                        'Kz' => 'Қазақ тіліндегі атауы (Шектеулер мен ауыртпалықтар)'
                    ],
                    'Type' => 'text',
                    'Size' => '1000'
                ]
            ],
            [
                'DataStructure' => [
                    'Code' => 'OGROBR_RUS',
                    'Name' => [
                        'Ru' => 'Формулировка на русском языке (Ограничения и обременения)',
                        'Kz' => 'Орыс тіліндегі атауы (Шектеулер мен ауыртпалықтар)'
                    ],
                    'Type' => 'text',
                    'Size' => '1000'
                ]
            ],
            [
                'DataStructure' => [
                    'Code' => 'TSN_KAZ',
                    'Name' => [
                        'Ru' => 'Формулировка на казахском языке (Целевое назначение)',
                        'Kz' => 'Қазақ тіліндегі атауы (Нысаналы мақсат)'
                    ],
                    'Type' => 'text',
                    'Size' => '1000'
                ]
            ],
            [
                'DataStructure' => [
                    'Code' => 'TSN_RUS',
                    'Name' => [
                        'Ru' => 'Формулировка на русском языке (Целевое назначение)',
                        'Kz' => 'Орыс тіліндегі атауы (Нысаналы мақсат)'
                    ],
                    'Type' => 'text',
                    'Size' => '1000'
                ]
            ],
            [
                'DataStructure' => [
                    'Code' => 'ADDRESS_KAZ',
                    'Name' => [
                        'Ru' => 'Полный адрес на казахском языке',
                        'Kz' => 'Қазақ тіліндегі толық мекен-жайы'
                    ],
                    'Type' => 'text',
                    'Size' => '1000'
                ]
            ],
            [
                'DataStructure' => [
                    'Code' => 'ADDRESS_RUS',
                    'Name' => [
                        'Ru' => 'Полный адрес на русском языке',
                        'Kz' => 'Орыс тіліндегі толық мекен-жайы'
                    ],
                    'Type' => 'text',
                    'Size' => '1000'
                ]
            ],
            [
                'DataStructure' => [
                    'Code' => 'SQU',
                    'Name' => [
                        'Ru' => 'Площадь',
                        'Kz' => 'Аудан'
                    ],
                    'Type' => 'number',
                    'Size' => '10'
                ]
            ]
        );
        $sResponseXml = ShepUtil::arrayToXML($aResponse);
        $sResponseXml = ShepXmlUtil::getSoapResponse('SCSS001', 'Запрос выполнен успешно', $sResponseXml);
        $sResponseXml = str_replace('<data>', '<data xmlns:gzk="http://aisgzk.kz/integrations/v2019" xsi:type="gzk:GIDataResponse">', $sResponseXml);
        return $sResponseXml;
    }
}
