@extends('layouts.admin')
@section('title','Detail Galeri')
@section('page-title','Detail Galeri')

@section('content')
<div class="adm-card mb-4">
    <div style="padding:1.25rem;display:flex;flex-wrap:wrap;gap:1rem;align-items:flex-start">
        @if($gallery->cover_image)
        <img src="{{ img_url($gallery->cover_image) }}"
             style="width:100px;height:75px;object-fit:cover;border-radius:var(--radius);flex-shrink:0" alt="">
        @endif
        <div style="flex:1;min-width:180px">
            <h4 style="margin-bottom:.3rem;font-size:1.1rem">{{ $gallery->title }}</h4>
            <p style="color:var(--muted);font-size:.88rem;margin:0">{{ $gallery->description ?? '—' }}</p>
            <span style="font-size:.75rem;color:#16a34a;background:#f0fdf4;border-radius:50px;padding:.2rem .65rem;display:inline-block;margin-top:.5rem;font-weight:700">
                {{ $gallery->images->count() }} foto
            </span>
        </div>
        <div style="display:flex;gap:.5rem;flex-wrap:wrap">
            <a href="{{ route('admin.gallery-images.create',$gallery) }}" class="btn-ac btn-ac-primary btn-ac-sm">
                <i class="bi bi-cloud-upload"></i>Upload Foto
            </a>
            <a href="{{ route('admin.galleries.edit',$gallery) }}" class="btn-ac btn-ac-outline btn-ac-sm">
                <i class="bi bi-pencil"></i>Edit
            </a>
            <a href="{{ route('admin.galleries.index') }}" class="btn-ac btn-ac-secondary btn-ac-sm">
                <i class="bi bi-arrow-left"></i>Kembali
            </a>
        </div>
    </div>
</div>

<div class="adm-card">
    <div class="adm-card-header"><i class="bi bi-images me-2" style="color:var(--ac)"></i>Koleksi Foto</div>
    <div style="padding:1.25rem">
        @if($gallery->images->isEmpty())
        <div style="text-align:center;padding:2.5rem;color:var(--muted)">
            <i class="bi bi-cloud-upload" style="font-size:2rem;display:block;margin-bottom:.5rem;opacity:.3"></i>
            Belum ada foto. <a href="{{ route('admin.gallery-images.create',$gallery) }}" style="color:var(--ac)">Upload sekarang</a>
        </div>
        @else
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:.85rem">
            @foreach($gallery->images as $img)
            <div class="adm-card" style="overflow:hidden">
                <img src="{{ img_url($img->image) }}"
                     style="width:100%;height:130px;object-fit:cover;display:block" alt="{{ $img->caption }}">
                <div style="padding:.6rem .7rem">
                    <p style="font-size:.75rem;color:var(--muted);margin:0 0 .5rem;min-height:2rem;line-height:1.4">
                        {{ $img->caption ?? '—' }}
                    </p>
                    <div style="display:flex;gap:.35rem">
                        <a href="{{ route('admin.gallery-images.edit',[$gallery,$img]) }}"
                           class="btn-ac btn-ac-outline btn-ac-sm" style="flex:1;justify-content:center">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.gallery-images.destroy',[$gallery,$img]) }}" method="POST"
                              onsubmit="return confirm('Hapus foto?')">
                            @csrf @method('DELETE')
                            <button class="btn-ac btn-ac-danger btn-ac-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
