<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        
        return view('movies.index', compact('movies'));
    }

    public function create()
    {
        return view('movies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'producer' => 'required|string|max:255',
            'actors' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'year' => 'required|integer|min:1800|max:' . date('Y')
        ]);

        Movie::create($validated);
        
        return redirect()->route('movies.index')
                        ->with('success', 'Movie added successfully!');
    }

    public function show(Movie $movie)
    {
        return view('movies.show', compact('movie'));
    }

    public function edit(Movie $movie)
    {
        return view('movies.edit', compact('movie'));
    }

    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'producer' => 'required|string|max:255',
            'actors' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'year' => 'required|integer|min:1800|max:' . date('Y')
        ]);

        $movie->update($validated);
        
        return redirect()->route('movies.show', $movie)
                        ->with('success', 'Movie updated successfully!');
    }

    public function destroy(Movie $movie)
    {
        $name = $movie->name;
        $movie->delete();
        
        return redirect()->route('movies.index')
                        ->with('success', "Movie '{$name}' has been deleted successfully!");
    }
}
