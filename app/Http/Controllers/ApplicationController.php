<?php

namespace App\Http\Controllers;

use App\Process;
use App\Handbook;
use App\Application;
use App\Role;
use App\Status;
use App\CityManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpWord\TemplateProcessor;

class ApplicationController extends Controller
{
    public function service() {
        $processes = Process::all();
        return view('application.dashboard')->with(compact('processes'));
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
        return view('application.index')->with(compact('applications', 'process','statuses'));
    }

    public function view(Application $application) {
        $process = Process::find($application->process_id);
        $user = Auth::user();
        $roleId = $user->role->id; //роль действующего юзера
        $statuses = $application->statuses()->get();

        $records = $this->getRecords($application->id);
        $statusLength = sizeof($statuses);
        $status_id = $statuses[$statusLength-1]->id;
        $canApprove = $roleId === $status_id; //может ли специалист подвисывать услугу
        $toCitizen = false;
        $userRole = Role::find($roleId);
        $appRoutes = json_decode($this->getAppRoutes($process->id));

        if ($appRoutes[sizeof($appRoutes)-1] === $userRole->name) {
            $toCitizen = true; // если заявку подписывает последний специалист в обороте, заявка идет обратно к заявителю
        }

        $sendToCityArch = false;
        $appProcess = Process::find($application->process_id);
        $parentRoleId = intval($appProcess->roles()->where('parent_role_id', '<>', Null)->first()->pivot->parent_role_id);
        $sendToCityArch = false;
        $sendToUpravlenie = false;
        $thisRole = $user->role;
        $name_upr = CityManagement::find($thisRole->city_management_id)->name;
        if ($roleId === $parentRoleId) {
            if ($name_upr === 'Управление') {
                $sendToCityArch = true;
            } else {
                $sendToUpravlenie = true;
            }
          
        }
        // dd($sendToCityArch, $sendToUpravlenie);
        return view('application.view')->with(compact('application', 'process','canApprove', 'toCitizen','records','sendToCityArch','sendToUpravlenie'));
    }

    public function create(Request $request, Process $process) {
        $fields = $process->handbook;
        $field_keys = array_keys(array_filter($fields->toArray()));
        $field_keys = array_slice($field_keys, 1, count($field_keys)-5);
        return view('application.create')->with(compact('process', 'field_keys'));
    }

    public function store(Process $process, Request $request) {
        $id = $request->input('process_id');
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
        $nextR = Role::where('name', $nextRole)->pluck('id'); //find $nextRole in Role table
        $idOfNextRole = $nextR[0]; // get first element of array
        $application->index = $index + 1;
        $status = Status::find($idOfNextRole);
        $application->status = $status->name;
        $application->update();
         // находим следующую роль в маршрутах и присваиваем заявке его статус
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

    public function getAppRoutes($id) {
        $routes = DB::table('roles')
            ->join('process_role', 'roles.id','=', 'process_role.role_id')
            ->select('name')
            ->where('process_role.process_id', '=', $id)
            ->get()->toArray();
        $json  = json_encode($routes);
        $array = json_decode($json, true);
        $res = array();
        foreach($array as  $arr) {
            foreach($arr as $key => $value) {
                array_push($res, $value);
            }
        }
        return json_encode($res);
    }

    public function getRecords($id) {
        return DB::table('statuses')
        ->join('application_status', 'statuses.id', '=', 'application_status.status_id')
        ->select('statuses.name', 'application_status.updated_at')
        ->where('application_status.application_id', $id)
        ->get();
    }
}
