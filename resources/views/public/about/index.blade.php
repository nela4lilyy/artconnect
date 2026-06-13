@extends('layouts.public')

@section('title', 'Tentang Kami')

@section('content')
<div class="py-4" style="background:linear-gradient(135deg,#1a1a2e,#6F42C1);color:#fff">
    <div class="container py-3">
        <h1 class="mb-1" style="font-size:2rem">Tentang ArtConnect</h1>
        <p class="mb-0 opacity-75">Menghubungkan seniman dan pecinta seni Indonesia</p>
    </div>
</div>

<div class="container py-5">
    {{-- Vision Mission --}}
    <div class="row g-5 align-items-center mb-5">
        <div class="col-lg-6">
            <span class="badge mb-3 px-3 py-2" style="background:#f0ebff;color:#6F42C1">Tentang Komunitas</span>
            <h2 class="mb-3">Platform Digital untuk Seniman Indonesia</h2>
            <p class="text-muted mb-3" style="line-height:1.9">
                ArtConnect lahir dari semangat untuk mendigitalkan dan menghubungkan ekosistem seni Indonesia
                yang kaya dan beragam. Kami percaya bahwa setiap karya seni memiliki cerita yang layak
                untuk didengar dan dilihat oleh dunia.
            </p>
            <p class="text-muted mb-4" style="line-height:1.9">
                Dengan teknologi modern, kami menjembatani seniman berbakat dari seluruh penjuru nusantara
                dengan audiens yang lebih luas, sekaligus menjadi arsip digital kekayaan seni budaya bangsa.
            </p>
        </div>
        <div class="col-lg-6">
            <div class="row g-3">
                @foreach([
                    ['icon' => 'bi-people-fill', 'num' => '500+', 'label' => 'Anggota Aktif'],
                    ['icon' => 'bi-newspaper', 'num' => '1000+', 'label' => 'Artikel Berita'],
                    ['icon' => 'bi-images', 'num' => '200+', 'label' => 'Galeri Karya'],
                    ['icon' => 'bi-geo-alt-fill', 'num' => '34', 'label' => 'Provinsi Terwakili'],
                ] as $stat)
                <div class="col-6">
                    <div class="card border-0 shadow-sm p-4 text-center h-100">
                        <i class="bi {{ $stat['icon'] }} mb-2" style="font-size:2rem;color:#6F42C1"></i>
                        <div style="font-size:2rem;font-weight:700;color:#6F42C1">{{ $stat['num'] }}</div>
                        <div class="text-muted small">{{ $stat['label'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Pillars --}}
    <div class="py-5 border-top">
        <div class="text-center mb-5">
            <h2 class="mb-2">Pilar Komunitas Kami</h2>
            <p class="text-muted">Nilai-nilai yang menjadi fondasi ArtConnect</p>
        </div>
        <div class="row g-4">
            @foreach([
                ['icon' => 'bi-palette2', 'title' => 'Ekspresi Bebas', 'desc' => 'Setiap seniman berhak mengekspresikan karya tanpa batas. Kami menyediakan ruang yang inklusif untuk semua aliran dan gaya seni.'],
                ['icon' => 'bi-people', 'title' => 'Komunitas Suportif', 'desc' => 'Membangun jaringan yang saling mendukung antara seniman, kurator, dan pecinta seni dari seluruh Indonesia.'],
                ['icon' => 'bi-archive', 'title' => 'Pelestarian Budaya', 'desc' => 'Mendokumentasikan dan melestarikan seni tradisional Indonesia agar tetap hidup dan relevan di era modern.'],
                ['icon' => 'bi-lightbulb', 'title' => 'Inovasi Kreatif', 'desc' => 'Mendorong eksplorasi dan inovasi dalam berkarya seni, memadukan tradisi dengan perspektif kontemporer.'],
            ] as $pillar)
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 p-4">
                    <div class="rounded-3 mb-3 d-flex align-items-center justify-content-center"
                         style="width:56px;height:56px;background:#f0ebff">
                        <i class="bi {{ $pillar['icon'] }}" style="font-size:1.5rem;color:#6F42C1"></i>
                    </div>
                    <h5 class="mb-2" style="font-size:1rem">{{ $pillar['title'] }}</h5>
                    <p class="text-muted small mb-0" style="line-height:1.7">{{ $pillar['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Contact --}}
    <div class="rounded-4 p-5 mt-5 text-center" style="background:linear-gradient(135deg,#6F42C1,#e83e8c);color:#fff">
        <h3 class="mb-2">Bergabunglah Bersama Kami</h3>
        <p class="mb-4 opacity-85">Jadilah bagian dari komunitas seni terbesar di Indonesia</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-envelope-fill"></i>
                <span>info@artconnect.id</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-telephone-fill"></i>
                <span>+62 21 1234 5678</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-geo-alt-fill"></i>
                <span>Jakarta, Indonesia</span>
            </div>
        </div>
    </div>
</div>
@endsection
