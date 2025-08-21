<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Review::with(['user', 'book']);

        // Filter by rating
        if ($request->filled('stars')) {
            $query->where('rating', $request->stars);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('book', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            })->orWhereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $reviews = $query->latest()->paginate(12);

        return view('reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReviewRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        // Map 'stars' field to 'rating' for database
        if (isset($validated['stars'])) {
            $validated['rating'] = $validated['stars'];
            unset($validated['stars']);
        }

        // Check if user already reviewed this book
        $existingReview = Review::where('user_id', auth()->id())
                               ->where('book_id', $validated['book_id'])
                               ->first();

        if ($existingReview) {
            return redirect()->back()
                ->with('error', 'You have already reviewed this book! You can edit your existing review instead. 📝');
        }

        Review::create($validated);

        return redirect()->back()
            ->with('success', 'Review added successfully! Thanks for sharing your thoughts! ⭐');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(ReviewRequest $request, Review $review)
    {
        // Check if user owns this review
        if ($review->user_id !== auth()->id()) {
            return redirect()->back()
                ->with('error', 'You can only edit your own reviews! 🚫');
        }

        $validated = $request->validated();

        // Map 'stars' field to 'rating' for database
        if (isset($validated['stars'])) {
            $validated['rating'] = $validated['stars'];
            unset($validated['stars']);
        }

        $review->update($validated);

        return redirect()->back()
            ->with('success', 'Review updated successfully! ✨');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        // Check if user owns this review
        if ($review->user_id !== auth()->id()) {
            return redirect()->back()
                ->with('error', 'You can only delete your own reviews! 🚫');
        }

        $review->delete();

        return redirect()->back()
            ->with('success', 'Review deleted successfully! 🗑️');
    }
}
