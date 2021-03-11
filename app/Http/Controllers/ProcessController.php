<?php

namespace App\Http\Controllers;

use App\Process;
use App\Template;
use App\Role;
use App\Route;
use App\Service;
use App\CityManagement;
use App\CreatedTable;
use App\TemplateDoc;
use App\Traits\dbQueries;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ProcessController extends Controller
{
    use dbQueries;

    public function index()
    {
        $processes = Process::all();
        return view('process.index', compact('processes'));
    }

    public function create()
    {
        return view('process.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'deadline' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::action([ProcessController::class, 'edit'], [$process])->with('failure', $validator->errors());
        }
        $process = new Process ([
            'name' => $request->name,
            'deadline' => $request->deadline,
        ]);
        $process->save();
        return Redirect::action([ProcessController::class, 'edit'], [$process])->with('status', 'Процесс был создан');
    }

    public function edit(Process $process) {
        try {
            $templates = Template::where('process_id', $process->id)->with('role')->with('doc')->get();
            $columns = $this->getAllDictionaries();
            $roles = Role::where('name' ,'!=', 'Заявитель')->get();
            $services = Service::all();
            $tableColumns = $this->getColumns($process->table_name);
            $organizations = CityManagement::all();
            $nameMainOrg = CityManagement::find($process->main_organization_id)->name ?? '';
            $process_roles = $this->get_roles_for_edit($process->id);
            $process_roles_2 = $this->get_roles_in_order($process->id);
            $templateDocs = TemplateDoc::all();
            return view('process.edit', compact('services', 'templates', 'process','tableColumns', 'columns', 'roles','process_roles', 'process_roles_2', 'organizations', 'nameMainOrg', 'templateDocs'));
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Process $process)
    {
        $records = $request->all();
        $validator = Validator::make( $records,[
            'name' => ['required', 'string', 'max:255'],
            'deadline' => ['required', 'string', 'max:2', 'min:1'],
        ]);

        if ((intval($request->deadline) === 0) || (intval($request->deadline) === Null)){
            return Redirect::action([ProcessController::class, 'edit'], [$process])->with('failure', 'Пожалуйста, введите правильный срок');
        }
        $process->name = $request->name;
        $process->deadline = intval($request->deadline);
        $process->update();
        return Redirect::action([ProcessController::class, 'edit'], [$process])->with('status', 'Процесс был обновлен');
    }

    public function createProcessTable(Request $request, Process $process) {
        try {
            DB::beginTransaction();
            if ($request->fields === Null) {
                return Redirect::action([ProcessController::class, 'edit'], [$process])->with('failure', 'Пожалуйста, выберите поля');
            }

            $tableName = $this->getTableName($process->name);
            $table = new CreatedTable();
            $table->name = $tableName;
            $table->save();

            $process->table_name = $tableName;
            $process->save();

            if (!Schema::hasTable($tableName)) {
                $dbQueryString = "CREATE TABLE $tableName (id INT PRIMARY KEY AUTO_INCREMENT)";
                DB::statement($dbQueryString);
            }
            foreach($request->fields as $fieldName) {
                if($this->isRussian($fieldName)) {
                    $fieldName = $this->translateSybmols($fieldName);
                }
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
            }

            if (!Schema::hasColumn($tableName, 'status_id')) {
                $dbQueryString = "ALTER TABLE $tableName ADD  status_id INT";
                DB::statement($dbQueryString);
            }
            if (!Schema::hasColumn($tableName, 'statuses')) {
                $dbQueryString = "ALTER TABLE $tableName ADD  statuses JSON";
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
            if (!Schema::hasColumn($tableName, 'current_order')) {
                $dbQueryString = "ALTER TABLE $tableName ADD current_order INT";
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
            if (!Schema::hasColumn($tableName, 'updated_at')) {
                $dbQueryString = "ALTER TABLE $tableName ADD updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ";
                DB::statement($dbQueryString);
            }
            DB::commit();
            return Redirect::action([ProcessController::class, 'edit'], [$process])->with('status', 'Таблица успешно создана');
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function addRole(Request $request, Process $process) {
        try {
            $validator = Validator::make($request->all(),[
                'order' => 'required|integer',
                'roles'   => 'required|array',
                'roles.*' => 'integer',
                'reject'   => 'nullable|array',
                'reject.*' => 'integer',
                'revision'   => 'nullable|array',
                'revision.*' => 'integer',
            ]);
            if ($validator->fails()) {
                
                return Redirect::action([ProcessController::class, 'edit'], [$process])->with('failure', $validator->errors());
            }
            DB::beginTransaction();
            if (sizeof($request->roles) === 1) {
                $process->roles()->attach($request->roles[0], [
                    'can_reject' => in_array($request->roles[0], $request->reject ?? []),
                    'can_send_to_revision' => in_array($request->roles[0], $request->revision ?? []),
                    'can_ecp_sign' => in_array($request->roles[0], $request->ecp_sign ?? []),
                    'can_motiv_otkaz' => in_array($request->roles[0], $request->motiv_otkaz ?? []),
                    'order' => $request->order
                ]);
                DB::commit();
                return Redirect::action([ProcessController::class, 'edit'], [$process])->with('status', 'Маршрут добавлен к процессу');
            } else {
               foreach ($request->roles as $id) {
                   $process->roles()->attach($id, [
                        'can_reject' => in_array($id, $request->reject ?? []),
                        'can_send_to_revision' => in_array($id, $request->revision ?? []),
                        'order' => $request->order
                    ]);
               }
               DB::commit();
               return Redirect::action([ProcessController::class, 'edit'], [$process])->with('status', 'Маршрут добавлен к процессу');
           }
        } catch (Exception $e) {
            DB::rollBack();
            return Redirect::action([ProcessController::class, 'edit'], [$process])->with('failure', $e->getMessage());
        }
    }

    public function add_sub_role(Request $request, Process $process) {
        try {
            $validator = Validator::make($request->all(),[
                'parent_role_id' => 'required|integer',
                'order' => 'required|integer',
                'roles'   => 'required|array',
                'roles.*' => 'integer',
                'reject'   => 'nullable|array',
                'reject.*' => 'integer',
                'revision'   => 'nullable|array',
                'revision.*' => 'integer',
            ]);
            if ($validator->fails()) {
                
                return Redirect::action([ProcessController::class, 'edit'], [$process])->with('failure', $validator->errors());
            }

            DB::beginTransaction();
            if (sizeof($request->roles) === 1) {
                $process->roles()->attach($request->roles[0], [
                    'parent_role_id' => $request->parent_role_id,
                    'can_reject' => in_array($request->roles[0], $request->reject ?? []),
                    'can_send_to_revision' => in_array($request->roles[0], $request->revision ?? []),
                    'can_ecp_sign' => in_array($request->roles[0], $request->ecp_sign ?? []),
                    'can_motiv_otkaz' => in_array($request->roles[0], $request->motiv_otkaz ?? []),
                    'order' => $request->order
                ]);
                DB::commit();
                return Redirect::action([ProcessController::class, 'edit'], [$process])->with('status', 'Маршрут добавлен к процессу');
            } else {
               foreach ($request->roles as $id) {
                   $process->roles()->attach($id, [
                        'parent_role_id' => $request->parent_role_id,
                        'can_reject' => in_array($id, $request->reject ?? []),
                        'can_send_to_revision' => in_array($id, $request->revision ?? []),
                        'can_ecp_sign' => in_array($id, $request->ecp_sign ?? []),
                        'can_motiv_otkaz' => in_array($id, $request->motiv_otkaz ?? []),
                        'order' => $request->order
                    ]);
               }
               DB::commit();
               return Redirect::action([ProcessController::class, 'edit'], [$process])->with('status', 'Маршрут добавлен к процессу');
           }
        } catch (Exception $e) {
            DB::rollBack();
            return Redirect::action([ProcessController::class, 'edit'], [$process])->with('failure', $e->getMessage());
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
        return Redirect::action([ProcessController::class, 'edit'], [$process])->with('status', 'Организация успешно изменена.');
    }

    public function update_process_role(Request $request, Process $process)
    {
        try {
            $validator = Validator::make($request->all(),[
                'id' => 'required|integer',
                'order' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return Redirect::action([ProcessController::class, 'edit'], [$process])->with('failure', $validator->errors());
            }
            DB::table('process_role')
                ->where('id', $request->id)
                ->update(['order' => $request->order]);
            return Redirect::action([ProcessController::class, 'edit'], [$process])->with('status', 'Очередность успешно изменена.');
        } catch (Exception $e) {
            return Redirect::action([ProcessController::class, 'edit'], [$process])->with('status', $e->getMessage());
        }
    }

    public function delete_process_role(Request $request, Process $process)
    {
        try {
            $validator = Validator::make($request->all(),[
                'id' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return Redirect::action([ProcessController::class, 'edit'], [$process])->with('failure', $validator->errors());
            }
            DB::table('process_role')
                ->where('id', $request->id)
                ->delete();
            return Redirect::action([ProcessController::class, 'edit'], [$process])->with('status', 'Успешно удален.');
        } catch (Exception $e) {
            return Redirect::action([ProcessController::class, 'edit'], [$process])->with('status', $e->getMessage());
        }
    }

    public function delete(Process $process)
    {
        $tableName = $this->getTableName($process->name);
        if(DB::table($tableName)->count() > 0){
            return  Redirect::to('process')->with('failure', 'Не удалось удалить процесс, удалите данные.');
        }
        $true = Schema::dropIfExists($tableName);
        if ($true !== Null) {
            return Redirect::to('process')->with('failure', 'Не удалось удалить процесс');
        }
        $process->delete();
        return Redirect::to('process')->with('status', 'Процесс успешно удален');
    }

    public function logs()
    {
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
