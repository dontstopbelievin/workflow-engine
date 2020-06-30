<?php

namespace App\Http\Controllers\Admin;
use App\User;
use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function registered() 
    {
        $users = User::where('usertype', NULL )->get();
        return view('admin.register')->with('users', $users);
    }

    public function registeredit(Request $request, $id) 
    {
       $user = User::findOrFail($id);
      $roles = Role::all();
      return view('admin.register-edit')->with(compact('user', 'roles'));
    }

    public function registerupdate(Request $request, $id) 
    {
      $user = User::find($id);
      $user->name = $request->input('username');
      $id = $request->input('role_id');
      $user->role_id = $id;
      $user->update();
      return redirect('/role-register')->with('status','Your Data Is Updated');
   }

    public function registerdelete($id) 
    {
       $users = User::findOrFail($id);
       $users->delete();
       return redirect('/role-register')->with('status','Your Data Is Deleted');
    }
}
