<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function index()
    {
        $books = Book::all();
        
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'year' => 'required|integer|min:1800|max:' . date('Y')
        ]);

        Book::create($validated);
        
        return redirect()->route('books.index')
                        ->with('success', 'Book created successfully!');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'year' => 'required|integer|min:1800|max:' . date('Y')
        ]);

        $book->update($validated);
        
        return redirect()->route('books.show', $book)
                        ->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book)
    {
        $name = $book->name;
        $book->delete();
        
        return redirect()->route('books.index')
                        ->with('success', "Book '{$name}' has been deleted successfully!");
    }
}