<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AfterEmailValidationNotification extends Notification
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
        return (new MailMessage)->subject('Confirmare activare cont')
            ->view('email-template.account-created',['name'=>$notifiable->first_name]);
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
