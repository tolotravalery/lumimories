<?php


namespace App\Notifications;


use App\Models\Profil;
use Illuminate\Notifications\Messages\MailMessage;

class AnniversaireDecesEmail extends MailMessage
{
    protected $content;
    protected $profil;

    public function __construct(array $content, Profil $profil)
    {
        $this->content = $content;
        $this->profil = $profil;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.email-anniversaire-deces')
                    ->with($this->content);
    }
}