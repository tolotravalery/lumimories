<?php


namespace App\Notifications;


use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NousContacterNotification extends Notification
{
    private $nousContacter;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($nousContacter)
    {
        $this->nousContacter = $nousContacter;
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
            ->from("contact@lumimories.com","Lumimories")
            ->subject($this->nousContacter->objet)
            ->greeting(" ")
            ->line("Nom :". $this->nousContacter->nom." ". $this->nousContacter->prenom)
            ->line("Telephone :". $this->nousContacter->tel)
            ->line("Email :". $this->nousContacter->email)
            ->line("Message :")
            ->line($this->nousContacter->message)
            //->line(__('website.text-email-affectionately') . ",")
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