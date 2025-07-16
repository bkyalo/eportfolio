<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactSubmissionController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of contact submissions.
     */
    public function index()
    {
        $submissions = ContactSubmission::latest()->paginate(15);
        $unreadCount = ContactSubmission::unread()->count();
        
        return view('contacts.submissions', compact('submissions', 'unreadCount'));
    }

    /**
     * Display the specified contact submission.
     */
    public function show(ContactSubmission $submission)
    {
        // Mark as read when viewed
        $submission->markAsRead();
        
        return view('contacts.show', compact('submission'));
    }

    /**
     * Remove the specified contact submission.
     */
    public function destroy(ContactSubmission $submission)
    {
        $submission->delete();
        
        return redirect()->route('contact.submissions.index')
            ->with('success', 'Submission deleted successfully.');
    }
    
    /**
     * Mark a submission as read.
     */
    public function markAsRead(ContactSubmission $submission)
    {
        $submission->markAsRead();
        
        return back()->with('success', 'Marked as read.');
    }
    
    /**
     * Mark a submission as unread.
     */
    public function markAsUnread(ContactSubmission $submission)
    {
        $submission->update(['is_read' => false]);
        
        return back()->with('success', 'Marked as unread.');
    }
}
