<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::published()->latest()->paginate(12);

        return view('news.index', compact('news'));
    }

    /**
     * Display admin listing of all news (including drafts).
     */
    public function adminIndex(Request $request)
    {
        $query = News::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->published();
            } elseif ($request->status === 'draft') {
                $query->draft();
            }
        }

        $news = $query->latest()->paginate(12);

        return view('admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsRequest $request)
    {
        $validated = $request->validated();

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('news-images', 'public');
            $validated['featured_image'] = $path;
        }

        // Set the author
        $validated['user_id'] = auth()->id();

        // Set published_at if publishing
        if ($validated['is_published'] ?? false) {
            $validated['published_at'] = $validated['published_at'] ?? now();
        }

        $news = News::create($validated);

        return redirect()->route('news.show', $news)
            ->with('success', 'News article created successfully! 🎉');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        // If not published, only allow admins to view
        if (!$news->is_published && (!auth()->check() || !auth()->user()->isAdmin())) {
            abort(404);
        }

        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NewsRequest $request, News $news)
    {
        $validated = $request->validated();

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }

            $path = $request->file('featured_image')->store('news-images', 'public');
            $validated['featured_image'] = $path;
        }

        // Set published_at if publishing
        if ($validated['is_published'] ?? false) {
            $validated['published_at'] = $validated['published_at'] ?? $news->published_at ?? now();
        }

        $news->update($validated);

        return redirect()->route('news.show', $news)
            ->with('success', 'News article updated successfully! ✨');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        // Delete featured image if exists
        if ($news->featured_image) {
            Storage::disk('public')->delete($news->featured_image);
        }

        $news->delete();

        return redirect()->route('news.index')
            ->with('success', 'News article deleted successfully! 🗑️');
    }
}
