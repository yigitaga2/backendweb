<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('publisher', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        // Filter by publisher
        if ($request->filled('publisher')) {
            $query->where('publisher', $request->publisher);
        }

        $books = $query->latest()->paginate(12);
        $publishers = Book::distinct()->pluck('publisher')->filter()->sort();

        return view('books.index', compact('books', 'publishers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        $validated = $request->validated();

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('book-covers', 'public');
            $validated['cover_image'] = $path;
        }

        $book = Book::create($validated);

        return redirect()->route('books.show', $book)
            ->with('success', 'Book added successfully! 📚');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book->load(['reviews.user', 'users']);
        $userBook = null;

        if (auth()->check()) {
            $userBook = auth()->user()->books()->where('book_id', $book->id)->first();
        }

        return view('books.show', compact('book', 'userBook'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
