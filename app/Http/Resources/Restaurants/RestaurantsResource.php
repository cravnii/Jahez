<?php

namespace App\Http\Resources\restaurants;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class RestaurantsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'location' => $this->location
        ];
    }
}
