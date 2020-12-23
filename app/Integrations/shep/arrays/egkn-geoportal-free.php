<?php

$data = [
    'Request' => [
        'Auction' => [
            'LotID' => '',
            'EgknID' => '',
            'StatusZU' => '', // "free" - свободный ЗУ; "auction" - аукцион/торги
            'LotNumber' => '',
            'LotStatus' => '', //"1" - Предстоящий; "2" - Несостоявшийся; "3" - Состоявшийся
            'Target' => [
                'ID' => '',
                'NameRus' => '',
                'NameKaz' => ''
            ],
            'Purpose' => [
                'ID' => '',
                'NameRus' => '',
                'NameKaz' => ''
            ],
            'RightType' => [
                'ID' => '',
                'NameRus' => '',
                'NameKaz' => ''
            ],
            'RentConditionsRus' => '',
            'RentConditionsKaz' => '',
            'Area' => '',
            'CadastreCost' => '',
            'StartCost' => '',
            'TaxCost' => '',
            'ParticipationCost' => '',
            'AuctionMethod' => '', //"1" - английский; "2" - голландский
            'AuctionDate' => '',
            'AuctionPlaceRus' => '',
            'AuctionPlaceKaz' => '',
            'RequestAddressRus' => '',
            'RequestAddressKaz' => '',
            'CommentRus' => '',
            'CommentKaz' => '',
            'Seller' => [
                'IINBIN' => '',
                'NameRus' => '',
                'NameKaz' => ''
            ],
            'Customer' => [
                'IINBIN' => '',
                'NameRus' => '',
                'NameKaz' => ''
            ],
            'AddressRus' => '',
            'AddressKaz' => '',
            'PublishDate' => '',
            'Files' => [
                'FileName' => '', //with extension
                'FileData' => ''
            ],
            'Coordinates' => '',
            'CoordinateSystem' => '',
            'AteID' => '',
            'TechConditions' => [
                'ElektrPower' => '',
                'ElektrFaza1' => '',
                'ElektrFaza3' => '',
                'WaterPower' => '',
                'WaterHoz' => '',
                'WaterProduction' => '',
                'SeweragePower' => '',
                'SewerageFecal' => '',
                'SewerageProduction' => '',
                'SewerageClean' => '',
                'HeatPower' => '',
                'HeatFiring' => '',
                'HeatVentilation' => '',
                'HeatHotWater' => '',
                'StormWater' => '',
                'Telekom' => '',
                'GasPower' => '',
                'GasOnCooking' => '',
                'GasHeating' => '',
                'GasVentilation' => '',
                'GasConditioning' => '',
                'GasHotWater' => ''
            ]
        ]
    ],
    'Signature' => true
];