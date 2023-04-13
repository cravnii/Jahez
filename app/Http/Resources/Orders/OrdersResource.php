<?php

namespace App\Http\Resources\Orders;

use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => $this->user ? [
                'id' => $this->user_id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'gender' => $this->user->gender,
                'phone_number' => $this->user->phone_number,
            ] : null,
            'restaurant' => $this->restaurant ? [
                'id' => $this->restaurant_id,
                'name' => $this->restaurant->name,
                'phone_number' => $this->restaurant->phone_number,
                'email' => $this->restaurant->email,
                'location' => $this->restaurant->location,
            ] : null,

            'total_price' => $this->total_price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }


}
