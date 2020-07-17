<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Process;
use App\Handbook;
use App\Application;
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
        return view('application.view')->with(compact('application', 'process'));
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
        $application->save();
        
        return Redirect::route('applications.service')->with('status', 'Заявка Успешно создана');
    }
}
