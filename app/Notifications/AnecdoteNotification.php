<?php


namespace App\Notifications;


use App\Models\Anecdote;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AnecdoteNotification extends Notification
{

    private $anecdote;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Anecdote $anecdote)
    {
        $this->anecdote = $anecdote;
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
            ->greeting(" ")
            ->from("contact@lumimories.com", "Lumimories")
            ->subject($this->anecdote->profil->nomFirstProfil() . " : " . __('website.text-email-anecdote-deposited'))
            ->line(__('website.text-email-anecdote') . " " . $this->anecdote->profil->nomFirstProfil())
            ->line(__('website.text-email-click-link'))
            ->line(__(url('/detail/' . $this->anecdote->profil->id)))
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