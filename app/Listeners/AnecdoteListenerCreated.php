<?php


namespace App\Listeners;


use App\Events\AnecdoteEventCreated;
use App\Notifications\AnecdoteNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class AnecdoteListenerCreated implements ShouldQueue
{
    /**
     * Connection for queue
     * @var string
     */
    public $connection = 'database';

    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(AnecdoteEventCreated $event)
    {
        $users = $event->anecdote->profil->usersSuivre;
        $users->push($event->anecdote->profil->user);
        Notification::send($users, new AnecdoteNotification($event->anecdote));
    }
}