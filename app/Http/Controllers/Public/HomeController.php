<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\News;

class HomeController extends Controller
{
    public function index()
    {
        // 5 berita terbaru untuk carousel (urut created_at terbaru)
        $carouselNews = News::with(['category', 'user'])
            ->latest()
            ->take(5)
            ->get();

        // 6 berita terbaru untuk section berita (urut publish_date)
        $latestNews = News::with(['category', 'user'])
            ->latest('publish_date')
            ->take(6)
            ->get();

        // 5 galeri terbaru
        $latestGalleries = Gallery::withCount('images')
            ->latest()
            ->take(5)
            ->get();

        return view('public.home.index', compact('carouselNews', 'latestNews', 'latestGalleries'));
    }

    public function about()
    {
        return view('public.about.index');
    }
}
