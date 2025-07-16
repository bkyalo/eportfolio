<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $publications = Publication::latest()->paginate(10);
        return view('publications.index', compact('publications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('publications.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20|unique:publications,isbn',
            'description' => 'nullable|string',
            'url' => 'nullable|url',
            'image' => 'nullable|image|max:2048',
        ]);

        $publication = new Publication($validated);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('publications', 'public');
            $publication->image_path = $path;
        }

        $publication->save();

        return redirect()->route('publications.index')
            ->with('success', 'Publication created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Publication $publication)
    {
        return view('publications.show', compact('publication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publication $publication)
    {
        return view('publications.edit', compact('publication'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Publication $publication)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('publications', 'isbn')->ignore($publication->id)
            ],
            'description' => 'nullable|string',
            'url' => 'nullable|url',
            'image' => 'nullable|image|max:2048',
            'remove_image' => 'sometimes|boolean',
        ]);

        $publication->fill($validated);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($publication->image_path) {
                Storage::disk('public')->delete($publication->image_path);
            }
            $path = $request->file('image')->store('publications', 'public');
            $publication->image_path = $path;
        } elseif ($request->input('remove_image')) {
            if ($publication->image_path) {
                Storage::disk('public')->delete($publication->image_path);
                $publication->image_path = null;
            }
        }

        $publication->save();

        return redirect()->route('publications.index')
            ->with('success', 'Publication updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publication $publication)
    {
        if ($publication->image_path) {
            Storage::disk('public')->delete($publication->image_path);
        }
        
        $publication->delete();

        return redirect()->route('publications.index')
            ->with('success', 'Publication deleted successfully.');
    }
}
