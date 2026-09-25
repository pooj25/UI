<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Fabric Management') — Track Tech</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 255px;
            /* Brand: deep charcoal sidebar + emerald green accent */
            --primary:        #16a34a;
            --primary-dark:   #15803d;
            --primary-light:  #4ade80;
            --primary-glow:   rgba(22,163,74,0.18);
            --sidebar-bg:     #111827;
            --sidebar-surface:#1f2937;
            --sidebar-text:   #9ca3af;
            --sidebar-hover:  rgba(255,255,255,0.06);
            --sidebar-active: rgba(22,163,74,0.18);
            --topbar-bg:      #ffffff;
            --body-bg:        #f3f4f6;
            --card-bg:        #ffffff;
            --border-color:   #e5e7eb;
            --text-main:      #111827;
            --text-muted:     #6b7280;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--body-bg);
            color: var(--text-main);
            margin: 0;
        }

        /* ── Sidebar ─────────────────────────────── */
        #sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            z-index: 1000;
            display: flex; flex-direction: column;
            overflow-y: auto;
            transition: transform 0.3s ease;
            border-right: 1px solid rgba(255,255,255,0.04);
        }
        .sidebar-brand {
            padding: 1.35rem 1.2rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .sidebar-brand .brand-logo {
            width: 38px; height: 38px; border-radius: 10px;
            background: linear-gradient(135deg, #16a34a, #4ade80);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(22,163,74,0.4);
        }
        .sidebar-brand h5 {
            color: #f9fafb; font-weight: 700; font-size: 1rem; margin: 0;
        }
        .sidebar-brand small { color: #6b7280; font-size: 0.7rem; }

        .sidebar-nav { padding: 0.6rem 0; flex: 1; }

        .nav-label {
            font-size: 0.62rem; font-weight: 700; letter-spacing: 0.1em;
            color: #4b5563; padding: 0.85rem 1.2rem 0.25rem;
            text-transform: uppercase;
        }
        .nav-item-link {
            display: flex; align-items: center; gap: 0.6rem;
            padding: 0.55rem 1.2rem; color: var(--sidebar-text);
            text-decoration: none; font-size: 0.845rem; font-weight: 500;
            border-radius: 0; transition: all 0.14s ease;
            position: relative; margin: 1px 0;
        }
        .nav-item-link:hover {
            background: var(--sidebar-hover);
            color: #f3f4f6;
        }
        .nav-item-link.active {
            background: var(--sidebar-active);
            color: var(--primary-light);
        }
        .nav-item-link.active::before {
            content: ''; position: absolute; left: 0; top: 0; bottom: 0;
            width: 3px; background: var(--primary);
            border-radius: 0 3px 3px 0;
        }
        .nav-item-link i { font-size: 0.95rem; width: 1rem; text-align: center; flex-shrink: 0; }

        .sidebar-footer {
            border-top: 1px solid rgba(255,255,255,0.06);
            padding: 0.9rem 1.2rem;
            background: var(--sidebar-surface);
        }
        .user-info { display: flex; align-items: center; gap: 0.7rem; }
        .user-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: linear-gradient(135deg, #16a34a, #4ade80);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: 0.82rem;
            flex-shrink: 0;
        }
        .user-name { color: #f3f4f6; font-size: 0.82rem; font-weight: 600; }
        .user-role { color: #6b7280; font-size: 0.7rem; }

        /* ── Main content ────────────────────────── */
        #main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex; flex-direction: column;
        }

        /* ── Topbar ──────────────────────────────── */
        .topbar {
            background: var(--topbar-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 0.8rem 1.75rem;
            display: flex; align-items: center;
            position: sticky; top: 0; z-index: 100;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .topbar-title { font-size: 1rem; font-weight: 700; color: var(--text-main); }
        .topbar-breadcrumb {
            font-size: 0.76rem; color: var(--text-muted); margin-top: 1px;
        }
        .topbar-breadcrumb a {
            color: var(--primary); text-decoration: none; font-weight: 500;
        }
        .topbar-breadcrumb a:hover { text-decoration: underline; }
        /* breadcrumb separator */
        .topbar-breadcrumb .sep {
            margin: 0 5px; color: #d1d5db;
        }

        /* ── Page content ────────────────────────── */
        .page-content { padding: 1.6rem; flex: 1; }

        /* ── Cards ───────────────────────────────── */
        .card {
            border: 1px solid var(--border-color);
            border-radius: 10px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
            background: var(--card-bg);
        }
        .card-header {
            background: #fafafa;
            border-bottom: 1px solid var(--border-color);
            padding: 0.85rem 1.2rem;
            border-radius: 10px 10px 0 0 !important;
        }

        /* ── Stat cards ──────────────────────────── */
        .stat-card {
            border-radius: 12px; padding: 1.3rem 1.4rem;
            position: relative; overflow: hidden;
            border: none; box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        }
        .stat-card .stat-icon {
            width: 48px; height: 48px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; margin-bottom: 0.8rem;
        }
        .stat-card .stat-value { font-size: 1.9rem; font-weight: 700; line-height: 1; margin-bottom: 0.2rem; }
        .stat-card .stat-label { font-size: 0.8rem; font-weight: 500; opacity: 0.82; }

        .stat-card-green  { background: linear-gradient(135deg, #15803d, #16a34a); color:#fff; }
        .stat-card-teal   { background: linear-gradient(135deg, #0f766e, #0d9488); color:#fff; }
        .stat-card-slate  { background: linear-gradient(135deg, #334155, #475569); color:#fff; }
        .stat-card-amber  { background: linear-gradient(135deg, #b45309, #d97706); color:#fff; }

        /* ── Buttons ─────────────────────────────── */
        .btn-primary {
            background: var(--primary); border-color: var(--primary);
            font-weight: 500; border-radius: 7px;
        }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }
        .btn-outline-primary {
            color: var(--primary); border-color: var(--primary);
            border-radius: 7px; font-weight: 500;
        }
        .btn-outline-primary:hover { background: var(--primary); color:#fff; }

        /* ── Tables ──────────────────────────────── */
        .table { font-size: 0.855rem; }
        .table thead th {
            font-size: 0.71rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.05em; color: #9ca3af;
            border-bottom: 1px solid var(--border-color);
            padding: 0.7rem 1rem; background: #f9fafb;
        }
        .table tbody td { padding: 0.75rem 1rem; vertical-align: middle; }
        .table tbody tr:hover { background: #f9fafb; }

        /* ── Badges ──────────────────────────────── */
        .badge-active {
            background: rgba(22,163,74,0.1); color: #15803d;
            padding: 0.28rem 0.6rem; border-radius: 20px;
            font-size: 0.71rem; font-weight: 600;
        }
        .badge-inactive {
            background: rgba(107,114,128,0.1); color: #6b7280;
            padding: 0.28rem 0.6rem; border-radius: 20px;
            font-size: 0.71rem; font-weight: 600;
        }

        /* ── Alerts ──────────────────────────────── */
        .alert { border-radius: 9px; border: none; font-size: 0.865rem; }
        .alert-success { background: rgba(22,163,74,0.09); color: #14532d; }
        .alert-danger  { background: rgba(220,38,38,0.08); color: #991b1b; }
        .alert-warning { background: rgba(217,119,6,0.09); color: #78350f; }

        /* ── Form controls ───────────────────────── */
        .form-control, .form-select {
            border-radius: 7px; border: 1px solid #d1d5db;
            font-size: 0.865rem; padding: 0.48rem 0.85rem;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(22,163,74,0.12);
        }
        .form-label { font-weight: 600; font-size: 0.82rem; margin-bottom: 0.35rem; color: #374151; }

        /* ── Action icon buttons ─────────────────── */
        .btn-action {
            width: 30px; height: 30px; border-radius: 7px; padding: 0;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 0.8rem; border: none; cursor: pointer;
            transition: all 0.13s;
        }
        .btn-view   { background: rgba(22,163,74,0.1);  color: var(--primary); }
        .btn-edit   { background: rgba(217,119,6,0.1);  color: #b45309; }
        .btn-delete { background: rgba(220,38,38,0.09); color: #dc2626; }
        .btn-view:hover   { background: var(--primary); color: #fff; }
        .btn-edit:hover   { background: #d97706; color: #fff; }
        .btn-delete:hover { background: #ef4444; color: #fff; }

        /* ── Section header ──────────────────────── */
        .section-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 1.15rem;
        }
        .section-header h4 { font-size: 1.1rem; font-weight: 700; margin: 0; }

        /* ── Responsive ──────────────────────────── */
        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            #main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-brand">
            <div class="d-flex align-items-center gap-2 mb-1">
                <div class="brand-logo">
                    <i class="bi bi-grid-3x3-gap-fill text-white" style="font-size:1.05rem;"></i>
                </div>
                <div>
                    <h5 class="mb-0">Track Tech</h5>
                </div>
            </div>
            <small>Fabric Production System</small>
        </div>

        <div class="sidebar-nav">
            <div class="nav-label">Overview</div>
            <a href="{{ route('dashboard') }}" class="nav-item-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <div class="nav-label">Master Data</div>
            <a href="{{ route('fabrics.index') }}" class="nav-item-link {{ request()->routeIs('fabrics.*') ? 'active' : '' }}">
                <i class="bi bi-layers"></i> Fabrics
            </a>
            <a href="{{ route('fabric-groups.index') }}" class="nav-item-link {{ request()->routeIs('fabric-groups.*') ? 'active' : '' }}">
                <i class="bi bi-collection"></i> Fabric Groups
            </a>

            <div class="nav-label">Warehouse</div>
            <a href="{{ route('grn.index') }}" class="nav-item-link {{ request()->routeIs('grn.index') || request()->routeIs('grn.create') || request()->routeIs('grn.show') || request()->routeIs('grn.print*') || request()->routeIs('grn.inspect*') || request()->routeIs('grn.store*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i> GRN / Rolls
            </a>
            <a href="{{ route('grn.scan') }}" class="nav-item-link {{ request()->routeIs('grn.scan') ? 'active' : '' }}">
                <i class="bi bi-qr-code-scan"></i> Scan QR
            </a>
            <a href="{{ route('fabric-reserve.index') }}" class="nav-item-link {{ request()->routeIs('fabric-reserve.*') ? 'active' : '' }}">
                <i class="bi bi-cart"></i> Fabric Reserve
            </a>

            <div class="nav-label">Production</div>
            <a href="{{ route('cutman.index') }}" class="nav-item-link {{ request()->routeIs('cutman.*') ? 'active' : '' }}">
                <i class="bi bi-scissors"></i> Cutman (Orders)
            </a>
            <a href="{{ route('lay-models.index') }}" class="nav-item-link {{ request()->routeIs('lay-models.*') ? 'active' : '' }}">
                <i class="bi bi-intersect"></i> Lay Models
            </a>
        </div>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div>
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="btn btn-sm w-100 mt-1"
                    style="background:rgba(239,68,68,0.12);color:#f87171;border:none;border-radius:7px;font-size:0.78rem;">
                    <i class="bi bi-box-arrow-right me-1"></i> Sign Out
                </button>
            </form>
        </div>
    </nav>

    <!-- Main -->
    <div id="main-content">
        <div class="topbar">
            <div class="flex-grow-1">
                <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span style="background:#f0fdf4;color:#15803d;font-size:0.72rem;padding:0.3rem 0.7rem;border-radius:20px;font-weight:600;border:1px solid #bbf7d0;">
                    <span style="display:inline-block;width:6px;height:6px;background:#16a34a;border-radius:50%;margin-right:4px;vertical-align:middle;"></span>Online
                </span>
            </div>
        </div>

        <div class="page-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
