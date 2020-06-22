<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProcessController extends Controller
{
    public function index() {
        return view('process.index');
    }

    public function create() {
        return view('process.create');
    }
}
