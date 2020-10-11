<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $guarded = [];
    
    public function getDataForEgkn()
    {
        return array(
            'Request' => [
                'Auction' => [
                    'LotID' => $this->lot_id,
                    'EgknID' => $this->egkn_id,
                    'StatusZU' => $this->status_zu, // "free" - свободный ЗУ; "auction" - аукцион/торги
                    'LotNumber' => $this->lot_number,
                    'LotStatus' => $this->lot_status, //"1" - Предстоящий; "2" - Несостоявшийся; "3" - Состоявшийся
                    'Target' => [
                        'ID' => $this->target,
                        'NameRus' => $this->target,
                        'NameKaz' => $this->target
                    ],
                    'Purpose' => [
                        'ID' => $this->purpose,
                        'NameRus' => $this->purpose,
                        'NameKaz' => $this->purpose
                    ],
                    'RightType' => [
                        'ID' => '',
                        'NameRus' => $this->right_type,
                        'NameKaz' => $this->right_type
                    ],
                    'RentConditionsRus' => $this->rent_conditions_rus,
                    'RentConditionsKaz' => $this->rent_conditions_kaz,
                    'Area' => $this->area,
                    'CadastreCost' => $this->cadastre_cost,
                    'StartCost' => $this->start_cost,
                    'TaxCost' => $this->tax_cost,
                    'ParticipationCost' => $this->participation_cost,
                    'AuctionMethod' => $this->auction_method, //"1" - английский; "2" - голландский
                    'AuctionDate' => $this->auction_date_time,
                    'AuctionPlaceRus' => $this->auction_place_rus,
                    'AuctionPlaceKaz' => $this->auction_place_kaz,
                    'RequestAddressRus' => $this->request_address_rus,
                    'RequestAddressKaz' => $this->request_address_kaz,
                    'CommentRus' => $this->comment_rus,
                    'CommentKaz' => $this->comment_kaz,
                    'Seller' => [
                        'IINBIN' => $this->iin_bin,
                        'NameRus' => $this->name_rus,
                        'NameKaz' => $this->name_kaz
                    ],
                    'Customer' => [
                        'IINBIN' => $this->iin_bin,
                        'NameRus' => $this->name_rus,
                        'NameKaz' => $this->name_kaz
                    ],
                    'AddressRus' => $this->address_rus,
                    'AddressKaz' => $this->address_kaz,
                    'PublishDate' => $this->publish_date,
                    'Files' => [
                        'FileName' => $this->identification_doc, //with extension
                        'FileData' => $this->identification_doc
                    ],
                    'Coordinates' => $this->coordinates_1,
                    'CoordinateSystem' => $this->coordinate_system,
                    'AteID' => $this->ate_id,
                    'TechConditions' => [
                        'ElektrPower' => $this->elektr_power,
                        'ElektrFaza1' => $this->elektr_faza_1,
                        'ElektrFaza3' => $this->elektr_faza_3,
                        'WaterPower' => $this->water_power,
                        'WaterHoz' => $this->water_hoz,
                        'WaterProduction' => $this->water_production,
                        'SeweragePower' => $this->sewerage_power,
                        'SewerageFecal' => $this->sewerage_fecal,
                        'SewerageProduction' => $this->sewerage_production,
                        'SewerageClean' => $this->sewerage_clean,
                        'HeatPower' => $this->heat_power,
                        'HeatFiring' => $this->heat_firing,
                        'HeatVentilation' => $this->heat_ventilation,
                        'HeatHotWater' => $this->heat_hot_water,
                        'StormWater' => $this->storm_water,
                        'Telekom' => $this->telekom,
                        'GasPower' => $this->gas_power,
                        'GasOnCooking' => $this->gas_on_cooking,
                        'GasHeating' => $this->gas_heating,
                        'GasVentilation' => $this->gas_ventilation,
                        'GasConditioning' => $this->gas_conditioning,
                        'GasHotWater' => $this->gas_hot_water
                    ]
                ]
            ],
            'Signature' => true
        );
    }
}
