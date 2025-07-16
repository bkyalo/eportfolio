<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PortfolioController extends Controller
{
    public function index()
    {
        $projects = [
            [
                'title' => 'E-Commerce Platform',
                'description' => 'A full-featured e-commerce platform with product management, cart, and payment integration.',
                'tech_stack' => 'Laravel, Vue.js, Tailwind CSS, MySQL',
                'image' => 'images/projects/ecommerce.jpg',
                'category' => 'Web Application',
                'live_url' => '#',
                'code_url' => '#',
                'accent' => 'purple'
            ],
            [
                'title' => 'Task Management App',
                'description' => 'A collaborative task management application with real-time updates and team features.',
                'tech_stack' => 'React, Node.js, MongoDB, Socket.io',
                'image' => 'images/projects/taskapp.jpg',
                'category' => 'Web Application',
                'live_url' => '#',
                'code_url' => '#',
                'accent' => 'blue'
            ],
            [
                'title' => 'Portfolio Website',
                'description' => 'A responsive portfolio website built with modern web technologies.',
                'tech_stack' => 'HTML5, CSS3, JavaScript, Bootstrap 5',
                'image' => 'images/projects/portfolio.jpg',
                'category' => 'Website',
                'live_url' => '#',
                'code_url' => '#',
                'accent' => 'green'
            ],
            [
                'title' => 'IoT Home Automation',
                'description' => 'Smart home automation system with remote control and monitoring capabilities.',
                'tech_stack' => 'Raspberry Pi, Python, MQTT, React Native',
                'image' => 'images/projects/iot.jpg',
                'category' => 'IoT',
                'live_url' => '#',
                'code_url' => '#',
                'accent' => 'orange'
            ],
            [
                'title' => 'Fitness Tracker',
                'description' => 'Mobile application for tracking workouts, nutrition, and fitness progress.',
                'tech_stack' => 'React Native, Firebase, Redux',
                'image' => 'images/projects/fitness.jpg',
                'category' => 'Mobile App',
                'live_url' => '#',
                'code_url' => '#',
                'accent' => 'red'
            ],
            [
                'title' => 'CMS Platform',
                'description' => 'Content management system with role-based access control and custom themes.',
                'tech_stack' => 'Laravel, Livewire, Alpine.js, Tailwind CSS',
                'image' => 'images/projects/cms.jpg',
                'category' => 'Web Application',
                'live_url' => '#',
                'code_url' => '#',
                'accent' => 'indigo'
            ]
        ];

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
        
        return view('home', compact('projects', 'skills'));
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
