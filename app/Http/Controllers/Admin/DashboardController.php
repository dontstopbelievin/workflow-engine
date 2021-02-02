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
    public function index()
    {
      return view('admin.dashboard');
    }

    public function registered()
    {
        $users = User::all();
        return view('admin.register')->with('users', $users);
    }

    public function registeredit(User $user)
    {
        if(isset($user->role)) {
            $roles = Role::all()->whereNotIn('id', [$user->role->id]);
        } else {
            $roles = Role::all();
        }
      return view('admin.register-edit', compact('user', 'roles'));
    }

    public function registerupdate(Request $request, User $user)
    {
      $admin = Auth::user()->name;
      $roleName = '';
      if ($user->role) {
          $roleName = $user->role->name;
      }

      $newRoleName = Role::find($request->role_id)->name;
        $user->name = $request->username;
        $user->role_id = $request->role_id;
        $user->update();

      $mytime = Carbon::now()->toDateTimeString();
      $txt = $mytime . ' ' . $admin . ' ' . 'поменял роль' . ' ' . $user->name . ' ' . 'с' . ' ' . $roleName . ' ' . 'на' . ' ' . $newRoleName . ' ' . "\r\n" ;
      file_put_contents(storage_path('logs/logfile.txt'), $txt, FILE_APPEND | LOCK_EX);
//        fwrite($myfile, $txt);
//        fclose($myfile);
      return Redirect::route('user-role.register')->with('status','Данные пользователя изменены');
   }

    public function registerdelete(User $user)
    {
       $user->delete();
       return Redirect::route('user-role.register')->with('status','Пользователь удален');
    }
}
