<?php

$aData = [
    'request' => [
        'SystemInfo' => [
            'RequestNumber' => '22345678341',
            'ChainId' => '1_22345678341',
            'RequestDate' => '2021-01-29T12:06:39.298+06:00',
        ],
        'RequestData' => [
            [
                'ServicesType' => [
                    'ServiceType' => [
                        'code' => '504400',
                        'nameRu' => '223456789'
                    ],
                    'Price' => '0.0',
                    'UrgencyPrice' => '0.0',
                    'MoreUrgencyPrice' => '0.0',
                    [
                        'Attacment' => [
                            'CodeType' => 'ZKR4',
                            'FileName' => 'Акт выбора ЗУ',
                            'FileId' => '00000000-0000-f1a8-ba4b-0b78748e605b',
                            'DocNumber' => '123',
                            'DocDate' => '2021-01-29+06:00'
                        ],
                    ],
                    [
                        'Attacment' => [
                            'CodeType' => 'ZKR5',
                            'FileName' => 'Ситуационная схема',
                            'FileId' => '00000000-0000-f1a8-ba4b-0b78748e605b',
                            'DocNumber' => '111',
                            'DocDate' => '2021-01-29+06:00'
                        ],
                    ],
                    'IsMain' => 'true'
                ]
            ],
            [
                'ServicesType' => [
                    'ServiceType' => [
                        'code' => '503100',
                        'nameRu' => '223456789'
                    ],
                    'Price' => '0.0',
                    'UrgencyPrice' => '0.0',
                    'MoreUrgencyPrice' => '0.0'
                ]
            ],
            'Objects' => [
                [
                    'ObjectInfo' => [
                        'Id' => '10000000115',
                        'Area' => '0.888',
                        'FuncUse' => [
                            'code' => '7020100100'
                        ],
                        'PurposeUse' => [
                            'code' => '37'
                        ],
                        'Coordinates' => 'MULTIPOLYGON(((674486.83 5667708.71,674456.65 5667778.87,674513.55 5667807.03,674547.45 5667737.74,674486.83 5667708.71)))',
                        'AddressData' => [
                            'AteCode' => '107193'
                        ],
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
                        ]
                    ]
                ]
            ],
            'PersonalData' => [
                'IIN' => '900319350069',
                'BirthDate' => '1986-04-30+06:00'
            ]
        ]
    ],
];
