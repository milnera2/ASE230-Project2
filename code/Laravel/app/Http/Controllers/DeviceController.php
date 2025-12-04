<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::all();
        
        return view('devices.index', compact('devices'));
    }

    public function create()
    {
        return view('devices.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'active' => 'boolean',
            'manufacturer' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'usage' => 'nullable|string'
        ]);

        Device::create($validated);
        
        return redirect()->route('devices.index')
                        ->with('success', 'Device added successfully!');
    }

    public function show(Device $device)
    {
        return view('devices.show', compact('device'));
    }

    public function edit(Device $device)
    {
        return view('devices.edit', compact('device'));
    }

    public function update(Request $request, Device $device)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'active' => 'boolean',
            'manufacturer' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'usage' => 'nullable|string'
        ]);

        $device->update($validated);
        
        return redirect()->route('devices.show', $device)
                        ->with('success', 'Device updated successfully!');
    }

    public function destroy(Device $device)
    {
        $name = $device->name;
        $device->delete();
        
        return redirect()->route('devices.index')
                        ->with('success', "Device '{$name}' has been deleted successfully!");
    }
}