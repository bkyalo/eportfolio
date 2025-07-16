<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            'stack' => 'required|string',
            'is_live' => 'boolean',
            'github_url' => 'nullable|url',
            'live_url' => 'nullable|url',
            'status' => 'required|in:complete,in_progress',
            'is_small_project' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        $project = new Project();
        $project->fill($validated);
        $project->slug = Str::slug($validated['title']);
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('project-images', 'public');
            $project->image_path = $path;
        }

        $project->save();

        return redirect()->route('projects.index')
                         ->with('success', 'Project created successfully.');
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
            'stack' => 'required|string',
            'is_live' => 'boolean',
            'github_url' => 'nullable|url',
            'live_url' => 'nullable|url',
            'status' => 'required|in:complete,in_progress',
            'is_small_project' => 'boolean',
            'image' => 'nullable|image|max:2048',
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

        $project->save();

        return redirect()->route('projects.index')
                         ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if ($project->image_path) {
            Storage::disk('public')->delete($project->image_path);
        }
        
        $project->delete();

        return redirect()->route('projects.index')
                         ->with('success', 'Project deleted successfully.');
    }
}
