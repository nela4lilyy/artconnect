<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreNewsRequest;
use App\Http\Requests\Admin\UpdateNewsRequest;
use App\Models\Category;
use App\Models\News;
use App\Services\CloudinaryService;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function __construct(private CloudinaryService $cloudinary) {}

    public function index()
    {
        $search = request('search');
        $news = News::with(['category', 'user'])
            ->when($search, fn($q, $s) => $q->where('title', 'like', "%$s%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.news.index', compact('news', 'search'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.news.create', compact('categories'));
    }

    public function store(StoreNewsRequest $request)
    {
        $data            = $request->validated();
        $data['user_id'] = auth()->id();
        $data['slug']    = News::generateSlug($data['title']);

        if ($request->hasFile('image')) {
            $data['image'] = $this->cloudinary->upload(
                $request->file('image'),
                'artconnect/news'
            );
        }

        News::create($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(News $news)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function update(UpdateNewsRequest $request, News $news)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($news->image) {
                $this->cloudinary->delete($news->image);
            }
            $data['image'] = $this->cloudinary->upload(
                $request->file('image'),
                'artconnect/news'
            );
        } else {
            unset($data['image']);
        }

        if ($data['title'] !== $news->title) {
            $data['slug'] = News::generateSlug($data['title']);
        }

        $news->update($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $news)
    {
        if ($news->image) {
            $this->cloudinary->delete($news->image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}
