<?php

namespace App\Listeners;

use App\Events\BougieEventCreated;
use App\Notifications\AllumerBougie;
use Illuminate\Support\Facades\Notification;

class BougieListenerCreated
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
     * @param object $event
     * @return void
     */
    public function handle(BougieEventCreated $event)
    {
        $users = $event->bougie->profil->usersSuivre;
        $users->push($event->bougie->profil->user);
        Notification::send($users, new AllumerBougie($event->bougie));
    }
}
