<?php

namespace App\Http\Controllers;

use App\Process;
use App\Handbook;
use App\Application;
use App\Role;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ApplicationController extends Controller
{
    public function service() {
        $processes = Process::all();
        return view('application.dashboard')->with(compact('processes'));
    }

    public function index(Process $process) {
        $applications = Application::where('process_id', $process->id)->get();
        return view('application.index')->with(compact('applications', 'process'));
    }

    public function view(Application $application) {
        $process = Process::find($application->process_id);
        $user = Auth::user();
        $roleId = $user->role->id;
        $canApprove = $roleId === $application->status_id; //может ли специалист подвисывать услугу
        $toCitizen = false;
        $userRole = Role::find($roleId);
        $appRoutes = json_decode($application->application_routes);

        if ($appRoutes[sizeof($appRoutes)-1] === $userRole->name) {
            $toCitizen = true; // если заявку подписывает последний специалист в обороте, заявка идет обратно к заявителю
        }
        return view('application.view')->with(compact('application', 'process','canApprove', 'toCitizen'));
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
        $process = Process::find($id);
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
        $application->process_id = $process->id;
        $application->status_id = 1;
        $application->application_routes = $process->process_routes;
        $application->save();
        
        return Redirect::route('applications.service')->with('status', 'Заявка Успешно создана');
    }

    public function approve(Application $application, Request $request) {
        $index = $application->index;
        $appRoutes = json_decode($application->application_routes); // array of roles in the process
        $nextRole = $appRoutes[$index]; // find next role 
        $nextR = Role::where('name', $nextRole)->pluck('id'); //find $nextRole in Role table
        $idOfNextR = $nextR[0]; // get first element of array
        $application->status_id = $idOfNextR;
        $application->index = $index + 1;
        $application->save();
        $status = Status::find($idOfNextR); // находим следующую роль в маршрутах и присваиваем заявке его статус
        $application->statuses()->attach($status);
        return Redirect::route('applications.service')->with('status', $status->name);
    }

    public function toCitizen(Application $application, Request $request) {
        $statusCount = count(Status::all());
        $application->status_id = $statusCount;
        $application->save();
        $status = Status::find($statusCount);
        return Redirect::route('applications.service')->with('status', $status->name);
    }   
}
