<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'device',
        'browser',
        'platform',
        'ip_address',
        'login_at',
    ];
}

