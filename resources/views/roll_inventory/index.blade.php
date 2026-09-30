@extends('layouts.app')
@section('title', 'Fabric Roll Inventory')
@section('page-title', 'Roll Inventory')

@push('styles')
<style>
    :root {
        --primary: #15803d;
        --ops-mono: 'IBM Plex Mono', monospace;
        --text-main: #1e2329;
    }
    .kpi-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
    .kpi-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 1.25rem; display: flex; flex-direction: column; }
    .kpi-label { font-size: 0.85rem; color: #64748b; font-weight: 600; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em; }
    .kpi-val { font-size: 1.5rem; font-weight: 700; color: var(--text-main); font-family: var(--ops-mono); }
    .kpi-sub { font-size: 0.75rem; margin-top: 0.25rem; }
    .kpi-sub.green { color: #15803d; }
    .kpi-sub.amber { color: #b45309; }
    .kpi-sub.blue { color: #0369a1; }
    .kpi-sub.red { color: #991b1b; }
    
    .action-btn-primary { background: var(--primary); color: #fff; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.88rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; border: none; cursor: pointer; }
    .action-btn-primary:hover { background: #166534; }
    
    .filters-strip { display: flex; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem; background: #fff; padding: 1rem; border-radius: 8px; border: 1px solid #e2e8f0; align-items: center; }
    .filter-group { display: flex; flex-direction: column; gap: 0.25rem; min-width: 150px; flex: 1; }
    .filter-group label { font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; }
    .filter-group input, .filter-group select { padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 0.88rem; color: var(--text-main); font-family: 'DM Sans', sans-serif; width: 100%; box-sizing: border-box; }
    
    .ops-badge { display: inline-flex; align-items: center; padding: 0.25rem 0.6rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.02em; }
    .badge-available { background: #dcfce7; color: #166534; }
    .badge-reserved { background: #fffbeb; color: #b45309; }
    .badge-hold { background: #fef2f2; color: #991b1b; }
    .badge-qc-pending { background: #e0f2fe; color: #0369a1; }
    .badge-qc-fail { background: #7f1d1d; color: #fca5a5; }
    .badge-issued { background: #f1f5f9; color: #475569; }
    
    .font-mono { font-family: var(--ops-mono); }
    
    .tbl-btn { background: #fff; border: 1px solid #cbd5e1; color: var(--text-main); padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600; text-decoration: none; display: inline-block; cursor: pointer; }
    .tbl-btn:hover { background: #f8fafc; }
    .tbl-btn-primary { background: var(--primary); color: #fff; border: 1px solid var(--primary); padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600; text-decoration: none; display: inline-block; cursor: pointer; }
    .tbl-btn-primary:hover { background: #166534; }
    
    .roll-id-chip { font-family: var(--ops-mono); font-weight: 700; color: var(--primary); font-size: 0.88rem; }
    .meter-val { font-family: var(--ops-mono); font-weight: 700; color: var(--text-main); }
    .qr-placeholder { width: 36px; height: 36px; background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 4px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.55rem; font-weight: 700; color: #94a3b8; font-family: var(--ops-mono); }
    
    .status-queue-strip { display: flex; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 1.5rem; overflow: hidden; }
    .status-queue-item { flex: 1; padding: 1rem; display: flex; align-items: center; gap: 0.75rem; border-right: 1px solid #e2e8f0; }
    .status-queue-item:last-child { border-right: none; }
    .status-queue-icon { font-size: 1.25rem; }
    .status-queue-text { font-size: 0.88rem; font-weight: 600; }
    
    .page-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem; }
    .page-title { font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0 0 0.25rem 0; }
    .page-desc { font-size: 0.88rem; color: #64748b; margin: 0; }
    
    .table-wrapper { background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; overflow-x: auto; margin-bottom: 1.5rem; }
    table { width: 100%; border-collapse: collapse; text-align: left; }
    th { background: #f8fafc; padding: 0.75rem 1rem; font-size: 0.75rem; font-weight: 600; color: #64748b; text-transform: uppercase; border-bottom: 1px solid #e2e8f0; }
    td { padding: 0.85rem 1rem; font-size: 0.88rem; color: var(--text-main); border-bottom: 1px solid #e2e8f0; vertical-align: middle; }
    tr:last-child td { border-bottom: none; }
    .text-muted { color: #64748b; }
    .text-sm { font-size: 0.75rem; }
    .text-amber { color: #b45309; }
    .text-green { color: #15803d; }
    .text-red { color: #991b1b; }
    .pagination { font-size: 0.88rem; color: #64748b; padding: 0 0.5rem; }
    .flex-col { display: flex; flex-direction: column; gap: 0.15rem; }
    .gap-2 { gap: 0.5rem; }
    .d-flex { display: flex; }
</style>
@endpush

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Fabric Roll Inventory</h1>
        <p class="page-desc">Track every fabric roll, remaining meters, location and status.</p>
    </div>
    <div>
        <a href="{{ route('roll-inventory.scan') }}" class="action-btn-primary">
            <i class="bi bi-upc-scan"></i> Scan Roll
        </a>
    </div>
</div>

<div class="kpi-grid">
    <div class="kpi-card">
        <span class="kpi-label">Available Fabric (m)</span>
        <span class="kpi-val">24,850.00</span>
        <span class="kpi-sub green">Ready to use</span>
    </div>
    <div class="kpi-card">
        <span class="kpi-label">Reserved Fabric (m)</span>
        <span class="kpi-val">8,200.50</span>
        <span class="kpi-sub amber">Active reservations</span>
    </div>
    <div class="kpi-card">
        <span class="kpi-label">Inspected OK (m)</span>
        <span class="kpi-val">18,420.00</span>
        <span class="kpi-sub blue">Passed QC</span>
    </div>
    <div class="kpi-card">
        <span class="kpi-label">Rolls on Hold</span>
        <span class="kpi-val">7</span>
        <span class="kpi-sub red">Pending action</span>
    </div>
</div>

<div class="status-queue-strip">
    <div class="status-queue-item text-green">
        <i class="bi bi-check-circle status-queue-icon"></i>
        <span class="status-queue-text">Available: 342 rolls · 24,850 m</span>
    </div>
    <div class="status-queue-item text-amber">
        <i class="bi bi-lock status-queue-icon"></i>
        <span class="status-queue-text">Reserved: 68 rolls · 8,200 m</span>
    </div>
    <div class="status-queue-item text-red">
        <i class="bi bi-exclamation-triangle status-queue-icon"></i>
        <span class="status-queue-text">On Hold / QC: 7 rolls</span>
    </div>
</div>

<div class="filters-strip">
    <div class="filter-group">
        <label>Search Roll ID / QR</label>
        <div style="position: relative;">
            <i class="bi bi-search" style="position: absolute; left: 0.5rem; top: 50%; transform: translateY(-50%); color: #64748b;"></i>
            <input type="text" placeholder="Search..." style="padding-left: 2rem;">
        </div>
    </div>
    <div class="filter-group">
        <label>Fabric</label>
        <select>
            <option>All Fabrics</option>
            <option>Cotton Jersey</option>
            <option>Oxford Shirting</option>
            <option>Rib Knit</option>
            <option>Linen Twill</option>
            <option>Heavy Fleece</option>
        </select>
    </div>
    <div class="filter-group">
        <label>Shade/Lot</label>
        <input type="text" placeholder="Shade or lot…">
    </div>
    <div class="filter-group">
        <label>Location</label>
        <select>
            <option>All Locations</option>
            <option>Warehouse A</option>
            <option>Warehouse B</option>
            <option>Cutting Floor</option>
            <option>Holding Area</option>
        </select>
    </div>
    <div class="filter-group">
        <label>Status</label>
        <select>
            <option>All</option>
            <option>Available</option>
            <option>Reserved</option>
            <option>Hold</option>
            <option>QC Pending</option>
            <option>QC Fail</option>
            <option>Issued</option>
        </select>
    </div>
</div>

<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>Roll ID</th>
                <th>QR</th>
                <th>Fabric</th>
                <th>Shade/Lot</th>
                <th>Width</th>
                <th>Recv Meters</th>
                <th>Rem Meters</th>
                <th>Location</th>
                <th>Status</th>
                <th>GRN</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($rolls as $roll)
            <tr>
                <td><span class="roll-id-chip">{{ $roll->roll_number }}</span></td>
                <td><div class="qr-placeholder">QR</div></td>
                <td>
                    <div class="flex-col">
                        <strong>{{ $roll->grn->fabric->fabric_name ?? 'Unknown' }}</strong>
                        <span class="font-mono text-muted text-sm">{{ $roll->grn->fabric->fabric_code ?? '-' }}</span>
                    </div>
                </td>
                <td>
                    <div class="flex-col">
                        <span class="font-mono">{{ $roll->shade_lot ?? 'N/A' }}</span>
                    </div>
                </td>
                <td><span class="meter-val">{{ $roll->width ?? '0' }} cm</span></td>
                <td><span class="meter-val">{{ number_format($roll->received_meters, 2) }} m</span></td>
                <td>
                    @php
                        $isLow = $roll->remaining_meters < ($roll->received_meters * 0.5);
                    @endphp
                    <span class="meter-val {{ $isLow ? 'text-amber' : '' }}">{{ number_format($roll->remaining_meters, 2) }} m</span>
                </td>
                <td>{{ $roll->location ?? 'Warehouse' }}</td>
                <td>
                    @php
                        $statusClass = [
                            'in_stock' => 'badge-available',
                            'reserved' => 'badge-reserved',
                            'issued' => 'badge-issued',
                            'pending_inspection' => 'badge-qc-pending',
                        ][$roll->status] ?? 'badge-hold';
                    @endphp
                    <span class="ops-badge {{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $roll->status)) }}</span>
                </td>
                <td><span class="font-mono text-muted text-sm">{{ $roll->grn->grn_number ?? '-' }}</span></td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="{{ route('roll-inventory.show', $roll) }}" class="tbl-btn-primary">Open</a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="11" class="text-center py-4 text-muted">No rolls found in inventory.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="pagination">
    Showing {{ $rolls->firstItem() ?? 0 }} of {{ $rolls->total() }} rolls
    <div class="mt-2">
        {{ $rolls->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
