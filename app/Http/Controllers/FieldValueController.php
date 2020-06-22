<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FieldValue;

class FieldValueController extends Controller
{
    public function index() {
        $fieldValue = FieldValue::all();
        return view('manual.index')->with('fieldValue', $fieldValue);
    }

    public function create() {
        return view('manual.create');
    }

    public function store(Request $request) {
        $request->validate([
            'field_name'=>'required',
        ]);

        $field = new FieldValue([
            'field_name' => $request->get('field_name')
        ]);
        $field->save();
        return redirect('/manual')->with('status', 'Field was succesfully Added');
    }
    public function edit($id) {
        $fieldValue = FieldValue::findOrFail($id);
        return view('manual.edit')->with('fieldValue', $fieldValue);
    }

    public function update(Request $request, $id) 
    {
      $field = FieldValue::find($id);
      $field->field_name = $request->input('field_name');
      $field->update();
      return redirect('/manual')->with('status','Your Data Is Updated');
    }

    public function delete($id)
    {
        $value = FieldValue::findOrFail($id);
        $value->delete();
        return redirect('/manual')->with('status','Your Data Is Deleted');
    }
}
