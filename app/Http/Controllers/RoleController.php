<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index() {
        $roles = Role::all();
        return view('role.index')->with('roles', $roles);
    }

    public function view($id) {
        $role = Role::findOrFail($id);
        $users = $role->users;
        return view('role.view')->with(compact('role', 'users'));
    }
 
    public function create() {
        return view('role.create');
    }
    public function store(Request $request) {
        $request->validate([
            'role_name'=>'required',
        ]);

        $role = new Role([
            'role_name' => $request->get('role_name')
        ]);
        $role->save();
        return redirect('/roles')->with('status', 'Роль успешно создана');
    }

    public function edit($id) {
        $role = Role::findOrFail($id);
        return view('role.edit')->with('role', $role);
    }

    public function update(Request $request, $id) 
    {
      $role = Role::find($id);
      $role->role_name = $request->input('role_name');
      $role->update();
      return redirect('/roles')->with('status','Роль успешно обновлена');
    }

    public function delete($id)
    {
        $role = Role::findOrFail($id);
        $role->users()->delete();
        $role->delete();
        return redirect('/roles')->with('status','Роль успешно удалена');
    }
}
