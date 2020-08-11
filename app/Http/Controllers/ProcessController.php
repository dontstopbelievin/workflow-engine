<?php

namespace App\Http\Controllers;

use App\Process;
use App\Template;
use App\Handbook;
use App\Role;
use App\Route;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $acceptedTemplateIds = Template::where('name', $request->input('accepted_template'))->pluck('id');
        $rejectedTemplateIds = Template::where('name', $request->input('rejected_template'))->pluck('id');
        
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
            'accepted_template_id'=> $acceptedTemplateIds[0],
            'rejected_template_id'=> $rejectedTemplateIds[0],
        ]);
        $process->save();
        $id = $process->id;
        $handbook = new Handbook;
        $columns = $handbook->getTableColumns();
        $columns = array_slice($columns, 1, -4);
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
        $roles = Role::all();
        $subRoles = $this->getSubRoutes($process);
        $parentRoleId = DB::table('process_role')
        ->select('parent_role_id')
        ->where('process_id', $process->id)
        ->Where('parent_role_id', '<>' ,'null')
        ->limit(1)
        ->get()->toArray();
        $json  = json_encode($parentRoleId);
        $arrayId = json_decode($json, true);
        $parentId = intval($arrayId[0]['parent_role_id']);
        
        $sAllRoles = array();

        foreach($process->roles as $key => $value) {
            $sAllRoles[$value->name] = $value->id;
            // dd($sAllRoles);
            $sTmp = $this->getSubRoutes($process);
            if ($value->id == $parentId) {
                foreach ($sAllRoles as $sKey => $sVal) {
                    $sAllRoles[$sKey] = $sTmp;
                } 
            }
        }
        
        // dd($sAllRoles);
        $subRoles = Role::with('children')->get();

        return view('process.edit')->with(compact('process', 'accepted', 'rejected', 'columns', 'roles','sAllRoles'));
    }

    public function update(Request $request, Process $process) {   
        $numberOfDays = intval($request->get('deadline'));
        $deadline = Carbon::now()->addDays($numberOfDays);
        $acceptedTemplateIds = Template::where('name', $request->input('accepted_template'))->pluck('id');
        $rejectedTemplateIds = Template::where('name', $request->input('rejected_template'))->pluck('id');
        $process->name = $request->input('name');
        $process->deadline = $request->input('deadline');
        $process->accepted_template_id = $acceptedTemplateIds[0];
        $process->rejected_template_id = $rejectedTemplateIds[0];
        $process->update();
        return Redirect::route('processes.edit', [$process])->with('status', 'Процесс был обновлен');
    }

    public function saveFields(Request $request, Process $process) {

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

        $roleIds = Role::where('name', $request->input('role'))->pluck('id');
        $role = Role::where('name', $request->role)->first();
        $route = new Route;
        $route->name = $request->input('role');
        $route->role_id = $roleIds[0];
        $route->process_id = $process->id;
        $route->save();
        $process->roles()->attach($role);
        $process->save();
        return Redirect::route('processes.edit', [$process])->with('status', 'Маршрут добавлен к процессу');
        
    }

    public function addSubRoles(Request $request) {

        $parentRoleId = Role::where('name', $request->input('roleToAdd'))->pluck('id');
        $process = Process::find($request->input('processId'));
        $subRoutes = $request->input('subRoles');
        foreach($subRoutes as $route) {
            $mRole = Role::where('name', $route)->get();
            $process->roles()->attach($mRole, [
                'parent_role_id' => $parentRoleId[0],
            ]);
        }
        return 'done';
    }

    public function delete(Process $process) {

        $process->routes()->delete();
        $process->handbook()->delete();
        $process->delete();
        return Redirect::route('processes.index')->with('status', 'Процесс успешно удален');  
    }

    public function getSubRoutes($process) {
        $routes = DB::table('roles')
        ->join('process_role', 'roles.id','=','process_role.role_id')
        ->select('name')
        ->where('process_role.process_id',$process->id)
        ->where('process_role.parent_role_id', '<>','null')
        ->get()->toArray();

        $json  = json_encode($routes);
        $array = json_decode($json, true);
        $res = array();
        foreach($array as  $arr) {
            foreach($arr as $key => $value) {
                array_push($res, $value);
            }
        }
        return $res;
    }
}
