<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::all();
        
        return view('stocks.index', compact('stocks'));
    }

    public function create()
    {
        return view('stocks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'aisle' => 'required|string|max:50',
            'quantity_store' => 'required|integer|min:0',
            'quantity_storage' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0.01',
            'SKU' => 'required|string|unique:stocks|max:50',
        ]);

        Stock::create($validated);
        
        return redirect()->route('stocks.index')
                        ->with('success', 'Stock item added successfully!');
    }

    public function show(Stock $stock)
    {
        return view('stocks.show', compact('stock'));
    }

    public function edit(Stock $stock)
    {
        return view('stocks.edit', compact('stock'));
    }

    public function update(Request $request, Stock $stock)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'aisle' => 'required|string|max:50',
            'quantity_store' => 'required|integer|min:0',
            'quantity_storage' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0.01',
            'SKU' => 'required|string|unique:stocks,SKU,' . $stock->id . '|max:50',
        ]);

        $stock->update($validated);
        
        return redirect()->route('stocks.show', $stock)
                        ->with('success', 'Stock item updated successfully!');
    }

    public function destroy(Stock $stock)
    {
        $name = $stock->name;
        $stock->delete();
        
        return redirect()->route('stocks.index')
                        ->with('success', "Stock item '{$name}' has been deleted successfully!");
    }
}

