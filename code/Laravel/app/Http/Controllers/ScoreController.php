<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function index()
    {
        $scores = Score::all();
        
        return view('scores.index', compact('scores'));
    }

    public function create()
    {
        return view('scores.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'class_name' => 'required|string|max:255',
            'assignment_score' => 'required|integer|min:0|max:100',
            'assignment_letter_grade' => 'required|string|max:2',
            'class_score' => 'required|integer|min:0|max:100',
            'class_letter_grade' => 'required|string|max:2',
        ]);

        Score::create($validated);
        
        return redirect()->route('scores.index')
                        ->with('success', 'Score recorded successfully!');
    }

    public function show(Score $score)
    {
        return view('scores.show', compact('score'));
    }

    public function edit(Score $score)
    {
        return view('scores.edit', compact('score'));
    }

    public function update(Request $request, Score $score)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'class_name' => 'required|string|max:255',
            'assignment_score' => 'required|integer|min:0|max:100',
            'assignment_letter_grade' => 'required|string|max:2',
            'class_score' => 'required|integer|min:0|max:100',
            'class_letter_grade' => 'required|string|max:2',
        ]);

        $score->update($validated);
        
        return redirect()->route('scores.show', $score)
                        ->with('success', 'Score updated successfully!');
    }

    public function destroy(Score $score)
    {
        $name = $score->student_name;
        $class = $score->class_name;
        $score->delete();
        
        return redirect()->route('scores.index')
                        ->with('success', "Score for {$name} in {$class} has been deleted successfully!");
    }
}
