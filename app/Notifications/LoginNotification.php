<?php

namespace App\Notifications;

use App\Models\Login;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Jenssegers\Agent\Agent;

class LoginNotification extends Notification
{
    
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
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
            ->line('IP_address: ' . $this->data['ip'])
            ->line(__('emails/login.time') . ': ' . $this->data['time'] . PHP_EOL)
            ->salutation(__('emails/login.salutation'));
    }



    public function toDatabase($notifiable)
    {
        return [
            'loginData' => json_encode($this->data),
        ];
    }

}











