<?php

namespace App\Http\Controllers;

use App\Process;
use App\Handbook;
use App\Application;
use App\Role;
use App\Status;
use App\CityManagement;
use App\Traits\dbQueries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpWord\TemplateProcessor;

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

        $applications = Application::where('process_id', $process->id)->get();
        $statuses = [];
        foreach($applications as $app) {
            $status = $app->statuses()->get();
            $statusLength = sizeof($status);
            $statusName = $status[$statusLength-1]->name;
            array_push($statuses, $statusName);
        }
        return view('application.index', compact('applications', 'process','statuses'));
    }

    public function view(Application $application) {

        $process = Process::find($application->process_id);
        $user = Auth::user();
        $thisRole = $user->role;
        $subRoutes = $this->getSubRoutes($process->id);
        if (!$user->role) {
            echo 'Дайте роль юзеру';
            return;
        }
        $roleId = $thisRole->id; //роль действующего юзера
        $statuses = $application->statuses()->get();
        $records = $this->getRecords($application->id);
        $statusLength = sizeof($statuses);
        $status_id = $statuses[$statusLength-1]->id;
        $canApprove = $roleId === $status_id; //может ли специалист подвисывать услугу
        $toCitizen = false;
        $backToMainOrg = false;
        $userRole = Role::find($roleId);
        $appRoutes = json_decode($this->getAppRoutes($process->id));
        $appProcess = Process::find($application->process_id);
        if ($appRoutes[sizeof($appRoutes)-1] === $userRole->name) {
            $toCitizen = true; // если заявку подписывает последний специалист в обороте, заявка идет обратно к заявителю
        }
        if (!empty($subRoutes)) {
            if($subRoutes[sizeof($subRoutes) - 1] === $userRole->name) {
                $backToMainOrg = true;
            }
        }
        if (Null !==($appProcess->roles()->where('parent_role_id', '<>', Null)->first())) {
            $parentRoleId = intval($appProcess->roles()->where('parent_role_id', '<>', Null)->first()->pivot->parent_role_id);
            $subOrg = CityManagement::find($process->support_organization_id)->first();
        
            $sendToSubRoute = [];
            $sendToSubRoute["isset"] = false;
            if (($application->index_sub_route > 0) && ($application->indexSubRoute<sizeof($subRoutes))) {
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
        return view('application.view', compact('application', 'process','canApprove', 'toCitizen','records','sendToSubRoute', 'backToMainOrg'));
    }

    public function create(Process $process) {

        $fields = $process->handbook;
        $field_keys = array_keys(array_filter($fields->toArray()));
        $field_keys = array_slice($field_keys, 1, count($field_keys)-5);
        return view('application.create', compact('process', 'field_keys'));
    }

    public function store(Process $process, Request $request) {

        $id = $request->process_id;
        $requestFields = array_slice($request->input(), 1);
        $field_keys = array_keys($requestFields);
        $handbook = new Handbook;
        $columns = $handbook->getTableColumns();
        $columns = array_slice($columns, 1, -4);
        $application = new Application;
        for ($i = 0; $i < count($columns); $i++) {
            for ($j = 0; $j < count($field_keys);  $j++) {
                if($columns[$i] === $field_keys[$j]) {
                    $application->{$columns[$i]} = $requestFields[$field_keys[$j]];                    
                }
            }
        }
        $user = Auth::user();
        $application->user_id = $user->id;
        $application->process_id = $id;
        $process = Process::find($id);
        $status = Status::find(1);
        $application->status =$status->name;
        $application->save();
        $application->statuses()->attach(1);

        return Redirect::route('applications.service')->with('status', 'Заявка Успешно создана');
    }

    public function approve(Application $application) {

        $index = $application->index;
        $appRoutes = json_decode($this->getAppRoutes($application->process_id));
        $nextRole = $appRoutes[$index]; // find next role
        $nextR = Role::where('name', $nextRole)->first(); //find $nextRole in Role table
        $idOfNextRole = $nextR->id; // get id of next role
        $application->index = $index + 1;
        $status = Status::find($idOfNextRole);
        $application->status = $status->name;
        $application->update();
         // находим следующую роль в маршрутах и присваиваем заявке его статус
        $application->statuses()->attach($status);
        return Redirect::route('applications.service')->with('status', $status->name);
    }

    public function sendToSubRoute(Application $application) {

        $process = Process::find($application->process_id);
        $subRoutes = $this->getSubRoutes($process->id);
        $index = $application->index_sub_route;
        $nextRole = $subRoutes[$index];
        $nextR = Role::where('name', $nextRole)->first();
        $idOfNextRole = $nextR->id;
        $application->index_sub_route = $index + 1;
        $status = Status::find($idOfNextRole);
        $application->status = $status->name;
        $application->update();
        $application->statuses()->attach($status);
        return Redirect::route('applications.service')->with('status', $status->name);
        
    }
    public function backToMainOrg(Application $application) {

        $process = Process::find($application->process_id);
        $parentId = $this->getParentRoleId($process->id);
        $parentRole = Role::find($parentId);
        $status = Status::find($parentId);
        $application->status = $status->name;
        $application->update();
        $application->statuses()->attach($status);
        return Redirect::route('applications.service')->with('status', $status->name);
        
    }


    public function toCitizen(Application $application) {

        $statusCount = count(Status::all());
        $application->statuses()->attach($statusCount);
        $status = Status::find($statusCount);
        $application->status = $status->name;
        $application->update();
        return Redirect::route('applications.service')->with('status', $status->name);
    }   

}
