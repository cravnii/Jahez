<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'location'
    ];


    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_user');
    }

    public function meals()
    {
        return $this->hasMany(Meal::class);
    }
}
