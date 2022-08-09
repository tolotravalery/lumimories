<?php


namespace App\Notifications;

use App\Models\Contact;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactNotification extends Notification
{
    private $contact;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
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
            ->from("contact@lumimories.com","Lumimories")
            ->subject(__('website.text-email-contact-subject'))
            ->cc(__('contact@lumimories.com'))
            ->line(__('website.profile-of',['name' => $this->contact->profil->nomFirstProfil()]))
            ->line(__('website.author')." : ".$this->contact->auteur)
            ->line(__('Email : ' . $this->contact->email))
            ->line(__('Message : ' . $this->contact->message))
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
