<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SkillCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SkillCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = SkillCategory::withCount('skills')
            ->ordered()
            ->get();
            
        return view('skills.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('skills.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:skill_categories,name',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $category = SkillCategory::create($validated);

        return redirect()
            ->route('skill-categories.index')
            ->with('success', 'Skill category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SkillCategory $skillCategory)
    {
        $skillCategory->load(['skills' => function($query) {
            $query->ordered();
        }]);
        
        return view('skills.categories.show', compact('skillCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SkillCategory $skillCategory)
    {
        return view('skills.categories.edit', compact('skillCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SkillCategory $skillCategory)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('skill_categories', 'name')->ignore($skillCategory->id)
            ],
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $skillCategory->update($validated);

        return redirect()
            ->route('skill-categories.index')
            ->with('success', 'Skill category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SkillCategory $skillCategory)
    {
        if ($skillCategory->skills()->exists()) {
            return back()
                ->with('error', 'Cannot delete category with associated skills. Please remove or reassign the skills first.');
        }

        $skillCategory->delete();

        return redirect()
            ->route('skill-categories.index')
            ->with('success', 'Skill category deleted successfully!');
    }
}
