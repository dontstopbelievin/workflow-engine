<?php

namespace App\Http\Controllers\Admin;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{   
    public function index()
    {
      return view('admin.dashboard');
    }

    public function registered()
    {
        $users = User::all();
        return view('admin.register')->with('users', $users);
    }

    public function registeredit(User $user)
    {
        if(isset($user->role)) {
            $roles = Role::all()->whereNotIn('id', [$user->role->id]);
        } else {
            $roles = Role::all();
        }
      return view('admin.register-edit', compact('user', 'roles'));
    }

    public function registerupdate(Request $request, User $user)
    {
      $validator = Validator::make( $request->all(),[
          'sur_name' => ['required', 'string', 'max:255'],
          'first_name' => ['required', 'string', 'max:255'],
          'middle_name' => ['nullable', 'string', 'max:255'],
          'role_id' => ['required', 'integer'],
      ]);
      if ($validator->fails()) {
          return Redirect::back()->with('status', $validator->errors());
      }
      $roleName = '';
      if ($user->role) {
          $roleName = $user->role->name;
      }

      $user->sur_name = $request->sur_name;
      $user->first_name = $request->first_name;
      $user->middle_name = $request->middle_name;
      $user->role_id = $request->role_id;
      $user->update();

      $admin = Auth::user()->sur_name.' '.Auth::user()->first_name;
      $newRoleName = Role::find($request->role_id)->name;

      $mytime = Carbon::now()->toDateTimeString();
      $txt = $mytime . ' ' . $admin . ' ' . 'поменял роль' . ' ' . $user->first_name . ' ' . 'с' . ' ' . $roleName . ' ' . 'на' . ' ' . $newRoleName . ' ' . "\r\n" ;
      file_put_contents(storage_path('logs/logfile.txt'), $txt, FILE_APPEND | LOCK_EX);
//        fwrite($myfile, $txt);
//        fclose($myfile);
      return Redirect::to('admin/user_role/register')->with('status','Данные пользователя изменены');
   }

    public function registerdelete(User $user)
    {
       $user->delete();
       return Redirect::to('admin/user_role/register')->with('status','Пользователь удален');
    }
}
