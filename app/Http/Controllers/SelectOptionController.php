<?php

namespace App\Http\Controllers;

use App\SelectOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class SelectOptionController extends Controller
{
   public function create() {

       $selectOptions = SelectOption::all();
       return view('select-options.create',compact('selectOptions'));
   }

    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'text' => ['required', 'min:3'],
        ]);
        if ($validator->fails()) {
          return Response::json(array(
              'error' => $validator->getMessageBag()->toArray()
          ), 400);
        }
        $item = new SelectOption;
        $item->name = $request->text;
        $item->save();
    }

    public function delete(Request $request) {
        $validator = Validator::make($request->all(),[
            'id' => ['required'],
        ]);
        if ($validator->fails()) {
          return Response::json(array(
              'error' => $validator->getMessageBag()->toArray()
          ), 400);
        }
        SelectOption::where('id', $request->id)->delete();
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(),[
            'id' => ['required'],
            'value' => ['required', 'min:3'],
        ]);
        if ($validator->fails()) {
          return Response::json(array(
              'error' => $validator->getMessageBag()->toArray()
          ), 400);
        }
        $item = SelectOption::find($request->id);
        $item->name = $request->value;
        $item->update();
    }
}
