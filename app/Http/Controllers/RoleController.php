<?php

namespace App\Http\Controllers;

use App\Role;
use App\CityManagement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $time = Carbon::now();
        return view('role.index', compact('roles', 'time'));
    }

    public function view(Role $role)
    {
        return view('role.view', compact('role'));
    }

    public function create()
    {
        $cityManagements = CityManagement::all();
        return view('role.create', compact('cityManagements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'city_management_id' => 'required',
        ]);
        $role = new Role;
        $role->name = $request->input('name');
        $role->city_management_id = $request->input('city_management_id');
        $role->save();
        return Redirect::to('admin/role')->with('status', 'Роль успешно создана');
    }

    public function edit(Role $role)
    {
        if(isset($role->cityManagement)) {
            $cityManagements = CityManagement::all()->whereNotIn('id', [$role->cityManagement->id]);
        } else {
            $cityManagements = CityManagement::all();
        }

        return view('role.edit', compact('role','cityManagements'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name'=>'required',
            'city_management_id' => 'required',
        ]);
        $role->name = $request->name;
        $role->city_management_id = $request->city_management_id;
        $role->update();
        return Redirect::to('admin/role')->with('status','Роль успешно обновлена');
    }

    public function delete(Role $role)
    {
        try {
            DB::beginTransaction();
            $role->users()->delete();
            $role->delete();
            DB::commit();
            return Redirect::to('admin/role')->with('status','Роль успешно удалена');
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function search(Request $request)
    {
        $q = $request->q;
        $searchRoles = Role::search($q)->get();
        dd($searchRoles);
        $roles = Role::all();
        $time = Carbon::now();
        if(count($searchRoles) > 0)
            return view('role.index')->withDetails($searchRoles)->withQuery($q)->withRoles($roles)->withTime($time);
        else return view ('role.index')->withStatus('Нет найденных совпадений')->withRoles($roles)->withTime($time);
    }
}
