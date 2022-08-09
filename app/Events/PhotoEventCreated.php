<?php


namespace App\Events;


use App\Models\Photo;
use Illuminate\Queue\SerializesModels;

class PhotoEventCreated
{
    use SerializesModels;
    public $photo;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Photo $photo)
    {
        $this->photo = $photo;
    }
}