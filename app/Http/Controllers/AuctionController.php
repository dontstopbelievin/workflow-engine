<?php

namespace App\Http\Controllers;

use App\Auction;
use App\Traits\dbQueries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Integrations\shep\sender\ShepRequestSender;

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

    public function sendToEgkn(Request $request)
    {
        try {
            $auction = Auction::find($request->id);
            $response = ShepRequestSender::send('geoportal_egkn_receive_layer', $auction->getDataForEgkn());
            print_r($response);
        } catch( \Exception $e) {
            echo $e->getMessage();
            log($e->getMessage());
        }
        exit;
    }
}
