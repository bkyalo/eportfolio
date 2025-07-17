<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmitted;

class ContactPageController extends Controller
{
    /**
     * Show the contact form.
     */
    public function show()
    {
        $contact = \App\Models\SiteContactDetail::first();
        return view('contact', compact('contact'));
    }

    /**
     * Handle contact form submission.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // Get the authenticated user if available
        $userId = auth()->check() ? auth()->id() : null;

        // Store in contact_submissions table
        $submission = \App\Models\ContactSubmission::create([
            'user_id' => $userId,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'is_read' => false,
        ]);

        // Send email notification (optional)
        try {
            // Mail::to('your-email@example.com')->send(new ContactFormSubmitted($submission));
        } catch (\Exception $e) {
            \Log::error('Failed to send contact email: ' . $e->getMessage());
        }

        return redirect()->route('contact.thank-you')
            ->with('success', 'Thank you for your message. We will get back to you soon!');
    }

    /**
     * Show thank you page after form submission.
     */
    public function thankYou()
    {
        if (!session()->has('success')) {
            return redirect()->route('contact');
        }

        return view('thank-you');
    }
}
