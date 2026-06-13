@extends('layouts.public')
@section('title','Beranda')
@section('description','ArtConnect – Portal informasi komunitas seni Indonesia.')

@push('styles')
<style>
/* ─── Carousel ──────────────────────────────────────────── */
.ac-carousel { background: var(--c-dark); position: relative; overflow: hidden; }
.ac-carousel .carousel-inner { aspect-ratio: 21/9; min-height: 320px; }
@media(max-width:575px){ .ac-carousel .carousel-inner { aspect-ratio: 4/3; min-height: 260px; } }
.carousel-item { height: 100%; }
.slide-bg {
    position: absolute; inset: 0;
    background-size: cover; background-position: center;
    transition: opacity .1s;
}
.slide-bg::after {
    content:''; position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(18,16,42,.88) 0%, rgba(111,66,193,.55) 55%, rgba(232,62,140,.2) 100%);
}
.slide-content {
    position: absolute; inset: 0; z-index: 2;
    display: flex; align-items: center; padding: 3rem 3.5rem;
}
@media(max-width:767px){ .slide-content { padding: 1.75rem; } }
.slide-inner { max-width: 620px; }
.slide-tag {
    display: inline-flex; align-items: center; gap: .4rem;
    background: rgba(255,255,255,.13); backdrop-filter: blur(8px);
    color: #e0d7ff; border-radius: 50px;
    padding: .3rem .9rem; font-size: .72rem; font-weight: 700;
    letter-spacing: .07em; text-transform: uppercase; margin-bottom: 1rem;
    border: 1px solid rgba(255,255,255,.12);
}
.slide-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.4rem, 4.5vw, 2.6rem);
    font-weight: 700; color: #fff; line-height: 1.2; margin-bottom: .9rem;
}
.slide-desc {
    color: rgba(255,255,255,.72); font-size: clamp(.82rem, 1.5vw, 1rem);
    line-height: 1.7; margin: 0;
}
/* Indicators */
.ac-carousel .carousel-indicators {
    margin-bottom: 1.25rem;
}
.ac-carousel .carousel-indicators button {
    width: 24px; height: 3px; border-radius: 2px;
    background: rgba(255,255,255,.35); border: 0;
    transition: width .3s, background .3s;
    margin: 0 3px;
}
.ac-carousel .carousel-indicators .active {
    width: 44px; background: #fff;
}
/* Prev / Next arrows — override Bootstrap fully */
.ac-carousel .carousel-control-prev,
.ac-carousel .carousel-control-next {
    position: absolute;
    top: 50%; transform: translateY(-50%);
    bottom: auto;
    width: 46px; height: 46px;
    border-radius: 50%;
    background: rgba(255,255,255,.15);
    backdrop-filter: blur(6px);
    border: 1px solid rgba(255,255,255,.2);
    opacity: 1;
    transition: background .2s, transform .2s;
    display: flex; align-items: center; justify-content: center;
    z-index: 10;
}
.ac-carousel .carousel-control-prev { left: 1.25rem; margin: 0; }
.ac-carousel .carousel-control-next { right: 1.25rem; margin: 0; }
.ac-carousel .carousel-control-prev:hover,
.ac-carousel .carousel-control-next:hover {
    background: rgba(255,255,255,.32);
    transform: translateY(-50%) scale(1.08);
}
.ac-carousel .carousel-control-prev-icon,
.ac-carousel .carousel-control-next-icon {
    width: 18px; height: 18px;
    filter: drop-shadow(0 1px 2px rgba(0,0,0,.4));
}

/* ─── Welcome ───────────────────────────────────────────── */
.welcome-sec { padding: 5.5rem 0; background: #fff; }
.welcome-pill {
    display: inline-flex; align-items: center; gap: .4rem;
    background: var(--c-primary-lt); color: var(--c-primary);
    border-radius: 50px; padding: .35rem .9rem;
    font-size: .73rem; font-weight: 800; letter-spacing: .07em;
    text-transform: uppercase; margin-bottom: 1.4rem;
    font-family: 'Inter', sans-serif;
}
.welcome-h1 {
    font-size: clamp(1.8rem, 4vw, 2.9rem);
    font-weight: 700; line-height: 1.2; color: var(--c-dark); margin-bottom: 1.1rem;
}
.welcome-p { color: var(--c-muted); font-size: 1.05rem; line-height: 1.8; max-width: 540px; }

/* ─── Featured gallery ──────────────────────────────────── */
.feat-sec { padding: 4.5rem 0; background: var(--c-bg); }
.art-scroll-wrap {
    overflow-x: auto; -webkit-overflow-scrolling: touch; scrollbar-width: none;
    padding-bottom: .5rem; margin: 0 -1rem; padding-left: 1rem;
}
.art-scroll-wrap::-webkit-scrollbar { display: none; }
.art-scroll-track { display: flex; gap: 1.1rem; width: max-content; }
@media(min-width:768px){
    .art-scroll-wrap { overflow: visible; margin: 0; padding: 0; }
    .art-scroll-track { display: grid; grid-template-columns: repeat(5,1fr); width: auto; }
}
.art-card {
    background: #fff; border-radius: var(--radius-md);
    overflow: hidden; border: 1px solid var(--c-border);
    box-shadow: var(--shadow-sm);
    transition: transform var(--transition), box-shadow var(--transition);
    flex: 0 0 210px;
    text-decoration: none; color: inherit;
}
@media(min-width:768px){ .art-card { flex: none; } }
.art-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-lg); }
.art-card-img { width: 100%; height: 180px; object-fit: cover; display: block; }
.art-card-body { padding: .85rem 1rem; }
.art-card-title { font-size: .92rem; font-weight: 700; color: var(--c-dark); margin-bottom: .2rem; line-height: 1.35; }
.art-card-sub { font-size: .75rem; color: var(--c-muted); }

/* ─── News section ──────────────────────────────────────── */
.news-sec { padding: 4.5rem 0; background: #fff; }
.news-grid { display: grid; gap: 1.25rem; grid-template-columns: 1fr; }
@media(min-width:600px){ .news-grid { grid-template-columns: repeat(2,1fr); } }
@media(min-width:992px){ .news-grid { grid-template-columns: repeat(3,1fr); } }
.news-card {
    background: #fff; border-radius: var(--radius-md); overflow: hidden;
    border: 1px solid var(--c-border); box-shadow: var(--shadow-sm);
    transition: transform var(--transition), box-shadow var(--transition);
    display: flex; flex-direction: column; text-decoration: none; color: inherit;
}
.news-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); }
.news-card-img { width: 100%; height: 195px; object-fit: cover; display: block; }
.news-card-body { padding: 1.1rem; display: flex; flex-direction: column; flex: 1; }
.news-card-title { font-size: .97rem; font-weight: 700; color: var(--c-dark); line-height: 1.45; margin-bottom: .5rem; flex: 1; }
.news-card-meta { display: flex; justify-content: space-between; font-size: .72rem; color: var(--c-muted); margin-top: auto; padding-top: .75rem; border-top: 1px solid var(--c-border); }
</style>
@endpush

@section('content')

{{-- ══ 1. CAROUSEL — 5 berita terbaru real ════════════════ --}}
@php
$gradients = [
    'linear-gradient(120deg,#12102a 0%,#6F42C1 100%)',
    'linear-gradient(120deg,#0f0c29 0%,#2d1b69 60%,#6F42C1 100%)',
    'linear-gradient(120deg,#12102a 0%,#7c1d6f 100%)',
    'linear-gradient(120deg,#0d1117 0%,#1e3a5f 100%)',
    'linear-gradient(120deg,#12102a 0%,#1a4731 100%)',
];
@endphp

<div id="heroCarousel" class="carousel slide ac-carousel" data-bs-ride="carousel" data-bs-interval="5000">

    {{-- Indicators --}}
    <div class="carousel-indicators">
        @foreach($carouselNews as $i => $item)
        <button type="button" data-bs-target="#heroCarousel"
                data-bs-slide-to="{{ $i }}"
                class="{{ $i === 0 ? 'active' : '' }}"
                aria-label="Slide {{ $i + 1 }}"></button>
        @endforeach
    </div>

    {{-- Slides --}}
    <div class="carousel-inner">
        @foreach($carouselNews as $i => $item)
        <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
            <div class="slide-bg"
                 style="{{ $item->image
                    ? 'background-image:url('.img_url($item->image).');background-size:cover;background-position:center'
                    : 'background:'.$gradients[$i % 5] }}">
                {{-- Decorative shapes --}}
                <svg style="position:absolute;inset:0;width:100%;height:100%;opacity:.05" viewBox="0 0 800 380" preserveAspectRatio="xMidYMid slice">
                    <circle cx="680" cy="60"  r="220" fill="#fff"/>
                    <circle cx="80"  cy="320" r="160" fill="#fff"/>
                    <circle cx="400" cy="190" r="90"  fill="none" stroke="#fff" stroke-width="1.5"/>
                </svg>
            </div>
            <div class="slide-content">
                <div class="slide-inner">
                    <div class="slide-tag">
                        <i class="bi bi-newspaper"></i>
                        {{ $item->category->name }}
                    </div>
                    <h2 class="slide-title">{{ $item->title }}</h2>
                    <p class="slide-desc d-none d-sm-block">
                        {{ Str::limit(strip_tags($item->content), 140) }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach

        {{-- Fallback jika belum ada berita --}}
        @if($carouselNews->isEmpty())
        <div class="carousel-item active">
            <div class="slide-bg" style="background:linear-gradient(120deg,#12102a,#6F42C1)"></div>
            <div class="slide-content">
                <div class="slide-inner">
                    <div class="slide-tag"><i class="bi bi-palette2"></i>Selamat Datang</div>
                    <h2 class="slide-title">Portal Informasi Komunitas Seni Indonesia</h2>
                    <p class="slide-desc d-none d-sm-block">Temukan berita, galeri karya, dan berbagai informasi seni dalam satu platform.</p>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Prev / Next — full button agar klik area luas --}}
    <button class="carousel-control-prev" type="button"
            data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Sebelumnya</span>
    </button>
    <button class="carousel-control-next" type="button"
            data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Berikutnya</span>
    </button>
</div>


{{-- ══ 2. WELCOME — tanpa kolom kanan ════════════════════ --}}
<section class="welcome-sec">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 text-center">
                <div class="welcome-pill"><i class="bi bi-palette2"></i>Portal Komunitas Seni</div>
                <h1 class="welcome-h1">
                    Menghubungkan Komunitas Seni<br class="d-none d-md-block">
                    Melalui Informasi dan Karya
                </h1>
                <p class="welcome-p mx-auto mb-5">
                    ArtConnect merupakan portal informasi komunitas seni yang menghadirkan berita,
                    galeri karya, dan berbagai aktivitas seni dalam satu platform.
                </p>
                <div class="d-flex gap-3 flex-wrap justify-content-center">
                    <a href="{{ route('galleries.index') }}" class="btn-ac-primary">
                        <i class="bi bi-images"></i>Jelajahi Galeri
                    </a>
                    <a href="{{ route('news.index') }}" class="btn-ac-outline">
                        <i class="bi bi-newspaper"></i>Baca Berita
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ══ 3. GALERI KARYA UNGGULAN ════════════════════════════ --}}
<section class="feat-sec">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end flex-wrap gap-2 mb-4">
            <div>
                <span class="section-eyebrow"><i class="bi bi-images me-1"></i>Karya Pilihan</span>
                <h2 class="section-title mb-0">Galeri Karya Unggulan</h2>
                <p class="section-sub mt-1">Lima karya terpilih dari anggota komunitas</p>
            </div>
            <a href="{{ route('galleries.index') }}" class="btn-ac-outline">
                Semua Galeri <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        @if($latestGalleries->isEmpty())
        <p class="text-muted text-center py-4">Belum ada galeri.</p>
        @else
        <div class="art-scroll-wrap">
            <div class="art-scroll-track">
                @foreach($latestGalleries as $gallery)
                <a href="{{ route('galleries.show', $gallery) }}" class="art-card">
                    @if($gallery->cover_image)
                    <img src="{{ img_url($gallery->cover_image) }}"
                         class="art-card-img" alt="{{ $gallery->title }}">
                    @else
                    <div class="art-card-img d-flex align-items-center justify-content-center"
                         style="background:linear-gradient(135deg,var(--c-primary-lt),var(--c-primary-mid));font-size:2.5rem;color:var(--c-primary)">
                        <i class="bi bi-images"></i>
                    </div>
                    @endif
                    <div class="art-card-body">
                        <div class="art-card-title">{{ Str::limit($gallery->title, 36) }}</div>
                        <div class="art-card-sub">
                            <i class="bi bi-image me-1"></i>{{ $gallery->images_count }} foto
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>


{{-- ══ 4. BERITA TERBARU ════════════════════════════════════ --}}
<section class="news-sec">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end flex-wrap gap-2 mb-4">
            <div>
                <span class="section-eyebrow"><i class="bi bi-newspaper me-1"></i>Terkini</span>
                <h2 class="section-title mb-0">Berita Terbaru</h2>
                <p class="section-sub mt-1">Informasi dan kabar terkini dari dunia seni</p>
            </div>
            <a href="{{ route('news.index') }}" class="btn-ac-outline">
                Semua Berita <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        @if($latestNews->isEmpty())
        <p class="text-muted text-center py-4">Belum ada berita.</p>
        @else
        <div class="news-grid">
            @foreach($latestNews as $item)
            <a href="{{ route('news.show', $item->slug) }}" class="news-card">
                @if($item->image)
                <img src="{{ img_url($item->image) }}"
                     class="news-card-img" alt="{{ $item->title }}">
                @else
                <div class="news-card-img d-flex align-items-center justify-content-center"
                     style="background:linear-gradient(135deg,var(--c-primary-lt),var(--c-primary-mid));font-size:2.5rem;color:var(--c-primary)">
                    <i class="bi bi-image"></i>
                </div>
                @endif
                <div class="news-card-body">
                    <span class="badge-cat badge text-white mb-2"
                          style="width:fit-content;font-size:.68rem">{{ $item->category->name }}</span>
                    <div class="news-card-title">{{ $item->title }}</div>
                    <div class="news-card-meta">
                        <span><i class="bi bi-person me-1"></i>{{ $item->user->name }}</span>
                        <span><i class="bi bi-calendar3 me-1"></i>{{ $item->publish_date->format('d M Y') }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @endif
    </div>
</section>

@endsection
