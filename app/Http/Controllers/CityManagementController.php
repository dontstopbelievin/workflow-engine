<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CityManagement;

class CityManagementController extends Controller
{
    public function index() {

        $cityManagements = CityManagement::all();
        return view('city.index', compact('cityManagements'));
    }

    public function create(Request $request) {
        
        $cityManagement = new CityManagement;
        $cityManagement->name = $request->text;
        $cityManagement->save();
        return 'Done';
    }

    public function delete(Request $request) {
        CityManagement::where('id', $request->id)->delete();
    }

    public function update(Request $request) {

        $cityManagement = CityManagement::find($request->id);
        $cityManagement->name = $request->value;
        $cityManagement->update();
        return $request->all();
    }
}
