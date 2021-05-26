<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'firstname' => 'required|string',
            'surname' => 'required|string',
            'lastname' => 'required|string',
            'iin' => 'required_without_all:bin',
            'bin' => 'required_without_all:iin',
            'telephone' => 'nullable|string',
            'password' => 'required|regex:/^.*(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[!$@#%]).*$/|min:8|confirmed',
            // 'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'policy' => 'required|integer',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $usertype = NULL;
        $iin = Null;
        $bin = Null;
        if ($data['iin'] !== Null) {
            $iin = $data['iin'];
        }
        if ($data['bin'] !== Null) {
            $bin = $data['bin'];
        }

        return User::create([
            'first_name' => $data['firstname'],
            'sur_name' => $data['surname'],
            'middle_name' => $data['lastname'],
            'telephone' => $data['telephone'],
            'iin' => $iin,
            'bin' => $bin,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'usertype' => $usertype,
            'role_id' => 1,
        ]);
    }
}
