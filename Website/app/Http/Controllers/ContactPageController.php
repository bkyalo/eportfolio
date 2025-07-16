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
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:2000',
        ]);

        // Store in database
        $contact = Contact::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email_personal' => $validated['email'],
            'phone_personal' => $validated['phone'] ?? null,
            'notes' => "Subject: {$validated['subject']}\n\n{$validated['message']}",
            'is_favorite' => false,
        ]);

        // Send email notification (optional)
        try {
            // Mail::to('your-email@example.com')->send(new ContactFormSubmitted($contact));
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
