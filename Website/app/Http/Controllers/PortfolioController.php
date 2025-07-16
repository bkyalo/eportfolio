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
        
        // Get projects from database
        $projects = Project::where('is_live', true)
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

        $skills = [
            [
                'title' => 'Frontend',
                'icon' => 'fas fa-laptop-code',
                'skills' => [
                    ['name' => 'HTML/CSS', 'level' => 90],
                    ['name' => 'JavaScript', 'level' => 85],
                    ['name' => 'React', 'level' => 80],
                    ['name' => 'Vue.js', 'level' => 75],
                ]
            ],
            [
                'title' => 'Backend',
                'icon' => 'fas fa-server',
                'skills' => [
                    ['name' => 'PHP/Laravel', 'level' => 85],
                    ['name' => 'Node.js', 'level' => 80],
                    ['name' => 'Python', 'level' => 70],
                    ['name' => 'SQL', 'level' => 75],
                ]
            ],
            [
                'title' => 'DevOps & Tools',
                'icon' => 'fas fa-code-branch',
                'tags' => ['Docker', 'Git', 'AWS', 'CI/CD', 'Linux', 'Bash']
            ],
            [
                'title' => 'Engineering',
                'icon' => 'fas fa-microchip',
                'tags' => ['Embedded Systems', 'IoT', 'PCB Design', 'Circuit Analysis']
            ]
        ];
        
        return view('home', compact('projects', 'contact', 'skills'));
    }

    public function projects()
    {
        $query = Project::where('status', 'complete')
                      ->latest();
        
        // Apply filters
        if (request()->has('filter')) {
            switch (request('filter')) {
                case 'featured':
                    $query->where('is_small_project', false);
                    break;
                case 'small':
                    $query->where('is_small_project', true);
                    break;
            }
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
        $projects = Project::latest()->paginate(10);
        
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
        // Get related projects (excluding the current one)
        $relatedProjects = Project::where('id', '!=', $project->id)
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
