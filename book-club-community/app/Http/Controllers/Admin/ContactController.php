<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of contact messages.
     */
    public function index(Request $request)
    {
        $query = Contact::query();

        // Filter by read status
        if ($request->filled('status')) {
            $query->where('is_read', $request->status === 'read');
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $contacts = $query->latest()->paginate(20);

        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Display the specified contact message.
     */
    public function show(Contact $contact)
    {
        // Mark as read when viewed
        if (!$contact->is_read) {
            $contact->update(['is_read' => true]);
        }

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Toggle read status of a contact message.
     */
    public function toggleRead(Contact $contact)
    {
        $contact->update(['is_read' => !$contact->is_read]);

        $status = $contact->is_read ? 'marked as read' : 'marked as unread';

        return redirect()->back()
            ->with('success', "Message {$status}! 📧");
    }

    /**
     * Remove the specified contact message.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact message deleted successfully! 🗑️');
    }
}
