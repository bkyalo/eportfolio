<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ContactSubmission;
use App\Models\FunFact;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get all projects for the stats
        $projects = Project::latest()->get();
        
        // Get recent projects for the recent projects section
        $recentProjects = Project::latest()
            ->take(5)
            ->get();
            
        // Get recent contact form submissions and unread count
        $recentSubmissions = ContactSubmission::latest()
            ->take(5)
            ->get();
            
        // Count unread messages
        $unreadCount = ContactSubmission::where('is_read', false)->count();
            
        // Get visible fun facts for the dashboard
        $funFacts = FunFact::where('is_visible', true)
            ->orderBy('sort_order')
            ->get();

        // Return the dashboard view with all the data
        return view('dashboard', compact(
            'projects',
            'recentProjects',
            'recentSubmissions',
            'funFacts',
            'unreadCount'
        ));
    }
}
