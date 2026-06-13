@extends('layouts.admin')
@section('title','Dashboard')
@section('page-title','Dashboard')

@section('content')

{{-- Stat cards --}}
<div class="row g-3 mb-4">
    @php
    $cards = [
        ['label'=>'Total Berita',    'value'=>$stats['news'],           'icon'=>'bi-newspaper', 'route'=>'admin.news.index',       'grad'=>'linear-gradient(135deg,#6F42C1,#9b6dff)'],
        ['label'=>'Total Kategori',  'value'=>$stats['categories'],     'icon'=>'bi-tags',      'route'=>'admin.categories.index', 'grad'=>'linear-gradient(135deg,#e83e8c,#ff7eb9)'],
        ['label'=>'Total Galeri',    'value'=>$stats['galleries'],      'icon'=>'bi-images',    'route'=>'admin.galleries.index',  'grad'=>'linear-gradient(135deg,#0ea5e9,#38bdf8)'],
        ['label'=>'Total Foto',      'value'=>$stats['gallery_images'], 'icon'=>'bi-image',     'route'=>'admin.galleries.index',  'grad'=>'linear-gradient(135deg,#16a34a,#4ade80)'],
    ];
    @endphp
    @foreach($cards as $c)
    <div class="col-6 col-xl-3">
        <div class="stat-card" style="background:{{ $c['grad'] }};color:#fff;transition:.22s">
            <div style="display:flex;justify-content:space-between;align-items:flex-start">
                <div>
                    <div class="stat-lbl">{{ $c['label'] }}</div>
                    <div class="stat-num">{{ $c['value'] }}</div>
                </div>
                <i class="bi {{ $c['icon'] }}" style="font-size:2rem;opacity:.25"></i>
            </div>
            <a href="{{ route($c['route']) }}" class="stat-link">
                Kelola <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
    @endforeach
</div>

{{-- Latest news table --}}
<div class="adm-card">
    <div class="adm-card-header">
        <div><i class="bi bi-newspaper me-2" style="color:var(--ac)"></i>Berita Terbaru</div>
        <a href="{{ route('admin.news.create') }}" class="btn-ac btn-ac-primary btn-ac-sm">
            <i class="bi bi-plus-lg"></i>Tambah Berita
        </a>
    </div>
    @if($latestNews->isEmpty())
    <div style="text-align:center;padding:3rem;color:var(--muted)">
        <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:.6rem;opacity:.35"></i>
        Belum ada berita.
    </div>
    @else
    <div style="overflow-x:auto">
        <table class="adm-table">
            <thead>
                <tr>
                    <th style="padding-left:1.25rem">Judul</th>
                    <th class="hide-xs">Kategori</th>
                    <th class="hide-xs">Tanggal</th>
                    <th style="padding-right:1.25rem">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($latestNews as $item)
                <tr>
                    <td style="padding-left:1.25rem">
                        <div style="font-weight:600;font-size:.86rem;line-height:1.4">{{ Str::limit($item->title,50) }}</div>
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
    <div style="padding:.75rem 1.25rem;border-top:1px solid var(--border)">
        <a href="{{ route('admin.news.index') }}" style="font-size:.82rem;color:var(--ac);text-decoration:none">
            Lihat semua berita <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
    @endif
</div>
@endsection
