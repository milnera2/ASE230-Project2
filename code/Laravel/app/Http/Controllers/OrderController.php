<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'is_delivered' => 'nullable|boolean',
            'last_location' => 'nullable|string|max:255',
            'current_location' => 'required|string|max:255',
            'tracking_sku' => 'required|string|unique:orders|max:50',
        ]);

        Order::create($validated);
        
        return redirect()->route('orders.index')
                        ->with('success', 'Order created and tracking initiated successfully!');
    }

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'is_delivered' => 'nullable|boolean',
            'last_location' => 'nullable|string|max:255',
            'current_location' => 'required|string|max:255',
            'tracking_sku' => 'required|string|unique:orders,tracking_sku,' . $order->id . '|max:50',
        ]);

        $order->update($validated);
        
        return redirect()->route('orders.show', $order)
                        ->with('success', 'Order updated successfully!');
    }

    public function destroy(Order $order)
    {
        $sku = $order->tracking_sku;
        $order->delete();
        
        return redirect()->route('orders.index')
                        ->with('success', "Order with SKU {$sku} has been deleted successfully!");
    }
}
