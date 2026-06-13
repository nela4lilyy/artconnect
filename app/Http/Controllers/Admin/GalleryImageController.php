<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGalleryImageRequest;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;

class GalleryImageController extends Controller
{
    public function __construct(private CloudinaryService $cloudinary) {}

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
            $path = $this->cloudinary->upload($file, 'artconnect/gallery-images');

            $gallery->images()->create([
                'image'   => $path,
                'caption' => $captions[$index] ?? null,
            ]);
        }

        $count = count($request->file('images'));

        return redirect()->route('admin.galleries.show', $gallery)
            ->with('success', "{$count} foto berhasil diupload.");
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
            $this->cloudinary->delete($galleryImage->image);
            $data['image'] = $this->cloudinary->upload(
                $request->file('image'),
                'artconnect/gallery-images'
            );
        }

        $galleryImage->update($data);

        return redirect()->route('admin.galleries.show', $gallery)
            ->with('success', 'Foto berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery, GalleryImage $galleryImage)
    {
        $this->cloudinary->delete($galleryImage->image);
        $galleryImage->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }
}
