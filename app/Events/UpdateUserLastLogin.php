<?php

namespace App\Events;

use Illuminate\Auth\Events\Login;
use Carbon\Carbon;

class UpdateUserLastLogin
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
        try {
            $user = $event->user;
            $user->last_login = Carbon::now()->toDateTimeString();
            $user->save();
        } catch (\Throwable $th) {
            report($th);
        }
    }
}