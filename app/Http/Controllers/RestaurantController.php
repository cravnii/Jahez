<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestaurantStoreRequest;
use App\Http\Requests\RestaurantUpdateRequest;
use App\Http\Resources\Restaurants\RestaurantsResource;
use App\Models\Restaurant;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::paginate(10);
        return response()->json([
            'data' => [
                'restaurants' => RestaurantsResource::collection($restaurants),
            ]
        ]);
    }

    public function store(RestaurantStoreRequest $request)
    {
        $validatedData = $request->validated();
        Restaurant::create($validatedData);

        return response()->json([
            'message' => 'Restaurant was created successfully'
        ]);
    }

    public function show(Restaurant $restaurant)
    {
        if (!$restaurant) {
            return response()->json([
                'message' => 'Restaurant not found'
            ], 404);
        }

        return response()->json([
            'restaurant' => new RestaurantsResource($restaurant),
        ]);
    }

    public function update(RestaurantUpdateRequest $request, Restaurant $restaurant)
    {
        $validatedData = $request->validated();

        $restaurant->update($validatedData);

        return response()->json([
            'message' => 'Restaurant was updated successfully'
        ]);
    }

    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();
        return response()->json([
            'message' => 'Restaurant deleted successfully'
        ]);
    }
}
