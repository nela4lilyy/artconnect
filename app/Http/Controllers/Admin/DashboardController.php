<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\News;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'news'           => News::count(),
            'categories'     => Category::count(),
            'galleries'      => Gallery::count(),
            'gallery_images' => GalleryImage::count(),
        ];

        $latestNews = News::with(['category', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact('stats', 'latestNews'));
    }
}
