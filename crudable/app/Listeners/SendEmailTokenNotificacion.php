<?php

namespace App\Listeners;

use App\Notifications\RegisterToken;
use App\Events\RegisteredToken;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendEmailTokenNotificacion
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
     * @param  \Events\RegisteredToken  $event
     * @return void
     */
    public function handle(RegisteredToken $event)
    {
        Notification::route("mail",$event->correo)->notify(new RegisterToken($event->correo));
    }
}
