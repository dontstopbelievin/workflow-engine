<?php

namespace App\Http\Controllers;

use App\Process;
use App\Role;
use App\Status;
use App\CityManagement;
use App\Comment;
use App\CreatedTable;
use App\Template;
use App\TemplateField;
use App\Traits\dbQueries;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    use dbQueries;

    public function service() {

        $processes = Process::all();
        return view('application.dashboard', compact('processes'));
    }

    public function index(Process $process) {

        $tableName = $this->getTableName($process->name);
        $applications = $this->getTableWithStatuses($tableName);
        $arrayApps = json_decode(json_encode($applications), true);
        foreach($arrayApps as &$app) {
            if ($app["to_revision"] === 1) {
                $app["status"] = $app["status"] . " на доработку";

            } else {
                $app["status"] = $app["status"] . " на согласование";
            }
        }
        $statuses = [];
        return view('application.index', compact('arrayApps', 'process','statuses'));
    }

    public function view($processId, $applicationId) {

        $process = Process::find($processId);
        $templateId = $process->accepted_template_id;
         $templateFields= TemplateField::where('template_id', $templateId)->get();
        $tableName = $this->getTableName($process->name);
        $table = CreatedTable::where('name', $tableName)->first();
        $application = DB::table($tableName)->where('id', $applicationId)->first();
        $applicationArray = json_decode(json_encode($application), true);
        $notInArray = ["id", "process_id", "status_id", "to_revision", "user_id","index_sub_route", "index_main", "reject_reason", "revision_reason" ];
//        $applicationArray = $this->filterApplicationArray($applicationArray, $notInArray); // not used yet, but surely will

        $statusId = $application->status_id;
        $user = Auth::user();
        $thisRole = $user->role;
        $subRoutes = $this->getSubRoutes($process->id);
        if (!$user->role) {
            echo 'Дайте роль юзеру';
            return;
        }

        $comments = $this->getComments($application->id, $table->id);
        $roleId = $thisRole->id; //роль действующего юзера
        $records = $this->getRecords($application->id, $table->id);

        $canApprove = $roleId === $statusId; //может ли специалист подвисывать услугу
        $toCitizen = false;
        $backToMainOrg = false;
        $userRole = Role::find($roleId);
        $appRoutes = json_decode($this->getAppRoutes($process->id));
        if ($appRoutes[sizeof($appRoutes)-1] === $userRole->name) {
            $toCitizen = true; // если заявку подписывает последний специалист в обороте, заявка идет обратно к заявителю
        }
        if (!empty($subRoutes)) {
            if($subRoutes[sizeof($subRoutes) - 1] === $userRole->name) {
                $backToMainOrg = true;
            }
        }
        $sendToSubRoute = [];
        $sendToSubRoute["isset"] = false;
        if (Null !==($process->roles()->where('parent_role_id', '<>', Null)->first())) {
            $parentRoleId = intval($process->roles()->where('parent_role_id', '<>', Null)->first()->pivot->parent_role_id); // добыть родительскую айдишку родительской роли для подролей
            $subOrg = CityManagement::find($process->support_organization_id);

            if (($application->index_sub_route > 0) && ($application->index_sub_route < sizeof($subRoutes))) {
                if ($thisRole->name === $subRoutes[$application->index_sub_route - 1]) {
                    $sendToSubRoute["isset"] = true;
                    if (isset($subOrg->name)) {
                        $sendToSubRoute["name"] = $subOrg->name;
                    }
                }
            }
            if ($parentRoleId === $thisRole->id)  {
                $sendToSubRoute["isset"] = true;
                if (isset($subOrg->name)) {
                    $sendToSubRoute["name"] = $subOrg->name;
                }
            }
        } 

        if (!$thisRole->city_management_id) {
            echo 'Укажите к какой организации относить роль';
            return;
        }
        $nameUpr = CityManagement::find($thisRole->city_management_id)->name;
        $mainRoles = $this->getIterateRoles($process);
        $subRoles = $this->getSubRoutes($process->id);
        $allRoles = $this->mergeRoles($mainRoles, $subRoles);


        $templateId = $process->accepted_template_id;
        $template = Template::where('id', $templateId)->first();
        $templateName = $template->name;

        $templateTable = $this->getTemplateTableName($templateName);
        $templateTableFields = [];
        if (Schema::hasTable($templateTable)) {
            if (Schema::hasColumn($templateTable, 'template_id') && (Schema::hasColumn($templateTable, 'process_id')) && Schema::hasColumn($templateTable, 'application_id')) {
                $templateTableFields = DB::table($templateTable)
                    ->where('process_id', $process->id)
                    ->where('application_id', $application->id)
                    ->where('template_id', $templateId)
                    ->get()->toArray();
                $templateTableFields = json_decode(json_encode($templateTableFields), true);
                $exceptionArray = ["id", "template_id", "process_id", "application_id"];
                $templateTableFields = $this->filterTemplateFieldsTable($templateTableFields, $exceptionArray);
            }
        }
        return view('application.view', compact('application','templateTableFields','templateFields', 'process','canApprove', 'toCitizen','sendToSubRoute', 'backToMainOrg','allRoles','comments','records'));
    }

    public function create(Process $process) {

        $tableName = $this->getTableName($process->name);
        $tableColumns = $this->getColumns($tableName);
        $originalTableColumns = $this->getOriginalColumns($tableColumns);
        $dictionaries = $this->getAllDictionaries();
        $res = [];

        foreach($dictionaries as $item) {
            foreach($originalTableColumns as $column) {
                if($item["name"] === $column) {
                    array_push($res, $item);
                }
            }
        }
        $dictionariesWithOptions = $this->addOptionsToDictionary($res);
        $arrayToFront = $this->getAllDictionariesWithOptions($dictionariesWithOptions);

        return view('application.create', compact('process', 'arrayToFront'));
    }

    public function store(Request $request) {

        $input = $request->input();
        $applicationTableFields = array_slice($input, 1, sizeof($input)-1);
        $process = Process::find($request->process_id);
        $routes = $this->getRolesWithoutParent($process->id);
        $arrRoutes = json_decode(json_encode($routes), true);
        $startRole = $arrRoutes[0]["name"]; //с какой роли начинается маршрут. Находится для того, чтобы присвоить статус маршруту
        $role = Role::where('name', $startRole)->first();
        $status = Status::find($role->id);
        $tableName = $this->getTableName($process->name);
        $table = CreatedTable::where('name', $tableName)->first();
        $user = Auth::user();

        $modifiedApplicationTableFields = $this->modifyApplicationTableFields($applicationTableFields, $status->id, $user->id);
        $applicationId = DB::table($tableName)->insertGetId( $modifiedApplicationTableFields);
        $logsArray = $this->getLogs($status->id, $table->id, $applicationId, $role->id); // получить историю хода согласования
        DB::table('logs')->insert( $logsArray);
        return Redirect::route('applications.service')->with('status', 'Заявка Успешно создана');
    }

    public function approve(Request $request) {

        $process = Process::find($request->process_id);
        $tableName = $this->getTableName($process->name);
        $application = DB::table($tableName)->where('id', $request->applicationId)->first();
        $table = CreatedTable::where('name', $tableName)->first();
        $fieldValues = $request->fieldValues;
        $templateId = $process->accepted_template_id;
        $template = Template::where('id', $templateId)->first();
        $templateName = $template->name;
        $templateTable = $this->getTemplateTableName($templateName);

        $this->insertTemplateFields($fieldValues, $templateTable, $process->id, $application->id, $templateId);
        $user = Auth::user();
        $role = $user->role;
        $this->insertComments($request->comments, $request->applicationId, $table->id);
        $index = $application->index_main;
        $appRoutes = json_decode($this->getAppRoutes($application->process_id));
        $nextRole = $appRoutes[$index]; // find next role
        $nextR = Role::where('name', $nextRole)->first(); //find $nextRole in Role table
        $idOfNextRole = $nextR->id; // get id of next role
        $index = $index + 1;
        $status = Status::find($idOfNextRole);
        $logsArray = $this->getLogs($status->id, $table->id, $application->id, $role->id);
        DB::table('logs')->insert( $logsArray);

        if ($application->to_revision === 0) {
            DB::table($tableName)
                ->where('id', $request->applicationId)
                ->update(['status_id' => $status->id, 'index_main' => $index]);
        } else {
            DB::table($tableName)
                ->where('id', $request->applicationId)
                ->update(['status_id' => $status->id, 'index_main' => $index,'to_revision' => 0 ]);
        }
        return Redirect::route('applications.service')->with('status', $status->name);
    }

    public function sendToSubRoute(Request $request) {

        $fieldValues = $request->fieldValues;
        $process = Process::find($request->processId);
        $tableName = $this->getTableName($process->name);
        $application = DB::table($tableName)->where('id', $request->applicationId)->first();
        $table = CreatedTable::where('name', $tableName)->first();
        $subRoutes = $this->getSubRoutes($process->id);
        $index = $application->index_sub_route;
        $nextRole = $subRoutes[$index];
        $nextR = Role::where('name', $nextRole)->first();
        $idOfNextRole = $nextR->id;
        $index = $index + 1;
        $status = Status::find($idOfNextRole);
        $user = Auth::user();
        $role = $user->role;

        $this->insertComments($request->comments, $request->applicationId, $table->id);
        $templateId = $process->accepted_template_id;
        $template = Template::where('id', $templateId)->first();
        $templateName = $template->name;
        $templateTable = $this->getTemplateTableName($templateName);
        $this->insertTemplateFields($fieldValues, $templateTable, $process->id, $application->id, $templateId);
        $logsArray = $this->getLogs($status->id, $table->id, $application->id, $role->id);
        DB::table('logs')->insert( $logsArray);

        if ($application->to_revision === 0) {
            DB::table($tableName)
                ->where('id', $request->applicationId)
                ->update(['status_id' => $status->id, 'index_sub_route' => $index]);
        } else {
            DB::table($tableName)
                ->where('id', $request->applicationId)
                ->update(['status_id' => $status->id, 'index_sub_route' => $index, 'to_revision' => 0]);
        }
        return Redirect::route('applications.service')->with('status', $status->name);
        
    }

    public function backToMainOrg($id, Request $request) {

        $process = Process::find($request->process_id);
        $tableName = $this->getTableName($process->name);
        $table = CreatedTable::where('name', $tableName)->first();
        $application = DB::table($tableName)->where('id', $id)->first();
        $parentId = $this->getParentRoleId($process->id);
        $parentRole = Role::find($parentId);
        $status = Status::find($parentId);

        $user = Auth::user();
        $role = $user->role;

        $logsArray = $this->getLogs($status->id, $table->id, $application->id, $role->id);
        DB::table('logs')->insert( $logsArray);
        
        DB::table($tableName)
            ->where('id', $id)
            ->update(['status_id' => $status->id, 'index_sub_route' => Null]);
        return Redirect::route('applications.service')->with('status', $status->name);
    }

    public function toCitizen($id, Request $request) {

        $process = Process::find($request->process_id);
        $tableName = $this->getTableName($process->name);
        $statusCount = count(Status::all());
        $status = Status::find($statusCount);
        $table = CreatedTable::where('name', $tableName)->first();
        $application = DB::table($tableName)->where('id', $id)->first();
        $user = Auth::user();
        $role = $user->role;
        $logsArray = $this->getLogs($status->id, $table->id, $application->id, $role->id);
        DB::table('logs')->insert( $logsArray);
        $affected = DB::table($tableName)
            ->where('id', $id)
            ->update(['status_id' => $status->id, 'index_main' => Null]);
        return Redirect::route('applications.service')->with('status', $status->name);
    }

    public function reject(Request $request) {

        $process = Process::find($request->processId);
        $tableName = $this->getTableName($process->name);
        $application = DB::table($tableName)->where('id', $request->applicationId)->first();
        $table = CreatedTable::where('name', $tableName)->first();
        $statusCount = count(Status::all());
        $status = Status::find($statusCount-1); //$statuscount-1 - индекс статуса отправлено заявителю с отказом
        $user = Auth::user();
        $role = $user->role;
        $logsArray = $this->getLogs($status->id, $table->id, $application->id, $role->id);
        DB::table('logs')->insert( $logsArray);
        if ($application->to_revision === 0) {
            DB::table($tableName)
                ->where('id', $request->applicationId)
                ->update(['status_id' => $status->id, 'reject_reason' => $request->rejectReason]);
        } else {
            DB::table($tableName)
                ->where('id', $request->applicationId)
                ->update(['status_id' => $status->id, 'reject_reason' => $request->rejectReason, 'to_revision' => 0]);
        }
    }

    public function revision(Request $request) {

        $roleToRevise = $request->roleToRevise; //Роль, которому форма отправляется на доработку
        $mainCounter = 0;
        $subCounter = 0;
        $index = 0;
        $indexSubRoute = 0;
        $process = Process::find($request->processId);
        $tableName = $this->getTableName($process->name);
        $mainRoles = $this->getIterateRoles($process); // get collection
        $mainRoleArr = $this->getMainRoleArray($mainRoles); // get array of names from collection
        $subRoles = $this->getSubRoutes($process->id);

        foreach($mainRoleArr as $role) {
            $mainCounter++;
            if ($role === $roleToRevise) {
                $index = $mainCounter;
                break;
            }
        }
        if ($index === 0) {
            foreach($subRoles as $role) {
                $subCounter++;
                if ($role === $roleToRevise) {
                    $indexSubRoute = $subCounter;
                    break;
                }
            }
        }

        $nextR = Role::where('name', $roleToRevise)->first();
        $idOfNextRole = $nextR->id;
        $status = Status::find($idOfNextRole);
        $user = Auth::user();
        $role = $user->role;
        $table = CreatedTable::where('name', $tableName)->first();
        $application = DB::table($tableName)->where('id', $request->applicationId)->first();
        $logsArray = $this->getLogs($status->id, $table->id, $application->id, $role->id);

        DB::table('logs')->insert( $logsArray);
        if ($index === 0) {
            DB::table($tableName)
                ->where('id', $request->applicationId)
                ->update(['status_id' => $status->id, 'revision_reason' => $request->revisionReason,'to_revision' => 1,'index_sub_route' => $indexSubRoute] );
        } else {
            DB::table($tableName)
                ->where('id', $request->applicationId)
                ->update(['status_id' => $status->id, 'revision_reason' => $request->revisionReason,'to_revision' => 1, 'index_main' => $index] );
        }
    }

    private function getLogs($statusId, $tableId, $applicationId, $roleId) {
        $logsArray = [];
        $logsArray["status_id"] = $statusId;
        $logsArray["role_id"] = $roleId;
        $logsArray["table_id"] = $tableId;
        $logsArray["application_id"] = $applicationId;
        $logsArray["created_at"] = Carbon::now();
        return $logsArray;
    }

    private function insertComments($comments, $applicationId, $tableId) {

        if ($comments !== Null) {
            $comment = new Comment( [
                'name' => $comments,
                'application_id' => $applicationId,
                'table_id' => $tableId,
                'role_id' => Auth::user()->role->id,
            ]);
            $comment->save();
        }
    }

    private function filterTemplateFieldsTable($array, $exceptionArray) {

        $res = [];
        foreach($array as $item) {
            foreach($item as $key=>$value) {
                if (!in_array($key, $exceptionArray)) {
                    $res[$key] = $value;
                }
            }
        }
        return $res;
    }

    private function modifyApplicationTableFields($applicationTableFields, $statusId, $userId) {

        $applicationTableFields["status_id"] = $statusId;
        $applicationTableFields["user_id"] = $userId;
        $applicationTableFields["index_main"] = 1;
        $applicationTableFields["index_sub_route"] = 0;
        return $applicationTableFields;
    }

    private function insertTemplateFields($fieldValues, $templateTable,$processId, $applicationId, $templateId) {

        if (!Schema::hasTable($templateTable)) {
            $dbQueryString = "CREATE TABLE $templateTable (id INT PRIMARY KEY AUTO_INCREMENT)";
            DB::statement($dbQueryString);
        }
        foreach($fieldValues as $key=>$value) {
            if (Schema::hasColumn($templateTable, $key)) {
                continue;
            } else {
                $dbQueryString = "ALTER TABLE $templateTable ADD COLUMN $key varchar(255)";
                DB::statement($dbQueryString);
            }
        }
        if (!Schema::hasColumn($templateTable, 'template_id')) {
            $dbQueryString = "ALTER TABLE $templateTable ADD  template_id INT";
            DB::statement($dbQueryString);
        }
        if (!Schema::hasColumn($templateTable, 'process_id')) {
            $dbQueryString = "ALTER TABLE $templateTable ADD  process_id INT";
            DB::statement($dbQueryString);
        }
        if (!Schema::hasColumn($templateTable, 'application_id')) {
            $dbQueryString = "ALTER TABLE $templateTable ADD  application_id INT";
            DB::statement($dbQueryString);
        }
        $checkRow = DB::table($templateTable)
            ->where('process_id', $processId)
            ->where('application_id', $applicationId)
            ->where('template_id', $templateId)
            ->first();
        $templateTableColumns = $this->getTemplateTableColumns($fieldValues, $templateId, $processId, $applicationId);
        if ($checkRow) {
            DB::table($templateTable)->update( $templateTableColumns);
        } else {
            DB::table($templateTable)->insert( $templateTableColumns);
        }
    }

    private function getTemplateTableColumns($fieldValues,$templateId, $processId, $applicationId ) {

        $templateTableColumns = [];
        foreach($fieldValues as $key=>$value) {
            if ($value !== Null) {
                $templateTableColumns[$key] = $value;
            }
        }
        $templateTableColumns["template_id"] = $templateId;
        $templateTableColumns["process_id"] = $processId;
        $templateTableColumns["application_id"] = $applicationId;
        return $templateTableColumns;
    }

    private function getTemplateTableName($templateName) {

        $templateTable = $this->translateSybmols($templateName);
        $templateTable = $this->checkForWrongCharacters($templateTable);
        $templateTable = $this->modifyTemplateTable($templateTable);
        if (strlen($templateTable) > 57) {
            $templateTable = $this->truncateTableName($templateTable); // если количество символов больше 64, то необходимо укоротить длину названия до 64
        }
        return $templateTable;
    }

    private function getAllDictionariesWithOptions($dictionariesWithOptions) {
        $arrayToFront = [];
        foreach($dictionariesWithOptions as $item) {
            $replaced = str_replace(' ', '_', $item["name"]);
            $item["name"] = $replaced;
            array_push($arrayToFront, $item);
        }
        return $arrayToFront;
    }

}
