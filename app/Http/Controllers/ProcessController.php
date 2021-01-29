<?php

namespace App\Http\Controllers;

use App\Process;
use App\Template;
use App\Role;
use App\Route;
use App\CityManagement;
use App\CreatedTable;
use App\TemplateDoc;
use App\Traits\dbQueries;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
        $tableName = $this->getTableName($process->name);
        $notInclude = ['id', 'process_id', 'status_id', 'user_id', 'index_sub_route', 'index_main', 'doc_path', 'reject_reason', 'reject_reason_from_spec_id', 'to_revision', 'revision_reason', 'revision_reason_from_spec_id', 'revision_reason_to_spec_id', 'updated_at'];
        $tableColumns = $this->getColumns($tableName, $notInclude);
        if ($parentId === 0) {
            return view('process.view', compact('process','tableColumns'));
        }
        $iterateRoles = $this->getIterateRoles($process);
        $sAllRoles = $this->getAllRoles($process, $parentId, $iterateRoles);
        return view('process.view', compact('process','sAllRoles','tableColumns'));
    }

    public function create() {

        return view('process.create');
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
            'deadline_until' => $deadline,
        ]);
        $process->save();
        return Redirect::route('processes.edit', [$process])->with('status', 'Процесс был создан');
    }

    public function edit(Process $process) {
        try {
            $accepted = Template::where('id', $process->accepted_template_id)->where('accept_template', 1)->first();
            $rejected = Template::where('id', $process->rejected_template_id)->where('accept_template', 0)->first();
            $columns = $this->getAllDictionaries();
            $roles = Role::where('name' ,'<>', 'Заявитель')->get();
            $tableName = $this->getTableName($process->name);
            $notInclude = ['id', 'process_id', 'status_id', 'user_id', 'index_sub_route', 'index_main', 'doc_path', 'reject_reason', 'reject_reason_from_spec_id', 'to_revision', 'revision_reason', 'revision_reason_from_spec_id', 'revision_reason_to_spec_id', 'updated_at'];
            $tableColumns = $this->getColumns($tableName, $notInclude);
            $parentId = $this->getParentRoleId($process->id);
            $organizations = CityManagement::all();
            $mainOrg = CityManagement::find($process->main_organization_id);
            $nameMainOrg = '';
            if(isset($mainOrg->name)) {
                $nameMainOrg=$mainOrg->name;
            }
            //dd($columns);
            $templateDocs = TemplateDoc::all();
            $iterateRoles = $this->getIterateRoles($process);
            $sAllRoles = $this->getAllRoles($process, $parentId, $iterateRoles);
            return view('process.edit', compact('templateDocs', 'process', 'accepted','tableColumns', 'rejected', 'columns', 'roles','sAllRoles', 'organizations', 'nameMainOrg'));
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Process $process) {
        $process->name = $request->name;
        $process->deadline = $request->deadline;
        $process->update();
        return Redirect::route('processes.edit', [$process])->with('status', 'Процесс был обновлен');
    }

    public function createProcessTable(Request $request, Process $process) {
        try {
            // return $request->fields;
            DB::beginTransaction();
            $processName = $process->name;
            $fields = $request->fields;
            $tableName = $this->translateSybmols($processName);
            $tableName = $this->checkForWrongCharacters($tableName);
            if (strlen($tableName) > 60) {
                $tableName = $this->truncateTableName($tableName); // если количество символов больше 64, то необходимо укоротить длину названия до 64
            }
            $tableName = $this->modifyTableName($tableName);
            $table = new CreatedTable();
            $table->name = $tableName;
            $table->save();
            if (!Schema::hasTable($tableName)) {
                $dbQueryString = "CREATE TABLE $tableName (id INT PRIMARY KEY AUTO_INCREMENT)";
                DB::statement($dbQueryString);
            }
            foreach($fields as $fieldName) {
                if($this->isRussian($fieldName)) {
                    $fieldName = $this->translateSybmols($fieldName);
                } ;
                $fieldName = $this->checkForWrongCharacters($fieldName);
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
                    [ 'process_id' => $process->id ]
                );
            }

            if (!Schema::hasColumn($tableName, 'status_id')) {
                $dbQueryString = "ALTER TABLE $tableName ADD  status_id INT";
                DB::statement($dbQueryString);
            }
            if (!Schema::hasColumn($tableName, 'to_revision')) {
                $dbQueryString = "ALTER TABLE $tableName ADD  to_revision BIT";
                DB::statement($dbQueryString);
            }
            if (!Schema::hasColumn($tableName, 'user_id')) {
                $dbQueryString = "ALTER TABLE $tableName ADD  user_id INT";
                DB::statement($dbQueryString);
            }
            if (!Schema::hasColumn($tableName, 'index_sub_route')) {
                $dbQueryString = "ALTER TABLE $tableName ADD  index_sub_route INT";
                DB::statement($dbQueryString);
            }
            if (!Schema::hasColumn($tableName, 'index_main')) {
                $dbQueryString = "ALTER TABLE $tableName ADD index_main INT";
                DB::statement($dbQueryString);
            }
            if (!Schema::hasColumn($tableName, 'doc_path')) {
                $dbQueryString = "ALTER TABLE $tableName ADD doc_path varchar(255)";
                DB::statement($dbQueryString);
            }
            if (!Schema::hasColumn($tableName, 'reject_reason')) {
                $dbQueryString = "ALTER TABLE $tableName ADD reject_reason varchar(255)";
                DB::statement($dbQueryString);
            }
            if (!Schema::hasColumn($tableName, 'reject_reason_from_spec_id')) {
                $dbQueryString = "ALTER TABLE $tableName ADD reject_reason_from_spec_id varchar(255)";
                DB::statement($dbQueryString);
            }
            if (!Schema::hasColumn($tableName, 'revision_reason')) {
                $dbQueryString = "ALTER TABLE $tableName ADD revision_reason varchar(255)";
                DB::statement($dbQueryString);
            }
            if (!Schema::hasColumn($tableName, 'revision_reason_from_spec_id')) {
                $dbQueryString = "ALTER TABLE $tableName ADD revision_reason_from_spec_id varchar(255)";
                DB::statement($dbQueryString);
            }
            if (!Schema::hasColumn($tableName, 'revision_reason_to_spec_id')) {
                $dbQueryString = "ALTER TABLE $tableName ADD revision_reason_to_spec_id varchar(255)";
                DB::statement($dbQueryString);
            }
            $dbQueryString = "ALTER TABLE $tableName ADD updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ";
            DB::statement($dbQueryString);
            DB::commit();
            return Redirect::route('processes.edit', [$process])->with('status', 'Таблица успешно создана');
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function addRole(Request $request, Process $process) {
        if (!isset($request->roles)) {
            echo 'Пожалуйста, выберите специалистов';
        } else if(sizeof($request->roles) == 1) {
            $role = Role::where('id', intval($request->roles[0]))->first();
            $route = new Route;
            $route->name = $role->name;
            $route->role_id = $role->id;
            $route->process_id = $process->id;
            $route->save();
            $can_reject = 1;// why 1 by default
            $can_send_to_revision = 1;
            if(isset($request->reject)){
              foreach ($request->reject as $id) {
                if($id == $role->id){
                  $can_reject = 1;
                  break;
                }
              }
            }
            if(isset($request->revision)){
              foreach ($request->revision as $id) {
                if($id == $role->id){
                  $can_send_to_revision = 1;
                  break;
                }
              }
            }
            $process->roles()->attach($role, ['can_reject' => $can_reject, 'can_send_to_revision' => $can_send_to_revision]);
            $process->save();
            return Redirect::route('processes.edit', [$process])->with('status', 'Маршрут добавлен к процессу');
        } else {
           $rolesId = $request->roles;
           $maxParallelNumber = DB::table('process_role')->max('is_parallel');
           foreach ($rolesId as $id) {
               $role = Role::where('id', intval($id))->first();
               $process->roles()->attach($role, ['is_parallel' => $maxParallelNumber + 1]);
               $process->save();
           }
           if(isset($request->reject)){
             foreach ($request->reject as $id) {
                 $this->updateProcessRoleCanReject($process->id, $id);
             }
           }
           if(isset($request->revision)){
             foreach ($request->revision as $id) {
                 $this->updateProcessRoleToRevision($process->id, $id);
             }
           }
           return Redirect::route('processes.edit', [$process])->with('status', 'Маршрут добавлен к процессу');
       }
    }

    public function addOrganization(Request $request, Process $process)
    {
        if (!$request->mainOrganization) {
            echo 'Пожалуйста, выберите организацию';
            return;
        }
        $process->main_organization_id = $request->mainOrganization;
        $process->update();
        return Redirect::route('processes.edit', [$process])->with('status', 'Основной маршрут выбран успешно');
    }

    public function addDocTemplates(Request $request)
    {
        $process = Process::find($request->processId);
        $process->template_doc_id = $request->docTemplateId;
        $process->save();
        return Redirect::back()->with('status', 'Основной маршрут выбран успешно');
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

        $tableName = $this->getTableName($process->name);
        Schema::dropIfExists($tableName);
        $process->delete();
        return Redirect::route('processes.index')->with('status', 'Процесс успешно удален');
    }

    public function logs() {
        $contents = file_get_contents(storage_path('logs/logfile.txt'));
        $result = str_split($contents);
        $logsArr = [];
        $start = 0;
        $index = 0;
        $len =0;
        if (sizeof($result) == 0) {
            echo "Логов пока нет";
        }
        for ($i = 0; $i < sizeof($result); $i ++) {
            $len++;
            if ($result[$i] === "\r") {
                $logsArr[$index] = implode('',(array_slice($result, $start, $len)));
            $index++;
            $len = 0;
            $start = $i+2;
            }
        }
        return view('process.logs', compact('logsArr'));
    }
}
