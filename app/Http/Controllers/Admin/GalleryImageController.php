<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGalleryImageRequest;
use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryImageController extends Controller
{
    public function index(Gallery $gallery)
    {
        $images = $gallery->images()->latest()->paginate(12);
        return view('admin.gallery-images.index', compact('gallery', 'images'));
    }

    public function create(Gallery $gallery)
    {
        return view('admin.gallery-images.create', compact('gallery'));
    }

    public function store(StoreGalleryImageRequest $request, Gallery $gallery)
    {
        $captions = $request->input('captions', []);

        foreach ($request->file('images') as $index => $file) {
            $path = $file->store('gallery-images', 'public');

            $gallery->images()->create([
                'image'   => $path,
                'caption' => $captions[$index] ?? null,
            ]);
        }

        return redirect()->route('admin.galleries.show', $gallery)
            ->with('success', count($request->file('images')) . ' foto berhasil diupload.');
    }

    public function edit(Gallery $gallery, GalleryImage $galleryImage)
    {
        return view('admin.gallery-images.edit', compact('gallery', 'galleryImage'));
    }

    public function update(Request $request, Gallery $gallery, GalleryImage $galleryImage)
    {
        $request->validate([
            'caption' => ['nullable', 'string', 'max:255'],
            'image'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $data = ['caption' => $request->caption];

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($galleryImage->image);
            $data['image'] = $request->file('image')->store('gallery-images', 'public');
        }

        $galleryImage->update($data);

        return redirect()->route('admin.galleries.show', $gallery)
            ->with('success', 'Foto berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery, GalleryImage $galleryImage)
    {
        Storage::disk('public')->delete($galleryImage->image);
        $galleryImage->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }
}
