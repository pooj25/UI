<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Fabric Management') — Track Tech</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 255px;
            --primary:        #15803d; /* Track Tech Green */
            --primary-dark:   #166534;
            --primary-light:  #dcfce7;
            --sidebar-bg:     #1e2329; /* Charcoal */
            --sidebar-surface:#272d35;
            --sidebar-text:   #94a3b8;
            --sidebar-hover:  rgba(255,255,255,0.06);
            --sidebar-active: rgba(255,255,255,0.1);
            --topbar-bg:      #ffffff;
            --body-bg:        #f4f6f8; /* Light Work Canvas */
            --card-bg:        #ffffff;
            --border-color:   #e2e8f0;
            --text-main:      #1e293b;
            --text-muted:     #64748b;
            --ops-mono:       'IBM Plex Mono', monospace;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'DM Sans', sans-serif;
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
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
        }
        .sidebar-brand {
            padding: 1.35rem 1.2rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .sidebar-brand .brand-logo {
            width: 38px; height: 38px; border-radius: 8px;
            background: var(--primary);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .sidebar-brand h5 {
            color: #ffffff; font-weight: 700; font-size: 1rem; margin: 0;
        }
        .sidebar-brand small { color: #94a3b8; font-size: 0.7rem; }

        .sidebar-nav { padding: 0.6rem 0; flex: 1; }

        .nav-label {
            font-size: 0.65rem; font-weight: 700; letter-spacing: 0.1em;
            color: #64748b; padding: 0.85rem 1.2rem 0.25rem;
            text-transform: uppercase;
        }
        .nav-item-link {
            display: flex; align-items: center; gap: 0.6rem;
            padding: 0.55rem 1.2rem; color: var(--sidebar-text);
            text-decoration: none; font-size: 0.85rem; font-weight: 500;
            transition: all 0.15s ease;
            position: relative; margin: 2px 0.65rem; border-radius: 6px;
        }
        .nav-item-link:hover {
            background: var(--sidebar-hover);
            color: #f1f5f9;
        }
        .nav-item-link.active {
            background: var(--sidebar-active);
            color: #ffffff;
            font-weight: 600;
        }
        .nav-item-link.active::before {
            content: ''; position: absolute; left: -0.65rem; top: 0; bottom: 0;
            width: 4px; background: var(--primary);
            border-radius: 0 4px 4px 0;
        }
        .nav-item-link i { font-size: 1rem; width: 1.1rem; text-align: center; flex-shrink: 0; }

        .sidebar-footer {
            border-top: 1px solid rgba(255,255,255,0.06);
            padding: 0.9rem 1.2rem;
            background: var(--sidebar-surface);
        }
        .user-info { display: flex; align-items: center; gap: 0.7rem; }
        .user-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--primary);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: 0.85rem;
            flex-shrink: 0;
        }
        .user-name { color: #ffffff; font-size: 0.85rem; font-weight: 600; }
        .user-role { color: #94a3b8; font-size: 0.75rem; }

        /* ── Main content ────────────────────────── */
        #main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex; flex-direction: column;
            background: var(--body-bg);
        }

        /* ── Topbar ──────────────────────────────── */
        .topbar {
            background: var(--topbar-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 0.8rem 1.75rem;
            display: flex; align-items: center;
            position: sticky; top: 0; z-index: 100;
            min-height: 62px; gap: 0.85rem;
        }
        .topbar-title { font-size: 1.1rem; font-weight: 700; color: var(--text-main); }
        
        /* ── Page content ────────────────────────── */
        .page-content { padding: 1.6rem; flex: 1; min-width: 0; }

        /* ── Cards ───────────────────────────────── */
        .card {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: var(--card-bg);
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
            margin-bottom: 1.5rem;
        }
        .card-header {
            background: #f8fafc;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 1.25rem;
            border-radius: 8px 8px 0 0 !important;
            font-weight: 600;
        }
        .card-body { padding: 1.25rem; }

        /* ── Buttons ─────────────────────────────── */
        .btn { border-radius: 6px; font-weight: 600; font-size: 0.85rem; padding: 0.45rem 1rem; }
        .btn-primary {
            background: var(--primary); border-color: var(--primary); color: #fff;
        }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); color: #fff; }
        
        .btn-action {
            display: inline-flex; align-items: center; justify-content: center;
            width: 32px; height: 32px; border-radius: 6px; border: 1px solid var(--border-color);
            background: #fff; color: var(--text-muted);
            transition: all 0.2s; padding: 0; text-decoration: none; cursor: pointer;
        }
        .btn-action:hover { background: #f1f5f9; color: var(--text-main); border-color: #cbd5e1; }
        .btn-view:hover { background: #eff6ff; color: #3b82f6; border-color: #bfdbfe; }
        .btn-edit:hover { background: #fffbeb; color: #d97706; border-color: #fde68a; }
        .btn-delete:hover { background: #fef2f2; color: #ef4444; border-color: #fecaca; }
        form .btn-delete { margin: 0; }
        
        /* ── Tables ──────────────────────────────── */
        .table { font-size: 0.85rem; margin-bottom: 0; color: var(--text-main); }
        .table thead th {
            font-size: 0.75rem; font-weight: 600; color: #475569;
            border-bottom: 2px solid var(--border-color);
            padding: 0.75rem 1rem; background: #f8fafc;
        }
        .table tbody td { padding: 0.85rem 1rem; vertical-align: middle; border-bottom: 1px solid var(--border-color); }
        .table tbody tr:hover { background: #f8fafc; }

        /* ── Badges ──────────────────────────────── */
        .badge { font-weight: 600; font-size: 0.75rem; padding: 0.35rem 0.6rem; border-radius: 4px; }
        .badge-success { background: #dcfce7; color: #15803d; }
        .badge-warning { background: #fef3c7; color: #b45309; }
        .badge-danger  { background: #fee2e2; color: #b91c1c; }
        .badge-info    { background: #e0f2fe; color: #0369a1; }
        .badge-secondary { background: #f1f5f9; color: #475569; }

        /* ── Forms ─────────────────────────────── */
        .form-control, .form-select {
            border-radius: 6px; border: 1px solid #cbd5e1;
            font-size: 0.85rem; padding: 0.5rem 0.75rem;
            color: var(--text-main); background: #fff;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary); box-shadow: 0 0 0 3px rgba(21,128,61,0.1);
        }
        .form-label { font-weight: 600; font-size: 0.85rem; color: #334155; margin-bottom: 0.4rem; }

        /* ── Responsive ──────────────────────────── */
        .mobile-menu-toggle {
            display: none; width: 36px; height: 36px; align-items: center; justify-content: center;
            color: var(--text-main); background: #fff; border: 1px solid var(--border-color); border-radius: 6px;
        }
        .sidebar-scrim { display: none; }
        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            #main-content { margin-left: 0; }
            .mobile-menu-toggle { display: inline-flex; }
            .sidebar-scrim.show {
                display: block; position: fixed; inset: 0; z-index: 1040; width: 100%; height: 100%;
                background: rgba(0,0,0,0.5);
            }
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



            <div class="nav-label">Administration</div>
            <a href="{{ route('users.index') }}" class="nav-item-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Users & Access
            </a>
            <a href="{{ route('buyers.index') }}" class="nav-item-link {{ request()->routeIs('buyers.*') ? 'active' : '' }}">
                <i class="bi bi-bag-check"></i> Buyers & Orders
            </a>
            <a href="{{ route('bom.index') }}" class="nav-item-link {{ request()->routeIs('bom.*') ? 'active' : '' }}">
                <i class="bi bi-list-columns"></i> Bill of Materials
            </a>
            <a href="{{ route('suppliers.index') }}" class="nav-item-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                <i class="bi bi-building"></i> Suppliers & Mills
            </a>

            <div class="nav-label">Inward & Stock</div>
            <a href="{{ route('grn.index') }}" class="nav-item-link {{ request()->routeIs('grn.*') ? 'active' : '' }}">
                <i class="bi bi-box-arrow-in-down"></i> GRN / Inward
            </a>
            <a href="{{ route('roll-inventory.index') }}" class="nav-item-link {{ request()->routeIs('roll-inventory.*') ? 'active' : '' }}">
                <i class="bi bi-upc-scan"></i> Roll Inventory
            </a>
            <a href="{{ route('fabric-inspection.index') }}" class="nav-item-link {{ request()->routeIs('fabric-inspection.*') ? 'active' : '' }}">
                <i class="bi bi-clipboard2-check"></i> Fabric Inspection
            </a>

            <div class="nav-label">Cutting & Production</div>
            <a href="{{ route('fabric-reserve.index') }}" class="nav-item-link {{ request()->routeIs('fabric-reserve.*') ? 'active' : '' }}">
                <i class="bi bi-bookmark-check"></i> Fabric Reserve
            </a>
            <a href="{{ route('lay-models.index') }}" class="nav-item-link {{ request()->routeIs('lay-models.*') ? 'active' : '' }}">
                <i class="bi bi-grid-3x3"></i> Lay / Marker
            </a>
            <a href="{{ route('cutman.index') }}" class="nav-item-link {{ request()->routeIs('cutman.*') ? 'active' : '' }}">
                <i class="bi bi-scissors"></i> Cutting Orders
            </a>
            <a href="{{ route('number-bundling.index') }}" class="nav-item-link {{ request()->routeIs('number-bundling.*') ? 'active' : '' }}">
                <i class="bi bi-qr-code"></i> Number Bundling
            </a>
            <a href="{{ route('panel-inspection.index') }}" class="nav-item-link {{ request()->routeIs('panel-inspection.*') ? 'active' : '' }}">
                <i class="bi bi-shield-check"></i> Panel Inspection
            </a>
            <a href="{{ route('supermarket.index') }}" class="nav-item-link {{ request()->routeIs('supermarket.*') ? 'active' : '' }}">
                <i class="bi bi-shop-window"></i> Super Market (Cut Parts)
            </a>

            <div class="nav-label">Sewing & Finishing</div>
            <a href="{{ route('sewing.index') }}" class="nav-item-link {{ request()->routeIs('sewing.*') ? 'active' : '' }}">
                <i class="bi bi-cpu"></i> Sewing Floor
            </a>
            <a href="{{ route('sewing-qc.index') }}" class="nav-item-link {{ request()->routeIs('sewing-qc.*') ? 'active' : '' }}">
                <i class="bi bi-patch-check"></i> Sewing / In-line QC
            </a>
            <a href="{{ route('spotwash.index') }}" class="nav-item-link {{ request()->routeIs('spotwash.*') ? 'active' : '' }}">
                <i class="bi bi-droplet-half"></i> Spotwash
            </a>
            <a href="{{ route('finishing-ui.index') }}" class="nav-item-link {{ request()->routeIs('finishing-ui.*') ? 'active' : '' }}">
                <i class="bi bi-magic"></i> Finishing
            </a>

            <div class="nav-label">Quality & Dispatch</div>
            <a href="{{ route('final-qc.index') }}" class="nav-item-link {{ request()->routeIs('final-qc.*') ? 'active' : '' }}">
                <i class="bi bi-award"></i> Final Inspection (AQL)
            </a>
            <a href="{{ route('packing.index') }}" class="nav-item-link {{ request()->routeIs('packing.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i> Packing
            </a>
            <a href="{{ route('dispatch-ui.index') }}" class="nav-item-link {{ request()->routeIs('dispatch-ui.*') ? 'active' : '' }}">
                <i class="bi bi-truck"></i> Carton & Dispatch
            </a>
            <a href="{{ route('traceability.index') }}" class="nav-item-link {{ request()->routeIs('traceability.*') ? 'active' : '' }}">
                <i class="bi bi-diagram-3"></i> Traceability
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

    <button class="sidebar-scrim" type="button" aria-label="Close navigation"></button>

    <!-- Main -->
    <div id="main-content">
        <div class="topbar">
            <button class="mobile-menu-toggle" type="button" aria-label="Open navigation" aria-controls="sidebar" aria-expanded="false">
                <i class="bi bi-list" aria-hidden="true"></i>
            </button>
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

    <!-- Universal Edit Modal -->
    <div class="modal fade" id="globalEditModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold" id="globalEditModalTitle">Edit Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="globalEditForm" action="#">
                    <div class="modal-body py-3" id="globalEditModalBody">
                        <div class="mb-3">
                            <label class="form-label">Record Title / ID</label>
                            <input type="text" id="globalEditInputTitle" class="form-control" value="">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select id="globalEditInputStatus" class="form-select">
                                <option value="Active">Active</option>
                                <option value="In Progress">In Progress</option>
                                <option value="On Hold">On Hold</option>
                                <option value="Completed">Completed</option>
                                <option value="Disabled">Disabled</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Operational Notes</label>
                            <textarea id="globalEditInputNotes" class="form-control" rows="2" placeholder="Update record notes..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" style="background:var(--primary);border-color:var(--primary);">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Universal QR Code Preview Modal -->
    <div class="modal fade" id="globalQrModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow text-center p-3">
                <div class="modal-header border-0 p-0 justify-content-end">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-2">
                    <h6 class="fw-bold mb-2" id="globalQrTitle">Track Tech QR Tag</h6>
                    <div class="p-3 bg-light rounded border mb-2 d-inline-block">
                        <i class="bi bi-qr-code-scan display-1 text-dark"></i>
                    </div>
                    <div class="font-mono text-muted small" id="globalQrCode">QR-2026-TRACK-TECH</div>
                    <div class="mt-2 text-success small font-weight-bold"><i class="bi bi-check-circle-fill"></i> Ready for Scanner Scan</div>
                </div>
                <div class="modal-footer border-0 p-0 justify-content-center">
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print()"><i class="bi bi-printer me-1"></i> Print Tag</button>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal" style="background:var(--primary);border-color:var(--primary);">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.querySelector('.mobile-menu-toggle');
            const sidebarScrim = document.querySelector('.sidebar-scrim');

            function setSidebarOpen(isOpen) {
                if (sidebar) sidebar.classList.toggle('show', isOpen);
                if (sidebarScrim) sidebarScrim.classList.toggle('show', isOpen);
                document.body.classList.toggle('sidebar-open', isOpen);
                if (sidebarToggle) sidebarToggle.setAttribute('aria-expanded', String(isOpen));
            }

            if (sidebarToggle) sidebarToggle.addEventListener('click', () => setSidebarOpen(!sidebar.classList.contains('show')));
            if (sidebarScrim) sidebarScrim.addEventListener('click', () => setSidebarOpen(false));
            document.addEventListener('keydown', event => {
                if (event.key === 'Escape') setSidebarOpen(false);
            });
        })();


        // ── Global Track Tech Interactive Utilities ──────────────────────
        function showTrackTechToast(message, type = 'success') {
            const toastId = 'tt-toast-' + Date.now();
            const bgClass = type === 'success' ? '#15803d' : (type === 'danger' ? '#dc2626' : '#2563eb');
            const icon = type === 'success' ? 'check-circle-fill' : (type === 'danger' ? 'exclamation-circle-fill' : 'info-circle-fill');
            
            const toastHtml = `
                <div id="${toastId}" class="toast align-items-center text-white border-0 shadow-lg" role="alert" style="background:${bgClass};position:fixed;bottom:20px;right:20px;z-index:9999;border-radius:8px;min-width:280px;">
                    <div class="d-flex p-3">
                        <div class="toast-body d-flex align-items-center gap-2">
                            <i class="bi bi-${icon} fs-5"></i>
                            <span>${message}</span>
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', toastHtml);
            const toastEl = document.getElementById(toastId);
            const bsToast = new bootstrap.Toast(toastEl, { delay: 3500 });
            bsToast.show();
            toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
        }

        document.addEventListener('DOMContentLoaded', () => {
            let activeEditingRow = null;

            // 1. Auto Table Search Filter
            const searchInputs = document.querySelectorAll('input[placeholder*="Search"], input[placeholder*="search"]');
            searchInputs.forEach(input => {
                input.addEventListener('input', (e) => {
                    const query = e.target.value.toLowerCase().trim();
                    const table = document.querySelector('table');
                    if (!table) return;
                    const rows = table.querySelectorAll('tbody tr');
                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(query) ? '' : 'none';
                    });
                });
            });

            // 2. Auto Select Dropdown Filter
            const filterSelects = document.querySelectorAll('.filter-section select, .filter-grid select, .card select, .filters-strip select');
            filterSelects.forEach(select => {
                select.addEventListener('change', (e) => {
                    const val = e.target.value.toLowerCase().trim();
                    const table = document.querySelector('table');
                    if (!table) return;
                    const rows = table.querySelectorAll('tbody tr');
                    rows.forEach(row => {
                        if (!val || val.includes('all')) {
                            row.style.display = '';
                        } else {
                            const text = row.textContent.toLowerCase();
                            row.style.display = text.includes(val) ? '' : 'none';
                        }
                    });
                });
            });

            // 3. Auto Prototype Form Submission Interceptor
            document.querySelectorAll('form:not([action*="logout"])').forEach(form => {
                if (!form.getAttribute('action') || form.getAttribute('action') === '#' || form.getAttribute('action').includes('javascript')) {
                    form.addEventListener('submit', (e) => {
                        e.preventDefault();
                        const modal = form.closest('.modal');
                        if (modal) {
                            const bsModal = bootstrap.Modal.getInstance(modal) || new bootstrap.Modal(modal);
                            bsModal.hide();
                        }
                        if (activeEditingRow) {
                            const badge = activeEditingRow.querySelector('.badge, .ops-badge, .status-badge');
                            if (badge) {
                                const newStatus = document.getElementById('globalEditInputStatus').value;
                                badge.textContent = newStatus;
                            }
                            activeEditingRow = null;
                        }
                        showTrackTechToast('Changes saved successfully!', 'success');
                    });
                }
            });

            // 4. Universal Action Button & Link Click Delegate
            document.addEventListener('click', (e) => {
                const targetBtn = e.target.closest('button, a, .tbl-btn, .table-action-btn, .btn-action, .action-links a');
                if (!targetBtn) return;

                // Ignore sidebar links, pagination, real route URLs, and logout form
                if (targetBtn.closest('#sidebar') || targetBtn.closest('form[action*="logout"]')) return;
                const href = targetBtn.getAttribute('href');
                if (href && href !== '#' && !href.startsWith('javascript:') && !targetBtn.classList.contains('tbl-btn') && !targetBtn.classList.contains('table-action-btn')) {
                    return; // Let normal page route navigation proceed
                }

                const btnText = (targetBtn.textContent || targetBtn.getAttribute('title') || '').toLowerCase().trim();
                const row = targetBtn.closest('tr, .card');

                // A. EDIT Action
                if (btnText.includes('edit') || targetBtn.classList.contains('btn-edit') || targetBtn.querySelector('.bi-pencil')) {
                    if (targetBtn.hasAttribute('data-bs-target') || targetBtn.classList.contains('real-action')) {
                        return; // Allow real modals/links to proceed
                    }
                    e.preventDefault();
                    activeEditingRow = row;
                    const rowTitle = row ? (row.querySelector('td:nth-child(2), td:first-child')?.textContent?.trim() || 'Record') : 'Record';
                    document.getElementById('globalEditModalTitle').textContent = 'Edit ' + rowTitle;
                    document.getElementById('globalEditInputTitle').value = rowTitle;
                    const modalEl = document.getElementById('globalEditModal');
                    const bsModal = new bootstrap.Modal(modalEl);
                    bsModal.show();
                    return;
                }

                // B. DELETE / DISABLE / CANCEL Action
                if (btnText.includes('delete') || btnText.includes('disable') || btnText.includes('cancel') || targetBtn.classList.contains('btn-delete') || targetBtn.classList.contains('table-action-danger')) {
                    e.preventDefault();
                    if (confirm('Are you sure you want to perform this action?')) {
                        const badge = row ? row.querySelector('.badge, .ops-badge, .status-badge') : null;
                        if (badge && btnText.includes('disable')) {
                            badge.textContent = 'Disabled';
                            badge.className = 'badge bg-danger text-white ops-badge badge-suspended';
                            showTrackTechToast('Status updated to Disabled.', 'danger');
                        } else if (row) {
                            row.style.transition = 'all 0.3s';
                            row.style.opacity = '0';
                            setTimeout(() => row.remove(), 300);
                            showTrackTechToast('Record removed successfully.', 'danger');
                        }
                    }
                    return;
                }

                // C. FREEZE / HOLD Action
                if (btnText.includes('freeze') || btnText.includes('hold') || btnText.includes('lock')) {
                    e.preventDefault();
                    const badge = row ? row.querySelector('.badge, .ops-badge, .status-badge') : null;
                    if (badge) {
                        const isHold = badge.textContent.toLowerCase().includes('hold') || badge.textContent.toLowerCase().includes('frozen');
                        badge.textContent = isHold ? 'Active' : 'On Hold';
                        badge.className = isHold ? 'badge bg-success text-white ops-badge badge-active' : 'badge bg-warning text-dark ops-badge badge-fabric-pending';
                    }
                    showTrackTechToast(btnText.includes('freeze') ? 'Order frozen successfully.' : 'Status updated to On Hold.', 'info');
                    return;
                }

                // D. DUPLICATE / COPY Action
                if (btnText.includes('duplicate') || btnText.includes('copy')) {
                    e.preventDefault();
                    if (row && row.parentNode) {
                        const clone = row.cloneNode(true);
                        const firstTd = clone.querySelector('td');
                        if (firstTd) {
                            firstTd.textContent = firstTd.textContent + '-COPY';
                        }
                        row.parentNode.insertBefore(clone, row.nextSibling);
                        showTrackTechToast('Record duplicated successfully!', 'success');
                    }
                    return;
                }

                // E. RESET / RESTORE Action
                if (btnText.includes('reset') || btnText.includes('restore')) {
                    e.preventDefault();
                    const badge = row ? row.querySelector('.badge, .ops-badge, .status-badge') : null;
                    if (badge) {
                        badge.textContent = 'Active';
                        badge.className = 'badge bg-success text-white ops-badge badge-active';
                    }
                    showTrackTechToast('Record restored successfully.', 'success');
                    return;
                }

                // F. PASS / APPROVE / RELEASE / COMPLETE / MOVE NEXT Action
                if (btnText.includes('pass') || btnText.includes('approve') || btnText.includes('release') || btnText.includes('complete') || btnText.includes('move next') || btnText.includes('start')) {
                    e.preventDefault();
                    const badge = row ? row.querySelector('.badge, .ops-badge, .status-badge') : null;
                    if (badge) {
                        badge.textContent = btnText.includes('pass') ? 'Passed' : (btnText.includes('release') ? 'Released' : 'Completed');
                        badge.className = 'badge bg-success text-white ops-badge badge-active';
                    }
                    showTrackTechToast(`Action "${targetBtn.textContent.trim()}" completed successfully!`, 'success');
                    return;
                }

                // G. FAIL / REJECT / REPAIR Action
                if (btnText.includes('fail') || btnText.includes('reject') || btnText.includes('send repair')) {
                    e.preventDefault();
                    const badge = row ? row.querySelector('.badge, .ops-badge, .status-badge') : null;
                    if (badge) {
                        badge.textContent = btnText.includes('repair') ? 'Repair' : 'Failed';
                        badge.className = 'badge bg-danger text-white ops-badge badge-suspended';
                    }
                    showTrackTechToast(`Record marked as ${btnText.includes('repair') ? 'Repair' : 'Failed'}.`, 'danger');
                    return;
                }

                // H. PRINT QR / BARCODE / TICKET Action
                if (btnText.includes('print') || btnText.includes('qr') || btnText.includes('ticket') || btnText.includes('barcode') || btnText.includes('label')) {
                    e.preventDefault();
                    const code = row ? (row.querySelector('.font-mono, td:first-child')?.textContent?.trim() || 'QR-2026-TRACK-TECH') : 'QR-2026-TRACK-TECH';
                    document.getElementById('globalQrCode').textContent = code;
                    const modalEl = document.getElementById('globalQrModal');
                    const bsModal = new bootstrap.Modal(modalEl);
                    bsModal.show();
                    return;
                }

                // I. Generic catch-all for '#' links or unhandled buttons
                if (href === '#' || href === '' || !href) {
                    e.preventDefault();
                    showTrackTechToast(`Action "${targetBtn.textContent.trim() || 'Command'}" executed successfully!`, 'success');
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
