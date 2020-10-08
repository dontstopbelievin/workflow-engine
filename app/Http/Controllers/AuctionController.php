<?php

namespace App\Http\Controllers;

use App\Auction;
use App\Traits\dbQueries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AuctionController extends Controller
{
    use dbQueries;

    public function index() {
        $fields = Auction::all();
        return view('auction.index', compact('fields'));
    }

    public function create() {
        return view('auction.create');
    }

    public function store(Request $request) {

        $request->validate([
//            'IIN' => 'required',
//            'Surname' => 'required',
//            'FirstName' => 'required', // max size of 5 mb
//            'MiddleName' => 'required',
//            'PhoneNumber' => 'required',
//            'City' => 'required', // max size of 5 mb
//            'PurposeUse' => 'required',
//            'Cadastre' => 'required',
//            'Area' => 'required',
//            'IdentificationDoc' => ['required', 'file'],
//            'LegalDoc' => ['required', 'file'],
//            'SketchProject' => ['required', 'file'],
//            'SchemeZu' => ['required', 'file'],// max size of 5 mb
//            'ActCost' => ['required', 'file'],
        ]);
        $identificationDocPath = $request->Files->store('templates', 'public');
//        $legalDocPath = $request->LegalDoc->store('templates', 'public');
//        $sketchDocPath = $request->SketchProject->store('templates', 'public');
//        $schemeZuDocPath = $request->SchemeZu->store('templates', 'public');
//        $actCostDocPath = $request->ActCost->store('templates', 'public');

        $auction = new Auction;
        $auction->lot_id = $request->LotID;
        $auction->egkn_id = $request->EgknID;
        $auction->lot_status = $request->LotStatus;
        $auction->lot_number = $request->LotNumber;
        $auction->status_zu = $request->StatusZU;
        $auction->publish_date = $request->PublishDate;
        $auction->rent_lease = $request->RentLease;
        $auction->rent_conditions_rus = $request->RentConditionsRus;
        $auction->rent_conditions_kaz = $request->RentConditionsKaz;
        $auction->area = $request->Area;
        $auction->cadastre_cost = $request->CadastreCost;
        $auction->start_cost = $request->StartCost;
        $auction->tax_cost = $request->TaxCost;
        $auction->participation_cost = $request->ParticipationCost;
        $auction->auction_method = $request->AuctionMethod;
        $auction->auction_date_time = $request->AuctionDateTime;
        $auction->auction_place_rus = $request->AuctionPlaceRus;
        $auction->auction_place_kaz = $request->AuctionPlaceKaz;
        $auction->request_address_rus = $request->RequestAddressRus;
        $auction->request_address_kaz = $request->RequestAddressKaz;
        $auction->comment_rus = $request->CommentRus;
        $auction->comment_kaz = $request->CommentKaz;
        $auction->ate_id = $request->AteID;
        $auction->address_rus = $request->AddressRus;
        $auction->address_kaz = $request->AddressKaz;
        $auction->restrictions_and_burdens_rus = $request->RestrictionsAndBurdensRus;
        $auction->restrictions_and_burdens_kaz = $request->RestrictionsAndBurdensKaz;

        $auction->coordinates_1 = $request->Coordinates1;
        $auction->coordinates_2 = $request->Coordinates2;
        $auction->coordinates_3 = $request->Coordinates3;
        $auction->coordinates_4 = $request->Coordinates4;
        //        $auction->coordinates = $request->Coordinates;
        $auction->coordinate_system = $request->CoordinateSystem;

        $auction->instalment_selling = $request->InstalmentSelling;
        $auction->installment_period = $request->InstallmentPeriod;

        $auction->elektr_power = $request->ElektrPower;
        $auction->elektr_faza_1 = $request->ElektrFaza1;
        $auction->elektr_faza_3 = $request->ElektrFaza3;
        $auction->water_power = $request->WaterPower;
        $auction->water_hoz = $request->WaterHoz;
        $auction->water_production = $request->WaterProduction;
        $auction->sewerage_power = $request->SeweragePower;
        $auction->sewerage_fecal = $request->SewerageFecal;
        $auction->sewerage_production = $request->SewerageProduction;
        $auction->sewerage_clean = $request->SewerageClean;
        $auction->heat_power = $request->HeatPower;
        $auction->heat_firing = $request->HeatFiring;
        $auction->heat_ventilation = $request->HeatVentilation;
        $auction->heat_hot_water = $request->HeatHotWater;
        $auction->storm_water = $request->StormWater;
        $auction->telekom = $request->Telekom;
        $auction->gas_power = $request->GasPower;
        $auction->gas_on_cooking = $request->GasOnCooking;
        $auction->gas_heating = $request->GasHeating;
        $auction->gas_ventilation = $request->GasVentilation;
        $auction->gas_conditioning = $request->GasConditioning;
        $auction->gas_hot_water = $request->GasHotWater;

        $auction->iin_bin = $request->IINBIN;
        $auction->name_rus = $request->NameRus;
        $auction->name_kaz = $request->NameKaz;
        $auction->is_fl = $request->IsFl;

        $auction->target = $request->Target;
        $auction->purpose = $request->Purpose;
        $auction->right_type = $request->RightType;
        $auction->land_divisibility = $request->LandDivisibility;

        $auction->identification_doc = $identificationDocPath;
        $auction->save();
        return Redirect::route('auction.index')->with('status','Поля успешно сохранены');
    }

    public function prepareDataForEgkn(Request $request)
    {
        $aAuctionRaws = $this->getAuctionRaws($request->id);
//        dd($aAuctionRaws);
        return array(
            'Request' => [
                'Auction' => [
                    'LotID' => $aAuctionRaws[0]['lot_id'],
                    'EgknID' => $aAuctionRaws[0]['egkn_id'],
                    'StatusZU' => $aAuctionRaws[0]['status_zu'], // "free" - свободный ЗУ; "auction" - аукцион/торги
                    'LotNumber' => $aAuctionRaws[0]['lot_number'],
                    'LotStatus' => $aAuctionRaws[0]['lot_status'], //"1" - Предстоящий; "2" - Несостоявшийся; "3" - Состоявшийся
                    'Target' => [
                        'ID' => $aAuctionRaws[0]['target'],
                        'NameRus' => $aAuctionRaws[0]['target'],
                        'NameKaz' => $aAuctionRaws[0]['target']
                    ],
                    'Purpose' => [
                        'ID' => $aAuctionRaws[0]['purpose'],
                        'NameRus' => $aAuctionRaws[0]['purpose'],
                        'NameKaz' => $aAuctionRaws[0]['purpose']
                    ],
                    'RightType' => [
                        'ID' => '',
                        'NameRus' => $aAuctionRaws[0]['right_type'],
                        'NameKaz' => $aAuctionRaws[0]['right_type']
                    ],
                    'RentConditionsRus' => $aAuctionRaws[0]['rent_conditions_rus'],
                    'RentConditionsKaz' => $aAuctionRaws[0]['rent_conditions_kaz'],
                    'Area' => $aAuctionRaws[0]['area'],
                    'CadastreCost' => $aAuctionRaws[0]['cadastre_cost'],
                    'StartCost' => $aAuctionRaws[0]['start_cost'],
                    'TaxCost' => $aAuctionRaws[0]['tax_cost'],
                    'ParticipationCost' => $aAuctionRaws[0]['participation_cost'],
                    'AuctionMethod' => $aAuctionRaws[0]['auction_method'], //"1" - английский; "2" - голландский
                    'AuctionDate' => $aAuctionRaws[0]['auction_date_time'],
                    'AuctionPlaceRus' => $aAuctionRaws[0]['auction_place_rus'],
                    'AuctionPlaceKaz' => $aAuctionRaws[0]['auction_place_kaz'],
                    'RequestAddressRus' => $aAuctionRaws[0]['request_address_rus'],
                    'RequestAddressKaz' => $aAuctionRaws[0]['request_address_kaz'],
                    'CommentRus' => $aAuctionRaws[0]['comment_rus'],
                    'CommentKaz' => $aAuctionRaws[0]['comment_kaz'],
                    'Seller' => [
                        'IINBIN' => $aAuctionRaws[0]['iin_bin'],
                        'NameRus' => $aAuctionRaws[0]['name_rus'],
                        'NameKaz' => $aAuctionRaws[0]['name_kaz']
                    ],
                    'Customer' => [
                        'IINBIN' => $aAuctionRaws[0]['iin_bin'],
                        'NameRus' => $aAuctionRaws[0]['name_rus'],
                        'NameKaz' => $aAuctionRaws[0]['name_kaz']
                    ],
                    'AddressRus' => $aAuctionRaws[0]['address_rus'],
                    'AddressKaz' => $aAuctionRaws[0]['address_kaz'],
                    'PublishDate' => $aAuctionRaws[0]['publish_date'],
                    'Files' => [
                        'FileName' => $aAuctionRaws[0]['identification_doc'], //with extension
                        'FileData' => $aAuctionRaws[0]['identification_doc']
                    ],
                    'Coordinates' => $aAuctionRaws[0]['coordinates_1'],
                    'CoordinateSystem' => $aAuctionRaws[0]['coordinate_system'],
                    'AteID' => $aAuctionRaws[0]['ate_id'],
                    'TechConditions' => [
                        'ElektrPower' => $aAuctionRaws[0]['elektr_power'],
                        'ElektrFaza1' => $aAuctionRaws[0]['elektr_faza_1'],
                        'ElektrFaza3' => $aAuctionRaws[0]['elektr_faza_3'],
                        'WaterPower' => $aAuctionRaws[0]['water_power'],
                        'WaterHoz' => $aAuctionRaws[0]['water_hoz'],
                        'WaterProduction' => $aAuctionRaws[0]['water_production'],
                        'SeweragePower' => $aAuctionRaws[0]['sewerage_power'],
                        'SewerageFecal' => $aAuctionRaws[0]['sewerage_fecal'],
                        'SewerageProduction' => $aAuctionRaws[0]['sewerage_production'],
                        'SewerageClean' => $aAuctionRaws[0]['sewerage_clean'],
                        'HeatPower' => $aAuctionRaws[0]['heat_power'],
                        'HeatFiring' => $aAuctionRaws[0]['heat_firing'],
                        'HeatVentilation' => $aAuctionRaws[0]['heat_ventilation'],
                        'HeatHotWater' => $aAuctionRaws[0]['heat_hot_water'],
                        'StormWater' => $aAuctionRaws[0]['storm_water'],
                        'Telekom' => $aAuctionRaws[0]['telekom'],
                        'GasPower' => $aAuctionRaws[0]['gas_power'],
                        'GasOnCooking' => $aAuctionRaws[0]['gas_on_cooking'],
                        'GasHeating' => $aAuctionRaws[0]['gas_heating'],
                        'GasVentilation' => $aAuctionRaws[0]['gas_ventilation'],
                        'GasConditioning' => $aAuctionRaws[0]['gas_conditioning'],
                        'GasHotWater' => $aAuctionRaws[0]['gas_hot_water']
                    ]
                ]
            ],
            'Signature' => true
        );
    }
}
