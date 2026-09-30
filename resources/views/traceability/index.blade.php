@extends('layouts.app')

@section('page-title', 'Stock Movement & Traceability')

@section('content')
<style>
    /* Styling configuration for Traceability */
    :root {
        --track-green: #15803d;
        --track-green-hover: #166534;
        --canvas-light: #f4f6f8;
        --border-color: #e2e8f0;
        --text-main: #1f2937;
        --text-muted: #64748b;
        --ops-mono: 'IBM Plex Mono', monospace;
    }
    
    body {
        font-family: 'DM Sans', sans-serif;
        background-color: var(--canvas-light);
        color: var(--text-main);
    }

    .ops-mono {
        font-family: var(--ops-mono);
    }

    .kpi-card {
        background-color: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 1.25rem;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }

    .kpi-title {
        font-size: 0.875rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .kpi-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-main);
    }

    .btn-primary {
        background-color: var(--track-green);
        color: #ffffff;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: background-color 0.15s ease-in-out;
    }

    .btn-primary:hover {
        background-color: var(--track-green-hover);
    }

    .btn-outline {
        background-color: transparent;
        color: var(--text-main);
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-weight: 500;
        border: 1px solid var(--border-color);
        cursor: pointer;
        transition: background-color 0.15s ease-in-out;
    }
    
    .btn-outline:hover {
        background-color: var(--canvas-light);
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        background-color: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .data-table th, .data-table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--border-color);
        text-align: left;
    }

    .data-table th {
        background-color: var(--canvas-light);
        font-weight: 600;
        color: var(--text-muted);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .badge {
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-success { background-color: #dcfce7; color: #166534; }
    .badge-info { background-color: #e0f2fe; color: #075985; }
    .badge-warning { background-color: #fef08a; color: #854d0e; }
    .badge-danger { background-color: #fee2e2; color: #991b1b; }

    .filter-panel {
        background-color: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .filter-input {
        border: 1px solid var(--border-color);
        border-radius: 0.375rem;
        padding: 0.5rem;
        font-family: inherit;
        width: 100%;
    }
</style>

<div class="container mx-auto px-4 py-6">
    <!-- Top Bar -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">Stock Movement & Traceability</h1>
            <p class="text-sm text-gray-500 mt-1">End-to-end operational traceability from raw fabric roll to finished garment carton.</p>
        </div>
        <div>
            <button class="btn-primary" data-bs-toggle="modal" data-bs-target="#newTraceModal">Manual Trace Entry</button>
        </div>
    </div>

<!-- New Trace Modal -->
<div class="modal fade" id="newTraceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Add Manual Trace Entry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('traceability.store') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Trace Code</label>
                            <input type="text" class="form-control font-mono" name="trace_code" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Master PO</label>
                            <input type="text" class="form-control font-mono" name="master_po">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fabric Roll ID</label>
                            <input type="text" class="form-control font-mono" name="fabric_roll_id">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Cut No</label>
                            <input type="text" class="form-control font-mono" name="cut_no">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Bundle ID</label>
                            <input type="text" class="form-control font-mono" name="bundle_id">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Carton ID</label>
                            <input type="text" class="form-control font-mono" name="carton_id">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Current Stage</label>
                            <input type="text" class="form-control" name="current_stage" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="ACTIVE">ACTIVE</option>
                                <option value="COMPLETED">COMPLETED</option>
                                <option value="QUARANTINED">QUARANTINED</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background:var(--track-green);">Save Trace Entry</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- KPIs -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="kpi-card">
            <div class="kpi-title">Total Tracked Lots</div>
            <div class="kpi-value">1,450 Lots</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-title">Active Roll-to-Garment Links</div>
            <div class="kpi-value">42,000 Pcs</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-title">Traceability Compliance</div>
            <div class="kpi-value text-green-700">100%</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-title">Quarantine / Trace Holds</div>
            <div class="kpi-value text-red-600">0 Holds</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-panel grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Search Identifier</label>
            <input type="text" class="filter-input" placeholder="Trace ID / PO / Roll / Carton...">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Buyer</label>
            <select class="filter-input">
                <option value="">All Buyers</option>
                <option value="nordic">Nordic Apparel</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Style</label>
            <input type="text" class="filter-input" placeholder="Style Code">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Stage</label>
            <select class="filter-input">
                <option value="">All Stages</option>
                <option value="cutting">Cutting</option>
                <option value="sewing">Sewing</option>
                <option value="packing">Packing</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Date Range</label>
            <input type="date" class="filter-input ops-mono">
        </div>
    </div>

    <!-- Main Table -->
    <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white">
        <table class="data-table w-full whitespace-nowrap">
            <thead>
                <tr>
                    <th>Trace Code</th>
                    <th>Master PO</th>
                    <th>Fabric Roll ID</th>
                    <th>Cut No</th>
                    <th>Bundle ID</th>
                    <th>Pack / Carton ID</th>
                    <th>Current Location / Stage</th>
                    <th>Compliance Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td class="font-medium ops-mono">{{ $log->trace_code }}</td>
                    <td class="ops-mono text-gray-600">{{ $log->master_po ?? 'Pending' }}</td>
                    <td class="ops-mono text-gray-600">{{ $log->fabric_roll_id ?? 'Pending' }}</td>
                    <td class="ops-mono text-gray-600">{{ $log->cut_no ?? 'Pending' }}</td>
                    <td class="ops-mono text-gray-600">{{ $log->bundle_id ?? 'Pending' }}</td>
                    <td class="ops-mono text-gray-600">{{ $log->carton_id ?? 'Pending' }}</td>
                    <td>{{ $log->current_stage }}</td>
                    <td>
                        <span class="badge {{ $log->status == 'ACTIVE' ? 'badge-info' : ($log->status == 'COMPLETED' ? 'badge-success' : 'badge-danger') }}">
                            {{ $log->status }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('traceability.show', $log) }}" class="text-green-700 hover:underline text-sm font-medium mr-3">View Audit Trail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4 text-muted">No traceability logs found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
