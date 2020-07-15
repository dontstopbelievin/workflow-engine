<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FieldValue;
use App\Process;
use App\Template;
use App\Handbook;
use App\Role;
use App\Route;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Redirect;

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
        $handbook = new Handbook;
        $columns = $handbook->getTableColumns();
        $columns = array_slice($columns, 0, -2);
        $accepted = Template::accepted()->get();
        $rejected = Template::rejected()->get();
        return view('process.create')->with(compact('accepted', 'rejected','columns'));
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
        // return view('process.create')->with(compact('id','columns'));
        $accepted = Template::accepted()->get();
        $rejected = Template::rejected()->get();
        return view('process.edit')->with(compact('process', 'accepted', 'rejected', 'columns'));
    }

    public function add(Process $process) {
        $accepted = Template::accepted()->get();
        $rejected = Template::rejected()->get();
        $handbook = new Handbook;
        $columns = $handbook->getTableColumns();
        $columns = array_slice($columns, 0, -2);
        $array = [];
        foreach ($process->routes as $route) {
            array_push($array, $route->name);
        }
        dd($array);
        return view('process.edit')->with(compact('process', 'accepted', 'rejected', 'columns'));
    }

    public function update(Request $request, Process $process) 
    {   
        $numberOfDays = intval($request->get('deadline'));
        $deadline = Carbon::now()->addDays($numberOfDays);
        $accepted_template_id = Template::where('name', $request->input('accepted_template'))->pluck('id');
        $rejected_template_id = Template::where('name', $request->input('rejected_template'))->pluck('id');
        $process->name = $request->input('name');
        $process->deadline = $request->input('deadline');
        $process->accepted_template_id = $accepted_template_id[0];
        $process->rejected_template_id = $rejected_template_id[0];
        $process->update();
        $accepted = Template::accepted()->get();
        $rejected = Template::rejected()->get();
        $handbook = new Handbook;
        $columns = $handbook->getTableColumns();
        $columns = array_slice($columns, 0, -2);
        return view('process.edit')->with(compact('process', 'accepted', 'rejected', 'columns'));
    }


    // public function getfields(Request $request) {
        
    //     $choosenFields = $request->input('fields');
    //     return view('processes.create')->with(compact('choosenFields'));
    // }
    public function savefields(Request $request, Process $process) {
        if (!$process->handbook()->exists()) {
            $handbook = new Handbook;
            $fields = $request->input('fields');
            foreach ($fields as $field) {
                if(Schema::hasColumn('handbooks', '$field')) ; //check whether handbooks table has columns in array
                {
                    $handbook->$field = 'exist';
                }
            }
            $handbook->process_id = $process->id;
            $handbook->active = 1;
            $handbook->save();
        }
        $arrayJson = json_encode($request->input('fields'));
        $process->fields = $arrayJson;
        $process->save();
        $accepted = Template::accepted()->get();
        $rejected = Template::rejected()->get();
        $roles = Role::all();
        return view('process.edit')->with(compact('process', 'accepted', 'rejected', 'roles'));
    }

    public function addRole(Request $request, Process $process) {
        $role_id = Role::where('name', $request->input('role'))->pluck('id');
        $route = new Route;
        $route->name = "Отправлено к ". $request->input('role');
        $route->role_id = $role_id[0];
        $route->process_id = $process->id;
        $route->save();
        return Redirect::route('processes.edit', [$process])->with('status', 'Роль добавлена к процессу');  
    } 
}
