<?php

namespace App\Http\Resources\Meals;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MealsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'restaurant_id' => $this->restaurant_id,
            'name' => $this->name,
            'price' => $this->price,

        ];
    }
}
