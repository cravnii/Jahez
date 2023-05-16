<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;


    public $token;


    public function __construct($token)
    {
        $this->token = $token;
    }


    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }


    public function toMail($notifiable)
    {
        $resetUrl = url('password/reset/' . $this->token);

        return (new MailMessage)
            ->subject(__('emails/reset.subject'))
            ->greeting(__('emails/reset.greeting'))
            ->line(__('emails/reset.body'))
            ->action(__('emails/reset.button'), $resetUrl)
            ->salutation(__('emails/reset.salutation'));
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
