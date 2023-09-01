<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AfterPurchaseNotification extends Notification
{
    public function __construct()
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)->subject('Start sesiune testare  - Intrebări asigurări')
            ->view('email-template.tests-access',['name'=>$notifiable->first_name]);
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
