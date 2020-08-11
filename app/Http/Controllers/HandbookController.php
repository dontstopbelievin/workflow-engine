<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Handbook;

class HandbookController extends Controller
{
    public function index() {
        $handbook = new Handbook;
        $columns = $handbook->getTableColumns();
        $columns = array_slice($columns, 0, -4);
        return view('manual.index')->with(compact( 'columns'));
    }
}
