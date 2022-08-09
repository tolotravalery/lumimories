<?php


namespace App\Events;


use App\Models\Checkgenealogie;
use Illuminate\Queue\SerializesModels;

class CheckgenealogieEventCreated
{
    use SerializesModels;
    public $check;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Checkgenealogie $check)
    {
        $this->check = $check;
    }
}