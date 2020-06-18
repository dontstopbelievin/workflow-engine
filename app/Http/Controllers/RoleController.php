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

    public function create() {
        return view('role.create');
    }
    public function store(Request $request) {
        // dd($request->get('role_name'));
        $request->validate([
            'role_name'=>'required',
        ]);

        $role = new Role([
            'role_name' => $request->get('role_name')
        ]);
        // dd($role);
        $role->save();
        return redirect('/roles')->with('status', 'Role was succesfully Added');
    }
}
