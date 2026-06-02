<!-- <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
     <title>@yield('title') |Administracion-Fuerza Urbana</title>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>

<body>

    @include('components.navbar')

     @yield('content-admin') //Cambair por las paginas que le deben aparecer al admin


</body>
</html> -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — @yield('title', 'Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-w: 240px;
            --dark:      #0f0f1a;
            --dark2:     #1a1a2e;
            --dark3:     #252540;
            --red:       #e63946;
            --red-dark:  #c1121f;
            --text-mute: rgba(255,255,255,.55);
            --text-dim:  rgba(255,255,255,.35);
        }
        *, body { font-family: 'Inter', sans-serif; }
        body { background: #f0eff5; }

        /* ── SIDEBAR ─────────────────────────────── */
        #sidebar {
            position: fixed; top: 0; left: 0;
            width: var(--sidebar-w); height: 100vh;
            background: var(--dark2);
            display: flex; flex-direction: column;
            z-index: 1040; overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--dark3) transparent;
        }
        .sidebar-brand {
            padding: 1.4rem 1.5rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,.06);
        }
        .sidebar-brand span {
            font-size: 1.2rem; font-weight: 600;
            color: #fff; letter-spacing: -.3px;
        }
        .sidebar-brand small { color: var(--red); font-size: .7rem; letter-spacing: 1px; text-transform: uppercase; }

        .sidebar-section {
            padding: .5rem 1rem .2rem;
            font-size: .65rem; font-weight: 600;
            color: var(--text-dim); text-transform: uppercase; letter-spacing: 1px;
        }
        #sidebar .nav-link {
            color: var(--text-mute);
            padding: .52rem 1.25rem;
            border-radius: 8px; margin: 1px .5rem;
            font-size: .86rem; font-weight: 500;
            display: flex; align-items: center; gap: .65rem;
            transition: background .15s, color .15s;
            text-decoration: none;
        }
        #sidebar .nav-link i { font-size: 1rem; width: 18px; flex-shrink: 0; }
        #sidebar .nav-link:hover  { background: rgba(255,255,255,.07); color: #fff; }
        #sidebar .nav-link.active { background: var(--red); color: #fff; }
        #sidebar .nav-link.active i { color: #fff; }

        .sidebar-footer {
            margin-top: auto;
            padding: 1rem 1rem .75rem;
            border-top: 1px solid rgba(255,255,255,.06);
        }

        /* ── TOP BAR ─────────────────────────────── */
        #topbar {
            position: fixed; top: 0;
            left: var(--sidebar-w);
            right: 0; height: 60px;
            background: #fff;
            border-bottom: 1px solid #e8e7f0;
            display: flex; align-items: center;
            padding: 0 1.75rem;
            z-index: 1030;
            box-shadow: 0 1px 6px rgba(0,0,0,.06);
        }
        .topbar-title {
            font-size: 1rem; font-weight: 600;
            color: #1a1a2e; flex: 1;
        }
        .admin-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--red); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: .8rem; font-weight: 600;
        }

        /* ── MAIN CONTENT ────────────────────────── */
        #main {
            margin-left: var(--sidebar-w);
            padding-top: 60px;
            min-height: 100vh;
        }
        .page-body { padding: 1.75rem; }

        /* ── STAT CARDS ──────────────────────────── */
        .stat-card {
            background: #fff; border-radius: 14px;
            padding: 1.4rem 1.5rem;
            border: 1px solid #ebe9f5;
            transition: transform .2s, box-shadow .2s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.07); }
        .stat-icon {
            width: 46px; height: 46px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
        }
        .stat-value { font-size: 1.75rem; font-weight: 700; color: #1a1a2e; line-height: 1.1; }
        .stat-label { font-size: .78rem; color: #888; font-weight: 500; margin-top: .2rem; }

        /* ── TABLES ──────────────────────────────── */
        .admin-card {
            background: #fff; border-radius: 14px;
            border: 1px solid #ebe9f5;
            overflow: hidden;
        }
        .admin-card-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #f0eff5;
            display: flex; align-items: center; justify-content: space-between;
        }
        .admin-card-header h6 { margin: 0; font-weight: 600; font-size: .95rem; color: #1a1a2e; }
        .table-admin { margin: 0; }
        .table-admin th {
            background: #f8f7fd; font-size: .75rem;
            text-transform: uppercase; letter-spacing: .5px;
            color: #888; font-weight: 600; border-bottom: 1px solid #ebe9f5;
            padding: .75rem 1rem;
        }
        .table-admin td { padding: .8rem 1rem; vertical-align: middle; font-size: .875rem; border-color: #f5f4fb; }
        .table-admin tbody tr:hover td { background: #faf9fe; }

        /* ── BADGES ──────────────────────────────── */
        .badge-estado { padding: 4px 10px; border-radius: 20px; font-size: .72rem; font-weight: 600; }

        /* ── FORMS ───────────────────────────────── */
        .form-label { font-weight: 500; font-size: .85rem; color: #444; }
        .form-control, .form-select {
            border-color: #ddd; border-radius: 8px;
            font-size: .875rem; padding: .55rem .85rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--red); box-shadow: 0 0 0 .2rem rgba(230,57,70,.15);
        }

        /* ── BUTTONS ─────────────────────────────── */
        .btn-red   { background: var(--red); border-color: var(--red); color: #fff; }
        .btn-red:hover { background: var(--red-dark); border-color: var(--red-dark); color: #fff; }
        .btn-dark2 { background: var(--dark2); border-color: var(--dark2); color: #fff; }
        .btn-dark2:hover { background: var(--dark); border-color: var(--dark); color: #fff; }

        /* ── ALERTS ──────────────────────────────── */
        .alert { border-radius: 10px; font-size: .875rem; }

        /* ── RESPONSIVE ──────────────────────────── */
        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); transition: transform .25s; }
            #sidebar.open { transform: translateX(0); }
            #topbar, #main { left: 0; margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- ── SIDEBAR ──────────────────────────────────────────────────── --}}
<nav id="sidebar">
    <div class="sidebar-brand">
        <div><small>Panel de</small></div>
        <span><i class="bi bi-shield-fill-check me-2" style="color:var(--red)"></i>Administración</span>
    </div>

    <div class="py-2">
        <div class="sidebar-section">Principal</div>
        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="sidebar-section mt-2">Catálogo</div>
        <a href="{{ route('admin.productos.index') }}"
           class="nav-link {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> Productos
        </a>
        <a href="{{ route('admin.categorias.index') }}"
           class="nav-link {{ request()->routeIs('admin.categorias.*') ? 'active' : '' }}">
            <i class="bi bi-tag"></i> Categorías
        </a>

        <div class="sidebar-section mt-2">Comercio</div>
        <a href="{{ route('admin.ventas.index') }}"
           class="nav-link {{ request()->routeIs('admin.ventas.*') ? 'active' : '' }}">
            <i class="bi bi-bag-check"></i> Ventas
        </a>
        <a href="{{ route('admin.facturacion.index') }}"
           class="nav-link {{ request()->routeIs('admin.facturacion.*') ? 'active' : '' }}">
            <i class="bi bi-receipt"></i> Facturación
        </a>
        <a href="{{ route('admin.reportes.index') }}"
           class="nav-link {{ request()->routeIs('admin.reportes.*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line"></i> Reportes
        </a>

        <div class="sidebar-section mt-2">Usuarios</div>
        <a href="{{ route('admin.usuarios.index') }}"
           class="nav-link {{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Usuarios
        </a>
        <a href="{{ route('admin.consultas.index') }}"
           class="nav-link {{ request()->routeIs('admin.consultas.*') ? 'active' : '' }}">
            <i class="bi bi-chat-dots"></i> Consultas
            @php $pendientes = \App\Models\Consulta::where('estado','pendiente')->count() @endphp
            @if($pendientes)
            <span class="badge ms-auto" style="background:var(--red);font-size:.65rem">{{ $pendientes }}</span>
            @endif
        </a>
    </div>

    <div class="sidebar-footer">
        <a href="{{ url('/') }}" class="nav-link" style="color:rgba(255,255,255,.4);font-size:.82rem">
            <i class="bi bi-arrow-left-circle"></i> Volver a la tienda
        </a>
    </div>
</nav>

{{-- ── TOP BAR ───────────────────────────────────────────────────── --}}
<header id="topbar">
    <button class="btn btn-sm d-md-none me-3 p-1"
            onclick="document.getElementById('sidebar').classList.toggle('open')">
        <i class="bi bi-list fs-5"></i>
    </button>
    <div class="topbar-title">@yield('title', 'Panel de Administración')</div>

    <div class="d-flex align-items-center gap-3">
        <div class="text-end d-none d-sm-block">
            <div style="font-size:.82rem;font-weight:600;color:#1a1a2e">{{ Auth::user()->name }}</div>
            <div style="font-size:.72rem;color:#aaa">Administrador</div>
        </div>
        <div class="admin-avatar">{{ strtoupper(substr(Auth::user()->name,0,2)) }}</div>
        <form action="{{ route('logout') }}" method="POST" class="mb-0">
            @csrf
            <button class="btn btn-sm btn-outline-danger px-3" title="Cerrar sesión">
                <i class="bi bi-box-arrow-right"></i>
            </button>
        </form>
    </div>
</header>

{{-- ── CONTENIDO ─────────────────────────────────────────────────── --}}
<main id="main">
    <div class="page-body">

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>