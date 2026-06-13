@extends('layouts.public')
@section('title', $query ? 'Hasil: "'.$query.'"' : 'Pencarian')

@section('content')
<div style="background:linear-gradient(135deg,var(--c-dark),var(--c-primary));padding:3rem 0 2.5rem;color:#fff">
    <div class="container">
        <span style="font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.55)">Pencarian Global</span>
        <h1 style="font-size:clamp(1.5rem,4vw,2.2rem);margin:.4rem 0 .75rem">
            @if($query)
                Hasil untuk <em style="font-style:italic;color:var(--c-primary-mid)">"{{ $query }}"</em>
            @else
                Pencarian
            @endif
        </h1>

        {{-- Search form --}}
        <form action="{{ route('search') }}" method="GET" style="max-width:520px;margin-top:1rem">
            <div style="display:flex;gap:.5rem">
                <div style="flex:1;position:relative">
                    <i class="bi bi-search" style="position:absolute;left:.9rem;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.5)"></i>
                    <input type="text" name="q" value="{{ $query }}"
                           style="width:100%;padding:.72rem .9rem .72rem 2.5rem;background:rgba(255,255,255,.12);border:1.5px solid rgba(255,255,255,.25);border-radius:var(--radius-sm);font-size:.9rem;color:#fff;outline:none;font-family:inherit"
                           placeholder="Cari berita atau galeri..."
                           onfocus="this.style.borderColor='rgba(255,255,255,.6)'" onblur="this.style.borderColor='rgba(255,255,255,.25)'">
                </div>
                <button type="submit" style="background:rgba(255,255,255,.2);border:1.5px solid rgba(255,255,255,.3);color:#fff;border-radius:var(--radius-sm);padding:.72rem 1.1rem;cursor:pointer;font-size:.9rem;transition:background .2s"
                        onmouseover="this.style.background='rgba(255,255,255,.35)'" onmouseout="this.style.background='rgba(255,255,255,.2)'">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="container py-5">

    @if(!$query)
    {{-- Empty state: no query --}}
    <div class="text-center py-5" style="color:var(--c-muted)">
        <i class="bi bi-search" style="font-size:3.5rem;display:block;margin-bottom:1.25rem;opacity:.25"></i>
        <h3 style="font-size:1.2rem;margin-bottom:.5rem">Masukkan kata kunci</h3>
        <p style="font-size:.93rem">Ketik judul berita atau galeri yang ingin Anda cari di kotak di atas.</p>
    </div>

    @elseif($total === 0)
    {{-- No results --}}
    <div class="text-center py-5" style="color:var(--c-muted)">
        <i class="bi bi-emoji-frown" style="font-size:3.5rem;display:block;margin-bottom:1.25rem;opacity:.25"></i>
        <h3 style="font-size:1.2rem;margin-bottom:.5rem">Tidak ditemukan hasil</h3>
        <p style="font-size:.93rem;max-width:420px;margin:0 auto">
            Tidak ada berita maupun galeri yang cocok dengan
            <strong>"{{ $query }}"</strong>. Coba gunakan kata kunci yang lebih umum.
        </p>
        <div style="margin-top:1.5rem;display:flex;gap:.75rem;justify-content:center;flex-wrap:wrap">
            <a href="{{ route('news.index') }}" class="btn-ac-outline">Semua Berita</a>
            <a href="{{ route('galleries.index') }}" class="btn-ac-primary">Semua Galeri</a>
        </div>
    </div>

    @else
    {{-- Summary badge --}}
    <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:2.5rem;flex-wrap:wrap">
        <span style="font-size:.88rem;color:var(--c-muted)">
            Ditemukan <strong style="color:var(--c-dark)">{{ $total }}</strong> hasil
        </span>
        @if($news->count())
        <span style="background:var(--c-primary-lt);color:var(--c-primary);border-radius:50px;padding:.25rem .75rem;font-size:.75rem;font-weight:700">
            <i class="bi bi-newspaper me-1"></i>{{ $news->count() }} Berita
        </span>
        @endif
        @if($galleries->count())
        <span style="background:#f0fdf4;color:#16a34a;border-radius:50px;padding:.25rem .75rem;font-size:.75rem;font-weight:700">
            <i class="bi bi-images me-1"></i>{{ $galleries->count() }} Galeri
        </span>
        @endif
    </div>

    {{-- NEWS RESULTS --}}
    @if($news->count())
    <div style="margin-bottom:3rem">
        <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:2px solid var(--c-border)">
            <i class="bi bi-newspaper" style="color:var(--c-primary);font-size:1.15rem"></i>
            <h2 style="font-size:1.1rem;margin:0;font-family:Inter,sans-serif;font-weight:700">Berita</h2>
            <span style="background:var(--c-primary);color:#fff;border-radius:50px;padding:.15rem .6rem;font-size:.72rem;font-weight:700">{{ $news->count() }}</span>
        </div>
        <div style="display:grid;gap:1.1rem;grid-template-columns:1fr" class="sr-news-grid">
            @foreach($news as $item)
            <a href="{{ route('news.show',$item->slug) }}" style="text-decoration:none;color:inherit">
                <div class="ac-card" style="display:flex;gap:0;flex-direction:row;align-items:stretch">
                    @if($item->image)
                    <img src="{{ img_url($item->image) }}"
                         style="width:110px;min-height:90px;object-fit:cover;flex-shrink:0" alt="{{ $item->title }}">
                    @else
                    <div style="width:110px;background:var(--c-primary-lt);display:flex;align-items:center;justify-content:center;font-size:1.8rem;color:var(--c-primary);flex-shrink:0">
                        <i class="bi bi-image"></i>
                    </div>
                    @endif
                    <div style="padding:.85rem 1rem;flex:1;min-width:0">
                        <span class="badge-cat badge text-white" style="font-size:.65rem;margin-bottom:.4rem">{{ $item->category->name }}</span>
                        <div style="font-size:.93rem;font-weight:700;color:var(--c-dark);line-height:1.4;margin-bottom:.35rem">
                            {!! preg_replace('/('.preg_quote($query,'/').')/i','<mark style="background:#fef3c7;padding:0 2px;border-radius:2px">$1</mark>', e($item->title)) !!}
                        </div>
                        <div style="font-size:.75rem;color:var(--c-muted)">
                            <i class="bi bi-calendar3 me-1"></i>{{ $item->publish_date->format('d M Y') }}
                            &nbsp;·&nbsp;
                            <i class="bi bi-person me-1"></i>{{ $item->user->name }}
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- GALLERY RESULTS --}}
    @if($galleries->count())
    <div>
        <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:2px solid var(--c-border)">
            <i class="bi bi-images" style="color:#16a34a;font-size:1.15rem"></i>
            <h2 style="font-size:1.1rem;margin:0;font-family:Inter,sans-serif;font-weight:700">Galeri</h2>
            <span style="background:#16a34a;color:#fff;border-radius:50px;padding:.15rem .6rem;font-size:.72rem;font-weight:700">{{ $galleries->count() }}</span>
        </div>
        <div style="display:grid;gap:1.1rem;grid-template-columns:1fr" class="sr-gal-grid">
            @foreach($galleries as $gallery)
            <a href="{{ route('galleries.show',$gallery) }}" style="text-decoration:none;color:inherit">
                <div class="ac-card" style="display:flex;flex-direction:row;align-items:stretch">
                    @if($gallery->cover_image)
                    <img src="{{ img_url($gallery->cover_image) }}"
                         style="width:110px;min-height:90px;object-fit:cover;flex-shrink:0" alt="{{ $gallery->title }}">
                    @else
                    <div style="width:110px;background:linear-gradient(135deg,var(--c-primary-lt),var(--c-primary-mid));display:flex;align-items:center;justify-content:center;font-size:1.8rem;color:var(--c-primary);flex-shrink:0">
                        <i class="bi bi-images"></i>
                    </div>
                    @endif
                    <div style="padding:.85rem 1rem;flex:1;min-width:0">
                        <span style="background:#f0fdf4;color:#16a34a;border-radius:50px;padding:.2rem .6rem;font-size:.65rem;font-weight:700;display:inline-block;margin-bottom:.4rem">
                            <i class="bi bi-images me-1"></i>Galeri
                        </span>
                        <div style="font-size:.93rem;font-weight:700;color:var(--c-dark);line-height:1.4;margin-bottom:.35rem">
                            {!! preg_replace('/('.preg_quote($query,'/').')/i','<mark style="background:#fef3c7;padding:0 2px;border-radius:2px">$1</mark>', e($gallery->title)) !!}
                        </div>
                        <div style="font-size:.75rem;color:var(--c-muted)">
                            <i class="bi bi-image me-1"></i>{{ $gallery->images_count }} foto
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
    @endif
</div>

@push('styles')
<style>
@media(min-width:640px){
    .sr-news-grid, .sr-gal-grid { grid-template-columns: repeat(2,1fr) !important; }
}
</style>
@endpush
@endsection
