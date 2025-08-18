<?php

namespace App\Http\Controllers;

use App\Http\Requests\FaqRequest;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqs = Faq::published()->ordered()->get();

        return view('faq.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('faq.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FaqRequest $request)
    {
        $validated = $request->validated();

        // Set default sort order if not provided
        if (!isset($validated['sort_order'])) {
            $validated['sort_order'] = Faq::max('sort_order') + 1;
        }

        Faq::create($validated);

        return redirect()->route('faq.index')
            ->with('success', 'FAQ created successfully! 🎉');
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        // FAQs don't need individual pages, redirect to index
        return redirect()->route('faq.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        return view('faq.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FaqRequest $request, Faq $faq)
    {
        $faq->update($request->validated());

        return redirect()->route('faq.index')
            ->with('success', 'FAQ updated successfully! ✨');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('faq.index')
            ->with('success', 'FAQ deleted successfully! 🗑️');
    }
}
