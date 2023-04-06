<?php

namespace App\Http\Controllers;

use App\Http\Resources\restaurants\RestaurantsResource;
use App\Models\Restaurant;
use Illuminate\Http\Request;


class RestaurantsController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::paginate(10);
        return response()->json([
            'data' => [
               'restaurants'=> RestaurantsResource::collection($restaurants) ,
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required'],
            'phone_number' => ['required'],
            'email' => ['required'],
            'location' => ['required'],
        ]);

        Restaurant::create($validatedData);
        return redirect()->route('restaurants.index');
    }

    public function show(Restaurant $restaurant)
    {
        return view('restaurants.show', compact('restaurant'));
    }


    public function update(Request $request, Restaurant $restaurant)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
            'email' => 'required',
            'location' => 'required',
        ]);

        $restaurant->update($validatedData);

        return response()->json([
            'message' => 'User was updated successfully'
        ]);
    }

    public function destroy(Restaurant $restaurant)
    {
        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
}
