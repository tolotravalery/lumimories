<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ValidationProfilMail extends Mailable
{

    use Queueable, SerializesModels;

    public $profil;

    public function __construct(Profil $d)
    {
        $this->profil = $d;
    }

    public function build()
    {
        return $this->subject("[Validation profil]")->from("contact@lumimories.com", "Lumimories")->view('email.email-validation-profil');
    }
}
