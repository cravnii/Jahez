<?php

namespace App\Notifications;
use App\Models\Login;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class LoginNotification extends Notification
{
    use Queueable;
    public $loginData;
    private $name;
    private $email;
    private $device;
    private $browser;
    private $platform;
    private $ip;
    private $time;

    /**
     * Create a new notification instance.
     *
     * @param string $name
     * @param string $email
     * @param string $device
     * @param string $browser
     * @param string $platform
     * @param string $ip
     * @param string $time
     */
    public function __construct($name, $email, $device, $browser, $platform, $ip, $time)
    {
        $this->name = $name;
        $this->email = $email;
        $this->device = $device;
        $this->browser = $browser;
        $this->platform = $platform;
        $this->ip = $ip;
        $this->time = $time;

        $login = new Login([
            'name' => $this->name,
            'email' => $this->email,
            'device' => $this->device,
            'browser' => $this->browser,
            'platform' => $this->platform,
            'ip_address' => $this->ip,
            'login_at' => $this->time,
        ]);
        DB::transaction(function () use ($login, &$loginId) {
            $login->save();
            $loginId = $login->id;
        });
        $this->loginData = [
            'login_id' => $loginId,
        ];
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            ->line(__('emails/login.name') . ': ' . $this->name . PHP_EOL)
            ->line(__('emails/login.email') . ': ' . $this->email . PHP_EOL)
            ->line(__('emails/login.device') . ': ' . $this->device . PHP_EOL)
            ->line(__('emails/login.browser') . ': ' . $this->browser . PHP_EOL)
            ->line(__('emails/login.platform') . ': ' . $this->platform . PHP_EOL)
            ->line('ip_address: ' . $this->ip)
            ->line(__('emails/login.time') . ': ' . $this->time . PHP_EOL)
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
            'login_id' => $this->loginData['login_id']
        ];
    }
}

