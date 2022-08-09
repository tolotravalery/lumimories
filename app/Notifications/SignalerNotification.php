<?php


namespace App\Notifications;

use App\Models\Signaler;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SignalerNotification extends Notification
{
    private $signaler;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Signaler $signaler)
    {
        $this->signaler = $signaler;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('website.text-email-signaler-subject',['name' => $this->signaler->profil->nomFirstProfil()]))
            ->line(__('website.text-email-signaler'))
            ->line(__('website.profile-of',['name' => $this->signaler->profil->nomFirstProfil()]))
            ->line(__('website.text-email-affectionately') . ",")
            ->salutation(__('website.text-email-slogan'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}