<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ArtConnect') – Portal Informasi Komunitas Seni</title>
    <meta name="description" content="@yield('description', 'ArtConnect adalah portal informasi komunitas seni yang menyediakan berita, event, dan galeri karya anggota komunitas seni Indonesia.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* ── Design Tokens ───────────────────────────────── */
        :root {
            --c-primary:      #6F42C1;
            --c-primary-dk:   #5432a0;
            --c-primary-lt:   #f0ebff;
            --c-primary-mid:  #d6c8f5;
            --c-accent:       #e83e8c;
            --c-dark:         #12102a;
            --c-text:         #2d2b3d;
            --c-muted:        #7a7890;
            --c-border:       #ede9f8;
            --c-bg:           #fafaf9;
            --radius-sm:      8px;
            --radius-md:      14px;
            --radius-lg:      20px;
            --shadow-sm:      0 1px 6px rgba(111,66,193,.08);
            --shadow-md:      0 4px 20px rgba(111,66,193,.13);
            --shadow-lg:      0 12px 40px rgba(111,66,193,.18);
            --transition:     .22s cubic-bezier(.4,0,.2,1);
        }

        /* ── Base ────────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; color: var(--c-text); background: var(--c-bg); margin: 0; -webkit-font-smoothing: antialiased; }
        h1,h2,h3,h4,h5,h6 { font-family: 'Playfair Display', serif; color: var(--c-dark); }
        a { color: inherit; }
        img { max-width: 100%; }

        /* ── Navbar ──────────────────────────────────────── */
        .ac-nav {
            position: sticky; top: 0; z-index: 900;
            background: rgba(255,255,255,.96);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--c-border);
            padding: 0;
        }
        .ac-nav-inner {
            display: flex; align-items: center; justify-content: space-between;
            height: 64px; padding: 0 1.5rem;
            max-width: 1200px; margin: 0 auto;
        }
        .ac-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem; font-weight: 700;
            color: var(--c-primary); text-decoration: none;
            display: flex; align-items: center; gap: .4rem;
            letter-spacing: -.02em;
        }
        .ac-logo i { font-size: 1.3rem; }

        /* Desktop nav */
        .ac-nav-links {
            display: flex; align-items: center; gap: .15rem;
            list-style: none; margin: 0; padding: 0;
        }
        .ac-nav-links a {
            display: block; padding: .5rem .8rem;
            font-size: .88rem; font-weight: 500; color: var(--c-muted);
            text-decoration: none; border-radius: var(--radius-sm);
            transition: color var(--transition), background var(--transition);
        }
        .ac-nav-links a:hover, .ac-nav-links a.active {
            color: var(--c-primary); background: var(--c-primary-lt);
        }

        /* Hamburger */
        .ac-nav-toggle {
            display: none; background: none; border: none; cursor: pointer;
            padding: .5rem; color: var(--c-dark); font-size: 1.4rem; line-height: 1;
            border-radius: var(--radius-sm); transition: background var(--transition);
        }
        .ac-nav-toggle:hover { background: var(--c-primary-lt); color: var(--c-primary); }
        @media (max-width: 767px) {
            .ac-nav-toggle { display: flex; align-items: center; justify-content: center; }
            .ac-nav-links   { display: none; }
        }

        /* ── Off-canvas drawer ────────────────────────────── */
        .oc-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(18,16,42,.55); backdrop-filter: blur(3px);
            z-index: 1000;
            opacity: 0; transition: opacity var(--transition);
        }
        .oc-overlay.show { display: block; opacity: 1; }

        .oc-drawer {
            position: fixed; top: 0; right: 0; bottom: 0;
            width: 300px; max-width: 88vw;
            background: #fff; z-index: 1001;
            display: flex; flex-direction: column;
            transform: translateX(100%);
            transition: transform .3s cubic-bezier(.4,0,.2,1);
            box-shadow: -8px 0 40px rgba(0,0,0,.16);
        }
        .oc-drawer.show { transform: translateX(0); }

        .oc-head {
            display: flex; align-items: center; justify-content: space-between;
            padding: 1.1rem 1.3rem;
            border-bottom: 1px solid var(--c-border);
            flex-shrink: 0;
        }
        .oc-head .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem; font-weight: 700; color: var(--c-primary);
        }
        .oc-close {
            background: none; border: none; cursor: pointer;
            color: var(--c-muted); font-size: 1.25rem; padding: .3rem;
            border-radius: var(--radius-sm); transition: color var(--transition), background var(--transition);
        }
        .oc-close:hover { color: var(--c-dark); background: var(--c-primary-lt); }

        .oc-body { flex: 1; overflow-y: auto; padding: 1rem 1rem 1.5rem; }

        /* Login button in drawer */
        .oc-login-btn {
            display: flex; align-items: center; gap: .65rem;
            padding: .85rem 1.1rem; border-radius: var(--radius-md);
            background: linear-gradient(135deg, var(--c-primary), #9b6dff);
            color: #fff !important; font-weight: 700; font-size: .93rem;
            text-decoration: none; margin-bottom: .75rem;
            transition: opacity var(--transition), transform var(--transition);
            box-shadow: 0 4px 14px rgba(111,66,193,.35);
        }
        .oc-login-btn:hover { opacity: .92; transform: translateY(-1px); }

        /* Nav items in drawer */
        .oc-nav-item {
            display: flex; align-items: center; gap: .75rem;
            padding: .72rem 1rem; border-radius: var(--radius-md);
            color: var(--c-text); text-decoration: none;
            font-size: .93rem; font-weight: 500;
            transition: background var(--transition), color var(--transition);
            margin-bottom: .15rem;
        }
        .oc-nav-item i {
            font-size: 1.05rem; width: 1.3rem; text-align: center;
            color: var(--c-primary); flex-shrink: 0;
        }
        .oc-nav-item:hover, .oc-nav-item.active {
            background: var(--c-primary-lt); color: var(--c-primary);
        }

        .oc-divider { height: 1px; background: var(--c-border); margin: .75rem 0; }

        /* Search in drawer */
        .oc-search-label {
            font-size: .72rem; font-weight: 700; letter-spacing: .08em;
            text-transform: uppercase; color: var(--c-muted);
            padding: 0 .25rem; margin-bottom: .5rem; display: block;
        }
        .oc-search-form { display: flex; gap: .4rem; }
        .oc-search-input {
            flex: 1; border: 1.5px solid var(--c-border);
            border-radius: var(--radius-sm); padding: .6rem .85rem;
            font-size: .88rem; font-family: inherit; outline: none;
            transition: border-color var(--transition);
            color: var(--c-text);
        }
        .oc-search-input:focus { border-color: var(--c-primary); }
        .oc-search-btn {
            background: var(--c-primary); color: #fff; border: none;
            border-radius: var(--radius-sm); padding: .6rem .9rem;
            font-size: .9rem; cursor: pointer; flex-shrink: 0;
            transition: background var(--transition);
        }
        .oc-search-btn:hover { background: var(--c-primary-dk); }

        /* ── Shared utilities ────────────────────────────── */
        .btn-ac-primary {
            background: var(--c-primary); color: #fff; border: 2px solid var(--c-primary);
            border-radius: var(--radius-sm); padding: .55rem 1.25rem;
            font-size: .88rem; font-weight: 600; text-decoration: none;
            display: inline-flex; align-items: center; gap: .4rem;
            transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
            cursor: pointer;
        }
        .btn-ac-primary:hover { background: var(--c-primary-dk); border-color: var(--c-primary-dk); color: #fff; transform: translateY(-1px); box-shadow: var(--shadow-md); }

        .btn-ac-outline {
            background: transparent; color: var(--c-primary); border: 2px solid var(--c-primary);
            border-radius: var(--radius-sm); padding: .55rem 1.25rem;
            font-size: .88rem; font-weight: 600; text-decoration: none;
            display: inline-flex; align-items: center; gap: .4rem;
            transition: background var(--transition), color var(--transition), transform var(--transition);
            cursor: pointer;
        }
        .btn-ac-outline:hover { background: var(--c-primary-lt); color: var(--c-primary); transform: translateY(-1px); }

        /* Bootstrap overrides */
        .btn-primary { background: var(--c-primary); border-color: var(--c-primary); }
        .btn-primary:hover, .btn-primary:focus { background: var(--c-primary-dk); border-color: var(--c-primary-dk); }
        .btn-outline-primary { color: var(--c-primary); border-color: var(--c-primary); }
        .btn-outline-primary:hover { background: var(--c-primary); border-color: var(--c-primary); }
        .text-primary { color: var(--c-primary) !important; }
        .badge-cat { background: var(--c-primary); font-size: .7rem; padding: .3em .7em; border-radius: 50px; }
        .page-link { color: var(--c-primary); border-radius: var(--radius-sm) !important; }
        .page-item.active .page-link { background: var(--c-primary); border-color: var(--c-primary); }
        .alert { border-radius: var(--radius-md); }
        .form-control, .form-select { border-radius: var(--radius-sm); border-color: var(--c-border); font-size: .9rem; }
        .form-control:focus, .form-select:focus { border-color: var(--c-primary); box-shadow: 0 0 0 3px rgba(111,66,193,.12); }

        /* ── Cards ───────────────────────────────────────── */
        .ac-card {
            background: #fff; border: 1px solid var(--c-border);
            border-radius: var(--radius-md); overflow: hidden;
            transition: transform var(--transition), box-shadow var(--transition);
            box-shadow: var(--shadow-sm);
        }
        .ac-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); }

        /* ── Section titles ──────────────────────────────── */
        .section-eyebrow {
            font-size: .72rem; font-weight: 700; letter-spacing: .1em;
            text-transform: uppercase; color: var(--c-primary);
            margin-bottom: .4rem; display: block;
            font-family: 'Inter', sans-serif;
        }
        .section-title { font-size: clamp(1.4rem, 3vw, 2rem); margin-bottom: .4rem; }
        .section-sub { color: var(--c-muted); font-size: .92rem; }

        /* ── Footer ──────────────────────────────────────── */
        .ac-footer { background: var(--c-dark); padding: 4rem 0 0; }
        .ac-footer-logo { font-family: 'Playfair Display', serif; font-size: 1.6rem; font-weight: 700; color: #fff; }
        .ac-footer p  { color: #8e8caa; font-size: .88rem; line-height: 1.75; }
        .ac-footer h6 { color: #fff; font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .09em; margin-bottom: 1.1rem; font-family: 'Inter', sans-serif; }
        .ac-footer a  { color: #8e8caa; text-decoration: none; font-size: .88rem; display: block; margin-bottom: .4rem; transition: color var(--transition); }
        .ac-footer a:hover { color: #d6c8f5; }
        .ac-footer .contact-row { display: flex; gap: .6rem; color: #8e8caa; font-size: .88rem; margin-bottom: .55rem; align-items: flex-start; }
        .ac-footer .contact-row i { color: var(--c-primary); margin-top: 2px; flex-shrink: 0; }
        .ac-footer-social a {
            display: inline-flex; align-items: center; justify-content: center;
            width: 38px; height: 38px; border-radius: 50%;
            background: rgba(255,255,255,.07); color: #8e8caa; font-size: 1rem;
            transition: background var(--transition), color var(--transition);
        }
        .ac-footer-social a:hover { background: var(--c-primary); color: #fff; }
        .ac-footer-bottom {
            border-top: 1px solid rgba(255,255,255,.06);
            padding: 1.2rem 0; margin-top: 3rem;
            text-align: center; color: #555568; font-size: .8rem;
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- ── NAVBAR ──────────────────────────────────────────────── --}}
<nav class="ac-nav" role="navigation">
    <div class="ac-nav-inner">
        <a class="ac-logo" href="{{ route('home') }}">
            <i class="bi bi-palette2"></i>ArtConnect
        </a>

        {{-- Desktop links (hidden on mobile) --}}
        <ul class="ac-nav-links">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a></li>
            <li><a href="{{ route('news.index') }}" class="{{ request()->routeIs('news.*') ? 'active' : '' }}">Berita</a></li>
            <li><a href="{{ route('galleries.index') }}" class="{{ request()->routeIs('galleries.*') ? 'active' : '' }}">Galeri</a></li>
            <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">Tentang</a></li>
            @auth
            <li><a href="{{ route('admin.dashboard') }}" class="btn-ac-primary ms-2">
                <i class="bi bi-speedometer2"></i>Dashboard
            </a></li>
            @else
            <li><a href="{{ route('admin.login') }}" class="btn-ac-primary ms-2">
                <i class="bi bi-person-circle"></i>Login
            </a></li>
            @endauth
        </ul>

        {{-- Hamburger --}}
        <button class="ac-nav-toggle" id="ocToggle" aria-label="Buka menu" aria-expanded="false">
            <i class="bi bi-list"></i>
        </button>
    </div>
</nav>

{{-- ── OFF-CANVAS DRAWER ───────────────────────────────────── --}}
<div class="oc-overlay" id="ocOverlay"></div>
<div class="oc-drawer" id="ocDrawer" role="dialog" aria-label="Menu navigasi">
    <div class="oc-head">
        <span class="logo"><i class="bi bi-palette2 me-1"></i>ArtConnect</span>
        <button class="oc-close" id="ocClose" aria-label="Tutup menu"><i class="bi bi-x-lg"></i></button>
    </div>
    <div class="oc-body">
        {{-- 1. Login --}}
        @auth
        <a class="oc-login-btn" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2 fs-5"></i>
            <div><div style="font-size:.72rem;opacity:.8;font-weight:500">Selamat datang,</div>{{ auth()->user()->name }}</div>
        </a>
        @else
        <a class="oc-login-btn" href="{{ route('admin.login') }}">
            <i class="bi bi-person-circle fs-5"></i>
            <div><div style="font-size:.72rem;opacity:.8;font-weight:500">Akses Admin</div>Login ke Dashboard</div>
        </a>
        @endauth

        <div class="oc-divider"></div>

        {{-- 2–5. Nav links --}}
        <a class="oc-nav-item {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
            <i class="bi bi-house-door-fill"></i>Beranda
        </a>
        <a class="oc-nav-item {{ request()->routeIs('news.*') ? 'active' : '' }}" href="{{ route('news.index') }}">
            <i class="bi bi-newspaper"></i>Berita
        </a>
        <a class="oc-nav-item {{ request()->routeIs('galleries.*') ? 'active' : '' }}" href="{{ route('galleries.index') }}">
            <i class="bi bi-images"></i>Galeri
        </a>
        <a class="oc-nav-item {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
            <i class="bi bi-info-circle-fill"></i>Tentang
        </a>

        <div class="oc-divider"></div>

        {{-- 6. Search --}}
        <span class="oc-search-label"><i class="bi bi-search me-1"></i>Pencarian Global</span>
        <form class="oc-search-form" action="{{ route('search') }}" method="GET">
            <input class="oc-search-input" type="text" name="q"
                   placeholder="Cari berita atau galeri..."
                   value="{{ request('q') }}" autocomplete="off">
            <button class="oc-search-btn" type="submit" aria-label="Cari">
                <i class="bi bi-search"></i>
            </button>
        </form>
        <div style="font-size:.73rem;color:var(--c-muted);margin-top:.4rem;padding:0 .25rem">
            Mencari berita dan galeri sekaligus
        </div>
    </div>
</div>

{{-- Flash --}}
@if(session('success'))
<div class="container mt-3">
    <div class="alert alert-success alert-dismissible fade show border-0" style="background:#f0fdf4;color:#166534">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

@yield('content')

{{-- ── FOOTER ───────────────────────────────────────────────── --}}
<footer class="ac-footer">
    <div class="container">
        <div class="row g-5">
            <div class="col-md-4">
                <div class="ac-footer-logo mb-2"><i class="bi bi-palette2 me-2"></i>ArtConnect</div>
                <p>Portal informasi komunitas seni Indonesia — menghubungkan seniman, karya, dan pecinta seni dari seluruh nusantara.</p>
                <div class="ac-footer-social d-flex gap-2 mt-3">
                    <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" aria-label="X/Twitter"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                    <a href="#" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <h6>Menu</h6>
                <a href="{{ route('home') }}">Beranda</a>
                <a href="{{ route('news.index') }}">Berita</a>
                <a href="{{ route('galleries.index') }}">Galeri</a>
                <a href="{{ route('about') }}">Tentang Kami</a>
                <a href="{{ route('admin.login') }}">Login Admin</a>
            </div>
            <div class="col-6 col-md-2">
                <h6>Jelajahi</h6>
                <a href="{{ route('search') }}?q=seni+lukis">Seni Lukis</a>
                <a href="{{ route('search') }}?q=fotografi">Fotografi</a>
                <a href="{{ route('search') }}?q=musik">Seni Musik</a>
                <a href="{{ route('search') }}?q=tari">Seni Tari</a>
                <a href="{{ route('search') }}?q=batik">Kerajinan</a>
            </div>
            <div class="col-md-4">
                <h6>Kontak</h6>
                <div class="contact-row"><i class="bi bi-envelope-fill"></i><span>info@artconnect.id</span></div>
                <div class="contact-row"><i class="bi bi-telephone-fill"></i><span>+62 21 1234 5678</span></div>
                <div class="contact-row"><i class="bi bi-geo-alt-fill"></i><span>Jl. Seni Budaya No. 1, Jakarta Pusat, Indonesia</span></div>
                <div class="contact-row mt-2"><i class="bi bi-clock-fill"></i><span>Senin–Jumat, 09.00–17.00 WIB</span></div>
            </div>
        </div>
        <div class="ac-footer-bottom">
            &copy; {{ date('Y') }} <strong style="color:#ccc">ArtConnect</strong> &nbsp;·&nbsp;
            Dibuat dengan <i class="bi bi-heart-fill" style="color:#e83e8c;font-size:.7rem"></i> untuk komunitas seni Indonesia
        </div>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script>
(function(){
    const toggle  = document.getElementById('ocToggle');
    const drawer  = document.getElementById('ocDrawer');
    const overlay = document.getElementById('ocOverlay');
    const close   = document.getElementById('ocClose');
    function open()  { drawer.classList.add('show'); overlay.classList.add('show'); document.body.style.overflow='hidden'; toggle.setAttribute('aria-expanded','true'); }
    function shut()  { drawer.classList.remove('show'); overlay.classList.remove('show'); document.body.style.overflow=''; toggle.setAttribute('aria-expanded','false'); }
    toggle.addEventListener('click', open);
    close.addEventListener('click', shut);
    overlay.addEventListener('click', shut);
    document.addEventListener('keydown', e => { if(e.key==='Escape') shut(); });
})();
</script>
@stack('scripts')
</body>
</html>
