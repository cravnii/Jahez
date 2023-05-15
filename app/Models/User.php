<?php

namespace App\Models;

use App\Enums\GenderEnum;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Order;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = ['name', 'email', 'gender', 'phone_number', 'password'];


    protected $hidden = [
        'password',
        'remember_token',
    ];


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
        return $this->belongsToMany(Order::class, 'order_user', 'user_id', 'order_id');
    }
}
