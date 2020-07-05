<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RoleController extends Controller
{
    public function index() {
        $roles = Role::all();
        $time = Carbon::now();
        return view('role.index')->with(compact('roles', 'time'));
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
        $data = $request->validate([
            'name'=>'required',
        ]);

        Role::create($data);
        return redirect('/roles')->with('status', 'Роль успешно создана');
    }

    public function edit($id) {
        $role = Role::findOrFail($id);
        return view('role.edit')->with('role', $role);
    }

    public function update(Request $request, $id) 
    {
      $role = Role::find($id);
      $role->name = $request->input('name');
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
