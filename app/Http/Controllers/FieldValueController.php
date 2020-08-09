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

}
