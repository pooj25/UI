@extends('layouts.app')

@section('page-title', 'Final Inspection (AQL)')

@section('content')
<style>
    :root {
        --track-tech-green: #15803d;
        --track-tech-green-hover: #166534;
        --track-tech-charcoal: #334155;
        --track-tech-canvas: #f4f6f8;
        --track-tech-border: #e2e8f0;
        --track-tech-text: #1e293b;
        --ops-mono: 'IBM Plex Mono', monospace;
        --body-font: 'DM Sans', sans-serif;
    }

    body {
        font-family: var(--body-font);
        background-color: var(--track-tech-canvas);
        color: var(--track-tech-text);
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem;
    }

    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }

    .header-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--track-tech-charcoal);
        margin: 0 0 0.5rem 0;
    }

    .header-desc {
        color: #64748b;
        margin: 0;
        font-size: 0.95rem;
    }

    .btn {
        padding: 0.5rem 1rem;
        border-radius: 4px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        border: 1px solid transparent;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary {
        background-color: var(--track-tech-green);
        color: white;
    }

    .btn-primary:hover {
        background-color: var(--track-tech-green-hover);
    }
    
    .btn-outline {
        border-color: var(--track-tech-border);
        color: var(--track-tech-charcoal);
        background-color: white;
    }

    .btn-outline:hover {
        background-color: #f8fafc;
    }

    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .kpi-card {
        background: white;
        border: 1px solid var(--track-tech-border);
        border-radius: 6px;
        padding: 1.25rem;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }

    .kpi-card.danger {
        border-left: 4px solid #ef4444;
    }

    .kpi-title {
        font-size: 0.875rem;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }

    .kpi-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--track-tech-charcoal);
        font-family: var(--ops-mono);
    }
    
    .kpi-value.danger-text {
        color: #ef4444;
    }

    .filters-section {
        background: white;
        border: 1px solid var(--track-tech-border);
        border-radius: 6px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .filter-input {
        flex: 1;
        min-width: 150px;
        padding: 0.5rem;
        border: 1px solid var(--track-tech-border);
        border-radius: 4px;
        font-family: var(--body-font);
        font-size: 0.875rem;
    }

    .data-table-container {
        background: white;
        border: 1px solid var(--track-tech-border);
        border-radius: 6px;
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
    }

    .data-table th, .data-table td {
        padding: 0.75rem 1rem;
        text-align: left;
        border-bottom: 1px solid var(--track-tech-border);
    }

    .data-table th {
        background-color: #f8fafc;
        font-weight: 600;
        color: #475569;
        white-space: nowrap;
    }

    .data-table td.mono {
        font-family: var(--ops-mono);
        color: #334155;
    }

    .badge {
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
    }

    .badge-pending { background-color: #fef3c7; color: #92400e; }
    .badge-pass { background-color: #dcfce3; color: #166534; }
    .badge-fail { background-color: #fee2e2; color: #991b1b; }
    .badge-reinspect { background-color: #e0f2fe; color: #075985; }
    .badge-hold { background-color: #f1f5f9; color: #334155; }

    .action-links {
        display: flex;
        gap: 0.5rem;
    }

    .action-link {
        color: var(--track-tech-green);
        text-decoration: none;
        font-weight: 500;
    }
    
    .action-link:hover {
        text-decoration: underline;
    }
</style>

<div class="container">
    <div class="header-section">
        <div>
            <h1 class="header-title">Final Inspection (AQL)</h1>
            <p class="header-desc">Perform AQL inspection and release approved garment lots for packing.</p>
        </div>
        <div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newInspectionModal">Create Inspection</button>
        </div>
    </div>

<!-- New Inspection Modal -->
<div class="modal fade" id="newInspectionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Create Final Inspection Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('final-qc.store') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Lot Number</label>
                            <input type="text" class="form-control font-mono" name="lot_number" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">PO Number</label>
                            <input type="text" class="form-control" name="po_number" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Buyer Name</label>
                            <input type="text" class="form-control" name="buyer_name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Style Code</label>
                            <input type="text" class="form-control" name="style_code" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Offer Qty</label>
                            <input type="number" class="form-control" name="offer_qty" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Sample Size</label>
                            <input type="number" class="form-control" name="sample_size" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Major / Minor Defects</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="major_defects" placeholder="Major" required>
                                <input type="number" class="form-control" name="minor_defects" placeholder="Minor" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Result</label>
                            <select class="form-select" name="result">
                                <option value="PASS">PASS</option>
                                <option value="FAIL">FAIL</option>
                                <option value="HOLD">HOLD</option>
                                <option value="REINSPECT">REINSPECT</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Inspector Name</label>
                            <input type="text" class="form-control" name="inspector_name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Inspection Date</label>
                            <input type="date" class="form-control" name="inspection_date">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Inspection</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-title">Lots Pending</div>
            <div class="kpi-value">12 Lots</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-title">Lots Passed</div>
            <div class="kpi-value">84 Lots</div>
        </div>
        <div class="kpi-card danger">
            <div class="kpi-title">Lots Failed</div>
            <div class="kpi-value danger-text">4 Lots</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-title">Packing Blocked</div>
            <div class="kpi-value">6 Lots</div>
        </div>
    </div>

    <div class="filters-section">
        <input type="text" class="filter-input" placeholder="Search Lot / PO / Style...">
        <select class="filter-input">
            <option value="">Buyer</option>
            <option value="nordic">Nordic Apparel</option>
        </select>
        <select class="filter-input">
            <option value="">PO</option>
        </select>
        <select class="filter-input">
            <option value="">Style</option>
        </select>
        <select class="filter-input">
            <option value="">Inspection Result</option>
            <option value="pass">Pass</option>
            <option value="fail">Fail</option>
            <option value="pending">Pending</option>
        </select>
        <select class="filter-input">
            <option value="">Inspector</option>
        </select>
        <input type="date" class="filter-input">
        <button class="btn btn-outline">Filter</button>
    </div>

    <div class="data-table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Lot ID</th>
                    <th>PO</th>
                    <th>Buyer</th>
                    <th>Style</th>
                    <th>Offer Pcs</th>
                    <th>Sample Size</th>
                    <th>Major</th>
                    <th>Minor</th>
                    <th>Result</th>
                    <th>Inspector</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inspections as $inspection)
                <tr>
                    <td class="mono">{{ $inspection->lot_number }}</td>
                    <td class="mono">{{ $inspection->po_number }}</td>
                    <td>{{ $inspection->buyer_name }}</td>
                    <td>{{ $inspection->style_code }}</td>
                    <td class="mono">{{ number_format($inspection->offer_qty) }}</td>
                    <td class="mono">{{ $inspection->sample_size }}</td>
                    <td class="mono">{{ $inspection->major_defects }}</td>
                    <td class="mono">{{ $inspection->minor_defects }}</td>
                    <td>
                        <span class="badge badge-{{ strtolower($inspection->result) }}">{{ $inspection->result }}</span>
                    </td>
                    <td>{{ $inspection->inspector_name ?? 'N/A' }}</td>
                    <td class="mono">{{ $inspection->inspection_date ? $inspection->inspection_date->format('Y-m-d') : 'N/A' }}</td>
                    <td>
                        <div class="action-links">
                            <a href="{{ route('final-qc.show', $inspection) }}" class="action-link">View Details</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="12" class="text-center py-4 text-muted">No inspections found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
