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
        return view('process.index');
    }

    public function create() {
        $fields = FieldValue::all();
        $handbook = new Handbook;
        $columns = $handbook->getTableColumns();
        $columns = array_slice($columns, 0, -2);
        $accepted = Template::where('accept_template', '1')->get();
        $rejected = Template::where('accept_template', '0')->get();
        return view('process.create')->with(compact('fields', 'accepted', 'rejected','columns'));
    }

    public function store(Request $request) {
        // dd($request->input());
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
        // dd($id);
        return redirect()->back()->with( 'id', $id);
    }

    public function getfields(Request $request) {
        $choosenFields = $request->input('fields');
        return view('process.create')->with('choosenFields', $choosenFields);
        // return redirect('/process/create')->with(compact('choosenFields'));
    }
    public function savefields(Request $request) {
        $array = $request->input();
        dd($array);
        $remove=array_shift($array);
        dd($array);
        // 
    }
}
