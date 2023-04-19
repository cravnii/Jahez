<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\StoreOrderRequest;
use App\Http\Requests\Orders\UpdateOrderRequest;
use App\Http\Resources\Orders\OrdersResource;
use App\Models\Meal;
use App\Models\Order;
use App\Models\OrderMeal;


class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::paginate(10);
        return response()->json([
            'data' => [
                'orders' => OrdersResource::collection($orders),
            ]
        ]);
    }
    public function store(StoreOrderRequest $request)
    {
        $meals = $request->input('meals');
        $mealIds = collect($meals)->pluck('id')->toArray();
        $mealsExist = Meal::whereIn('id', $mealIds)->count() === count($mealIds);

        if (!$mealsExist) {
            return response()->json([
                'message' => 'One or more selected meals do not exist in the database',
            ], 422);
        }

        $restaurantIds = collect($meals)->pluck('restaurant_id')->unique();
        if ($restaurantIds->count() !== 1) {
            return response()->json([
                'message' => 'All meals must belong to the same restaurant',
            ], 422);
        }

        $restaurantId = $restaurantIds->first();
        if (!$restaurantId) {
            return response()->json([
                'message' => 'Invalid restaurant ID',
            ], 422);
        }

        $total_price = collect($meals)->sum('price');

        $order = Order::create([
            'user_id' => $request->input('user_id'),
            'restaurant_id' => $restaurantId,
            'total_price' => $total_price,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $orderMeals = [];
        foreach ($meals as $meal) {
            $orderMeals[] = new OrderMeal([
                'meal_id' => $meal['id'],
            ]);
        }

        $order->orderMeals()->saveMany($orderMeals);

        return response()->json([
            'message' => 'Order was created successfully',
            'order' => [
                'id' => $order->id,
                'user_id' => $order->user_id,
                'restaurant_id' => $order->restaurant_id,
                'total_price' => $order->total_price,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
            ],
        ]);
    }





    public function show(Order $order)
    {
        if (!$order) {
            return response()->json([
                'message' => 'Order not found'
            ], 404);
        }

        return response()->json([
            'order' => new OrdersResource($order),
        ]);
    }


    public function update(UpdateOrderRequest $request,  Order $order)
    {
        $validatedData = $request->validated();

        $order->update($validatedData);

        return response()->json([
            'message' => 'Order was updated successfully',
            'order' => new OrdersResource($order)
        ]);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json([
            'message' => 'Order deleted successfully'
        ]);
    }

}
