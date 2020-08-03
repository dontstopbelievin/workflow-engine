<?php

namespace App\Http\Controllers;

use App\Role;

class RouteController extends Controller
{
    public function index() {
        return view('route.index');
    }

    public function create() {      
        $participants = Role::all();
        return view('route.create')->with('participants', $participants);
    }
}
