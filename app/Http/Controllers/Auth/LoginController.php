<?php

namespace App\Http\Controllers\Auth;

use App\Process;
use App\User;
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

    protected function redirectTo()
    {

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

            if ($user->session_id != '') {
                $last_session = \Session::getHandler()->read($user->session_id);

                if ($last_session) {
                    if (\Session::getHandler()->destroy($user->session_id)) {
                        $user = auth()->guard('web')->user();
                        $mytime = Carbon::now()->toDateTimeString();

                        $txt = $user->name . ' '. $user->email . ' ' . $mytime . ' ' . "Попытка параллельного входа в систему\r\n";
                        file_put_contents(storage_path('logs/logfile.txt'), $txt, FILE_APPEND | LOCK_EX);
                    }
                }
            }

            \DB::table('users')->where('id', $user->id)->update(['session_id' => $new_sessid]);


//            $error = true;
//            $secret = '6LcOIv4ZAAAAAPJ6Gj6X_5kG368Ck-YZ0LclzNUI';
//
//            if (!empty($_POST['g-recaptcha-response'])) {
//                $out = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
//                $out = json_decode($out);
//                if ($out->success == true) {
//                    $error = false;
//                }
//            }
//
//            if ($error) {
//                echo 'Ошибка заполнения капчи.';
//            }

            $user = auth()->guard('web')->user();
            $mytime = Carbon::now()->toDateTimeString();

            $txt = $user->name . ' ' . $user->email . ' ' . $mytime . ' ' . "Успешный вход в систему\r\n";
            file_put_contents(storage_path('logs/logfile.txt'), $txt, FILE_APPEND | LOCK_EX);

            $user->update([
                'last_login_at' => $user->current_login_at,
                'current_login_at' => Carbon::now()->toDateTimeString(),
                'last_login_ip' => $request->getClientIp()
            ]);
            $processes = Process::all();

            if (Auth::user()->name === 'Admin') {

                $modalPopup = User::where('name', 'Admin')->first()->has_not_accepted_agreement;
                return view('application.dashboard', compact('processes', 'modalPopup'));
            }
            return redirect($this->redirectTo());
        }
        \Session::put('login_error', 'Your email and password wrong!!');

        $failedUser = User::find($user->id);
        $mytime = Carbon::now()->toDateTimeString();
        $txt = $user->name . ' ' . $user->email . ' ' . $mytime . ' ' . "Не успешный вход в систему\r\n";
        file_put_contents(storage_path('logs/logfile.txt'), $txt, FILE_APPEND | LOCK_EX);

        $failedUser->update([
            'last_failed_login_at' => Carbon::now()->toDateTimeString(),
            'last_failed_login_ip' => $request->getClientIp()
        ]);
        return back();
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->has_not_accepted_agreement = true;
        $user->update();
        \Session::flush();
        \Session::put('success', 'Вы успешно вышли из системы');
        $mytime = Carbon::now()->toDateTimeString();
        $txt = $user->name . ' ' . $user->email . ' ' . $mytime . ' ' . "Успешный выход из системы\r\n";
        file_put_contents(storage_path('logs/logfile.txt'), $txt, FILE_APPEND | LOCK_EX);

        return redirect()->to('/login');
    }
}
