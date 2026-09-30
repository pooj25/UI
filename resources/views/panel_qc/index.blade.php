@extends('layouts.app')

@section('page-title', 'Panel Inspection')

@section('content')
<style>
    :root {
        --track-green: #15803d;
        --track-green-hover: #166534;
        --track-green-light: #dcfce7;
        --track-green-text: #166534;
        --charcoal: #1f2937;
        --canvas: #f4f6f8;
        --border: #e2e8f0;
        --text-main: #334155;
        --text-muted: #64748b;
        --white: #ffffff;
        
        --success-bg: #dcfce7;
        --success-text: #166534;
        --warning-bg: #fef08a;
        --warning-text: #854d0e;
        --danger-bg: #fee2e2;
        --danger-text: #991b1b;
        --info-bg: #e0f2fe;
        --info-text: #075985;
        --primary-bg: #dbeafe;
        --primary-text: #1e40af;
        
        --ops-mono: 'IBM Plex Mono', monospace;
    }

    body {
        font-family: 'DM Sans', sans-serif;
        background-color: var(--canvas);
        color: var(--text-main);
    }

    .ops-mono {
        font-family: var(--ops-mono);
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }

    .page-title-section h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--charcoal);
        margin: 0 0 0.25rem 0;
    }

    .page-description {
        color: var(--text-muted);
        font-size: 0.875rem;
        margin: 0;
    }

    .btn-primary {
        background-color: var(--track-green);
        color: var(--white);
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-weight: 500;
        font-size: 0.875rem;
        cursor: pointer;
        transition: background-color 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary:hover {
        background-color: var(--track-green-hover);
        color: var(--white);
    }

    /* KPI Cards */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .kpi-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        padding: 1rem;
    }

    .kpi-title {
        color: var(--text-muted);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .kpi-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--charcoal);
    }

    /* Filters */
    .filter-bar {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .form-control {
        border: 1px solid var(--border);
        border-radius: 0.375rem;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        color: var(--text-main);
        background-color: var(--white);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--track-green);
        box-shadow: 0 0 0 2px var(--track-green-light);
    }

    .search-input {
        flex: 1;
        min-width: 250px;
    }

    /* Table */
    .table-container {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
    }

    .data-table th {
        background-color: #f8fafc;
        border-bottom: 1px solid var(--border);
        padding: 0.75rem 1rem;
        text-align: left;
        font-weight: 600;
        color: var(--charcoal);
        white-space: nowrap;
    }

    .data-table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--border);
        color: var(--text-main);
        vertical-align: middle;
    }

    .data-table tbody tr:hover {
        background-color: #f1f5f9;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.625rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-success { background-color: var(--success-bg); color: var(--success-text); }
    .badge-warning { background-color: var(--warning-bg); color: var(--warning-text); }
    .badge-danger { background-color: var(--danger-bg); color: var(--danger-text); }
    .badge-info { background-color: var(--info-bg); color: var(--info-text); }
    .badge-primary { background-color: var(--primary-bg); color: var(--primary-text); }

    .action-group {
        display: flex;
        gap: 0.5rem;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        border-radius: 0.25rem;
        border: 1px solid var(--border);
        background: var(--white);
        color: var(--text-main);
        cursor: pointer;
        text-decoration: none;
    }

    .btn-sm:hover {
        background: #f1f5f9;
    }

    .btn-icon {
        padding: 0.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        border: 1px solid transparent;
        border-radius: 0.25rem;
        background: transparent;
        cursor: pointer;
    }

    .btn-icon:hover {
        background: #f1f5f9;
        color: var(--charcoal);
        border-color: var(--border);
    }
</style>

<div class="page-header">
    <div class="page-title-section">
        <h1>Panel Inspection</h1>
        <p class="page-description">Inspect cut fabric panels for defects, shading, and dimensional accuracy prior to supermarket / sewing.</p>
    </div>
    <a href="#" class="btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        New Panel Audit
    </a>
</div>

<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-title">Audited Panels Today</div>
        <div class="kpi-value ops-mono">3,400 Pcs</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-title">Defect Rate</div>
        <div class="kpi-value ops-mono">1.42%</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-title">Pending Recuts</div>
        <div class="kpi-value ops-mono">18 Pcs</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-title">Pass Rate</div>
        <div class="kpi-value ops-mono">98.58%</div>
    </div>
</div>

<div class="filter-bar">
    <input type="text" class="form-control search-input" placeholder="Search Audit ID / Bundle ID / Style...">
    
    <select class="form-control">
        <option value="">Inspector</option>
        <option value="1">R. Sharma</option>
        <option value="2">M. Patel</option>
        <option value="3">A. Gupta</option>
    </select>

    <select class="form-control">
        <option value="">Defect Type</option>
        <option value="shading">Shading</option>
        <option value="miscut">Mis-cut</option>
        <option value="oil">Oil Spot</option>
        <option value="hole">Hole/Tear</option>
    </select>

    <select class="form-control">
        <option value="">Status</option>
        <option value="passed">Passed</option>
        <option value="minor">Minor Defect</option>
        <option value="major">Major Defect</option>
        <option value="recut">Recut Requested</option>
    </select>
</div>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>Audit ID</th>
                <th>Cut No / Bundle ID</th>
                <th>Style & Buyer</th>
                <th>Panel Component</th>
                <th>Inspected</th>
                <th>Defect</th>
                <th>Defect Type</th>
                <th>Inspector</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="ops-mono">AUD-2026-0104</td>
                <td>
                    <div class="ops-mono">CUT-2026-042</div>
                    <div class="ops-mono" style="font-size: 0.75rem; color: var(--text-muted);">BND-2026-0891</div>
                </td>
                <td>
                    <div>ST-092-AW</div>
                    <div style="font-size: 0.75rem; color: var(--text-muted);">H&M</div>
                </td>
                <td>All Components</td>
                <td class="ops-mono">100</td>
                <td class="ops-mono">0</td>
                <td>-</td>
                <td>R. Sharma</td>
                <td><span class="badge badge-success">Passed</span></td>
                <td>
                    <div class="action-group">
                        <a href="{{ route('panel-qc.show', 'AUD-2026-0104') }}" class="btn-sm">View Details</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="ops-mono">AUD-2026-0105</td>
                <td>
                    <div class="ops-mono">CUT-2026-042</div>
                    <div class="ops-mono" style="font-size: 0.75rem; color: var(--text-muted);">BND-2026-0892</div>
                </td>
                <td>
                    <div>ST-092-AW</div>
                    <div style="font-size: 0.75rem; color: var(--text-muted);">H&M</div>
                </td>
                <td>Front Body</td>
                <td class="ops-mono">100</td>
                <td class="ops-mono">2</td>
                <td>Oil Spot</td>
                <td>M. Patel</td>
                <td><span class="badge badge-warning">Minor Defect</span></td>
                <td>
                    <div class="action-group">
                        <a href="{{ route('panel-qc.show', 'AUD-2026-0105') }}" class="btn-sm">View Details</a>
                        <button class="btn-icon" title="Pass Ticket"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--track-green)"><path d="M22 11.08V12a10 10 2-2-0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg></button>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="ops-mono">AUD-2026-0106</td>
                <td>
                    <div class="ops-mono">CUT-2026-043</div>
                    <div class="ops-mono" style="font-size: 0.75rem; color: var(--text-muted);">BND-2026-0901</div>
                </td>
                <td>
                    <div>ST-104-SS</div>
                    <div style="font-size: 0.75rem; color: var(--text-muted);">ZARA</div>
                </td>
                <td>Left Sleeve</td>
                <td class="ops-mono">80</td>
                <td class="ops-mono">5</td>
                <td>Mis-cut</td>
                <td>A. Gupta</td>
                <td><span class="badge badge-danger">Major Defect</span></td>
                <td>
                    <div class="action-group">
                        <a href="{{ route('panel-qc.show', 'AUD-2026-0106') }}" class="btn-sm">View Details</a>
                        <button class="btn-icon" title="Recut Request"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--warning-text)"><polyline points="1 4 1 10 7 10"></polyline><polyline points="23 20 23 14 17 14"></polyline><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path></svg></button>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="ops-mono">AUD-2026-0107</td>
                <td>
                    <div class="ops-mono">CUT-2026-043</div>
                    <div class="ops-mono" style="font-size: 0.75rem; color: var(--text-muted);">BND-2026-0905</div>
                </td>
                <td>
                    <div>ST-104-SS</div>
                    <div style="font-size: 0.75rem; color: var(--text-muted);">ZARA</div>
                </td>
                <td>Back Body</td>
                <td class="ops-mono">80</td>
                <td class="ops-mono">0</td>
                <td>-</td>
                <td>R. Sharma</td>
                <td><span class="badge badge-primary">Re-inspected</span></td>
                <td>
                    <div class="action-group">
                        <a href="{{ route('panel-qc.show', 'AUD-2026-0107') }}" class="btn-sm">View Details</a>
                    </div>
                </td>
            </tr>
             <tr>
                <td class="ops-mono">AUD-2026-0108</td>
                <td>
                    <div class="ops-mono">CUT-2026-044</div>
                    <div class="ops-mono" style="font-size: 0.75rem; color: var(--text-muted);">BND-2026-0910</div>
                </td>
                <td>
                    <div>ST-105-SS</div>
                    <div style="font-size: 0.75rem; color: var(--text-muted);">UNIQLO</div>
                </td>
                <td>Rib Collar</td>
                <td class="ops-mono">120</td>
                <td class="ops-mono">12</td>
                <td>Shading</td>
                <td>M. Patel</td>
                <td><span class="badge badge-info">Recut Requested</span></td>
                <td>
                    <div class="action-group">
                        <a href="{{ route('panel-qc.show', 'AUD-2026-0108') }}" class="btn-sm">View Details</a>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
