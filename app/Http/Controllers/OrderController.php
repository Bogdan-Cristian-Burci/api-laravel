<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return Order::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'integer'],
            'amount' => ['required', 'numeric'],
            'status' => ['required'],
        ]);

        return Order::create($request->validated());
    }

    public function show(Order $order)
    {
        return $order;
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'user_id' => ['required', 'integer'],
            'amount' => ['required', 'numeric'],
            'status' => ['required'],
        ]);

        $order->update($request->validated());

        return $order;
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json();
    }
}
