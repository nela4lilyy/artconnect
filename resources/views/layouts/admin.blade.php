<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Admin') – ArtConnect</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --ac:        #6F42C1;
            --ac-dk:     #5432a0;
            --ac-lt:     #f0ebff;
            --ac-mid:    #d6c8f5;
            --sidebar-w: 240px;
            --top-h:     60px;
            --dark:      #12102a;
            --muted:     #7a7890;
            --border:    #ede9f8;
            --bg:        #f5f4fb;
            --radius:    10px;
            --shadow:    0 2px 12px rgba(111,66,193,.09);
            --shadow-lg: 0 8px 32px rgba(111,66,193,.16);
        }
        *,*::before,*::after { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: #2d2b3d; margin: 0; -webkit-font-smoothing: antialiased; }

        /* ── Sidebar ─────────────────────────────────────── */
        .adm-sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: var(--dark);
            z-index: 500; overflow-y: auto; overflow-x: hidden;
            display: flex; flex-direction: column;
            transition: transform .28s cubic-bezier(.4,0,.2,1);
        }
        .sidebar-brand {
            display: flex; align-items: center; gap: .5rem;
            padding: 1.1rem 1.2rem;
            font-size: 1.2rem; font-weight: 800; color: #fff;
            text-decoration: none; border-bottom: 1px solid rgba(255,255,255,.07);
            flex-shrink: 0;
        }
        .sidebar-brand span { color: var(--ac); }
        .sidebar-brand i { color: var(--ac); font-size: 1.1rem; }

        .sidebar-section {
            font-size: .62rem; font-weight: 800; letter-spacing: .1em;
            text-transform: uppercase; color: rgba(255,255,255,.3);
            padding: 1.1rem 1.2rem .35rem;
        }
        .sidebar-link {
            display: flex; align-items: center; gap: .7rem;
            padding: .6rem 1rem; margin: 1px .6rem;
            border-radius: var(--radius);
            color: rgba(255,255,255,.6); text-decoration: none;
            font-size: .86rem; font-weight: 500;
            transition: background .2s, color .2s;
        }
        .sidebar-link i { font-size: 1rem; width: 1.2rem; text-align: center; flex-shrink: 0; }
        .sidebar-link:hover  { background: rgba(255,255,255,.07); color: rgba(255,255,255,.9); }
        .sidebar-link.active { background: var(--ac); color: #fff; }

        .sidebar-footer {
            margin-top: auto; padding: 1rem 1.2rem;
            border-top: 1px solid rgba(255,255,255,.07); flex-shrink: 0;
        }
        .sidebar-user {
            display: flex; align-items: center; gap: .7rem; margin-bottom: .75rem;
        }
        .sidebar-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--ac); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: .85rem; font-weight: 700; flex-shrink: 0;
        }
        .sidebar-user-name { font-size: .82rem; font-weight: 600; color: #fff; }
        .sidebar-user-role { font-size: .7rem; color: rgba(255,255,255,.4); }
        .sidebar-logout {
            display: flex; align-items: center; justify-content: center; gap: .5rem;
            width: 100%; padding: .52rem; border-radius: var(--radius);
            background: rgba(255,255,255,.07); border: none;
            color: rgba(255,255,255,.55); font-size: .82rem; font-weight: 500;
            cursor: pointer; transition: background .2s, color .2s; font-family: inherit;
        }
        .sidebar-logout:hover { background: rgba(220,38,38,.2); color: #fca5a5; }

        /* ── Overlay (mobile) ────────────────────────────── */
        .adm-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.5); z-index: 499;
        }
        .adm-overlay.show { display: block; }

        /* ── Main wrapper ────────────────────────────────── */
        .adm-main { margin-left: var(--sidebar-w); display: flex; flex-direction: column; min-height: 100vh; }

        /* ── Topbar ──────────────────────────────────────── */
        .adm-topbar {
            position: sticky; top: 0; z-index: 400;
            height: var(--top-h); background: #fff;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 1.5rem; gap: 1rem;
        }
        .adm-topbar-title { font-size: 1rem; font-weight: 700; color: var(--dark); margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .adm-menu-btn {
            display: none; background: none; border: none; cursor: pointer;
            color: var(--dark); font-size: 1.35rem; padding: .35rem;
            border-radius: var(--radius); transition: background .2s;
        }
        .adm-menu-btn:hover { background: var(--ac-lt); color: var(--ac); }

        /* ── Content ─────────────────────────────────────── */
        .adm-content { padding: 1.5rem; flex: 1; }

        /* ── Stat cards ──────────────────────────────────── */
        .stat-card { border-radius: 14px; padding: 1.35rem; border: none; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg); }
        .stat-num { font-size: 2.2rem; font-weight: 800; line-height: 1; }
        .stat-lbl { font-size: .78rem; opacity: .75; font-weight: 500; margin-top: .2rem; }
        .stat-link { font-size: .73rem; opacity: .6; margin-top: .5rem; display: block; color: inherit; text-decoration: none; }
        .stat-link:hover { opacity: .9; }

        /* ── Cards ───────────────────────────────────────── */
        .adm-card { background: #fff; border-radius: 14px; box-shadow: var(--shadow); border: 1px solid var(--border); }
        .adm-card-header {
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: .75rem;
            padding: 1rem 1.25rem; border-bottom: 1px solid var(--border);
            font-size: .88rem; font-weight: 700; color: var(--dark);
        }

        /* ── Table ───────────────────────────────────────── */
        .adm-table { width: 100%; border-collapse: collapse; font-size: .86rem; }
        .adm-table th {
            font-size: .7rem; font-weight: 800; text-transform: uppercase;
            letter-spacing: .06em; color: var(--muted);
            background: #fafaf9; padding: .7rem 1rem; white-space: nowrap;
            border-bottom: 1px solid var(--border);
        }
        .adm-table td { padding: .7rem 1rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
        .adm-table tr:last-child td { border-bottom: none; }
        .adm-table tr:hover td { background: #fafaf9; }

        /* ── Buttons ─────────────────────────────────────── */
        .btn-ac { display: inline-flex; align-items: center; gap: .4rem; border-radius: var(--radius); font-size: .84rem; font-weight: 600; padding: .5rem 1rem; cursor: pointer; text-decoration: none; transition: .2s; border: 2px solid transparent; font-family: inherit; }
        .btn-ac-primary { background: var(--ac); color: #fff; border-color: var(--ac); }
        .btn-ac-primary:hover { background: var(--ac-dk); border-color: var(--ac-dk); color: #fff; }
        .btn-ac-outline { background: transparent; color: var(--ac); border-color: var(--ac); }
        .btn-ac-outline:hover { background: var(--ac-lt); color: var(--ac); }
        .btn-ac-sm { padding: .35rem .7rem; font-size: .78rem; }
        .btn-ac-danger { background: transparent; color: #dc2626; border-color: #dc2626; }
        .btn-ac-danger:hover { background: #fef2f2; }
        .btn-ac-secondary { background: transparent; color: var(--muted); border-color: var(--border); }
        .btn-ac-secondary:hover { background: var(--bg); }

        /* Bootstrap overrides */
        .btn-primary  { background: var(--ac); border-color: var(--ac); }
        .btn-primary:hover { background: var(--ac-dk); border-color: var(--ac-dk); }
        .btn-outline-primary { color: var(--ac); border-color: var(--ac); }
        .btn-outline-primary:hover { background: var(--ac); border-color: var(--ac); color: #fff; }
        .text-primary { color: var(--ac) !important; }
        .form-control, .form-select { border-radius: var(--radius); border-color: var(--border); font-size: .88rem; }
        .form-control:focus, .form-select:focus { border-color: var(--ac); box-shadow: 0 0 0 3px rgba(111,66,193,.1); }
        .form-label { font-size: .83rem; font-weight: 600; color: #555; margin-bottom: .4rem; }
        .form-text  { font-size: .75rem; }
        .invalid-feedback { font-size: .76rem; }
        .alert { border-radius: var(--radius); font-size: .86rem; }
        .pagination { flex-wrap: wrap; gap: .2rem; }
        .page-link { border-radius: var(--radius) !important; font-size: .82rem; }
        .page-item.active .page-link { background: var(--ac); border-color: var(--ac); }

        /* ── Thumbnail ───────────────────────────────────── */
        .img-thumb { width: 46px; height: 46px; object-fit: cover; border-radius: var(--radius); flex-shrink: 0; }
        .img-thumb-placeholder { width: 46px; height: 46px; border-radius: var(--radius); background: var(--ac-lt); display: flex; align-items: center; justify-content: center; color: var(--ac); font-size: .9rem; flex-shrink: 0; }

        /* ── Search input ────────────────────────────────── */
        .adm-search { display: flex; gap: .5rem; }
        .adm-search-input {
            padding: .5rem .85rem .5rem 2.3rem; border: 1.5px solid var(--border);
            border-radius: var(--radius); font-size: .86rem; font-family: inherit;
            outline: none; transition: border-color .2s; background: #fafaf9;
            min-width: 0; flex: 1;
        }
        .adm-search-input:focus { border-color: var(--ac); background: #fff; }
        .adm-search-wrap { position: relative; flex: 1; min-width: 0; max-width: 280px; }
        .adm-search-wrap i { position: absolute; left: .75rem; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: .85rem; }

        /* ── Mobile breakpoints ──────────────────────────── */
        @media (max-width: 767px) {
            .adm-sidebar { transform: translateX(-100%); }
            .adm-sidebar.open { transform: translateX(0); box-shadow: 8px 0 40px rgba(0,0,0,.25); }
            .adm-main { margin-left: 0; }
            .adm-menu-btn { display: flex; align-items: center; }
            .adm-content { padding: 1rem; }
            .adm-topbar { padding: 0 1rem; }
        }
        @media (max-width: 575px) {
            .stat-num { font-size: 1.8rem; }
            .hide-xs { display: none !important; }
        }
    </style>
    @stack('styles')
</head>
<body>

<div class="adm-overlay" id="admOverlay"></div>

{{-- SIDEBAR --}}
<aside class="adm-sidebar" id="admSidebar">
    <a class="sidebar-brand" href="{{ route('admin.dashboard') }}">
        <i class="bi bi-palette2"></i>Art<span>Connect</span>
    </a>

    <nav style="flex:1;padding:.75rem 0">
        <div class="sidebar-section">Utama</div>
        <a class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2"></i>Dashboard
        </a>

        <div class="sidebar-section mt-2">Konten</div>
        <a class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
            <i class="bi bi-tags"></i>Kategori
        </a>
        <a class="sidebar-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}" href="{{ route('admin.news.index') }}">
            <i class="bi bi-newspaper"></i>Berita
        </a>
        <a class="sidebar-link {{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}" href="{{ route('admin.galleries.index') }}">
            <i class="bi bi-images"></i>Galeri
        </a>

        <div class="sidebar-section mt-2">Lainnya</div>
        <a class="sidebar-link" href="{{ route('home') }}" target="_blank">
            <i class="bi bi-box-arrow-up-right"></i>Lihat Website
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
            <div>
                <div class="sidebar-user-name">{{ Str::limit(auth()->user()->name,18) }}</div>
                <div class="sidebar-user-role">{{ auth()->user()->role }}</div>
            </div>
        </div>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="sidebar-logout">
                <i class="bi bi-box-arrow-left"></i>Logout
            </button>
        </form>
    </div>
</aside>

{{-- MAIN --}}
<div class="adm-main">
    <div class="adm-topbar">
        <div style="display:flex;align-items:center;gap:.75rem;min-width:0">
            <button class="adm-menu-btn" id="admMenuBtn" aria-label="Buka sidebar">
                <i class="bi bi-list"></i>
            </button>
            <h6 class="adm-topbar-title">@yield('page-title','Dashboard')</h6>
        </div>
        <div style="display:flex;align-items:center;gap:.75rem">
            <a href="{{ route('home') }}" target="_blank" class="btn-ac btn-ac-secondary btn-ac-sm d-none d-md-inline-flex">
                <i class="bi bi-globe"></i><span>Website</span>
            </a>
        </div>
    </div>

    <div class="adm-content">
        @if(session('success'))
        <div class="alert border-0 mb-4" style="background:#f0fdf4;color:#166534;display:flex;align-items:center;gap:.6rem">
            <i class="bi bi-check-circle-fill" style="font-size:1rem"></i>
            {{ session('success') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" style="font-size:.75rem"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert border-0 mb-4" style="background:#fef2f2;color:#dc2626;display:flex;align-items:center;gap:.6rem">
            <i class="bi bi-exclamation-circle-fill" style="font-size:1rem"></i>
            {{ session('error') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" style="font-size:.75rem"></button>
        </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script>
(function(){
    const btn     = document.getElementById('admMenuBtn');
    const sidebar = document.getElementById('admSidebar');
    const overlay = document.getElementById('admOverlay');
    function open()  { sidebar.classList.add('open'); overlay.classList.add('show'); document.body.style.overflow='hidden'; }
    function shut()  { sidebar.classList.remove('open'); overlay.classList.remove('show'); document.body.style.overflow=''; }
    btn.addEventListener('click', open);
    overlay.addEventListener('click', shut);
    document.addEventListener('keydown', e => { if(e.key==='Escape') shut(); });
})();
</script>
@stack('scripts')
</body>
</html>
