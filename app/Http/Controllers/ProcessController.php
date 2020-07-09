<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FieldValue;
use App\Process;
use App\Template;
use App\Handbook;
use Carbon\Carbon;

class ProcessController extends Controller
{
    public function index() {
        $processes = Process::all();
        return view('process.index')->with(compact('processes'));
    }

    public function view(Process $process) {
        return view('process.view')->with(compact('process'));
    }

    public function create() {
        $fields = FieldValue::all();
        $handbook = new Handbook;
        $columns = $handbook->getTableColumns();
        $columns = array_slice($columns, 0, -2);
        $accepted = Template::accepted()->get();
        $rejected = Template::rejected()->get();
        return view('process.create')->with(compact('fields', 'accepted', 'rejected','columns'));
    }

    public function store(Request $request) {
        $numberOfDays = intval($request->get('deadline'));
        $deadline = Carbon::now()->addDays($numberOfDays);
        $accepted_template_id = Template::where('name', $request->input('accepted_template'))->pluck('id');
        $rejected_template_id = Template::where('name', $request->input('rejected_template'))->pluck('id');
        
        $request->validate([
            'name' => 'required',
            'deadline' => 'required',
            'accepted_template' => 'required',
            'rejected_template' => 'required',
        ]);
        $process = new Process ([
            'name' => $request->get('name'),
            'deadline' => $numberOfDays,
            'deadline_until' => $deadline,
            'accepted_template_id'=> $accepted_template_id[0],
            'rejected_template_id'=> $rejected_template_id[0],
        ]);
        $process->save();
        $id = $process->id;
        $handbook = new Handbook;
        $columns = $handbook->getTableColumns();
        $columns = array_slice($columns, 0, -2);
        return view('process.create')->with(compact('id','columns'));
    }
    public function edit(Process $process) {
        return view('process.edit')->with(compact('$process'));
    }

    public function update(Request $request, Process $process) {
        
    }

    public function getfields(Request $request) {
        
        $choosenFields = $request->input('fields');
        return view('process.create')->with(compact('choosenFields'));;
    }
    public function savefields(Request $request) {
        $arrayJson = json_encode($request->input('fields'));
        $process = Process::find($request->input('id'));
        $process->fields = $arrayJson;
        $process->save();
        return redirect('/processes');
    }
}
