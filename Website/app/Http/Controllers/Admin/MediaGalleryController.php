<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaGalleryController extends Controller
{
    public function index()
    {
        $media = MediaGallery::orderBy('order')->get();
        return view('admin.media-gallery.index', compact('media'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:10240', // 10MB max
        ]);

        $file = $request->file('image');
        $path = $file->store('media-gallery', 'public');

        MediaGallery::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'file_type' => $file->getClientMimeType(),
            'order' => MediaGallery::max('order') + 1,
            'is_published' => $request->has('publish')
        ]);

        return redirect()->route('admin.media-gallery.index')
            ->with('success', 'Image uploaded successfully!');
    }

    public function update(Request $request, MediaGallery $mediaGallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:10240',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'is_published' => $request->has('publish')
        ];

        if ($request->hasFile('image')) {
            // Delete old file
            Storage::disk('public')->delete($mediaGallery->file_path);
            
            // Store new file
            $file = $request->file('image');
            $path = $file->store('media-gallery', 'public');
            
            $data = array_merge($data, [
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'file_type' => $file->getClientMimeType(),
            ]);
        }

        $mediaGallery->update($data);

        return redirect()->route('admin.media-gallery.index')
            ->with('success', 'Image updated successfully!');
    }

    public function destroy(MediaGallery $mediaGallery)
    {
        Storage::disk('public')->delete($mediaGallery->file_path);
        $mediaGallery->delete();

        return response()->json(['success' => 'Image deleted successfully']);
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:media_gallery,id',
            'items.*.order' => 'required|integer',
        ]);

        foreach ($request->items as $item) {
            MediaGallery::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }
}
