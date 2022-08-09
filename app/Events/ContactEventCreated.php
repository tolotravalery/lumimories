<?php

namespace App\Events;


use App\Models\Contact;
use Illuminate\Queue\SerializesModels;

class ContactEventCreated
{
    use SerializesModels;
    public $contact;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }
}
