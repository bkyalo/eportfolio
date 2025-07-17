<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::latest()->paginate(10);
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'brief_description' => 'required|string',
            'description' => 'nullable|string',
            'stack' => 'required|string',
            'is_live' => 'boolean',
            'is_public' => 'boolean',
            'github_url' => 'nullable|url',
            'live_url' => 'nullable|url',
            'status' => 'required|in:complete,in_progress,planned',
            'is_small_project' => 'boolean',
            'image' => 'nullable|image|max:2048',
            'featured_image' => 'nullable|image|max:2048',
            'demo_video_url' => 'nullable|url',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'client' => 'nullable|string|max:255',
            'client_url' => 'nullable|url',
            'technologies' => 'nullable|array',
            'technologies.*' => 'string|max:255',
            'platforms' => 'nullable|array',
            'platforms.*' => 'string|max:255',
            'challenges' => 'nullable|string',
            'solutions' => 'nullable|string',
            'results' => 'nullable|string',
            'testimonial' => 'nullable|string',
            'testimonial_author' => 'nullable|string|max:255',
            'testimonial_author_role' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'order' => 'nullable|integer|min:0',
        ]);

        $project = new Project();
        $project->fill($validated);
        $project->slug = Str::slug($validated['title']);
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('project-images', 'public');
            $project->image_path = $path;
        }

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('project-images/featured', 'public');
            $project->featured_image_path = $path;
        }

        // Handle technologies and platforms as JSON
        if (isset($validated['technologies'])) {
            $project->technologies = json_encode($validated['technologies']);
        }
        
        if (isset($validated['platforms'])) {
            $project->platforms = json_encode($validated['platforms']);
        }

        $project->save();

        return redirect()->route('admin.projects.index')
                         ->with('success', 'Project created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'brief_description' => 'required|string',
            'description' => 'nullable|string',
            'stack' => 'required|string',
            'is_live' => 'boolean',
            'is_public' => 'boolean',
            'github_url' => 'nullable|url',
            'live_url' => 'nullable|url',
            'status' => 'required|in:complete,in_progress,planned',
            'is_small_project' => 'boolean',
            'image' => 'nullable|image|max:2048',
            'featured_image' => 'nullable|image|max:2048',
            'demo_video_url' => 'nullable|url',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'client' => 'nullable|string|max:255',
            'client_url' => 'nullable|url',
            'technologies' => 'nullable|array',
            'technologies.*' => 'string|max:255',
            'platforms' => 'nullable|array',
            'platforms.*' => 'string|max:255',
            'challenges' => 'nullable|string',
            'solutions' => 'nullable|string',
            'results' => 'nullable|string',
            'testimonial' => 'nullable|string',
            'testimonial_author' => 'nullable|string|max:255',
            'testimonial_author_role' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'order' => 'nullable|integer|min:0',
        ]);

        $project->fill($validated);
        
        // Update slug only if title changed
        if ($project->isDirty('title')) {
            $project->slug = Str::slug($validated['title']);
        }
        
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($project->image_path) {
                Storage::disk('public')->delete($project->image_path);
            }
            $path = $request->file('image')->store('project-images', 'public');
            $project->image_path = $path;
        }

        if ($request->hasFile('featured_image')) {
            // Delete old featured image if exists
            if ($project->featured_image_path) {
                Storage::disk('public')->delete($project->featured_image_path);
            }
            $path = $request->file('featured_image')->store('project-images/featured', 'public');
            $project->featured_image_path = $path;
        }

        // Handle technologies and platforms as JSON
        if (isset($validated['technologies'])) {
            $project->technologies = json_encode($validated['technologies']);
        }
        
        if (isset($validated['platforms'])) {
            $project->platforms = json_encode($validated['platforms']);
        }

        $project->save();

        return redirect()->route('admin.projects.index')
                         ->with('success', 'Project updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if ($project->image_path) {
            Storage::disk('public')->delete($project->image_path);
        }
        
        if ($project->featured_image_path) {
            Storage::disk('public')->delete($project->featured_image_path);
        }
        
        $project->delete();

        return redirect()->route('admin.projects.index')
                         ->with('success', 'Project deleted successfully!');
    }

    /**
     * Toggle the publish status of a project.
     */
    public function togglePublish(Project $project)
    {
        $project->update([
            'is_public' => !$project->is_public
        ]);

        $status = $project->is_public ? 'published' : 'unpublished';
        
        return redirect()->back()
            ->with('success', "Project {$status} successfully");
    }
}
