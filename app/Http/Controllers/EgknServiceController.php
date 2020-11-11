<?php

namespace App\Http\Controllers;

use App\EgknService;
use Illuminate\Http\Request;
use App\Traits\dbQueries;
use Illuminate\Support\Facades\Redirect;

class EgknServiceController extends Controller
{
    use dbQueries;

    public function index()
    {
        $aFields = EgknService::all();
        return view('egknservice.index', compact('aFields'));
    }

    public function view(Request $request)
    {
        $aFields = EgknService::where('id', $request->id)->get()->toArray();
        return view('egknservice.view', compact('aFields'));
    }

    public function load()
    {
        return Redirect::back();
    }

    public function status(Request $request)
    {
        $aField = EgknService::where('id', $request->id)->first();
        $aField->egkn_status = 'Зарегистрировано';
        $aField->update();
        return Redirect::back();
    }

    public function act(Request $request)
    {
        dd($request->id);
    }

}
