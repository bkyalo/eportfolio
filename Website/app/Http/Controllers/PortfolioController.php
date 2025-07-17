<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\SiteContactDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PortfolioController extends Controller
{
    public function index()
    {
        // Get the contact details
        $contact = SiteContactDetail::first();
        
        // Get projects from database - only include public projects
        $projects = Project::where('is_public', true)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($project) {
                return [
                    'title' => $project->title,
                    'description' => $project->brief_description,
                    'tech_stack' => $project->stack,
                    'image' => $project->image_path ?? 'images/projects/placeholder.jpg',
                    'category' => 'Web Development', // Default category since it's not in the schema
                    'live_url' => $project->live_url ?? '#',
                    'is_live' => $project->is_live, // Add is_live status
                    'code_url' => $project->github_url ?? '#',
                    'accent' => 'purple' // Default accent color since it's not in the schema
                ];
            })->toArray();
            
        // Add fallback projects if no projects found in the database
        if (empty($projects)) {
            $projects = [
                [
                    'title' => 'Sample Project',
                    'description' => 'This is a sample project. Add your projects in the admin panel.',
                    'tech_stack' => 'Laravel, Vue.js, Tailwind CSS',
                    'image' => 'images/projects/placeholder.jpg',
                    'category' => 'Web Application',
                    'live_url' => '#',
                    'code_url' => '#',
                    'accent' => 'purple'
                ]
            ];
        }

        // Get skill categories with their active skills
        $skillCategories = \App\Models\SkillCategory::with(['activeSkills' => function($query) {
            $query->orderBy('order');
        }])->orderBy('order')->get();
        
        // Format the skills data for the view
        $skills = $skillCategories->map(function($category) {
            $categoryData = [
                'title' => $category->name,
                'icon' => $category->icon ?? 'fa fa-code', // Default icon if not set
                'skills' => []
            ];
            
            // Map skills to the required format
            if ($category->activeSkills->isNotEmpty()) {
                $categoryData['skills'] = $category->activeSkills->map(function($skill) {
                    return [
                        'name' => $skill->name,
                        'level' => $skill->proficiency ?? 0
                    ];
                })->toArray();
            }
            
            return $categoryData;
        })->toArray();
        
        // Ensure we have at least one category for the layout
        if (empty($skills)) {
            $skills = [
                [
                    'title' => 'Skills',
                    'icon' => 'fa fa-code',
                    'skills' => [
                        ['name' => 'No skills found', 'level' => 0]
                    ]
                ]
            ];
        }
        
        return view('home', compact('projects', 'contact', 'skills'));
    }

    public function projects()
    {
        $query = Project::where('is_public', true)
                      ->addSelect('*');
        
        // Debug: Log the raw SQL query
        \Log::info('Projects Query:', ['sql' => $query->toSql(), 'bindings' => $query->getBindings()]);
        
        // Get the projects
        $projects = $query->get();
        
        // Debug: Log the projects data
        \Log::info('Projects Data:', $projects->toArray());
        
        // Handle search
        if (request()->has('search')) {
            $search = request('search');
            $projects = $projects->filter(function($project) use ($search) {
                return str_contains(strtolower($project->title), strtolower($search)) ||
                       str_contains(strtolower($project->brief_description), strtolower($search)) ||
                       str_contains(strtolower($project->stack), strtolower($search));
            });
        }
        
        // Handle category filter
        if (request()->has('category')) {
            $category = request('category');
            // Assuming you have a category field in your projects table
            // If not, you might need to adjust this based on your actual database structure
            $query->where('category', $category);
        }
        
        // Handle sorting
        $sort = request('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'alphabetical':
                $query->orderBy('title');
                break;
            default: // newest
                $query->latest();
                break;
        }
        
        $projects = $query->paginate(9);
        
        return view('projects', compact('projects'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function dashboard()
    {
        // Only show public projects in the dashboard
        $projects = Project::where('is_public', true)
                         ->latest()
                         ->paginate(10);
        
        // Get unread messages count for the dashboard card
        $unreadCount = \App\Models\ContactSubmission::unread()->count();
        
        // Get contact details if they exist
        $contactDetails = \App\Models\SiteContactDetail::first();
        
        return view('dashboard', compact('projects', 'unreadCount', 'contactDetails'));
    }
    
    /**
     * Display the specified project publicly.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\View\View
     */
    public function showProject(Project $project)
    {
        // Ensure the project is public and live
        if (!$project->is_public || !$project->is_live) {
            abort(404);
        }

        // Get related public projects (excluding the current one)
        $relatedProjects = Project::where('id', '!=', $project->id)
                                ->where('is_public', true)
                                ->where('is_live', true)
                                ->where('status', 'complete')
                                ->inRandomOrder()
                                ->take(3)
                                ->get();
        
        return view('projects.public_show', [
            'project' => $project,
            'relatedProjects' => $relatedProjects
        ]);
    }
}
