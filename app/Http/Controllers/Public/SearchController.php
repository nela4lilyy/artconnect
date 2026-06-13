<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\News;

class SearchController extends Controller
{
    public function index()
    {
        $query = trim(request('q', ''));

        $news      = collect();
        $galleries = collect();

        if ($query !== '') {
            $news = News::with(['category', 'user'])
                ->where('title', 'like', "%{$query}%")
                ->latest('publish_date')
                ->take(12)
                ->get();

            // Use proper grouped where to avoid leaking conditions
            $galleries = Gallery::withCount('images')
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%");
                })
                ->latest()
                ->take(12)
                ->get();
        }

        $total = $news->count() + $galleries->count();

        return view('public.search.index', compact('query', 'news', 'galleries', 'total'));
    }
}
