@extends('layouts.admin')
@section('title','Kategori')
@section('page-title','Manajemen Kategori')

@section('content')
<div class="adm-card">
    <div class="adm-card-header">
        <form action="{{ route('admin.categories.index') }}" method="GET" class="adm-search" style="flex:1;max-width:320px">
            <div class="adm-search-wrap">
                <i class="bi bi-search"></i>
                <input type="text" name="search" class="adm-search-input" placeholder="Cari kategori..." value="{{ $search }}">
            </div>
            <button type="submit" class="btn-ac btn-ac-primary btn-ac-sm">Cari</button>
            @if($search)<a href="{{ route('admin.categories.index') }}" class="btn-ac btn-ac-secondary btn-ac-sm">Reset</a>@endif
        </form>
        <a href="{{ route('admin.categories.create') }}" class="btn-ac btn-ac-primary btn-ac-sm">
            <i class="bi bi-plus-lg"></i><span class="d-none d-sm-inline">Tambah</span>
        </a>
    </div>

    @if($categories->isEmpty())
    <div style="text-align:center;padding:3rem;color:var(--muted)">
        <i class="bi bi-tags" style="font-size:2rem;display:block;margin-bottom:.5rem;opacity:.3"></i>
        {{ $search ? 'Tidak ada hasil untuk "'.$search.'"' : 'Belum ada kategori.' }}
    </div>
    @else
    <div style="overflow-x:auto">
        <table class="adm-table">
            <thead>
                <tr>
                    <th style="padding-left:1.25rem;width:50px">#</th>
                    <th style="width:60px">Cover</th>
                    <th>Nama</th>
                    <th class="hide-xs">Berita</th>
                    <th style="padding-right:1.25rem">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $i => $cat)
                <tr>
                    <td style="padding-left:1.25rem;color:var(--muted)">{{ $categories->firstItem()+$i }}</td>
                    <td>
                        @if($cat->cover_image)
                        <img src="{{ asset('storage/'.$cat->cover_image) }}" class="img-thumb" alt="">
                        @else
                        <div class="img-thumb-placeholder"><i class="bi bi-image"></i></div>
                        @endif
                    </td>
                    <td style="font-weight:600">{{ $cat->name }}</td>
                    <td class="hide-xs">
                        <span style="background:var(--ac-lt);color:var(--ac);border-radius:50px;padding:.2rem .65rem;font-size:.72rem;font-weight:700">
                            {{ $cat->news_count }} berita
                        </span>
                    </td>
                    <td style="padding-right:1.25rem;white-space:nowrap">
                        <a href="{{ route('admin.categories.edit',$cat) }}" class="btn-ac btn-ac-outline btn-ac-sm me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.categories.destroy',$cat) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf @method('DELETE')
                            <button class="btn-ac btn-ac-danger btn-ac-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($categories->hasPages())
    <div style="padding:.85rem 1.25rem;border-top:1px solid var(--border)">{{ $categories->links() }}</div>
    @endif
    @endif
</div>
@endsection
