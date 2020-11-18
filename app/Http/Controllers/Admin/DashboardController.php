<?php

namespace App\Http\Controllers\Admin;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{   
    public function index() {

      return view('admin.dashboard');
    }

    public function registered() {
      
        $users = User::all();
        return view('admin.register')->with('users', $users);
    }

    public function registeredit(User $user) {

      $roles = Role::all();
      return view('admin.register-edit', compact('user', 'roles'));
    }

    public function registerupdate(Request $request, User $user)
    {
//        dd($user);
        $admin = Auth::user()->name;
        $roleName = '';
        if ($user->role) {
            $roleName = $user->role->name;
        }

        $newRoleName = Role::find($request->role_id)->name;
      $user->name = $request->username;
      $user->role_id = $request->role_id;
      $user->update();
//      dd($user);

//        $myfile = fopen("../public/storage/logs/logfile.txt", "a") or die("Unable to open file!");
        $mytime = Carbon::now()->toDateTimeString();
        $txt = $admin . ' ' . 'поменял роль' . ' ' . $user->name . ' ' . 'с' . ' ' . $roleName . ' ' . 'на' . ' ' . $newRoleName . ' ' .  $mytime . "\r\n" ;
        file_put_contents(storage_path('logs/logfile.txt'), $txt, FILE_APPEND | LOCK_EX);
//        fwrite($myfile, $txt);
//        fclose($myfile);
      return Redirect::route('user-role.register')->with('status','Данные пользователя изменены');
   }

    public function registerdelete(User $user) {

       $user->delete();
       return Redirect::route('user-role.register')->with('status','Пользователь удален');
    }
}
