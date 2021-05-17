<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CityManagement;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class CityManagementController extends Controller
{
    public function index() {

        $cityManagements = CityManagement::all();
        return view('city.index', compact('cityManagements'));
    }

    public function create(Request $request) {

        $validator = Validator::make($request->all(),[
            'text' => ['required', 'unique:App\CityManagement,name','max:191'],
        ]);
        if ($validator->fails()) {
          return Response::json(array(
              'error' => $validator->getMessageBag()->toArray()
          ), 400);
        }
        $cityManagement = new CityManagement;
        $cityManagement->name = $request->text;
        $cityManagement->save();
        return 'Done';
    }

    public function delete(Request $request) {
        $maxID = CityManagement::max('id');
        $validator = Validator::make($request->all(),[
            'id' => 'require|max:' . $maxID,
        ]);
        if ($validator->fails()) {
          return Response::json(array(
              'error' => $validator->getMessageBag()->toArray()
          ), 400);
        }
        CityManagement::where('id', $request->id)->delete();
    }  // HERE!!!

    public function update(Request $request) {
        $maxID = CityManagement::max('id');
        $validator = Validator::make($request->all(),[
            'id' => ['required', 'max:'.$maxID ],
            'value' => ['required', 'unique:App\CityManagement,name','max:191'],
        ]);

        if ($validator->fails()) {
          return Response::json(array(
              'error' => $validator->getMessageBag()->toArray()
          ), 400);
        }
        $cityManagement = CityManagement::find($request->id);
        $cityManagement->name = $request->value;
        $cityManagement->update();
        return $request->all();
    }  // HERE!!!
}
