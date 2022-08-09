<?php

namespace App\Listeners;

use App\Events\ContactEventCreated;
use App\Notifications\ContactNotification;
use Illuminate\Support\Facades\Notification;

class ContactListenerCreated
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
    public function handle(ContactEventCreated $event)
    {
        Notification::send($event->contact->profil->user, new ContactNotification($event->contact));

    }
}
