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
        $columns = array_slice($columns, 1, -5);
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
        $accepted = Template::accepted()->get();
        $rejected = Template::rejected()->get();
        $array = [];
        foreach ($process->routes as $route) {
            array_push($array, $route->name);
        }
        $roles = Role::all();
        return view('process.edit')->with(compact('process', 'accepted', 'rejected', 'columns', 'array', 'roles'));
    }

    public function add(Process $process) {
        $accepted = Template::accepted()->get();
        $rejected = Template::rejected()->get();
        $handbook = new Handbook;
        $columns = $handbook->getTableColumns();
        $columns = array_slice($columns, 1, -4);
        $array = [];
        foreach ($process->routes as $route) {
            array_push($array, $route->name);
        }
        $roles = Role::all();
        return view('process.edit')->with(compact('process', 'accepted', 'rejected', 'columns', 'array', 'roles'));
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
        return Redirect::route('processes.edit', [$process])->with('status', 'Процесс был обновлен');
    }

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
        return Redirect::route('processes.edit', [$process])->with('status', 'Справочники успешно сохранены');
    }

    public function addRole(Request $request, Process $process) {
        $role_id = Role::where('name', $request->input('role'))->pluck('id');
        $route = new Route;
        $route->name = $request->input('role');
        $route->role_id = $role_id[0];
        $route->process_id = $process->id;
        $route->save();
        $process_routes = array();
        if (empty($process->process_routes )) {
            array_push($process_routes, $request->input('role'));
            $process->process_routes = json_encode($process_routes);
        } else {
            $decoded_process_routes = json_decode($process->process_routes);
            array_push($decoded_process_routes, $request->input('role'));
            $process->process_routes = json_encode($decoded_process_routes);
        }
        $process->save();
        return Redirect::route('processes.edit', [$process])->with('status', 'Роль добавлена к процессу');  
        
    } 

    public function delete(Process $process)
    {
        $process->routes()->delete();
        $process->handbook()->delete();
        $process->delete();
        return Redirect::route('processes.index')->with('status', 'Процесс успешно удален');  
    }
}
