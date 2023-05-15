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


    public function toMail(object $notifiable): MailMessage
    {
        $resetUrl = url('password/reset/' . $this->token);

        return (new MailMessage)
            ->subject('Reset Password')
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', $resetUrl)
            ->line('If you did not request a password reset, no further action is required.');
    }



    public function toArray(object $notifiable): array
    {
        return [];
    }
}
