<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PreExpirationNotification extends Notification
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
        return (new MailMessage)->subject('Au mai ramas 5 zile')->view('email-template.pre-expiration',['name'=>$notifiable->first_name, 'trainings'=>$this->trainings]);
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
