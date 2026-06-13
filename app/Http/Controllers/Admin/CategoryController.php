<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CloudinaryService;

class CategoryController extends Controller
{
    public function __construct(private CloudinaryService $cloudinary) {}

    public function index()
    {
        $search = request('search');
        $categories = Category::when($search, fn($q, $s) => $q->where('name', 'like', "%$s%"))
            ->withCount('news')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.categories.index', compact('categories', 'search'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->cloudinary->upload(
                $request->file('cover_image'),
                'artconnect/categories'
            );
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            if ($category->cover_image) {
                $this->cloudinary->delete($category->cover_image);
            }
            $data['cover_image'] = $this->cloudinary->upload(
                $request->file('cover_image'),
                'artconnect/categories'
            );
        } else {
            unset($data['cover_image']);
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->news()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki berita.');
        }

        if ($category->cover_image) {
            $this->cloudinary->delete($category->cover_image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
