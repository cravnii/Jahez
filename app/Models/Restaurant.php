<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Restaurant extends Model
{
    protected $fillable = ['name', 'phone_number', 'email', 'location'];

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required'],
            'phone_number' => ['required'],
            'email' => ['required'],
            'location' => ['required'],
        ]);

        return self::create($validatedData);
    }
}


