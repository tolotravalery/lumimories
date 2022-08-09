<?php

namespace App\Events;

use App\Models\Bougie;
use Illuminate\Queue\SerializesModels;

class BougieEventCreated
{
    use SerializesModels;
    public $bougie;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Bougie $bougie)
    {
        $this->bougie = $bougie;
    }
}
