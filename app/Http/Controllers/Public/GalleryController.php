<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::withCount('images')
            ->latest()
            ->paginate(9);

        return view('public.galleries.index', compact('galleries'));
    }

    public function show(Gallery $gallery)
    {
        $gallery->load('images');
        return view('public.galleries.show', compact('gallery'));
    }
}
