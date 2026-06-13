@extends('layouts.public')
@section('title', $news->title)
@section('description', Str::limit(strip_tags($news->content),160))

@section('content')
<div style="background:linear-gradient(135deg,var(--c-dark),var(--c-primary));padding:2.5rem 0 2rem;color:#fff">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol style="display:flex;gap:.5rem;list-style:none;margin:0;padding:0;font-size:.8rem;flex-wrap:wrap">
                <li><a href="{{ route('home') }}" style="color:rgba(255,255,255,.5);text-decoration:none">Beranda</a></li>
                <li style="color:rgba(255,255,255,.3)">/</li>
                <li><a href="{{ route('news.index') }}" style="color:rgba(255,255,255,.5);text-decoration:none">Berita</a></li>
                <li style="color:rgba(255,255,255,.3)">/</li>
                <li style="color:rgba(255,255,255,.75)">{{ Str::limit($news->title,40) }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-8">
            <span class="badge-cat badge text-white mb-3" style="font-size:.73rem">{{ $news->category->name }}</span>
            <h1 style="font-size:clamp(1.5rem,4vw,2.2rem);line-height:1.3;margin-bottom:1rem">{{ $news->title }}</h1>
            <div style="display:flex;flex-wrap:wrap;gap:1.2rem;font-size:.8rem;color:var(--c-muted);margin-bottom:1.8rem;padding-bottom:1.2rem;border-bottom:1px solid var(--c-border)">
                <span><i class="bi bi-person-circle me-1"></i>{{ $news->user->name }}</span>
                <span><i class="bi bi-calendar3 me-1"></i>{{ $news->publish_date->format('d F Y') }}</span>
                <span><i class="bi bi-tags me-1"></i>{{ $news->category->name }}</span>
            </div>
            @if($news->image)
            <img src="{{ img_url($news->image) }}"
                 style="width:100%;max-height:440px;object-fit:cover;border-radius:var(--radius-md);margin-bottom:2rem" alt="{{ $news->title }}">
            @endif
            <div style="font-size:1.05rem;line-height:1.95;color:#444">
                {!! nl2br(e($news->content)) !!}
            </div>
            <div style="margin-top:2.5rem;padding-top:1.5rem;border-top:1px solid var(--c-border)">
                <a href="{{ route('news.index') }}" class="btn-ac-outline">
                    <i class="bi bi-arrow-left"></i>Kembali ke Daftar Berita
                </a>
            </div>
        </div>

        <div class="col-lg-4">
            <div style="position:sticky;top:80px">
                @if($relatedNews->isNotEmpty())
                <div class="ac-card mb-4">
                    <div style="padding:.9rem 1.1rem;border-bottom:1px solid var(--c-border);font-size:.85rem;font-weight:700;color:var(--c-dark)">
                        <i class="bi bi-newspaper me-2" style="color:var(--c-primary)"></i>Berita Terkait
                    </div>
                    @foreach($relatedNews as $r)
                    <a href="{{ route('news.show',$r->slug) }}"
                       style="display:flex;gap:.85rem;padding:.9rem 1.1rem;border-bottom:1px solid var(--c-border);text-decoration:none;transition:background .2s"
                       onmouseover="this.style.background='var(--c-primary-lt)'" onmouseout="this.style.background=''">
                        @if($r->image)
                        <img src="{{ img_url($r->image) }}" style="width:58px;height:48px;object-fit:cover;border-radius:var(--radius-sm);flex-shrink:0" alt="">
                        @else
                        <div style="width:58px;height:48px;background:var(--c-primary-lt);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center;color:var(--c-primary);flex-shrink:0">
                            <i class="bi bi-image"></i>
                        </div>
                        @endif
                        <div>
                            <div style="font-size:.85rem;font-weight:600;color:var(--c-dark);line-height:1.4">{{ Str::limit($r->title,52) }}</div>
                            <div style="font-size:.72rem;color:var(--c-muted);margin-top:.2rem">{{ $r->publish_date->format('d M Y') }}</div>
                        </div>
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
