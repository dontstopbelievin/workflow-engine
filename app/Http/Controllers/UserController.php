<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\User;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('user.index', compact('user'));
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make( $request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:10', 'min:10'],
        ]);
        if ($validator->fails()) {
            return Redirect::back()->with('status', 'Введите правильные данные');
        }
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->update();
        return Redirect::route('user.personalArea')->with('status', 'Данные успешно обновлены');
    }
}
