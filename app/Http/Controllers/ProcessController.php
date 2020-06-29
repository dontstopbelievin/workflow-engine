<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FieldValue;
use App\Process;
use App\Template;
use Carbon\Carbon;

class ProcessController extends Controller
{
    public function index() {
        return view('process.index');
    }

    public function create() {
        $fields = FieldValue::all();
        $accepted = Template::where('accept_template', '1')->get();
        $rejected = Template::where('accept_template', '0')->get();
        return view('process.create')->with(compact('fields', 'accepted', 'rejected'));
    }

    public function store(Request $request) {

        $numberOfDays = intval($request->get('deadline'));
        $deadline = Carbon::now()->addDays($numberOfDays);
        $accepted_template_id = Template::where('name', $request->input('accepted_template'))->pluck('id');
        // dd($accepted_template_id[0]);
        $rejected_template_id = Template::where('name', $request->input('rejected_template'))->pluck('id');
        // dd($rejected_template_id[0]);
        $request->validate([
            'name' => 'required',
            'deadline' => 'required',
            'accepted_template' => 'required',
            'rejected_template' => 'required',
        ]);
        // dd($deadline);
        $process = new Process ([
            'name' => $request->get('name'),
            'deadline' => $numberOfDays,
            'deadline_until' => $deadline,
            'accepted_template_id'=> $accepted_template_id[0],
            'rejected_template_id'=> $rejected_template_id[0],
        ]);
        $process->save();
        $fields = FieldValue::all();
        // return view('process.create')->with(compact( 'fields'));
        return redirect()->back();
    }

    public function getfields(Request $request) {
        $choosenFields = $request->input('fields');
        return view('process.create')->with(compact('choosenFields'));
    }
    public function savefields(Request $request) {
        dd($request->all());
    }
}
