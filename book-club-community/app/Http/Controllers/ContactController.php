<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactFormMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Show the contact form.
     */
    public function index()
    {
        return view('contact.index');
    }

    /**
     * Store a new contact message.
     */
    public function store(ContactRequest $request)
    {
        $validated = $request->validated();

        // Store the contact message in database
        $contact = Contact::create($validated);

        // Send email notification to admin
        try {
            Mail::to(config('mail.admin_email', 'admin@bookclub.com'))
                ->send(new ContactFormMail($contact));
        } catch (\Exception $e) {
            // Log the error but don't fail the request
            Log::error('Failed to send contact email: ' . $e->getMessage());
        }

        return redirect()->route('contact.index')
            ->with('success', 'Thank you for your message! We\'ll get back to you soon. 📧');
    }
}
