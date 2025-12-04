<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'time_requirement' => 'required|string|max:255',
            'importance' => 'required|string|max:255',
            'complete' => 'nullable|boolean',
            'completion_date' => 'nullable|date',
            'owner' => 'required|string|max:255',
        ]);

        Task::create($validated);
        
        return redirect()->route('tasks.index')
                        ->with('success', 'Task created successfully!');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'time_requirement' => 'required|string|max:255',
            'importance' => 'required|string|max:255',
            'complete' => 'nullable|boolean',
            'completion_date' => 'nullable|date',
            'owner' => 'required|string|max:255',
        ]);

        $task->update($validated);
        
        return redirect()->route('tasks.show', $task)
                        ->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        $title = $task->title;
        $task->delete();
        
        return redirect()->route('tasks.index')
                        ->with('success', "Task '{$title}' has been deleted successfully!");
    }
}
