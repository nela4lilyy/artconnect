@extends('layouts.public')
@section('title', $gallery->title)

@section('content')
<div style="background:linear-gradient(135deg,var(--c-dark),var(--c-primary));padding:2.5rem 0 2rem;color:#fff">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol style="display:flex;gap:.5rem;list-style:none;margin:0;padding:0;font-size:.8rem;flex-wrap:wrap">
                <li><a href="{{ route('home') }}" style="color:rgba(255,255,255,.5);text-decoration:none">Beranda</a></li>
                <li style="color:rgba(255,255,255,.3)">/</li>
                <li><a href="{{ route('galleries.index') }}" style="color:rgba(255,255,255,.5);text-decoration:none">Galeri</a></li>
                <li style="color:rgba(255,255,255,.3)">/</li>
                <li style="color:rgba(255,255,255,.75)">{{ Str::limit($gallery->title,40) }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    {{-- Gallery header --}}
    <div class="row g-4 align-items-center mb-5">
        @if($gallery->cover_image)
        <div class="col-md-4">
            <img src="{{ img_url($gallery->cover_image) }}"
                 style="width:100%;max-height:260px;object-fit:cover;border-radius:var(--radius-md)" alt="{{ $gallery->title }}">
        </div>
        @endif
        <div class="{{ $gallery->cover_image ? 'col-md-8' : 'col-12' }}">
            <span style="font-size:.7rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--c-primary);font-family:Inter,sans-serif">
                <i class="bi bi-images me-1"></i>{{ $gallery->images->count() }} Foto
            </span>
            <h1 style="font-size:clamp(1.5rem,4vw,2.3rem);margin:.4rem 0 .75rem">{{ $gallery->title }}</h1>
            @if($gallery->description)
            <p style="color:var(--c-muted);font-size:1rem;line-height:1.75;margin-bottom:1.25rem">{{ $gallery->description }}</p>
            @endif
            <a href="{{ route('galleries.index') }}" class="btn-ac-outline">
                <i class="bi bi-arrow-left"></i>Kembali
            </a>
        </div>
    </div>

    @if($gallery->images->isEmpty())
    <div class="text-center py-5" style="color:var(--c-muted)">
        <i class="bi bi-images" style="font-size:3rem;display:block;margin-bottom:1rem;opacity:.3"></i>
        <p>Galeri ini belum memiliki foto.</p>
    </div>
    @else
    <div style="display:grid;gap:.85rem;grid-template-columns:repeat(2,1fr)" class="photo-grid">
        @foreach($gallery->images as $img)
        <div style="border-radius:var(--radius-sm);overflow:hidden;cursor:zoom-in;position:relative"
             onclick="openLb('{{ img_url($img->image) }}','{{ addslashes($img->caption??'') }}')">
            <img src="{{ img_url($img->image) }}"
                 style="width:100%;height:190px;object-fit:cover;display:block;transition:transform .35s"
                 onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform=''"
                 alt="{{ $img->caption }}">
            @if($img->caption)
            <div style="position:absolute;bottom:0;left:0;right:0;background:linear-gradient(transparent,rgba(0,0,0,.65));padding:1.2rem .75rem .55rem;font-size:.75rem;color:#fff">
                {{ $img->caption }}
            </div>
            @endif
        </div>
        @endforeach
    </div>
    @endif
</div>

{{-- Lightbox --}}
<div id="lb" onclick="closeLb()" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.93);z-index:9999;align-items:center;justify-content:center;flex-direction:column">
    <button onclick="event.stopPropagation();closeLb()"
            style="position:absolute;top:1rem;right:1.5rem;background:rgba(255,255,255,.12);border:none;color:#fff;font-size:1.3rem;width:40px;height:40px;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center">
        <i class="bi bi-x-lg"></i>
    </button>
    <img id="lbImg" src="" style="max-height:85vh;max-width:90vw;border-radius:var(--radius-sm);object-fit:contain" alt="">
    <p id="lbCap" style="color:rgba(255,255,255,.55);margin-top:.75rem;font-size:.85rem;text-align:center"></p>
</div>

@push('styles')
<style>
@media(min-width:576px){ .photo-grid { grid-template-columns: repeat(3,1fr) !important; } }
@media(min-width:992px){ .photo-grid { grid-template-columns: repeat(4,1fr) !important; } }
</style>
@endpush
@push('scripts')
<script>
function openLb(src,cap){ const lb=document.getElementById('lb'); document.getElementById('lbImg').src=src; document.getElementById('lbCap').textContent=cap; lb.style.display='flex'; document.body.style.overflow='hidden'; }
function closeLb(){ document.getElementById('lb').style.display='none'; document.body.style.overflow=''; }
document.addEventListener('keydown',e=>{ if(e.key==='Escape') closeLb(); });
</script>
@endpush
@endsection
