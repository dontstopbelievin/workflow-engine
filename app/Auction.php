<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $guarded = [];
    
    public function getDataForEgkn()
    {
        return [
            'Request' => [
                'BusinessData' => [
                    'LayerCode' => 'FREE_LAND',
                    'Auction' => [
                        'LotID' => '2404_006',
                        'EgknID' => '',
                        'StatusZU' => 'auction', // "free" - свободный ЗУ; "auction" - аукцион/торги
                        'LotNumber' => '14',
                        'LotStatus' => 1, //"1" - Предстоящий; "2" - Несостоявшийся; "3" - Состоявшийся
                        'Target' => [
                            'ID' => '7020100100',
                            'NameRus' => 'Индивидуальный жилой дом',
                            'NameKaz' => 'Жеке тұрғын үй'
                        ],
                        'Purpose' => [
                            'ID' => '37',
                            'NameRus' => 'строительство',
                            'NameKaz' => 'құрылыс салу'
                        ],
                        'RightType' => [
                            'ID' => '10',
                            'NameRus' => 'временное возмездное долгосрочное землепользование',
                            'NameKaz' => 'Уақытша (ұзақ уақыт) жерді пайдалану құқығы'
                        ],
                        'LandDivisibility' => [
                            'ID' => 'divis_y',
                            'NameRus' => 'Частная собственность',
                            'NameKaz' => 'Жеке меншік'
                        ],
                        'RentConditionsRus' => 'Право аренды сроком на 3 года',
                        'RentConditionsKaz' => 'Право аренды сроком на 3 года',
                        'RentLease' => '2022-07-30',
                        'Area' => '0.98',
                        'CadastreCost' => '4850000.0',
                        'StartCost' => '291000.0',
                        'TaxCost' => '101300.0',
                        'ParticipationCost' => '115450.0',
                        'AuctionMethod' => '1', //"1" - английский; "2" - голландский
                        'AuctionDate' => '2020-10-12T17:17:25.497+06:00',
                        'AuctionPlaceRus' => 'Акимат города Астана',
                        'AuctionPlaceKaz' => 'Астана қаласының әкімдігі',
                        'RequestAddressRus' => 'Улица Алтынсарина, 2',
                        'RequestAddressKaz' => 'Алтынсарина көшесі, 2',
                        'CommentRus' => 'Акт согласован',
                        'CommentKaz' => 'Акт согласован',
                        'Seller' => [
                            'IINBIN' => '020340002753',
                            'IsFl' => 'false',
                            'NameRus' => 'ГУ АППАРАТ АКИМА ГОРОДА НУР-СУЛТАН',
                            'NameKaz' => 'ГУ АППАРАТ АКИМА ГОРОДА НУР-СУЛТАН (каз.яз.)'
                        ],
                        'AddressRus' => 'Астана, мкр. Промышленный',
                        'AddressKaz' => 'Астана қ., Промышленный ауд.',
                        'PublishDate' => '2020-10-10',
                        'Coordinates' => 'MULTIPOLYGON(((5180471.87897782 7195642.55024562,5180481.43360635 7195986.5168729,5180963.9423474 7195943.52104449,5180973.49697594 7195671.21413122,5180471.87897782 7195642.55024562)))',
                        'CoordinateSystem' => '32642',
                        'AteID' => '68402',
                        'NoteRus' => 'примечание рус',
                        'NoteKaz' => 'примечание каз',
                        'RestrictionsAndBurdensRus' => 'ограничений нет',
                        'RestrictionsAndBurdensKaz' => 'ограничений нет',
                        'InstalmentSelling' => '1',
                        'InstallmentPeriod' => '12',
                        'TechConditions' => [
                            'ElektrPower' => '25',
                            'ElektrFaza1' => '111',
                            'ElektrFaza3' => '333',
                            'WaterPower' => '444',
                            'WaterHoz' => '5555',
                            'WaterProduction' => '66',
                            'SeweragePower' => '777',
                            'SewerageFecal' => '88',
                            'SewerageProduction' => '999',
                            'SewerageClean' => '1010',
                            'HeatPower' => '11',
                            'HeatFiring' => '12',
                            'HeatVentilation' => '1313',
                            'HeatHotWater' => '14140',
                            'StormWater' => 'Есть',
                            'Telekom' => 'Есть',
                            'GasPower' => '1515',
                            'GasOnCooking' => '1616',
                            'GasHeating' => '171',
                            'GasVentilation' => '1818',
                            'GasConditioning' => '19',
                            'GasHotWater' => '2020'
                        ]
                    ]
                ]
            ]
        ];
    }
}
