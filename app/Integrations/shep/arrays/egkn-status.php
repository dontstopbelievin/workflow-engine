<?php

$aData = [
    'Request' => [
        'SystemInfo' => [
            'RequestNumber' => '22345678342',
            'ChainId' => '1_22345678342',
            'RequestDate' => '2021-02-08+06:00',
            'ResponseCode' => 'ResponseCode', //????
            'AdditionalInfoRu' => 'Доп инфо рус',
            'AdditionalInfoKz' => 'Доп инфо каз'
        ],
        'BusinessData' => [
            'CodeStatus' => [
                'ResultCode' => '45',
                'ResultMessageRu' => 'Акт согласован рус',
                'ResultMessageKz' => 'Акт согласован каз',
                'ResultMessageEn' => 'Акт согласован англ'
            ],
            'Attachment' => [
                'CodeType' => 'ZKR4',
                'FileName' => 'Акт выбора ЗУ',
                'FileId' => '00000000-0000-f1a8-ba4b-0b78748e605b',
                'DocNumber' => '123',
                'DocDate' => '2021-01-29+06:00'
            ],
            'Objects' => [
                'ObjectInfo' => [
                    'Id' => '10000000115',
                    'Area' => '0.888',
                    'Scale' => '5000',
                    'FuncUse' => [
                        'code' => '7020100100'
                    ],
                    'PurposeUse' => [
                        'code' => '37'
                    ],
//                    'CadastrNum' => '',
//                    'CadastrCaseId' => '',
//                    'CadastrCaseNum' => '',
                    'Coordinates' => 'MULTIPOLYGON(((674486.83 5667708.71,674456.65 5667778.87,674513.55 5667807.03,674547.45 5667737.74,674486.83 5667708.71)))',
                    'AddressData' => [
                        'Ate' => [
                            'AteCode' => '107193'
                        ],
//                        'Toponim' => [
//                            'ToponimCode' => '',
//                            'ToponimTypeCode' => '',
//                            'ParentToponimCode' => '',
//                            'KATO' => '',
//                            'NameRu' => '',
//                            'NameKz' => ''
//                        ],
//                        'Region' => '',
//                        'City' => '',
//                        'Street' => '',
//                        'Ground' => [
//                            'RCA' => '',
//                            'Number' => ''
//                        ],
//                        'Building' => [
//                            'RCA' => '',
//                            'BuildingTypeCode' => '',
//                            'ThisIs' => '',
//                            'Number' => '',
//                            'ParentRCA' => '',
//                            'Distance' => ''
//                        ],
//                        'BuildingPart' => [
//                            'RCA' => '',
//                            'BuildingPartTypeCode' => '',
//                            'BuildingRCA' => '',
//                            'Number' => ''
//                        ],
//                        'Block' => '',
//                        'Flat' => '',
//                        'AddressCode' => '',
//                        'CadastreNumber' => '',
//                        'ObjectType' => '',
//                        'AddressNameRu' => '',
//                        'AddressNameKz' => ''
                    ],
//                    'KadastrStoim' => '',
                    'RightType' => [
                        'code' => '02'
                    ],
                    'OwnershipForm' => [
                        'code' => '',
                        'nameRu' => ''
                    ],
                    'GenOwnershipForm' => [
                        'code' => ''
                    ],
                    'EstateObjectTypeCode' => '1',
                    'LandCategory' => [
                        'code' => 'landcat_znp'
                    ],
                    'LandDivisibility' => [
                        'code' => 'divis_y'
                    ],
                    'TechConditions' => [
                        'ElektrPower' => '25', //Выделяемая мощность (лимит) (кВт)
                        'ElektrFaza1' => '111', //Характер нагрузки: Однофазная (кВт)
                        'ElektrFaza3' => '333', //Характер нагрузки: Трехфазная (кВт)
                        'WaterPower' => '444', //Общая потребность в воде (лимит) (м3/час)
                        'WaterHoz' => '5555', //На хозпитьевые нужды (м3/час)
                        'WaterProduction' => '66', //На производственные нужды (м3/час)
                        'SeweragePower' => 'да', //Водоотведение(да/нет)
                        'CentralSewerary' => 'да', //Центральная канализация(да/нет)
                        'HeatFiring' => 'да', //Центральное отопление (да/нет)
                        'HeatHotWater' => 'да', //Центральное горячее водоснабжение (да/нет)
                        'Telekom' => 'да', //Телефонизация(да/нет)
                        'GasPower' => 'да', //Газоснабжение (да/нет)
                    ],
                    'TechConditionsEndAuction' => [
                        'ElektrPower' => '25', //Выделяемая мощность (лимит) (кВт)
                        'ElektrFaza1' => '111', //Характер нагрузки: Однофазная (кВт)
                        'ElektrFaza3' => '333', //Характер нагрузки: Трехфазная (кВт)
                        'WaterPower' => '444', //Общая потребность в воде (лимит) (м3/час)
                        'WaterHoz' => '5555', //На хозпитьевые нужды (м3/час)
                        'WaterProduction' => '66', //На производственные нужды (м3/час)
                        'SeweragePower' => '777', //Общее количество сточных вод (м3/час)
                        'SewerageFecal' => '88', //Фекальных (м3/час)
                        'SewerageProduction' => '999', //Производственно-загрязненных (м3/час)
                        'SewerageClean' => '1010', //Условно-чистых сбрасываемых на городскую канализацию (м3/час)
                        'HeatPower' => '11', //Общая тепловая нагрузка (лимит) (Гкал/час)
                        'HeatFiring' => '12', //Отопление (Гкал/час)
                        'HeatVentilation' => '1313', //Вентиляция (Гкал/час)
                        'HeatHotWater' => '14140', //Горячее водоснабжение (Гкал/час)
                        'StormWater' => 'Есть', //Ливневая канализация
                        'Telekom' => 'Есть', //Телефонизация
                        'GasPower' => '1515', //Общая потребность (лимит) (м3/час)
                        'GasOnCooking' => '1616', //На приготовление пищи (м3/час)
                        'GasHeating' => '171', //Отопление
                        'GasVentilation' => '1818', //Вентиляция (м3/час)
                        'GasConditioning' => '19', //Кондиционирование (м3/час)
                        'GasHotWater' => '2020' //Горячее водоснабжение при газификации многоэтажных домов (м3/час)
                    ]
                ]
            ],
            'PersonalData' => [ //Сведения ФЛ
                'IIN' => '900319350069',
//                'Surname' => '',
//                'Name' => '',
//                'Middlename' => '',
//                'BirthDate' => ''
            ],
//            'JuridicalData' => [ //Сведения ЮЛ
//                'BIN' => '',
//                'NameKz' => '',
//                'NameRu' => ''
//            ],
//            'WarrantData' => [ //Сведения о доверенности
//                'WarrantNumber' => '',
//                'WarrantDate' => '',
//                'NotaryName' => '',
//                'Brief' => '',
//                'Status' => '',
//                'WarrantIIN' => ''
//            ],
            'Phone' => '+77028271930' //Контактный номер телефона
        ]
    ]
];
