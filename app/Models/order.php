<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'total_price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function meals()
    {
        return $this->belongsToMany(Meal::class, 'order_meals')
            ->withPivot('price');
    }


    public function orderMeals()
    {
        return $this->hasMany(OrderMeals::class);
    }
}
