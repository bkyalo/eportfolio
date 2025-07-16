<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Contact::query();

        // Search functionality
        if ($request->has('search')) {
            $query->search($request->input('search'));
        }

        // Filter by favorites
        if ($request->has('favorites')) {
            $query->favorite();
        }

        // Ordering
        $orderBy = $request->input('order_by', 'first_name');
        $orderDirection = $request->input('order_direction', 'asc');
        $query->orderBy($orderBy, $orderDirection);

        // Pagination
        $perPage = $request->input('per_page', 15);
        $contacts = $query->paginate($perPage);

        return response()->json($contacts);
    }

    /**
     * Store a newly created contact in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email_personal' => 'nullable|email|unique:contacts,email_personal',
            'email_work' => 'nullable|email|unique:contacts,email_work',
            'phone_personal' => 'nullable|string|max:20',
            'phone_work' => 'nullable|string|max:20',
            'github_username' => 'nullable|string|max:50',
            'x_username' => 'nullable|string|max:50',
            'facebook_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'address_line1' => 'nullable|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'notes' => 'nullable|string',
            'is_favorite' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $contact = Contact::create($validator->validated());

        return response()->json([
            'success' => true,
            'data' => $contact,
            'message' => 'Contact created successfully.'
        ], 201);
    }

    /**
     * Display the specified contact.
     */
    public function show(Contact $contact)
    {
        return response()->json([
            'success' => true,
            'data' => $contact
        ]);
    }

    /**
     * Update the specified contact in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'sometimes|required|string|max:100',
            'last_name' => 'sometimes|required|string|max:100',
            'email_personal' => [
                'nullable',
                'email',
                Rule::unique('contacts', 'email_personal')->ignore($contact->id)
            ],
            'email_work' => [
                'nullable',
                'email',
                Rule::unique('contacts', 'email_work')->ignore($contact->id)
            ],
            'phone_personal' => 'nullable|string|max:20',
            'phone_work' => 'nullable|string|max:20',
            'github_username' => 'nullable|string|max:50',
            'x_username' => 'nullable|string|max:50',
            'facebook_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'address_line1' => 'nullable|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'notes' => 'nullable|string',
            'is_favorite' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $contact->update($validator->validated());

        return response()->json([
            'success' => true,
            'data' => $contact,
            'message' => 'Contact updated successfully.'
        ]);
    }

    /**
     * Remove the specified contact from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return response()->json([
            'success' => true,
            'message' => 'Contact deleted successfully.'
        ]);
    }

    /**
     * Toggle favorite status of a contact.
     */
    public function toggleFavorite(Contact $contact)
    {
        $contact->update([
            'is_favorite' => !$contact->is_favorite
        ]);

        return response()->json([
            'success' => true,
            'data' => $contact,
            'message' => 'Favorite status updated.'
        ]);
    }

    /**
     * Get contacts count by location.
     */
    public function byLocation()
    {
        $contacts = Contact::select('country', 'city')
            ->selectRaw('count(*) as count')
            ->whereNotNull('country')
            ->groupBy('country', 'city')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $contacts
        ]);
    }

    /**
     * Export contacts to a CSV file.
     */
    public function export()
    {
        $fileName = 'contacts-' . now()->format('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $contacts = Contact::all();
        $columns = [
            'ID', 'First Name', 'Last Name', 'Personal Email', 'Work Email',
            'Personal Phone', 'Work Phone', 'Github', 'Twitter', 'Facebook',
            'LinkedIn', 'Address', 'City', 'State', 'Postal Code', 'Country',
            'Notes', 'Is Favorite', 'Created At', 'Updated At'
        ];

        $callback = function() use($contacts, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($contacts as $contact) {
                $row = [
                    $contact->id,
                    $contact->first_name,
                    $contact->last_name,
                    $contact->email_personal,
                    $contact->email_work,
                    $contact->phone_personal,
                    $contact->phone_work,
                    $contact->github_username,
                    $contact->x_username,
                    $contact->facebook_url,
                    $contact->linkedin_url,
                    $contact->address_line1 . ($contact->address_line2 ? ' ' . $contact->address_line2 : ''),
                    $contact->city,
                    $contact->state,
                    $contact->postal_code,
                    $contact->country,
                    $contact->notes,
                    $contact->is_favorite ? 'Yes' : 'No',
                    $contact->created_at,
                    $contact->updated_at
                ];

                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
