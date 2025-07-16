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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required_without:video_url|file|mimes:jpeg,png,jpg,gif,webp,mp4,mov,avi,wmv|max:102400', // 100MB max
            'video_url' => 'nullable|url',
            'is_visible' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $media = new Media([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'is_visible' => $validated['is_visible'] ?? true,
            'is_featured' => $validated['is_featured'] ?? false,
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $mimeType = $file->getMimeType();
            $type = str_starts_with($mimeType, 'video/') ? 'video' : 'image';
            
            $media->type = $type;
            $media->mime_type = $mimeType;
            $media->size = $file->getSize();
            $media->save();

            $media->addMedia($file)
                ->usingName(Str::slug($validated['title']))
                ->toMediaCollection('default');
                
            // Update dimensions if it's an image
            if ($type === 'image') {
                $media->dimensions = getimagesize($file);
                $media->save();
            }
        } elseif (!empty($validated['video_url'])) {
            $media->type = 'video';
            $media->custom_properties = ['video_url' => $validated['video_url']];
            $media->save();
        }

        return redirect()
            ->route('media.index')
            ->with('success', 'Media uploaded successfully!');
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
