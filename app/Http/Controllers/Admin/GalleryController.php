<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGalleryRequest;
use App\Http\Requests\Admin\UpdateGalleryRequest;
use App\Models\Gallery;
use App\Services\CloudinaryService;

class GalleryController extends Controller
{
    public function __construct(private CloudinaryService $cloudinary) {}

    public function index()
    {
        $search = request('search');
        $galleries = Gallery::withCount('images')
            ->when($search, fn($q, $s) => $q->where('title', 'like', "%$s%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.galleries.index', compact('galleries', 'search'));
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(StoreGalleryRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->cloudinary->upload(
                $request->file('cover_image'),
                'artconnect/galleries'
            );
        }

        Gallery::create($data);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galeri berhasil ditambahkan.');
    }

    public function show(Gallery $gallery)
    {
        $gallery->load('images');
        return view('admin.galleries.show', compact('gallery'));
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    public function update(UpdateGalleryRequest $request, Gallery $gallery)
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            if ($gallery->cover_image) {
                $this->cloudinary->delete($gallery->cover_image);
            }
            $data['cover_image'] = $this->cloudinary->upload(
                $request->file('cover_image'),
                'artconnect/galleries'
            );
        } else {
            unset($data['cover_image']);
        }

        $gallery->update($data);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->cover_image) {
            $this->cloudinary->delete($gallery->cover_image);
        }

        foreach ($gallery->images as $image) {
            $this->cloudinary->delete($image->image);
        }

        $gallery->delete();

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galeri berhasil dihapus.');
    }
}
