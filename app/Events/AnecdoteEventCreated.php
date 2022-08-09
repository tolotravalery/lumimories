<?php


namespace App\Events;


use App\Models\Anecdote;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AnecdoteEventCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $anecdote;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Anecdote $anecdote)
    {
        $this->anecdote = $anecdote;
    }
}