<?php

namespace App\Http\Controllers\Admin;
use App\User;
use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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

    public function registerupdate(Request $request, User $user) {

      $user->name = $request->username;
      $user->role_id = $request->role_id;
      $user->update();
      return Redirect::route('user-role.register')->with('status','Данные пользователя изменены');
   }

    public function registerdelete(User $user) {

       $user->delete();
       return Redirect::route('user-role.register')->with('status','Пользователь удален');
    }
}
