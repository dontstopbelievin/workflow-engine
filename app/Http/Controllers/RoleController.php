<?php

namespace App\Http\Controllers;

use App\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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
        dd($request->all());
        $data = $request->validate([
            'name'=>'required',
        ]);
        Role::create($data);
        return Redirect::route('role.index')->with('status', 'Роль успешно создана');
    }

    public function edit(Role $role) {
        return view('role.edit')->with(compact('role'));
    }

    public function update(Request $request, Role $role) 
    {
      $role->name = $request->input('name');
      $role->update();
      return Redirect::route('role.index')->with('status','Роль успешно обновлена');
    }

    public function delete(Role $role)
    {
        $role->users()->delete();
        $role->delete();
        return Redirect::route('role.index')->with('status','Роль успешно удалена');
    }

    public function search(Request $request) {
        $q = $request->input('q');
        
        $searchRoles = Role::search($q)->get();
        dd($searchRoles);
        $roles = Role::all();
        $time = Carbon::now();
        if(count($searchRoles) > 0)
            return view('role.index')->withDetails($searchRoles)->withQuery($q)->withRoles($roles)->withTime($time);
        else return view ('role.index')->withStatus('Нет найденных совпадений')->withRoles($roles)->withTime($time);
    }
}
