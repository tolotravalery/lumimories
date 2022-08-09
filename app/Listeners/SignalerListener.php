<?php


namespace App\Listeners;

use App\Events\SignalerEvent;
use App\Models\User;
use App\Notifications\SignalerNotification;
use Illuminate\Support\Facades\Notification;

class SignalerListener
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
    public function handle(SignalerEvent $event)
    {
        $users = $event->signaler->profil->user;
        $user = User::findOrFail(2);
        $users->push($user);
        Notification::send($users, new SignalerNotification($event->signaler));
    }
}