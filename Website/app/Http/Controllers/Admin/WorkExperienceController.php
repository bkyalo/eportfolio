<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkExperience;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class WorkExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workExperiences = WorkExperience::latest('sort_order')
            ->latest('start_date')
            ->get();
            
        return view('work-experience.index', compact('workExperiences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('work-experience.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
        
        // Handle current job
        if ($request->has('is_current') && $request->is_current) {
            $validated['end_date'] = null;
            $validated['is_current'] = true;
        } else {
            $validated['is_current'] = false;
        }
        
        WorkExperience::create($validated);
        
        return redirect()->route('work-experience.index')
            ->with('success', 'Work experience added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkExperience $workExperience)
    {
        return view('work-experience.show', compact('workExperience'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkExperience $workExperience)
    {
        return view('work-experience.edit', compact('workExperience'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkExperience $workExperience)
    {
        $validated = $this->validateRequest($request, $workExperience->id);
        
        // Handle current job
        if ($request->has('is_current') && $request->is_current) {
            $validated['end_date'] = null;
            $validated['is_current'] = true;
        } else {
            $validated['is_current'] = false;
        }
        
        $workExperience->update($validated);
        
        return redirect()->route('work-experience.index')
            ->with('success', 'Work experience updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkExperience $workExperience)
    {
        $workExperience->delete();
        
        return redirect()->route('work-experience.index')
            ->with('success', 'Work experience deleted successfully.');
    }
    
    /**
     * Toggle the visibility of the specified resource.
     */
    public function toggleVisibility(WorkExperience $workExperience)
    {
        $workExperience->update([
            'is_visible' => !$workExperience->is_visible
        ]);
        
        $status = $workExperience->is_visible ? 'visible' : 'hidden';
        
        return back()->with('success', "Work experience is now {$status}.");
    }
    
    /**
     * Update the sort order of work experiences.
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:work_experiences,id',
        ]);
        
        foreach ($request->order as $index => $id) {
            WorkExperience::where('id', $id)->update(['sort_order' => $index]);
        }
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Validate the request data.
     */
    protected function validateRequest(Request $request, $id = null)
    {
        $rules = [
            'role' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'nullable|boolean',
            'description' => 'nullable|string',
            'is_visible' => 'boolean',
            'sort_order' => 'integer',
        ];
        
        // If it's a current job, we don't need end_date validation
        if ($request->has('is_current') && $request->is_current) {
            $rules['end_date'] = 'nullable';
        }
        
        return $request->validate($rules);
    }
}
