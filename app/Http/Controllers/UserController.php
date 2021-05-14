<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Role;
use App\Log;
use App\Process;
use App\Dictionary;
use App\CreatedTable;
use DateTime;
use PDF;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;
use Response;
use App\Traits\dbQueries;
use App\Exports\ApplicationsExport;
use Excel;

class UserController extends Controller
{
    use dbQueries;

    public function index()
    {
        $user = Auth::user();
        $processes = DB::table('process_role')->join('processes', 'processes.id', '=', 'process_role.process_id')
                                              ->select('process_id', 'name')
                                              ->where('role_id', $user->role_id)
                                              ->get()->toArray();
        return view('user.index', compact('user', 'processes'));
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user) // HERE!!!
    {
        $validator = Validator::make( $request->all(),[
            'sur_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:10', 'min:10'],
        ]);
        if ($validator->fails()) {
            return Redirect::back()->with('status', 'Введите правильные данные');
        }
        $user->sur_name = $request->sur_name;
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->phone = $request->phone;
        $user->update();
        return Redirect::to('user/personal_area')->with('status', 'Данные успешно обновлены');
    }

    public function filter(Request $request){
        $validator = Validator::make($request->all(),[
            'process' => 'required|int',
        ], $messages = [
            'required' => 'Поле процесс обязательно для заполнения.',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->with('error', $validator->messages()->all());
        }
        return Excel::download(new ApplicationsExport($request->all()), 'Отчет по заявкам.xlsx');
    }
}