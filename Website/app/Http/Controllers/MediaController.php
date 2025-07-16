<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Exceptions\InvalidBase64Data;
use Spatie\MediaLibrary\MediaCollections\Exceptions\InvalidUrl;
use Spatie\MediaLibrary\MediaCollections\Exceptions\UnreachableUrl;

class MediaController extends Controller
{
    /**
     * Display a listing of the media items.
     */
    public function index()
    {
        $media = Media::orderBy('order_column')
            ->with('media')
            ->paginate(24);

        return view('media.index', compact('media'));
    }

    /**
     * Show the form for creating a new media item.
     */
    public function create()
    {
        return view('media.create');
    }

    /**
     * Store a newly created media item in storage.
     *
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @throws InvalidBase64Data
     * @throws InvalidUrl
     * @throws UnreachableUrl
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required_without:video_url|file|mimes:jpeg,png,jpg,gif,webp,mp4,mov,avi,wmv|max:102400',
            'video_url' => 'required_without:file|nullable|url',
            'is_visible' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        try {
            // Create media record with all required fields
            $media = new Media();
            $media->title = $request->title ?? 'Untitled ' . now()->format('Y-m-d H:i:s');
            $media->description = $request->description;
            $media->is_visible = $request->boolean('is_visible', true);
            $media->is_featured = $request->boolean('is_featured', false);
            $media->model_type = Media::class;
            $media->model_id = 1; // Default model ID, adjust as needed
            $media->collection_name = 'default';
            $media->name = $request->title;
            $media->file_name = $request->hasFile('file') ? $request->file('file')->getClientOriginalName() : 'video_' . time();
            $media->mime_type = $request->hasFile('file') ? $request->file('file')->getMimeType() : 'video/url';
            $media->disk = 'public';
            $media->conversions_disk = 'public';
            $media->size = $request->hasFile('file') ? $request->file('file')->getSize() : 0;
            $media->type = $request->hasFile('file') ? (str_starts_with($media->mime_type, 'image/') ? 'image' : 'video') : 'video';
            $media->save();

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $media->addMedia($file)
                    ->withCustomProperties([
                        'title' => $request->title,
                        'description' => $request->description
                    ])
                    ->toMediaCollection();
            } elseif ($request->filled('video_url')) {
                $media->type = 'video';
                $media->addMediaFromUrl($request->video_url)
                    ->withCustomProperties([
                        'video_url' => $request->video_url,
                        'title' => $request->title,
                        'description' => $request->description
                    ])
                    ->toMediaCollection();
            }

            $response = [
                'success' => true,
                'message' => 'Media uploaded successfully!',
                'media' => [
                    'id' => $media->id,
                    'title' => $media->title,
                    'url' => $media->getUrl(),
                    'type' => $media->type,
                    'is_featured' => $media->is_featured,
                    'is_visible' => $media->is_visible,
                    'created_at' => $media->created_at->diffForHumans(),
                ]
            ];

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json($response);
            }

            return redirect()
                ->route('media.index')
                ->with('success', $response['message']);

        } catch (\Exception $e) {
            $errorMessage = 'Error uploading media: ' . $e->getMessage();
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 500);
            }

            return back()
                ->withInput()
                ->with('error', $errorMessage);
        }
    }

    /**
     * Display the specified media item.
     */
    public function show(Media $media)
    {
        return view('media.show', compact('media'));
    }

    /**
     * Show the form for editing the specified media item.
     */
    public function edit(Media $media)
    {
        return view('media.edit', compact('media'));
    }

    /**
     * Update the specified media item in storage.
     */
    public function update(Request $request, Media $media)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_visible' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $media->update($validated);

        // Handle featured media - ensure only one is featured
        if ($validated['is_featured'] ?? false) {
            Media::where('id', '!=', $media->id)
                ->where('is_featured', true)
                ->update(['is_featured' => false]);
        }

        return redirect()
            ->route('media.index')
            ->with('success', 'Media updated successfully!');
    }

    /**
     * Remove the specified media item from storage.
     */
    public function destroy(Media $media)
    {
        $media->delete();

        return redirect()
            ->route('media.index')
            ->with('success', 'Media deleted successfully!');
    }

    /**
     * Reorder media items.
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:media,id',
            'items.*.order' => 'required|integer|min:1'
        ]);
        
        foreach ($request->items as $item) {
            Media::where('id', $item['id'])->update(['order_column' => $item['order']]);
        }
        
        return response()->json(['success' => true]);
    }
}
