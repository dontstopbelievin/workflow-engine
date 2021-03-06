<?php

$aData = [
    'request' => [
        'SystemInfo' => [
            'RequestNumber' => '',
            'ChainId' => '',
            'RequestDate' => '',
            'ResponseCode' => '', //????
            'AdditionalInfoRu' => '',
            'AdditionalInfoKz' => ''
        ],
        'RequestData' => [
            'ServicesType' => [
                'ServiceType' => [
                    'code' => '',
                    'nameRu' => '',
                    'nameKz' => ''
                ],
                'PriceCriteryes' => [
                    'WorkType' => [
                        'code' => '',
                        'nameRu' => '',
                        'nameKz' => ''
                    ],
                    'PriceCritery' => [
                        'code' => '',
                        'nameRu' => '',
                        'nameKz' => ''
                    ],
                    'Price' => '',
                    'UrgencyPrice' => '',
                    'MoreUrgencyPrice' => '',
                    'Term' => '',
                    'UrgencyTerm' => '',
                    'MoreUrgencyTerm' => '',
                    'IsPrepayment' => ''
                ],
                'Price' => '',
                'UrgencyPrice' => '',
                'MoreUrgencyPrice' => '',
                'Term' => '',
                'UrgencyTerm' => '',
                'MoreUrgencyTerm' => '',
                'AmountToPay' => '',
                'PaymentData' => [
                    'PayCode' => '',
                    'PayDate' => '',
                    'PaySum' => '',
                    'PrivilegesType' => '',
                    'BankNameKz' => '',
                    'BankNameRu' => '',
                    'CheckURL' => '',
                    'FileName' => ''
                ],
                'Attacment' => [
                    'CodeType' => '',
                    'FileName' => '',
                    'FileId' => '',
                    'Hash' => '',
                    'DocNumber' => '',
                    'DocDate' => '',
                    'Content' => '' //????????????????(?????? ???????????????????????? ???????? ?????? ????????)
                ],
                'IsMain' => ''
            ],
            'Objects' => [
                'ObjectInfo' => [
                    'Id' => '',
                    'Area' => '',
                    'Scale' => '',
                    'FuncUse' => [
                        'code' => '',
                        'nameRu' => '',
                        'nameKz' => ''
                    ],
                    'PurposeUse' => [
                        'code' => '',
                        'nameRu' => '',
                        'nameKz' => ''
                    ],
                    'CadastrNum' => '',
                    'CadastrCaseId' => '',
                    'CadastrCaseNum' => '',
                    'Coordinates' => '',
                    'AddressData' => [
                        'AteCode' => '',
                        'ToponimCode' => '',
                        'Region' => '',
                        'City' => '',
                        'Street' => '',
                        'Building' => '',
                        'Block' => '',
                        'Flat' => '',
                        'AddressCode' => '',
                        'CadastreNumber' => '',
                        'ObjectType' => ''
                    ],
                    'KadastrStoim' => '',
                    'RightType' => [
                        'code' => '',
                        'nameRu' => '',
                        'nameKz' => ''
                    ],
                    'OwnershipForm' => [
                        'code' => '',
                        'nameRu' => '',
                        'nameKz' => ''
                    ],
                    'GenOwnershipForm' => [
                        'code' => '',
                        'nameRu' => '',
                        'nameKz' => ''
                    ],
                    'EstateObjectTypeCode' => '', //?????? ???????? ???????????????????????? 1 - ?????????????????? ??????????????; 3 - ?????????????????? ????????????; 4 - ?????????????????? ????????????; 5 - ????????; 6 - ??????????
                    'LandCategory' => [
                        'code' => '',
                        'nameRu' => '',
                        'nameKz' => ''
                    ],
                    'TechConditions' => [
                        'ElektrPower' => '',
                        'ElektrFaza1' => '',
                        'ElektrFaza3' => '',
                        'WaterPower' => '',
                        'WaterHoz' => '',
                        'WaterProduction' => '',
                        'SeweragePower' => '',
                        'CentralSewerary' => '',
                        'HeatFiring' => '',
                        'HeatHotWater' => '',
                        'Telekom' => '',
                        'GasPower' => '',
                    ],
                    'LandDivisibility' => [
                        'code' => '',
                        'nameRu' => '',
                        'nameKz' => ''
                    ]
                ]
            ],
            'PersonalData' => [
                'IIN' => '',
                'Surname' => '',
                'Name' => '',
                'Middlename' => '',
                'BirthDate' => ''
            ],
            'JuridicalData' => [
                'BIN' => '',
                'NameKz' => '',
                'NameRu' => ''
            ],
            'WarrantData' => [
                'WarrantNumber' => '',
                'WarrantDate' => '',
                'NotaryName' => '',
                'Brief' => '',
                'Status' => '',
                'WarrantIIN' => ''
            ],
            'Phone' => ''
        ]
    ],
];
