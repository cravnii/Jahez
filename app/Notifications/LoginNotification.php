<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginNotification extends Notification
{
    use Queueable;

    private $data;


    public function __construct(array $data)
    {
        $this->data = $data;
    }


    public function via($notifiable)
    {
        return ['database', 'mail'];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('emails/login.subject'))
            ->greeting(__('emails/login.greeting'))
            ->line(__('emails/login.body'))
            ->line(__('emails/login.name') . ': ' . $this->data['name'] . PHP_EOL)
            ->line(__('emails/login.email') . ': ' . $this->data['email'] . PHP_EOL)
            ->line(__('emails/login.device') . ': ' . $this->data['device'] . PHP_EOL)
            ->line(__('emails/login.browser') . ': ' . $this->data['browser'] . PHP_EOL)
            ->line(__('emails/login.platform') . ': ' . $this->data['platform'] . PHP_EOL)
            ->line('ip_address: ' . $this->data['ip_address'])
            ->line(__('emails/login.time') . ': ' . $this->data['time'] . PHP_EOL)
            ->salutation(__('emails/login.salutation'));
    }


    public function toArray($notifiable)
    {
        return [
            'type' => 'NEW_SIGN_IN',
            'notifiable_type' => get_class($notifiable),
            'notifiable_id' => $notifiable->id,
            'data' => json_encode($this->data),
        ];
    }
}
