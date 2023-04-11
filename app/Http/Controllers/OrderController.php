<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Http\Resources\Orders\OrderResource;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::paginate(10);
        return response()->json([
            'data' => [
                'orders' => OrderResource::collection($orders),
            ]
        ]);
    }

    public function store(CreateOrderRequest $request)
{
    $validatedData = $request->all();
    $order = Order::create($validatedData);

    return response()->json([
        'message' => 'Order was created successfully',
        'order' => new OrderResource($order)
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
            'order' => new OrderResource($order),
        ]);
    }


    public function update(OrderUpdateRequest $request,  Order $order)
    {
        $validatedData = $request->validated();

        $order->update($validatedData);

        return response()->json([
            'message' => 'Order was updated successfully',
            'order' => new OrderResource($order)
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
