<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'name',
        'price'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
