@extends('layouts.public')
@section('title','Galeri')

@section('content')
<div style="background:linear-gradient(135deg,var(--c-dark),var(--c-primary));padding:3rem 0 2.5rem;color:#fff">
    <div class="container">
        <span style="font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.55)">Koleksi Karya</span>
        <h1 style="font-size:clamp(1.6rem,4vw,2.4rem);margin:.4rem 0 .5rem">Galeri Karya Seni</h1>
        <p style="color:rgba(255,255,255,.7);margin:0;font-size:.95rem">Koleksi karya terbaik anggota komunitas ArtConnect</p>
    </div>
</div>

<div class="container py-5">
    @if($galleries->isEmpty())
    <div class="text-center py-5" style="color:var(--c-muted)">
        <i class="bi bi-images" style="font-size:3rem;display:block;margin-bottom:1rem;opacity:.3"></i>
        <p>Belum ada galeri tersedia.</p>
    </div>
    @else
    <div style="display:grid;gap:1.3rem;grid-template-columns:1fr" class="gal-pub-grid">
        @foreach($galleries as $gallery)
        <a href="{{ route('galleries.show',$gallery) }}" style="text-decoration:none;color:inherit">
            <div class="ac-card">
                <div style="position:relative;overflow:hidden">
                    @if($gallery->cover_image)
                    <img src="{{ img_url($gallery->cover_image) }}"
                         style="width:100%;height:220px;object-fit:cover;display:block;transition:transform .4s" class="gal-img" alt="{{ $gallery->title }}">
                    @else
                    <div style="width:100%;height:220px;background:linear-gradient(135deg,var(--c-primary-lt),var(--c-primary-mid));display:flex;align-items:center;justify-content:center;font-size:3rem;color:var(--c-primary)">
                        <i class="bi bi-images"></i>
                    </div>
                    @endif
                    <div style="position:absolute;bottom:0;left:0;right:0;background:linear-gradient(transparent,rgba(0,0,0,.7));padding:2rem 1.2rem .9rem">
                        <span style="font-size:.68rem;background:rgba(255,255,255,.2);color:#fff;border-radius:50px;padding:.2rem .65rem">
                            <i class="bi bi-image me-1"></i>{{ $gallery->images_count }} foto
                        </span>
                    </div>
                </div>
                <div style="padding:1rem 1.1rem">
                    <h3 style="font-size:.97rem;font-weight:700;color:var(--c-dark);margin-bottom:.35rem;line-height:1.4">{{ $gallery->title }}</h3>
                    @if($gallery->description)
                    <p style="font-size:.82rem;color:var(--c-muted);margin:0;line-height:1.55">{{ Str::limit($gallery->description,80) }}</p>
                    @endif
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @if($galleries->hasPages())
    <div class="d-flex justify-content-center mt-5">{{ $galleries->links() }}</div>
    @endif
    @endif
</div>

@push('styles')
<style>
@media(min-width:576px){ .gal-pub-grid { grid-template-columns: repeat(2,1fr) !important; } }
@media(min-width:992px){ .gal-pub-grid { grid-template-columns: repeat(3,1fr) !important; } }
.ac-card:hover .gal-img { transform: scale(1.05); }
</style>
@endpush
@endsection
