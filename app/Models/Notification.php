<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\LoginNotification;
use Illuminate\Notifications\HasDatabaseNotifications;
use Illuminate\Notifications\Notifiable;

class Notification extends Model

{
    use HasFactory, Notifiable;
    use HasDatabaseNotifications;

    protected $fillable = [
        'type', 'notifiable_id', 'notifiable_type', 'data', 'login_data'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function sendNewMessageNotification(User $user, $message)
    {
        $notification = new LoginNotification($message);
        $user->notify($notification);

    }
}

