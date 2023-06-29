<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExpirationNotification extends Notification
{
    public array $trainings;
    public function __construct($trainings)
    {
        $this->trainings=$trainings;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)->subject('Sesiunea de testare a expirat!')
            ->view('email-template.expiration',['name'=>$notifiable->first_name, 'trainings'=>$this->trainings]);
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
