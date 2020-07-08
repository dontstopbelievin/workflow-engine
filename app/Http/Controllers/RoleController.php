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

    public function view(Role $role) {

        return view('role.view')->with(compact('role'));
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

    public function edit(Role $role) {
        return view('role.edit')->with(compact('role'));
    }

    public function update(Request $request, Role $role) 
    {
      $role->name = $request->input('name');
      $role->update();
      return redirect('/roles')->with('status','Роль успешно обновлена');
    }

    public function delete(Role $role)
    {
        $role->users()->delete();
        $role->delete();
        return redirect('/roles')->with('status','Роль успешно удалена');
    }

    public function search(Request $request) {
        $q = $request->input('q');
        $searchRoles = Role::search($q)->get();
        $roles = Role::all();
        $time = Carbon::now();
        if(count($searchRoles) > 0)
            return view('role.index')->withDetails($searchRoles)->withQuery ( $q )->withRoles($roles)->withTime($time);
        else return view ('role.index')->withStatus('No Details found. Try to search again !')->withRoles($roles)->withTime($time);
    }
}
