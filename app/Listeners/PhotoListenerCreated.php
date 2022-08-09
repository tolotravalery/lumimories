<?php


namespace App\Listeners;


use App\Events\PhotoEventCreated;
use App\Notifications\PhotoNotification;
use Illuminate\Support\Facades\Notification;

class PhotoListenerCreated
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
    public function handle(PhotoEventCreated $event)
    {
        $users = $event->photo->profil->usersSuivre;
        $users->push($event->photo->profil->user);
        Notification::send($users, new PhotoNotification($event->photo));
    }
}