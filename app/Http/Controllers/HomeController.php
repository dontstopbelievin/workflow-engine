<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Process;
use App\Dictionary;
use App\Role;
use Notification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ApproveNotification;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
     {
         $this->middleware('auth');
     }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('application.dashboard');
    }

    public function sendNotification()
    {

        $user = User::find(29);



        $details = [

            'greeting' => 'Привет, '.$user->sur_name.' '.$user->first_name.' '.$user->middle_name,

            'body' => 'Это уведомление о том, что Вы должны согласовать заявку',

            'thanks' => 'Пожалуйста, зайдите на портал и согласуйте услугу',

            'actionText' => 'Workflow Engine',
//
            'actionURL' => url('/docs'),
//
            'order_id' => 101

        ];



        Notification::send($user, new ApproveNotification($details));



        dd('done');
    }

    public function report(){
        $processes = Process::all();
        $roles = Role::all();
        return view('application.reports', compact('processes', 'roles'));
    }

    public function super_admin(){
        return view('admin.super_admin');
    }

    public function change_super_admin(Request $request){
        $validator = Validator::make( $request->all(),[
          'email' => ['required', 'string', 'email', 'max:255', 'exists:users'],
        ]);
        if ($validator->fails()) {
            return Redirect::back()->with('error', $validator->errors()->all());
        }
        DB::beginTransaction();
        try {
            $user = User::where('email', $request->email)->first();
            if($user->role->name != 'Admin'){
                return Redirect::back()->with('error', 'Этот пользователь не является админом!');       
            }
            $user->usertype = 'super_admin';
            $user->update();
            $cur_user = Auth::user();
            $cur_user->usertype = null;
            $cur_user->update();
            DB::commit();
            return Redirect::to('admin/user_role/register')->with('status', 'Возможности супер админа успешно переданы.');
        } catch (Exception $e) {
            DB::rollBack();
            return Redirect::back()->with('error', $e->getMessage());
        }
    }

    public function get_token(){
        $client = new \GuzzleHttp\Client();
        $url = 'https://gis.esaulet.kz/portal/sharing/rest/generateToken';
        $user = 'admin';
        $response = $client->request(
            'POST',
            $url,
            [
                'form_params' => [
                    'username' => $user,
                    'password' => 'Adminas21!@#',
                    'client' => 'referer',
                    'ip' => '',
                    'referer' => env('APP_URL', 'http://workflow.back'),
                    'expiration' => 1440,
                    'f' => 'pjson',
                ]
            ]
        );
        $result = json_decode($response->getBody(), true);
        $result['user'] = $user;
        return $result;
    }
}