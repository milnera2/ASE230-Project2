<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::all();
        
        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'join_date' => 'required|date',
            'dues_paid' => 'nullable|boolean',
            'active' => 'nullable|boolean',
            'events_attended' => 'nullable|integer|min:0',
        ]);

        Member::create($validated);
        
        return redirect()->route('members.index')
                        ->with('success', 'Member added successfully!');
    }

    public function show(Member $member)
    {
        return view('members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'join_date' => 'required|date',
            'dues_paid' => 'nullable|boolean',
            'active' => 'nullable|boolean',
            'events_attended' => 'nullable|integer|min:0',
        ]);

        $member->update($validated);
        
        return redirect()->route('members.show', $member)
                        ->with('success', 'Member profile updated successfully!');
    }

    public function destroy(Member $member)
    {
        $name = $member->name;
        $member->delete();
        
        return redirect()->route('members.index')
                        ->with('success', "Member '{$name}' has been deleted successfully!");
    }
}

