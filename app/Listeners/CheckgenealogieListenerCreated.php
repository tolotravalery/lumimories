<?php


namespace App\Listeners;


use App\Events\CheckgenealogieEventCreated;
use App\Notifications\CheckgenealogieNotification;
use Illuminate\Support\Facades\Notification;

class CheckgenealogieListenerCreated
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
    public function handle(CheckgenealogieEventCreated $event)
    {
        Notification::send($event->check->profil->user, new CheckgenealogieNotification($event->check));
    }
}