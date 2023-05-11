<?php

namespace App\Models;

use App\Enums\GenderEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\LoginNotification;
use Jenssegers\Agent\Agent;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'gender',
        'phone_number',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'gender' => GenderEnum::class,
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_user');
    }

    public function notifyLogin(string $ip, string $userAgent): void
    {
        // get user information
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'device' => '',
            'browser' => '',
            'platform' => '',
            'IP_address' => $ip,
            'time' => now(),
        ];

        // create a new login record
        $user = Auth::user();
        $login = $user->logins()->create([
            'IP_address' => $ip,
            'user_agent' => $userAgent,
        ]);

        // get device, browser and platform information from user agent
        $agent = new Agent();
        $data['device'] = $agent->device() ?? '';
        $data['browser'] = $agent->browser() ?? '';
        $data['platform'] = $agent->platform() ?? '';

        // notify the user
        $user->notify(new LoginNotification($login));

        // create a new notification record in the database
        $this->notifications()->create([
            'type' => LoginNotification::class,
            'data' => $data,
            'user_id' => $this->id,
        ]);
    }

}

