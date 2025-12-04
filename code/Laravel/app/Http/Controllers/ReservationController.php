<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::all();
        
        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        return view('reservations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'time_start' => 'required|date',
            'time_end' => 'required|date|after:time_start',
            'num_guests' => 'required|integer|min:1',
            'is_purchased' => 'nullable|boolean',
        ]);

        Reservation::create($validated);
        
        return redirect()->route('reservations.index')
                        ->with('success', 'Reservation created successfully!');
    }

    public function show(Reservation $reservation)
    {
        return view('reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        return view('reservations.edit', compact('reservation'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'time_start' => 'required|date',
            'time_end' => 'required|date|after:time_start',
            'num_guests' => 'required|integer|min:1',
            'is_purchased' => 'nullable|boolean',
        ]);

        $reservation->update($validated);
        
        return redirect()->route('reservations.show', $reservation)
                        ->with('success', 'Reservation updated successfully!');
    }

    public function destroy(Reservation $reservation)
    {
        $name = $reservation->name;
        $reservation->delete();
        
        return redirect()->route('reservations.index')
                        ->with('success', "Reservation for '{$name}' has been deleted successfully!");
    }
}