<?php

namespace App\Http\Controllers;

use App\Models\UserContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserContactController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the user's contact information.
     */
    public function index()
    {
        $contact = Auth::user()->contact ?? new UserContact();
        return view('profile.contact', compact('contact'));
    }

    /**
     * Store or update the user's contact information.
     */
    public function store(Request $request)
    {
        $user = $request->user();
        
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'email_primary' => ['required', 'email', 'max:255'],
            'email_secondary' => ['nullable', 'email', 'max:255'],
            'phone_primary' => ['nullable', 'string', 'max:20'],
            'phone_secondary' => ['nullable', 'string', 'max:20'],
            'github_username' => ['nullable', 'string', 'max:39'], // GitHub username max length is 39
            'x_username' => ['nullable', 'string', 'max:15'], // X (Twitter) username max length is 15
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'address_line1' => ['nullable', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state_province' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'profile_photo' => ['nullable', 'image', 'max:2048'], // 2MB max
            'is_public' => ['boolean'],
            'working_hours' => ['nullable', 'array'],
            'working_hours.*.day' => ['required_with:working_hours', 'string', 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday'],
            'working_hours.*.start' => ['required_with:working_hours.*.day', 'date_format:H:i'],
            'working_hours.*.end' => ['required_with:working_hours.*.day', 'date_format:H:i', 'after:working_hours.*.start'],
            'working_hours.*.available' => ['boolean'],
        ]);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            if ($user->contact && $user->contact->profile_photo_path) {
                Storage::delete('public/' . $user->contact->profile_photo_path);
            }
            
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $validated['profile_photo_path'] = $path;
        }

        // Create or update the user's contact information
        $user->contact()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return redirect()->route('profile.contact')
            ->with('status', 'Contact information saved successfully!');
    }

    /**
     * Remove the user's profile photo.
     */
    public function destroyPhoto(Request $request)
    {
        $user = $request->user();
        
        if ($user->contact && $user->contact->profile_photo_path) {
            Storage::delete('public/' . $user->contact->profile_photo_path);
            $user->contact->update(['profile_photo_path' => null]);
            
            return back()->with('status', 'Profile photo removed.');
        }
        
        return back()->with('error', 'No profile photo found.');
    }
}
