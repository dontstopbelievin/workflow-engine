<?php

namespace App\Http\Controllers;

use App\Process;
use App\Role;
use App\Status;
use App\CityManagement;
use App\Comment;
use App\CreatedTable;
use App\Traits\dbQueries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    use dbQueries;

    public function __construct() {

    }

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
        $tableName = $this->getTableName($process->name);
        $table = CreatedTable::where('name', $tableName)->first();
        $application = DB::table($tableName)->where('id', $applicationId)->first();
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
//        $statuses = $application->statuses()->get();
//        $records = $this->getRecords($application->id);
//        $statusLength = sizeof($statuses);
//        $status_id = $statuses[$statusLength-1]->id;

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
        if (Null !==($process->roles()->where('parent_role_id', '<>', Null)->first())) {
            $parentRoleId = intval($process->roles()->where('parent_role_id', '<>', Null)->first()->pivot->parent_role_id); // добыть родительскую айдишку родительской роли для подролей
            $subOrg = CityManagement::find($process->support_organization_id)->first();
        
            $sendToSubRoute = [];
            $sendToSubRoute["isset"] = false;
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

        return view('application.view', compact('application', 'process','canApprove', 'toCitizen','sendToSubRoute', 'backToMainOrg','allRoles','comments'));
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

        $arrayToFront = [];
        foreach($dictionariesWithOptions as $item) {
            $replaced = str_replace(' ', '_', $item["name"]);
            $item["name"] = $replaced;
            array_push($arrayToFront, $item);
        }
        return view('application.create', compact('process', 'arrayToFront'));
    }

    public function store(Request $request) {

        $input = $request->input();

        $arrayToInsert = array_slice($input, 1, sizeof($input)-1);
        $process = Process::find($request->process_id);
        $routes = $this->getRolesWithoutParent($process->id);
        $arrRoutes = json_decode(json_encode($routes), true);
        $startRole = $arrRoutes[0]["name"]; //с какой роли начинается маршрут. Находится для того, чтобы присвоить статус маршруту
        $role = Role::where('name', $startRole)->first();
        $status = Status::find($role->id);
        $arrayToInsert["status_id"] = $status->id;
        $tableName = $this->getTableName($process->name);
        $user = Auth::user();
        $arrayToInsert["user_id"] = $user->id;
        $arrayToInsert["index_main"] = 1;
        $arrayToInsert["index_sub_route"] = 0;
        DB::table($tableName)->insert( $arrayToInsert);
        return Redirect::route('applications.service')->with('status', 'Заявка Успешно создана');
    }

    public function approve(Request $request) {

        $id = $request->applicationId;

        $process = Process::find($request->process_id);
        $tableName = $this->getTableName($process->name);
        $application = DB::table($tableName)->where('id', $id)->first();
        $table = CreatedTable::where('name', $tableName)->first();


        $user = Auth::user();

        if ($request->comments !== Null) {
            $comment = new Comment();
            $comment->name = $request->comments;
            $comment->application_id = $id;
            $comment->table_id = $table->id;
            $comment->role_id = $user->role->id;
            $comment->save();

        }

        $index = $application->index_main;
        $appRoutes = json_decode($this->getAppRoutes($application->process_id));
        $nextRole = $appRoutes[$index]; // find next role
        $nextR = Role::where('name', $nextRole)->first(); //find $nextRole in Role table
        $idOfNextRole = $nextR->id; // get id of next role
        $index = $index + 1;
        $status = Status::find($idOfNextRole);
        if ($application->to_revision === 0) {
            DB::table($tableName)
                ->where('id', $id)
                ->update(['status_id' => $status->id, 'index_main' => $index]);
        } else {
            DB::table($tableName)
                ->where('id', $id)
                ->update(['status_id' => $status->id, 'index_main' => $index,'to_revision' => 0 ]);
        }

//        $application->statuses()->attach($status);
        return Redirect::route('applications.service')->with('status', $status->name);
    }

    public function sendToSubRoute($id, Request $request) {

        $process = Process::find($request->process_id);
        $tableName = $this->getTableName($process->name);
        $application = DB::table($tableName)->where('id', $id)->first();
        $subRoutes = $this->getSubRoutes($process->id);
        $index = $application->index_sub_route;
        $nextRole = $subRoutes[$index];
        $nextR = Role::where('name', $nextRole)->first();
        $idOfNextRole = $nextR->id;
        $index = $index + 1;
        $status = Status::find($idOfNextRole);
        if ($application->to_revision === 0) {
            DB::table($tableName)
                ->where('id', $id)
                ->update(['status_id' => $status->id, 'index_sub_route' => $index]);
        } else {
            DB::table($tableName)
                ->where('id', $id)
                ->update(['status_id' => $status->id, 'index_sub_route' => $index, 'to_revision' => 0]);
        }
        return Redirect::route('applications.service')->with('status', $status->name);
        
    }
    public function backToMainOrg($id, Request $request) {

        $process = Process::find($request->process_id);
        $tableName = $this->getTableName($process->name);
        $application = DB::table($tableName)->where('id', $id)->first();
        $parentId = $this->getParentRoleId($process->id);
        $parentRole = Role::find($parentId);
        $status = Status::find($parentId);
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
        $affected = DB::table($tableName)
            ->where('id', $id)
            ->update(['status_id' => $status->id, 'index_main' => Null]);
        return Redirect::route('applications.service')->with('status', $status->name);
    }

    public function reject(Request $request) {

        $process = Process::find($request->processId);
        $tableName = $this->getTableName($process->name);
        $application = DB::table($tableName)->where('id', $request->applicationId)->first();
        $statusCount = count(Status::all());
        $status = Status::find($statusCount-1); //$statuscount-1 - индекс статуса отправлено заявителю с отказом
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



}
