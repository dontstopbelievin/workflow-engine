<?php

namespace App\Http\Controllers;

use App\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AuctionController extends Controller
{
    public function index() {
        $fields = Auction::all();
        return view('auction.index', compact('fields'));
    }

    public function create() {
        return view('auction.create');
    }

    public function store(Request $request) {

        $request->validate([
            'IIN' => 'required',
            'Surname' => 'required',
            'FirstName' => 'required', // max size of 5 mb
            'MiddleName' => 'required',
            'PhoneNumber' => 'required',
            'City' => 'required', // max size of 5 mb
            'PurposeUse' => 'required',
            'Cadastre' => 'required',
            'Area' => 'required',
            'IdentificationDoc' => ['required', 'file'],
            'LegalDoc' => ['required', 'file'],
            'SketchProject' => ['required', 'file'],
            'SchemeZu' => ['required', 'file'],// max size of 5 mb
            'ActCost' => ['required', 'file'],
        ]);
        $identificationDocPath = $request->IdentificationDoc->store('templates', 'public');
        $legalDocPath = $request->LegalDoc->store('templates', 'public');
        $sketchDocPath = $request->SketchProject->store('templates', 'public');
        $schemeZuDocPath = $request->SchemeZu->store('templates', 'public');
        $actCostDocPath = $request->ActCost->store('templates', 'public');

        $auction = new Auction;
        $auction->iin = $request->IIN;
        $auction->surname = $request->Surname;
        $auction->first_name = $request->FirstName;
        $auction->middle_name = $request->MiddleName;
        $auction->phone_number = $request->PhoneNumber;
        $auction->purpose_use = $request->PurposeUse;
        $auction->city = $request->City;
        $auction->cadastre = $request->Cadastre;
        $auction->area = $request->Area;
        $auction->identification_doc = $identificationDocPath;
        $auction->legal_doc = $legalDocPath;
        $auction->sketch_doc = $sketchDocPath;
        $auction->scheme_zu_doc = $schemeZuDocPath;
        $auction->act_cost_doc = $actCostDocPath;
        $auction->save();
        return Redirect::route('auction.index')->with('status','Поля успешно сохранены');
    }
}
