<?php

namespace App\Http\Controllers;

use App\Models\FunFact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FunFactController extends Controller
{
    /**
     * Display the fun facts management page or return JSON for API requests.
     */
    public function index(Request $request)
    {
        $facts = FunFact::ordered()->get();
        
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json($facts);
        }
        
        return view('fun-facts.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fact' => 'required|string|max:500',
            'is_visible' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $fact = FunFact::create([
            'fact' => $request->fact,
            'is_visible' => $request->boolean('is_visible', true),
            'sort_order' => $request->sort_order ?? 0
        ]);

        return response()->json([
            'message' => 'Fun fact added successfully!',
            'data' => $fact
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FunFact $funFact)
    {
        $validator = Validator::make($request->all(), [
            'fact' => 'string|max:500',
            'is_visible' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $funFact->update($request->only(['fact', 'is_visible', 'sort_order']));

        return response()->json([
            'message' => 'Fun fact updated successfully!',
            'data' => $funFact->fresh()
        ]);
    }

    /**
     * Toggle the visibility of the specified resource.
     */
    public function toggleVisibility(Request $request, $id)
    {
        $funFact = FunFact::findOrFail($id);
        
        $funFact->update([
            'is_visible' => !$funFact->is_visible
        ]);

        return response()->json([
            'message' => 'Visibility updated successfully!',
            'data' => $funFact->fresh()
        ]);
    }

    /**
     * Reorder the fun facts.
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:fun_facts,id'
        ]);

        foreach ($request->order as $index => $id) {
            FunFact::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json([
            'message' => 'Order updated successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FunFact $funFact)
    {
        $funFact->delete();

        return response()->json([
            'message' => 'Fun fact deleted successfully!'
        ]);
    }
}
