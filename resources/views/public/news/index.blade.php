@extends('layouts.public')
@section('title','Berita')

@section('content')
<div style="background:linear-gradient(135deg,var(--c-dark),var(--c-primary));padding:3rem 0 2.5rem;color:#fff">
    <div class="container">
        <span style="font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.55)">Portal ArtConnect</span>
        <h1 style="font-size:clamp(1.6rem,4vw,2.4rem);margin:.4rem 0 .5rem">Berita & Informasi</h1>
        <p style="color:rgba(255,255,255,.7);margin:0;font-size:.95rem">Kabar terkini dari dunia seni komunitas ArtConnect</p>
    </div>
</div>

<div class="container py-5">
    {{-- Search bar (no category filter per spec) --}}
    <div class="mb-5" style="max-width:520px">
        <form action="{{ route('news.index') }}" method="GET">
            <div style="display:flex;gap:.5rem">
                <div style="flex:1;position:relative">
                    <i class="bi bi-search" style="position:absolute;left:.9rem;top:50%;transform:translateY(-50%);color:var(--c-muted)"></i>
                    <input type="text" name="search" value="{{ $search }}"
                           style="width:100%;padding:.72rem .9rem .72rem 2.5rem;border:1.5px solid var(--c-border);border-radius:var(--radius-sm);font-size:.9rem;outline:none;transition:border-color .2s;font-family:inherit"
                           placeholder="Cari judul berita..."
                           onfocus="this.style.borderColor='var(--c-primary)'" onblur="this.style.borderColor='var(--c-border)'">
                </div>
                <button type="submit" class="btn-ac-primary" style="flex-shrink:0">
                    <i class="bi bi-search"></i><span class="d-none d-sm-inline">Cari</span>
                </button>
                @if($search)
                <a href="{{ route('news.index') }}" class="btn-ac-outline" style="flex-shrink:0">Reset</a>
                @endif
            </div>
        </form>
        @if($search)
        <p style="font-size:.82rem;color:var(--c-muted);margin:.6rem 0 0">
            Menampilkan hasil untuk: <strong style="color:var(--c-primary)">"{{ $search }}"</strong>
        </p>
        @endif
    </div>

    @if($news->isEmpty())
    <div class="text-center py-5" style="color:var(--c-muted)">
        <i class="bi bi-newspaper" style="font-size:3rem;display:block;margin-bottom:1rem;opacity:.3"></i>
        <p style="font-size:1.05rem">{{ $search ? 'Tidak ada berita yang cocok dengan pencarian.' : 'Belum ada berita.' }}</p>
        @if($search)
        <a href="{{ route('news.index') }}" class="btn-ac-outline" style="margin-top:.5rem">Lihat Semua Berita</a>
        @endif
    </div>
    @else
    <div style="display:grid;gap:1.25rem;grid-template-columns:1fr" class="news-pub-grid">
        @foreach($news as $item)
        <a href="{{ route('news.show', $item->slug) }}" style="text-decoration:none;color:inherit">
            <div class="ac-card" style="display:flex;gap:0;flex-direction:column">
                <div style="display:flex;flex-direction:column">
                    @if($item->image)
                    <img src="{{ asset('storage/'.$item->image) }}"
                         style="width:100%;height:200px;object-fit:cover;display:block" alt="{{ $item->title }}">
                    @else
                    <div style="width:100%;height:200px;background:linear-gradient(135deg,var(--c-primary-lt),var(--c-primary-mid));display:flex;align-items:center;justify-content:center;font-size:2.5rem;color:var(--c-primary)">
                        <i class="bi bi-image"></i>
                    </div>
                    @endif
                    <div style="padding:1.1rem">
                        <span class="badge-cat badge text-white" style="font-size:.68rem;margin-bottom:.55rem">{{ $item->category->name }}</span>
                        <h3 style="font-size:1rem;font-weight:700;line-height:1.45;margin-bottom:.5rem;color:var(--c-dark)">{{ $item->title }}</h3>
                        <p style="font-size:.84rem;color:var(--c-muted);margin-bottom:.75rem;line-height:1.6">
                            {{ Str::limit(strip_tags($item->content), 110) }}
                        </p>
                        <div style="display:flex;justify-content:space-between;font-size:.72rem;color:var(--c-muted);padding-top:.6rem;border-top:1px solid var(--c-border)">
                            <span><i class="bi bi-person me-1"></i>{{ $item->user->name }}</span>
                            <span><i class="bi bi-calendar3 me-1"></i>{{ $item->publish_date->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @endif

    @if($news->hasPages())
    <div class="d-flex justify-content-center mt-5">{{ $news->links() }}</div>
    @endif
</div>

@push('styles')
<style>
@media(min-width:576px){ .news-pub-grid { grid-template-columns: repeat(2,1fr) !important; } }
@media(min-width:992px){ .news-pub-grid { grid-template-columns: repeat(3,1fr) !important; } }
</style>
@endpush
@endsection
