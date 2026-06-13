@extends('layouts.admin')
@section('title','Berita')
@section('page-title','Manajemen Berita')

@section('content')
<div class="adm-card">
    <div class="adm-card-header">
        <form action="{{ route('admin.news.index') }}" method="GET" class="adm-search" style="flex:1;max-width:340px">
            <div class="adm-search-wrap">
                <i class="bi bi-search"></i>
                <input type="text" name="search" class="adm-search-input" placeholder="Cari judul berita..." value="{{ $search }}">
            </div>
            <button type="submit" class="btn-ac btn-ac-primary btn-ac-sm">Cari</button>
            @if($search)<a href="{{ route('admin.news.index') }}" class="btn-ac btn-ac-secondary btn-ac-sm">Reset</a>@endif
        </form>
        <a href="{{ route('admin.news.create') }}" class="btn-ac btn-ac-primary btn-ac-sm">
            <i class="bi bi-plus-lg"></i><span class="d-none d-sm-inline">Tambah</span>
        </a>
    </div>

    @if($news->isEmpty())
    <div style="text-align:center;padding:3rem;color:var(--muted)">
        <i class="bi bi-newspaper" style="font-size:2rem;display:block;margin-bottom:.5rem;opacity:.3"></i>
        {{ $search ? 'Tidak ada hasil.' : 'Belum ada berita.' }}
    </div>
    @else
    <div style="overflow-x:auto">
        <table class="adm-table">
            <thead>
                <tr>
                    <th style="padding-left:1.25rem;width:55px">#</th>
                    <th style="width:60px">Img</th>
                    <th>Judul</th>
                    <th class="hide-xs">Kategori</th>
                    <th class="hide-xs">Tanggal</th>
                    <th style="padding-right:1.25rem">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($news as $i => $item)
                <tr>
                    <td style="padding-left:1.25rem;color:var(--muted)">{{ $news->firstItem()+$i }}</td>
                    <td>
                        @if($item->image)
                        <img src="{{ asset('storage/'.$item->image) }}" class="img-thumb" alt="">
                        @else
                        <div class="img-thumb-placeholder"><i class="bi bi-image"></i></div>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight:600;font-size:.86rem">{{ Str::limit($item->title,45) }}</div>
                        <div style="font-size:.72rem;color:var(--muted)" class="d-md-none">
                            {{ $item->category->name }} · {{ $item->publish_date->format('d M Y') }}
                        </div>
                    </td>
                    <td class="hide-xs">
                        <span style="background:var(--ac-lt);color:var(--ac);border-radius:50px;padding:.2rem .65rem;font-size:.72rem;font-weight:700">
                            {{ $item->category->name }}
                        </span>
                    </td>
                    <td class="hide-xs" style="color:var(--muted);font-size:.82rem">{{ $item->publish_date->format('d M Y') }}</td>
                    <td style="padding-right:1.25rem;white-space:nowrap">
                        <a href="{{ route('admin.news.edit',$item) }}" class="btn-ac btn-ac-outline btn-ac-sm me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.news.destroy',$item) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus berita ini?')">
                            @csrf @method('DELETE')
                            <button class="btn-ac btn-ac-danger btn-ac-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($news->hasPages())
    <div style="padding:.85rem 1.25rem;border-top:1px solid var(--border)">{{ $news->links() }}</div>
    @endif
    @endif
</div>
@endsection
