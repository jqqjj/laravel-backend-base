<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;

class BacknedLoginListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user;
        Session::put("backend_last_login_time",$user->last_login_time);
        Session::put("backend_last_login_ip",$user->last_login_ip);
        $user->last_login_ip = Request::server('REMOTE_ADDR');
        $user->last_login_time = date("Y-m-d H:i:s");
        $user->save();
    }
}
