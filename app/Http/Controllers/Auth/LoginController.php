<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    protected function redirectTo() {
        return 'services';
    }

    /**
     * Create a new controller instance.
     * 
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = \DB::table('users')->where('email', $request->input('email'))->first();

        if (auth()->guard('web')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {

            $new_sessid   = \Session::getId(); //get new session_id after user sign in

            if($user->session_id != '') {
                $last_session = \Session::getHandler()->read($user->session_id);

                if ($last_session) {
                    if (\Session::getHandler()->destroy($user->session_id)) {

                    }
                }
            }

            \DB::table('users')->where('id', $user->id)->update(['session_id' => $new_sessid]);

            $user = auth()->guard('web')->user();
            $myfile = fopen(base_path()."../public/storage/logs/logfile.txt", "a") or die("Unable to open file!");
            $mytime = Carbon::now()->toDateTimeString();
            $txt = $user->name . ' '. $user->email . ' ' . $mytime . ' ' . "Успешный вход в систему\r\n";
            fwrite($myfile, $txt);
            fclose($myfile);

//            return Redirect::route('applications.service');

            return redirect($this->redirectTo());
        }
        \Session::put('login_error', 'Your email and password wrong!!');
        $myfile = fopen(base_path()."../public/storage/logs/logfile.txt", "a") or die("Unable to open file!");
        $mytime = Carbon::now()->toDateTimeString();
        $txt = $user->name . ' '. $user->email . ' ' . $mytime . ' ' . "Не успешный вход в систему\r\n";
        fwrite($myfile, $txt);
        fclose($myfile);
        return back();

    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        \Session::flush();
        \Session::put('success','you are logout Successfully');
        $myfile = fopen(base_path()."../public/storage/logs/logfile.txt", "a") or die("Unable to open file!");
        $mytime = Carbon::now()->toDateTimeString();
        $txt = $user->name . ' ' . $user->email . ' ' . $mytime . ' ' . "Успешный выход из системы\r\n";
        fwrite($myfile, $txt);
        fclose($myfile);
        return redirect()->to('/login');
    }
}
