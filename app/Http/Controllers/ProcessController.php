<?php

namespace App\Http\Controllers;

use App\Process;
use App\Template;
use App\Handbook;
use App\Role;
use App\Route;
use App\CityManagement;
use App\Traits\dbQueries;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Redirect;

class ProcessController extends Controller
{
    use dbQueries;

    public function index() {

        $processes = Process::all();
        return view('process.index', compact('processes'));
    }

    public function view(Process $process) {

        $parentId = $this->getParentRoleId($process->id);
        if ($parentId === 0) {
            return view('process.view', compact('process'));
        } 
        $iterateRoles = $this->getIterateRoles($process);
        $sAllRoles = $this->getAllRoles($process, $parentId, $iterateRoles);
        return view('process.view', compact('process','sAllRoles'));
    }

    public function create() {

        $handbook = new Handbook;
        $columns = $handbook->getTableColumns();
        $columns = array_slice($columns, 1, -5);
        $accepted = Template::accepted()->get();
        $rejected = Template::rejected()->get();
        return view('process.create', compact('accepted', 'rejected','columns'));
    }

    public function store(Request $request) {

        $numberOfDays = intval($request->get('deadline'));
        $deadline = Carbon::now()->addDays($numberOfDays);
        $acceptedTemplate = Template::where('name', $request->accepted_template)->first();
        $rejectedTemplate = Template::where('name', $request->rejected_template)->first();

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
            'accepted_template_id'=> $acceptedTemplate->id,
            'rejected_template_id'=> $rejectedTemplate->id,
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
        $organizations = CityManagement::all();
        $mainOrg = CityManagement::find($process->main_organization_id);
        if (empty($mainOrg)) {
            return view('process.edit', compact('process', 'accepted', 'rejected', 'columns', 'array', 'roles', 'organizations', 'nameMainOrg'));
        }
        $nameMainOrg = $mainOrg->name;
        return view('process.edit', compact('process', 'accepted', 'rejected', 'columns', 'array', 'roles', 'organizations', 'nameMainOrg'));
    }

    public function edit(Process $process) {

        $accepted = Template::accepted()->get();
        $rejected = Template::rejected()->get();
        $columns = $this->getAllDictionaries();;
        $roles = Role::all();
        $tableName = $this->translateSybmols($process->name);
        $tableName = str_replace(' ', '_', $tableName);
        $tableColumns = Schema::getColumnListing($tableName);
//        dd($tableColumns);
        $parentId = $this->getParentRoleId($process->id);
        $organizations = CityManagement::all();
        $mainOrg = CityManagement::find($process->main_organization_id);
        if (empty($mainOrg)) {
            return view('process.edit', compact('process', 'accepted','tableColumns', 'rejected', 'columns', 'array', 'roles', 'organizations', 'nameMainOrg'));
        }
        $nameMainOrg = $mainOrg->name;
        if (empty($organizations)) {
            echo 'Добавьте организации';
            return;
        }
        if ($parentId === 0) {
            return view('process.edit', compact('process', 'accepted','tableColumns', 'rejected', 'columns', 'roles','organizations','nameMainOrg'));
        }

        $iterateRoles = $this->getIterateRoles($process);
        $sAllRoles = $this->getAllRoles($process, $parentId,$iterateRoles);
        return view('process.edit', compact('process', 'accepted','tableColumns', 'rejected', 'columns', 'roles','sAllRoles', 'organizations', 'nameMainOrg'));
    }

    public function update(Request $request, Process $process) {   

        $numberOfDays = intval($request->get('deadline'));
        $deadline = Carbon::now()->addDays($numberOfDays);
        $acceptedTemplate = Template::where('name', $request->accepted_template)->first();
        $rejectedTemplate = Template::where('name', $request->rejected_template)->first();
        $process->name = $request->name;
        $process->deadline = $request->deadline;
        $process->accepted_template_id = $acceptedTemplate->id;
        $process->rejected_template_id = $rejectedTemplate->id;
        $process->update();
        return Redirect::route('processes.edit', [$process])->with('status', 'Процесс был обновлен');
    }

    public function createProcessTable(Request $request, Process $process) {
        $processName = $process->name;
        $fields = $request->fields;
        $tableName = $this->translateSybmols($processName);
        $tableName = str_replace(' ', '_', $tableName);
        if (!Schema::hasTable($tableName)) {
            $dbQueryString = "CREATE TABLE $tableName (id INT PRIMARY KEY AUTO_INCREMENT)";
            DB::statement($dbQueryString);
        }
        foreach($fields as $fieldName) {
            if($this->isRussian($fieldName)) {
                $fieldName = $this->translateSybmols($fieldName);
                $fieldName = str_replace(' ', '_', $fieldName);
            } ;
            if (Schema::hasColumn($tableName, $fieldName)) {
                continue;
            } else {
                $dbQueryString = "ALTER TABLE $tableName ADD COLUMN $fieldName varchar(255)";
                DB::statement($dbQueryString);
            }
        }
        if (!Schema::hasColumn($tableName, 'process_id')) {
            $dbQueryString = "ALTER TABLE $tableName ADD  process_id INT";
            DB::statement($dbQueryString);
            DB::table($tableName)->insert(
                [ 'process_id' => $process->id]
            );
        }



//        dd('done im here');


//        if (!$process->handbook()->exists()) {
//            $handbook = new Handbook;
//            $fields = $request->fields;
//            foreach ($fields as $field) {
//                if(Schema::hasColumn('handbooks', '$field')) ; //check whether handbooks table has columns in array
//                {
//                    $handbook->$field = 'exist';
//                }
//            }
//            $handbook->process_id = $process->id;
//            $handbook->active = 1;
//            $handbook->save();
//        }
//        $arrayJson = json_encode($request->fields);
//        $process->fields = $arrayJson;
//        $process->save();
        return Redirect::route('processes.edit', [$process])->with('status', 'Справочники успешно сохранены');
    }
    public function isRussian($text) {
        return preg_match('/[А-Яа-яЁё]/u', $text);
    }

    public function addRole(Request $request, Process $process) {

        $role = Role::where('name', $request->role)->first();
        $route = new Route;
        $route->name = $request->role;
        $route->role_id = $role->id;
        $route->process_id = $process->id;
        $route->save();
        $process->roles()->attach($role);
        $process->save();
        return Redirect::route('processes.edit', [$process])->with('status', 'Маршрут добавлен к процессу'); 
    }

    public function addOrganization(Request $request, Process $process) {

        $organization = CityManagement::where('name', $request->mainOrganization)->first();
        $process->main_organization_id = $organization->id;
        $process->update();
        return Redirect::route('processes.edit', [$process])->with('status', 'Осносвной Маршрут Выбран успешно');
    }

    public function addSubRoles(Request $request) {

        $parentRole = Role::where('name', $request->roleToAdd)->first();
        $process = Process::find($request->processId);
        $subRoutes = $request->subRoles;
        $supportOrganization = CityManagement::where('name', $request->subOrg)->first();
        $process->support_organization_id = $supportOrganization->id;
        foreach($subRoutes as $route) {
            $mRole = Role::where('name', $route)->get();
            $process->roles()->attach($mRole, [
                'parent_role_id' => $parentRole->id,
            ]);
        }
        $process->update();
        return 'done';
    }

    public function delete(Process $process) {

        $process->routes()->delete();
        $process->handbook()->delete();
        $process->delete();
        return Redirect::route('processes.index')->with('status', 'Процесс успешно удален');  
    }
}
