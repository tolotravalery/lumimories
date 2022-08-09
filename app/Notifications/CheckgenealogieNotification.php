<?php


namespace App\Notifications;


use App\Models\Checkgenealogie;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CheckgenealogieNotification extends Notification
{
    private $check;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Checkgenealogie $check)
    {
        $this->check = $check;
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
        return (new MailMessage)
            ->greeting(" ")
            ->from("contact@lumimories.com","Lumimories")
            ->subject($this->check->profil->nomFirstProfil().' : '.__( 'website.check-genealogy'))
            ->line(__('website.'.$this->check->status)." " . __('website.of')." " .$this->check->profil_value->nomFirstProfil()." => " .$this->check->profil->nomFirstProfil())
            ->line(__('website.text-email-click-link'))
            ->line(__(url('/detail/' . $this->check->profil->id)))
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