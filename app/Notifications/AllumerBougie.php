<?php

namespace App\Notifications;

use App\Models\Bougie;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AllumerBougie extends Notification
{
    private $bougie;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Bougie $bougie)
    {
        $this->bougie = $bougie;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $nombre = $this->bougie->profil->nbreBougie+1;
        return (new MailMessage)
                    ->greeting(" ")
                    ->from("contact@lumimories.com","Lumimories")
                    ->subject($this->bougie->nom != "" ? __('website.text-email-subject-allumer-bougie', ['name' =>$this->bougie->nom]) : __('website.text-email-subject-allumer-bougie-global'))
                    ->line(__('website.text-email-allumer-bougie'))
                    ->line( $this->bougie->nom != "" ? __('website.text-email-allumer-bougie-line-1',['candles' => $nombre, 'name' => $this->bougie->profil->nomFirstProfil(), 'nameSender' => $this->bougie->nom]) : __('website.text-email-allumer-bougie-line-1-global',['candles' => $nombre, 'name' => $this->bougie->profil->nomFirstProfil()]))
                    ->line(__('website.text-email-affectionately') . ",")
                    ->salutation(__('website.text-email-slogan'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
