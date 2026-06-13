<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $search = request('search');

        $news = News::with(['category', 'user'])
            ->when($search, fn($q, $s) => $q->where('title', 'like', "%{$s}%"))
            ->latest('publish_date')
            ->paginate(9)
            ->withQueryString();

        return view('public.news.index', compact('news', 'search'));
    }

    public function show(string $slug)
    {
        $news = News::with(['category', 'user'])
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedNews = News::with(['category'])
            ->where('category_id', $news->category_id)
            ->where('id', '!=', $news->id)
            ->latest('publish_date')
            ->take(3)
            ->get();

        return view('public.news.show', compact('news', 'relatedNews'));
    }
}
