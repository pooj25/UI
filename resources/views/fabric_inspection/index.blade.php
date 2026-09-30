@extends('layouts.app')
@section('title', 'Fabric Inspection')
@section('page-title', 'Fabric Inspection')

@push('styles')
<style>
    /* Track Tech Design System - Shared */
    :root {
        --primary: #15803d;
        --primary-dark: #166534;
        --sidebar: #1e2329;
        --canvas: #f4f6f8;
        --surface: #ffffff;
        --border: #e2e8f0;
        --text-main: #0f172a;
        --text-muted: #64748b;
        --ops-mono: 'IBM Plex Mono', monospace;
        --ops-sans: 'DM Sans', sans-serif;
    }

    body {
        font-family: var(--ops-sans);
        background-color: var(--canvas);
        color: var(--text-main);
    }

    .font-mono { font-family: var(--ops-mono); }
    
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2rem;
    }

    .page-title-group h2 {
        margin: 0 0 0.5rem 0;
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-main);
    }

    .page-title-group p {
        margin: 0;
        color: var(--text-muted);
    }

    .action-btn-primary {
        background-color: var(--primary);
        color: white;
        border: none;
        padding: 0.6rem 1.25rem;
        border-radius: 6px;
        font-family: var(--ops-sans);
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        transition: background-color 0.2s;
    }
    .action-btn-primary:hover { background-color: var(--primary-dark); }

    /* KPI Grid */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .kpi-card {
        background-color: var(--surface);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 1.25rem;
    }

    .kpi-label {
        font-size: 0.9rem;
        color: var(--text-muted);
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .kpi-val {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-main);
        font-family: var(--ops-mono);
        margin-bottom: 0.25rem;
    }
    
    .kpi-val .small-pts {
        font-size: 1rem;
        color: var(--text-muted);
    }

    .kpi-sub {
        font-size: 0.85rem;
        font-weight: 500;
    }
    .kpi-sub.amber { color: #d97706; }
    .kpi-sub.green { color: #15803d; }
    .kpi-sub.red { color: #b91c1c; }
    .kpi-sub.blue { color: #0284c7; }

    /* Filters */
    .filters-strip {
        display: flex;
        gap: 1rem;
        background-color: var(--surface);
        padding: 1rem;
        border: 1px solid var(--border);
        border-radius: 8px;
        margin-bottom: 1.5rem;
        align-items: flex-end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        flex: 1;
    }

    .filter-group label {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-muted);
    }

    .filter-group input,
    .filter-group select {
        padding: 0.5rem 0.75rem;
        border: 1px solid var(--border);
        border-radius: 4px;
        font-family: var(--ops-sans);
        font-size: 0.9rem;
    }
    
    .filter-group.search-group { flex: 1.5; position: relative; }
    .filter-group.search-group i {
        position: absolute;
        bottom: 0.7rem;
        left: 0.75rem;
        color: var(--text-muted);
    }
    .filter-group.search-group input { padding-left: 2.2rem; }

    /* Table */
    .table-container {
        background-color: var(--surface);
        border: 1px solid var(--border);
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    thead th {
        background-color: #f8fafc;
        padding: 1rem;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-muted);
        border-bottom: 1px solid var(--border);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    tbody td {
        padding: 1rem;
        border-bottom: 1px solid var(--border);
        font-size: 0.95rem;
        vertical-align: middle;
    }

    tbody tr:last-child td { border-bottom: none; }

    .ops-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.6rem;
        border-radius: 9999px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .badge-pending { background-color: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
    .badge-pass { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .badge-fail { background-color: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }
    .badge-hold { background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a; }

    .tbl-btn {
        background: none;
        border: 1px solid var(--border);
        padding: 0.4rem 0.75rem;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-main);
        text-decoration: none;
        display: inline-block;
        margin-right: 0.5rem;
    }
    .tbl-btn:hover { background-color: #f8fafc; }

    .tbl-btn-primary {
        background-color: #f0fdf4;
        color: var(--primary);
        border-color: #bbf7d0;
    }
    .tbl-btn-primary:hover { background-color: #dcfce7; }

    .points-val { font-family: var(--ops-mono); font-weight: 700; }
    .pass-text { color: #166534; font-weight: 700; }
    .fail-text { color: #b91c1c; font-weight: 700; }

    .roll-id-col { color: var(--primary); font-weight: 700; }
    
    .fabric-info { display: flex; flex-direction: column; }
    .fabric-info strong { color: var(--text-main); }
    .fabric-code { font-size: 0.8rem; color: var(--text-muted); margin-top: 0.2rem; }

    .pagination-bar {
        font-size: 0.9rem;
        color: var(--text-muted);
        padding: 1rem;
        border-top: 1px solid var(--border);
        background-color: #f8fafc;
    }
</style>
@endpush

<div class="page-header">
    <div class="page-title-group">
        <h2>Fabric Inspection</h2>
        <p>Inspect fabric rolls, record defects, shade status and usable meters.</p>
    </div>
    <button class="action-btn-primary">
        <i class="bi bi-play-fill"></i> Start Inspection
    </button>
</div>

<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-label">Pending Inspection</div>
        <div class="kpi-val">14</div>
        <div class="kpi-sub amber">Rolls awaiting inspection</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Passed Meters</div>
        <div class="kpi-val">18,420.00</div>
        <div class="kpi-sub green">Approved for production</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Failed Meters</div>
        <div class="kpi-val">840.50</div>
        <div class="kpi-sub red">Rejected rolls</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Avg Points / 100m</div>
        <div class="kpi-val">18.4 <span class="small-pts">pts</span></div>
        <div class="kpi-sub blue">Target: &lt;28 pts</div>
    </div>
</div>

<div class="filters-strip">
    <div class="filter-group search-group">
        <label>Search</label>
        <i class="bi bi-search"></i>
        <input type="text" placeholder="Search Roll ID...">
    </div>
    <div class="filter-group">
        <label>Fabric</label>
        <select>
            <option>All</option>
            <option>Cotton Jersey</option>
            <option>Oxford Shirting</option>
            <option>Rib Knit</option>
            <option>Linen Twill</option>
        </select>
    </div>
    <div class="filter-group">
        <label>Inspector</label>
        <select>
            <option>All Inspectors</option>
            <option>Anita Desai</option>
            <option>Priya Nair</option>
            <option>Kumar S.</option>
            <option>Ravi M.</option>
        </select>
    </div>
    <div class="filter-group">
        <label>Result</label>
        <select>
            <option>All</option>
            <option>Pass</option>
            <option>Fail</option>
            <option>Hold</option>
            <option>Pending</option>
        </select>
    </div>
    <div class="filter-group">
        <label>Date</label>
        <input type="date">
    </div>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Roll ID</th>
                <th>Fabric</th>
                <th>Shade</th>
                <th>Length (m)</th>
                <th>Inspector</th>
                <th>Result</th>
                <th>Usable Meters</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inspections as $inspection)
            <tr>
                <td class="font-mono roll-id-col">{{ $inspection->roll->roll_number ?? 'Unknown' }}</td>
                <td>
                    <div class="fabric-info">
                        <strong>{{ $inspection->roll->grn->fabric->fabric_name ?? 'Unknown' }}</strong>
                        <span class="fabric-code font-mono">{{ $inspection->roll->grn->fabric->fabric_code ?? '-' }}</span>
                    </div>
                </td>
                <td>{{ $inspection->shade_result ?? 'OK' }}</td>
                <td class="font-mono">{{ number_format($inspection->roll->received_meters ?? 0, 2) }} m</td>
                <td>{{ $inspection->inspected_by ?? 'Unknown' }}</td>
                <td>
                    @php
                        $badgeClass = [
                            'Pass' => 'badge-pass',
                            'Fail' => 'badge-fail',
                            'Conditional' => 'badge-hold'
                        ][$inspection->overall_result] ?? 'badge-pending';
                    @endphp
                    <span class="ops-badge {{ $badgeClass }}">{{ $inspection->overall_result }}</span>
                </td>
                <td class="font-mono {{ $inspection->overall_result == 'Pass' ? 'pass-text' : ($inspection->overall_result == 'Fail' ? 'fail-text' : '') }}">{{ number_format($inspection->roll->remaining_meters ?? 0, 2) }} m</td>
                <td class="font-mono">{{ $inspection->inspection_date ? \Carbon\Carbon::parse($inspection->inspection_date)->format('Y-m-d') : '-' }}</td>
                <td>
                    <a href="{{ route('fabric-inspection.show', $inspection) }}" class="tbl-btn tbl-btn-primary">Open</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center py-4 text-muted">No inspections found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination-bar">
        Showing {{ $inspections->firstItem() ?? 0 }} of {{ $inspections->total() }} inspections
        <div class="mt-2">
            {{ $inspections->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
