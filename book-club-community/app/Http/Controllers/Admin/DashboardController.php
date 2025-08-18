<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Contact;
use App\Models\Faq;
use App\Models\News;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Get statistics for dashboard
        $stats = [
            'total_users' => User::count(),
            'new_users_this_month' => User::whereMonth('created_at', now()->month)->count(),
            'total_books' => Book::count(),
            'total_reviews' => Review::count(),
            'total_news' => News::count(),
            'published_news' => News::published()->count(),
            'total_faqs' => Faq::count(),
            'published_faqs' => Faq::published()->count(),
            'total_contacts' => Contact::count(),
            'unread_contacts' => Contact::where('is_read', false)->count(),
        ];

        // Get recent activity
        $recent_users = User::latest()->take(5)->get();
        $recent_contacts = Contact::latest()->take(5)->get();
        $recent_reviews = Review::with(['user', 'book'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_users', 'recent_contacts', 'recent_reviews'));
    }
}
