<?php

namespace App\Http\Controllers;

use App\Models\SiteContactDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SiteContactController extends Controller
{
    /**
     * Show the form for editing the site contact details.
     */
    public function edit()
    {
        $contact = SiteContactDetail::firstOrNew(['user_id' => Auth::id()]);
        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the site contact details in storage.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'job_title' => 'nullable|string|max:255',
            'github_username' => 'nullable|string|max:39',
            'x_username' => 'nullable|string|max:15',
            'linkedin_url' => 'nullable|url|max:255',
            'location' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $validated['profile_photo_path'] = $path;
        }

        // Update or create the contact details
        $contact = SiteContactDetail::updateOrCreate(
            ['user_id' => Auth::id()],
            $validated
        );

        return redirect()->route('dashboard')
            ->with('success', 'Contact details updated successfully!');
    }

    /**
     * Remove the profile photo.
     */
    public function destroyPhoto()
    {
        $contact = SiteContactDetail::where('user_id', Auth::id())->first();
        
        if ($contact && $contact->profile_photo_path) {
            Storage::disk('public')->delete($contact->profile_photo_path);
            $contact->update(['profile_photo_path' => null]);
            
            return back()->with('success', 'Profile photo removed successfully.');
        }
        
        return back()->with('error', 'No profile photo found.');
    }
}
