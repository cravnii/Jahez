<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Meals\StoreMealRequest;
use App\Http\Requests\Meals\UpdateMealRequest;
use App\Http\Resources\Meals\MealsResource;
use App\Models\Meal;


class MealController extends Controller
{
    public function index()
    {
        $meals = Meal::paginate(10);
        return response()->json([
            'data' => [
                'meals' => MealsResource::collection($meals),
            ]
        ]);
    }

    public function store(StoreMealRequest $request)
    {
        $validatedData = $request->validated();
        Meal::create($validatedData);

        return response()->json([
            'message' => 'Meal was sent successfully'
        ]);
    }

    public function show(Meal $meal)
    {
        if (!$meal) {
            return response()->json([
                'message' => 'Meal not found'
            ], 404);
        }

        return response()->json([
            'meal' => new MealsResource($meal),
        ]);
    }

    public function update(UpdateMealRequest $request, Meal $meal)
    {
        $validatedData = $request->validated();

        $meal->update($validatedData);

        return response()->json([
            'message' => 'Meal was updated successfully'
        ]);
    }

    public function destroy(Meal $meal)
    {
        $meal->delete();
        return response()->json([
            'message' => 'Meal deleted successfully'
        ]);
    }
}
