@extends('layouts.app')

@section('page-title', 'Carton & Dispatch')

@section('content')
<style>
    :root {
        --track-green: #15803d;
        --track-green-hover: #166534;
        --canvas-bg: #f4f6f8;
        --card-bg: #ffffff;
        --border-color: #e2e8f0;
        --text-main: #1f2937;
        --text-muted: #6b7280;
        --font-sans: 'DM Sans', sans-serif;
        --ops-mono: 'IBM Plex Mono', monospace;
    }

    body {
        background-color: var(--canvas-bg);
        font-family: var(--font-sans);
        color: var(--text-main);
    }

    .ops-mono {
        font-family: var(--ops-mono);
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .page-title h1 {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0 0 0.25rem 0;
    }

    .page-title p {
        color: var(--text-muted);
        margin: 0;
        font-size: 0.875rem;
    }

    .btn-primary {
        background-color: var(--track-green);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .btn-primary:hover {
        background-color: var(--track-green-hover);
    }

    .btn-secondary {
        background-color: white;
        color: var(--text-main);
        border: 1px solid var(--border-color);
        padding: 0.25rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }

    .btn-secondary:hover {
        background-color: #f9fafb;
    }

    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .kpi-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 1.25rem;
    }

    .kpi-label {
        color: var(--text-muted);
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }

    .kpi-value {
        font-size: 1.5rem;
        font-weight: 600;
    }

    .filters-bar {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .form-control {
        border: 1px solid var(--border-color);
        border-radius: 0.375rem;
        padding: 0.5rem;
        font-family: inherit;
        font-size: 0.875rem;
    }
    
    .search-input {
        flex-grow: 1;
    }

    .table-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .table th {
        background-color: #f8fafc;
        padding: 0.75rem 1rem;
        font-size: 0.75rem;
        text-transform: uppercase;
        color: var(--text-muted);
        border-bottom: 1px solid var(--border-color);
        font-weight: 600;
    }

    .table td {
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
        font-size: 0.875rem;
    }

    .table tbody tr:hover {
        background-color: #f8fafc;
    }

    .badge {
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .badge-warning { background: #fef08a; color: #854d0e; }
    .badge-info { background: #bae6fd; color: #075985; }
    .badge-primary { background: #bfdbfe; color: #1e40af; }
    .badge-success { background: #bbf7d0; color: #166534; }
    .badge-danger { background: #fecaca; color: #991b1b; }
    
    .actions {
        display: flex;
        gap: 0.5rem;
    }
</style>

<div class="page-header">
    <div class="page-title">
        <h1>Carton & Dispatch</h1>
        <p>Manage finished goods cartons, palletizing, export containers, and dispatch gate passes.</p>
    </div>
    <div>
        <button class="btn-primary" data-bs-toggle="modal" data-bs-target="#newShipmentModal">New Gate Pass / Shipment</button>
    </div>
</div>

<!-- New Shipment Modal -->
<div class="modal fade" id="newShipmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Create New Shipment / Gate Pass</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dispatch-ui.store') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Shipment Number</label>
                            <input type="text" class="form-control font-mono" name="shipment_number" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gate Pass No</label>
                            <input type="text" class="form-control" name="gate_pass_no">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Buyer Name</label>
                            <input type="text" class="form-control" name="buyer_name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">PO Number</label>
                            <input type="text" class="form-control font-mono" name="po_number" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Container / Vehicle No</label>
                            <input type="text" class="form-control font-mono" name="container_no">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Destination</label>
                            <input type="text" class="form-control" name="destination">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Total Cartons</label>
                            <input type="number" class="form-control" name="total_cartons" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Total Pieces</label>
                            <input type="number" class="form-control" name="total_pieces" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Dispatch Date</label>
                            <input type="date" class="form-control" name="dispatch_date">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background:var(--track-green);">Create Shipment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-label">Cartons in Warehouse</div>
        <div class="kpi-value ops-mono">850 Cartons</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Ready for Shipment</div>
        <div class="kpi-value ops-mono">620 Cartons</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Pending Gate Pass</div>
        <div class="kpi-value ops-mono">3 Shipments</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Shipped Today</div>
        <div class="kpi-value ops-mono">1,200 Cartons</div>
    </div>
</div>

<div class="filters-bar">
    <input type="text" class="form-control search-input" placeholder="Search Shipment / Gate Pass / PO / Buyer...">
    <select class="form-control">
        <option>All Statuses</option>
        <option>Pending</option>
        <option>Staged</option>
        <option>Loaded</option>
        <option>Dispatched</option>
        <option>On Hold</option>
    </select>
    <select class="form-control">
        <option>All Zones</option>
        <option>Zone A (Export)</option>
        <option>Zone B (Domestic)</option>
    </select>
    <input type="date" class="form-control" value="2026-09-30">
    <button class="btn-secondary" style="padding: 0.5rem 1rem;">Filter</button>
</div>

<div class="table-card">
    <table class="table">
        <thead>
            <tr>
                <th>Shipment / Gate Pass ID</th>
                <th>Container / Truck No</th>
                <th>PO & Buyer</th>
                <th>Total Cartons / Pieces</th>
                <th>Warehouse Zone</th>
                <th>Dispatch Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($shipments as $shipment)
            <tr>
                <td>
                    <div class="ops-mono">{{ $shipment->shipment_number }}</div>
                    <div class="ops-mono" style="color: var(--text-muted); font-size: 0.75rem;">{{ $shipment->gate_pass_no ?? '-' }}</div>
                </td>
                <td class="ops-mono">{{ $shipment->container_no ?? $shipment->vehicle_no ?? '-' }}</td>
                <td>
                    <div class="ops-mono">{{ $shipment->po_number }}</div>
                    <div>{{ $shipment->buyer_name }}</div>
                </td>
                <td>
                    <div class="ops-mono">{{ number_format($shipment->total_cartons) }} Cartons</div>
                    <div class="ops-mono" style="color: var(--text-muted); font-size: 0.75rem;">{{ number_format($shipment->total_pieces) }} Pcs</div>
                </td>
                <td>Zone A (Export)</td>
                <td><span class="badge badge-primary">{{ $shipment->status }}</span></td>
                <td class="actions">
                    <a href="{{ route('dispatch-ui.show', $shipment) }}" class="btn-secondary">View Details</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-4 text-muted">No shipments found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
