<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use Illuminate\Http\Request;

class ContractorController extends Controller
{
    public function index()
    {
        $contractors = Contractor::all();
        
        return view('contractors.index', compact('contractors'));
    }

    public function create()
    {
        return view('contractors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'employer' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'supervisor' => 'required|string|max:255'
        ]);

        Contractor::create($validated);
        
        return redirect()->route('contractors.index')
                        ->with('success', 'Contractor profile created successfully!');
    }

    public function show(Contractor $contractor)
    {
        return view('contractors.show', compact('contractor'));
    }

    public function edit(Contractor $contractor)
    {
        return view('contractors.edit', compact('contractor'));
    }

    public function update(Request $request, Contractor $contractor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'employer' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'supervisor' => 'required|string|max:255'
        ]);

        $contractor->update($validated);
        
        return redirect()->route('contractors.show', $contractor)
                        ->with('success', 'Contractor profile updated successfully!');
    }

    public function destroy(Contractor $contractor)
    {
        $name = $contractor->name;
        $contractor->delete();
        
        return redirect()->route('contractors.index')
                        ->with('success', "Contractor '{$name}' has been deleted successfully!");
    }
}