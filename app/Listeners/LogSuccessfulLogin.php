<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\LoginActivity;

class LogSuccessfulLogin
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
        $store_log_activity = new LoginActivity();
        $store_log_activity->user_id = $event->user->id;
        $store_log_activity->user_name = $event->user->name;
        $store_log_activity->user_agent = \Illuminate\Support\Facades\Request::header('User-Agent');
        $store_log_activity->ip_address =\Illuminate\Support\Facades\Request::ip();
        $store_log_activity->save();

    }
}
