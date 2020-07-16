<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Process;
use App\Handbook;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ApplicationController extends Controller
{
    public function index() {
        $processes = Process::all();
        return view('application.dashboard')->with(compact('processes'));
    }

    public function create(Request $request, Process $process) {
        // dd($process->name);
        $fields = $process->handbook;
        // dd($fields);
        $field_keys = array_keys(array_filter($fields->toArray()));
        $field_keys = array_slice($field_keys, 1, count($field_keys)-5);
        // dd($field_keys);
        return view('application.create')->with(compact('process', 'field_keys'));
    }

    public function store(Process $process, Request $request) {
        $id = $request->input('process_id');
        $requestFields = array_slice($request->input(), 1);
        $field_keys = array_keys($requestFields);
        $process = Process::find($id);
        // $handbook = $process->handbook; //2
        $handbook = new Handbook;
        $columns = $handbook->getTableColumns();
        $columns = array_slice($columns, 1, -4);
        $count = 0;
        for ($i = 0; $i < count($columns); $i++) {
            for ($j = 0; $j < count($field_keys);  $j++) {
                if($columns[$i] === $field_keys[$j]) {
                    $handbook->{$columns[$i]} = $requestFields[$field_keys[$j]];                    
                }
            }
        }
        $user = Auth::user();
        $handbook->user_id = $user->id;
        $handbook->save();
        
        return Redirect::route('applications.index')->with('status', 'Заявка Успешно создана');
    }
}
