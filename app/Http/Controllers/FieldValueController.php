<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FieldValue;
use App\Handbook;

class FieldValueController extends Controller
{
    public function index() {
        $fieldValue = FieldValue::all();
        $handbook = new Handbook;
        $columns = $handbook->getTableColumns();
        $columns = array_slice($columns, 0, -2);
        return view('manual.index')->with(compact('fieldValue', 'columns'));
    }

    public function create() {
        return view('manual.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name'=>'required',
        ]);

        $field = new FieldValue([
            'name' => $request->get('name')
        ]);
        $field->save();
        return redirect('/manual')->with('status', 'Поле успешно создано');
    }
    public function edit($id) {
        $fieldValue = FieldValue::findOrFail($id);
        return view('manual.edit')->with('fieldValue', $fieldValue);
    }

    public function update(Request $request, $id) 
    {
      $field = FieldValue::find($id);
      $field->name = $request->input('name');
      $field->update();
      return redirect('/manual')->with('status','Поле успешно обновлено');
    }

    public function delete($id)
    {
        $value = FieldValue::findOrFail($id);
        $value->delete();
        return redirect('/manual')->with('status','Поле успешно создано');
    }
}
