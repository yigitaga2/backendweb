<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class UserLibraryController extends Controller
{
    /**
     * Display the user's library.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = $user->books();

        // Filter by status
        if ($request->filled('status')) {
            $query->wherePivot('status', $request->status);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        $books = $query->latest('book_user.created_at')->paginate(12);

        return view('library.index', compact('books'));
    }

    /**
     * Add a book to user's library.
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'status' => 'required|in:want_to_read,currently_reading,read',
        ]);

        $user = auth()->user();

        // Check if book is already in library
        if ($user->books()->where('book_id', $request->book_id)->exists()) {
            return redirect()->back()
                ->with('error', 'This book is already in your library! 📚');
        }

        $user->books()->attach($request->book_id, [
            'status' => $request->status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Book added to your library! 🎉');
    }

    /**
     * Update book status in user's library.
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'status' => 'required|in:want_to_read,currently_reading,read',
        ]);

        $user = auth()->user();

        $user->books()->updateExistingPivot($book->id, [
            'status' => $request->status,
            'updated_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Reading status updated! ✨');
    }

    /**
     * Remove book from user's library.
     */
    public function destroy(Book $book)
    {
        auth()->user()->books()->detach($book->id);

        return redirect()->back()
            ->with('success', 'Book removed from your library! 🗑️');
    }
}
