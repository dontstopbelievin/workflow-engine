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
        $users = User::all();
        // dd($users);
        return view('admin.register')->with('users', $users);
    }

    public function registeredit(Request $request, $id) 
    {
       $users = User::findOrFail($id);
       $roles = Role::pluck('role_name')->toArray();  
      return view('admin.register-edit')->with(compact('users', 'roles'));
    }

    public function registerupdate(Request $request, $id) 
    {
      $users = User::find($id);
      $users->name = $request->input('username');
      $id = Role::where('role_name', $request->input('role_name'))->pluck('id');
      $users->role_id = $id[0];
      $users->update();
      return redirect('/role-register')->with('status','Your Data Is Updated');
   }

    public function registerdelete($id) 
    {
       $users = User::findOrFail($id);
       $users->delete();
       return redirect('/role-register')->with('status','Your Data Is Deleted');
    }
}
