<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginNotification extends Notification
{
    use Queueable;

    private $data;

    /**
     * Create a new notification instance.
     *
     * @param  array  $data
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
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

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
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

