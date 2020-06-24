<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FieldValue;
use App\Process;
use Carbon\Carbon;

class ProcessController extends Controller
{
    public function index() {
        return view('process.index');
    }

    public function create() {
        $fields = FieldValue::all();
        return view('process.create')->with('fields', $fields);
    }

    public function store(Request $request) {
        $numberOfDays = intval($request->get('deadline'));
        $deadline = Carbon::now()->addDays($numberOfDays);
        $request->validate([
            'name' => 'required',
            'deadline' => 'required',
        ]);
        $process = new Process ([
            'name' => $request->get('name'),
            'deadline' => $numberOfDays,
            'deadline_until' => $deadline
        ]);
        $process->save();
        $fields = FieldValue::all();
        return view('process.create')->with(compact( 'fields'));
    }

    public function getfields(Request $request) {
        $choosenFields = $request->input('fields');
        return view('process.create')->with(compact('choosenFields'));
    }
    public function savefields(Request $request) {
        dd($request->all());
    }
}
