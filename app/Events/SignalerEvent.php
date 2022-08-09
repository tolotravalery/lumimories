<?php


namespace App\Events;

use App\Models\Signaler;
use Illuminate\Queue\SerializesModels;

class SignalerEvent
{
    use SerializesModels;
    public $signaler;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Signaler $signaler)
    {
        $this->signaler = $signaler;
    }
}