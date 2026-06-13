@extends('layouts.admin')
@section('title','Galeri')
@section('page-title','Manajemen Galeri')

@section('content')
<div class="adm-card">
    <div class="adm-card-header">
        <form action="{{ route('admin.galleries.index') }}" method="GET" class="adm-search" style="flex:1;max-width:340px">
            <div class="adm-search-wrap">
                <i class="bi bi-search"></i>
                <input type="text" name="search" class="adm-search-input" placeholder="Cari galeri..." value="{{ $search }}">
            </div>
            <button type="submit" class="btn-ac btn-ac-primary btn-ac-sm">Cari</button>
            @if($search)<a href="{{ route('admin.galleries.index') }}" class="btn-ac btn-ac-secondary btn-ac-sm">Reset</a>@endif
        </form>
        <a href="{{ route('admin.galleries.create') }}" class="btn-ac btn-ac-primary btn-ac-sm">
            <i class="bi bi-plus-lg"></i><span class="d-none d-sm-inline">Tambah</span>
        </a>
    </div>

    @if($galleries->isEmpty())
    <div style="text-align:center;padding:3rem;color:var(--muted)">
        <i class="bi bi-images" style="font-size:2rem;display:block;margin-bottom:.5rem;opacity:.3"></i>
        {{ $search ? 'Tidak ada hasil.' : 'Belum ada galeri.' }}
    </div>
    @else
    <div style="overflow-x:auto">
        <table class="adm-table">
            <thead>
                <tr>
                    <th style="padding-left:1.25rem;width:55px">#</th>
                    <th style="width:60px">Cover</th>
                    <th>Judul</th>
                    <th class="hide-xs">Foto</th>
                    <th style="padding-right:1.25rem">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($galleries as $i => $gallery)
                <tr>
                    <td style="padding-left:1.25rem;color:var(--muted)">{{ $galleries->firstItem()+$i }}</td>
                    <td>
                        @if($gallery->cover_image)
                        <img src="{{ img_url($gallery->cover_image) }}" class="img-thumb" alt="">
                        @else
                        <div class="img-thumb-placeholder"><i class="bi bi-images"></i></div>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight:600;font-size:.86rem">{{ Str::limit($gallery->title,42) }}</div>
                        <div style="font-size:.72rem;color:var(--muted)" class="d-md-none">{{ $gallery->images_count }} foto</div>
                    </td>
                    <td class="hide-xs">
                        <span style="background:#f0fdf4;color:#16a34a;border-radius:50px;padding:.2rem .65rem;font-size:.72rem;font-weight:700">
                            {{ $gallery->images_count }} foto
                        </span>
                    </td>
                    <td style="padding-right:1.25rem;white-space:nowrap">
                        <a href="{{ route('admin.galleries.show',$gallery) }}" class="btn-ac btn-ac-secondary btn-ac-sm me-1" title="Foto">
                            <i class="bi bi-images"></i>
                        </a>
                        <a href="{{ route('admin.galleries.edit',$gallery) }}" class="btn-ac btn-ac-outline btn-ac-sm me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.galleries.destroy',$gallery) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus galeri dan semua fotonya?')">
                            @csrf @method('DELETE')
                            <button class="btn-ac btn-ac-danger btn-ac-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($galleries->hasPages())
    <div style="padding:.85rem 1.25rem;border-top:1px solid var(--border)">{{ $galleries->links() }}</div>
    @endif
    @endif
</div>
@endsection
