<?php

namespace App\Http\Controllers\Admin;
use App\User;
use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{   
    public function index() 
    {
      return view('admin.dashboard');
    }
    public function registered() 
    {
        $users = User::active()->get();
        return view('admin.register')->with('users', $users);
    }

    public function registeredit(Request $request, User $user) 
    {
      $roles = Role::all();
      return view('admin.register-edit')->with(compact('user', 'roles'));
    }

    public function registerupdate(Request $request, User $user) 
    {
      $user->name = $request->input('username');
      $id = $request->input('role_id');
      $user->role_id = $id;
      $user->update();
      return redirect('/role-register')->with('status','Your Data Is Updated');
   }

    public function registerdelete(User $user) 
    {
       $users = User::findOrFail($id);
       $users->delete();
       return redirect('/role-register')->with('status','Your Data Is Deleted');
    }
}
