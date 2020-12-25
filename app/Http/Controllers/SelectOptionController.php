<?php

namespace App\Http\Controllers;

use App\SelectOption;
use Illuminate\Http\Request;

class SelectOptionController extends Controller
{
   public function create() {

       $selectOptions = SelectOption::all();
       return view('select-options.create',compact('selectOptions'));
   }

    public function store(Request $request) {

        $item = new SelectOption;
        $item->name = $request->text;
        $item->save();
    }

    public function delete(Request $request) {
        SelectOption::where('id', $request->id)->delete();
    }

    public function update(Request $request) {

        $item = SelectOption::find($request->id);
        $item->name = $request->value;
        $item->update();
    }
}
