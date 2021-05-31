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
        if($user->email == $request->email){
            $request->offsetUnset('email');
        }
        $validator = Validator::make( $request->all(),[
            'sur_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:10', 'min:10'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'iin' => 'required_without_all:bin',
            'bin' => 'required_without_all:iin',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->with('error', $validator->errors()->all());
        }
        $user->sur_name = $request->sur_name;
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->telephone = $request->phone;
        if($request->email){
            $user->email = $request->email;
        }
        if($request->iin){
            $user->iin = $request->iin;
        }
        if($request->bin){
            $user->bin = $request->bin;
        }
        $user->update();
        return Redirect::back()->with('status', 'Данные успешно обновлены');
    }

    public function change_pass(User $user)
    {
        return view('user.change_pass', compact('user'));
    }

    public function change_password(Request $request)
    {
        $validator = Validator::make( $request->all(),[
            'cur_password' => 'required',
            'password' => 'required|regex:/^.*(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[!$@#%]).*$/|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->with('error', $validator->errors()->all());
        }

        $user = Auth::user();
        if(\Hash::check($user->password, $request->cur_password)){
            return Redirect::back()->with('error', 'Текущий пароль не верный!');   
        }

        $user->password = \Hash::make($request->password);
        $user->new_password = 0;
        $user->update();

        return Redirect::back()->with('status', 'Пароль успешно изменен');
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