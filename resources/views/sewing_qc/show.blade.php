@extends('layouts.app')

@section('page-title', 'Sewing / In-line QC')

@section('content')
<div class="page-container">
    <div class="page-header">
        <h1 class="page-title">Sewing / In-line QC Details</h1>
        <a href="{{ url('sewing-qc/index') }}" class="btn btn-outline">Back to List</a>
    </div>

    <!-- Header Card -->
    <div class="card mb-4">
        <div class="card-header">
            <h3>Bundle Information</h3>
        </div>
        <div class="card-body">
            <div class="info-grid">
                <div><span class="label">Bundle ID:</span> <span class="value font-mono">BND-2026-0891</span></div>
                <div><span class="label">Style:</span> <span class="value">STY-9012</span></div>
                <div><span class="label">Colour:</span> <span class="value">Navy</span></div>
                <div><span class="label">Size:</span> <span class="value font-mono">M</span></div>
                <div><span class="label">Sewing Line:</span> <span class="value">Line 03</span></div>
                <div><span class="label">Operator:</span> <span class="value">M. Patel</span></div>
                <div><span class="label">Inspector:</span> <span class="value">A. Kumar</span></div>
                <div><span class="label">Checked Pcs:</span> <span class="value font-mono">50</span></div>
                <div><span class="label">Defect Pcs:</span> <span class="value font-mono">2</span></div>
                <div><span class="label">Total Defects:</span> <span class="value font-mono text-danger">3</span></div>
                <div><span class="label">DHU %:</span> <span class="value font-mono text-danger">6.00%</span></div>
                <div><span class="label">Result:</span> <span class="badge badge-danger">Repair</span></div>
            </div>
        </div>
    </div>

    <!-- DHU Calculation Card -->
    <div class="card mb-4 bg-light">
        <div class="card-body dhu-calc text-center">
            <strong>DHU Calculation:</strong> 
            <span class="font-mono text-muted">DHU % = Total Defects / Checked Pieces × 100</span> &rarr;
            <span class="font-mono font-bold">(3 / 50) × 100 = 6.00%</span>
        </div>
    </div>

    <!-- Defect Entry Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h3>Record Defect</h3>
        </div>
        <div class="card-body">
            <div class="defect-entry-form">
                <select class="form-control">
                    <option value="">Select Defect Type</option>
                    <option>Open Seam</option>
                    <option>Skip Stitch</option>
                    <option>Broken Stitch</option>
                    <option>Uneven Stitch</option>
                    <option>Measurement Issue</option>
                    <option>Puckering</option>
                    <option>Loose Thread</option>
                    <option>Other</option>
                </select>
                <input type="text" class="form-control" placeholder="Operation">
                <input type="text" class="form-control" placeholder="Location">
                <input type="number" class="form-control font-mono" placeholder="Quantity">
                <select class="form-control">
                    <option value="">Severity</option>
                    <option>Minor</option>
                    <option>Major</option>
                    <option>Critical</option>
                </select>
                <button class="btn btn-primary">Add Defect</button>
            </div>

            <div class="table-responsive mt-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Defect Type</th>
                            <th>Operation</th>
                            <th>Location</th>
                            <th>Qty</th>
                            <th>Severity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Open Seam</td>
                            <td>Side Seam</td>
                            <td>Left Side</td>
                            <td class="font-mono">1</td>
                            <td><span class="badge badge-warning">Major</span></td>
                            <td><button class="btn btn-sm btn-outline text-danger">Remove</button></td>
                        </tr>
                        <tr>
                            <td>Skip Stitch</td>
                            <td>Hemming</td>
                            <td>Bottom</td>
                            <td class="font-mono">2</td>
                            <td><span class="badge badge-warning">Major</span></td>
                            <td><button class="btn btn-sm btn-outline text-danger">Remove</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Summary & Actions -->
    <div class="summary-actions-grid">
        <div class="card">
            <div class="card-header">
                <h3>Summary</h3>
            </div>
            <div class="card-body">
                <div class="summary-breakdown">
                    <div class="summary-item"><span>Total Checked:</span> <span class="font-mono font-bold">50</span></div>
                    <div class="summary-item"><span>Total Defect Pcs:</span> <span class="font-mono font-bold">2</span></div>
                    <div class="summary-item"><span>Total Defects:</span> <span class="font-mono font-bold">3</span></div>
                    <div class="summary-item"><span>DHU %:</span> <span class="font-mono font-bold text-danger">6.00%</span></div>
                    <div class="summary-item summary-result">
                        <span class="badge badge-danger">Repair</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Workflow Actions</h3>
            </div>
            <div class="card-body actions-body">
                <div class="alert alert-danger mb-3">
                    <strong>Rejected/Repair Status:</strong> Bundle cannot proceed to Spotwash / Finishing.
                </div>
                <div class="workflow-buttons">
                    <button class="btn btn-success" disabled>Send to Spotwash / Finishing</button>
                    <button class="btn btn-warning w-100 mb-2">Send to Repair</button>
                    <button class="btn btn-dark w-100">Reject Bundle</button>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>QC Sign-off</h3>
            </div>
            <div class="card-body sign-off">
                <div><strong>Inspector:</strong> A. Kumar</div>
                <div><strong>Date/Time:</strong> <span class="font-mono">2026-09-30 10:45 AM</span></div>
                <div><strong>Result:</strong> <span class="badge badge-danger">Repair</span></div>
                <div class="mt-3">
                    <button class="btn btn-outline w-100">Sign-off</button>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    :root {
        --track-green: #15803d;
        --charcoal: #334155;
        --canvas: #f4f6f8;
        --border: #e2e8f0;
        --success: #16a34a;
        --danger: #dc2626;
        --warning: #f59e0b;
        --info: #0284c7;
        --dark: #0f172a;
        --ops-mono: 'IBM Plex Mono', monospace;
    }

    body {
        font-family: 'DM Sans', sans-serif;
        background-color: var(--canvas);
        color: var(--charcoal);
        margin: 0;
    }

    .font-mono { font-family: var(--ops-mono); }
    .font-bold { font-weight: 700; }
    .text-success { color: var(--success); }
    .text-danger { color: var(--danger); }
    .text-warning { color: var(--warning); }
    .text-muted { color: #94a3b8; }
    .mb-3 { margin-bottom: 12px; }
    .mb-4 { margin-bottom: 24px; }
    .mt-3 { margin-top: 12px; }
    .mt-4 { margin-top: 24px; }
    .text-center { text-align: center; }
    .w-100 { width: 100%; }

    .page-container {
        padding: 24px;
        max-width: 1400px;
        margin: 0 auto;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
        color: var(--dark);
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 16px;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 6px;
        border: 1px solid transparent;
        cursor: pointer;
        text-decoration: none;
    }

    .btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .btn-primary { background-color: var(--track-green); color: white; }
    .btn-outline { background-color: white; border-color: var(--border); color: var(--charcoal); }
    .btn-success { background-color: var(--success); color: white; }
    .btn-warning { background-color: var(--warning); color: white; }
    .btn-dark { background-color: var(--dark); color: white; }
    .btn-sm { padding: 4px 8px; font-size: 0.75rem; }

    .card {
        background: white;
        border: 1px solid var(--border);
        border-radius: 8px;
        overflow: hidden;
    }

    .card-header {
        padding: 16px 20px;
        border-bottom: 1px solid var(--border);
        background: #f8fafc;
    }

    .card-header h3 {
        margin: 0;
        font-size: 1rem;
        font-weight: 600;
        color: var(--dark);
    }

    .card-body {
        padding: 20px;
    }

    .bg-light { background-color: #f8fafc; }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .info-grid .label {
        font-size: 0.875rem;
        color: #64748b;
        display: block;
        margin-bottom: 4px;
    }

    .info-grid .value {
        font-size: 1rem;
        font-weight: 500;
        color: var(--dark);
    }

    .badge {
        padding: 4px 8px;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }

    .badge-success { background: #dcfce7; color: #166534; }
    .badge-danger { background: #fee2e2; color: #991b1b; }
    .badge-warning { background: #fef3c7; color: #92400e; }

    .dhu-calc {
        font-size: 1.125rem;
        color: var(--dark);
    }

    .defect-entry-form {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .form-control {
        padding: 8px 12px;
        border: 1px solid var(--border);
        border-radius: 6px;
        font-size: 0.875rem;
        font-family: inherit;
        flex: 1;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th, .table td {
        padding: 12px 16px;
        text-align: left;
        border-bottom: 1px solid var(--border);
        font-size: 0.875rem;
    }

    .table th { background-color: #f8fafc; font-weight: 600; color: #475569; }

    .summary-actions-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .summary-breakdown .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 0.875rem;
    }

    .summary-result {
        border-top: 1px solid var(--border);
        padding-top: 12px;
        margin-top: 12px;
    }

    .alert {
        padding: 12px;
        border-radius: 6px;
        font-size: 0.875rem;
        border: 1px solid transparent;
    }

    .alert-danger {
        background-color: #fef2f2;
        border-color: #fca5a5;
        color: #991b1b;
    }

    .workflow-buttons .btn {
        margin-bottom: 8px;
    }

    .sign-off div {
        margin-bottom: 8px;
        font-size: 0.875rem;
    }
</style>
@endsection
