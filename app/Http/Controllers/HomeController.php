<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Notification;
use App\Notifications\ApproveNotification;

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

            'greeting' => 'Привет' . ', ' . $user->name,

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

}
