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
//            $auction = Auction::find($request->id);
//            $response = ShepRequestSender::send('geoportal_egkn_receive_layer', $auction->getDataForEgkn());
            $response = ShepRequestSender::send('geoportal_egkn_receive_layer', $this->tempMethodGetDataForEgkn());
            print_r($response);
        } catch( \Exception $e) {
            echo 'SHEP sending error: ' . $e->getMessage();
        }
        exit;
    }

    private function tempMethodGetDataForEgkn()
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
                        'AuctionDateTime' => '2020-10-20T17:17:25.497+06:00',
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
