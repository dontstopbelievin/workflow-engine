<?php

$aData = [
    'request' => [
        'SystemInfo' => [
            'RequestNumber' => '22345678340',
            'ChainId' => '1_22345678340',
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
                            'FileId' => '00000000-0000-f17d-4748-d493c6001948',
                            'DocNumber' => '123',
                            'DocDate' => '2021-01-29+06:00'
                        ],
                    ],
                    [
                        'Attacment' => [
                            'CodeType' => 'ZKR5',
                            'FileName' => 'Ситуационная схема',
                            'FileId' => '00000000-0000-f17d-4748-d493c6001948',
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
                        'Id' => '10000000114',
                        'Area' => '0.888',
                        'FuncUse' => [
                            'code' => '7020100100'
                        ],
                        'PurposeUse' => [
                            'code' => '37'
                        ],
                        'Coordinates' => 'MULTIPOLYGON(((7958620.459177932 6645181.035262049,7958781.693534457 6645246.7233332265,7958817.523391463 6645138.039433643,7958671.815306306 6645067.574048199,7958620.459177932 6645181.035262049)))',
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
