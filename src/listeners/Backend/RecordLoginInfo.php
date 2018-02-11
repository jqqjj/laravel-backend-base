<?php

namespace App\Listeners\Backend;

use App\Events\AdminAccessedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;

class RecordLoginInfo
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
     * @param  AdminAccessedEvent  $event
     * @return void
     */
    public function handle(AdminAccessedEvent $event)
    {
        $admin = $event->admin;
        Session::put("backend_last_login_time",$admin->last_login_time);
        Session::put("backend_last_login_ip",$admin->last_login_ip);
        $admin->last_login_ip = Request::server('REMOTE_ADDR');
        $admin->last_login_time = date("Y-m-d H:i:s");
        $admin->save();
    }
}
