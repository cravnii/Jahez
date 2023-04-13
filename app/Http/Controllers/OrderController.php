<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\StoreOrderRequest;
use App\Http\Requests\Orders\UpdateOrderRequest;
use App\Http\Resources\Orders\OrdersResource;
use App\Models\Order;

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
    $validatedData = $request->all();
    $order = Order::create($validatedData);

    return response()->json([
        'message' => 'Order was created successfully',
        'order' => new OrdersResource($order)
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
