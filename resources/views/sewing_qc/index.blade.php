@extends('layouts.app')

@section('page-title', 'Sewing / In-line QC')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">Sewing / In-line QC</h1>
            <p class="page-description">Inspect sewing quality, record defects and monitor DHU.</p>
        </div>
        <div class="header-actions">
            <!-- Replace route with actual route name if different or when implemented -->
            <a href="{{ url('sewing-qc/scan') }}" class="btn btn-primary">Scan Bundle</a>
        </div>
    </div>

    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-label">Waiting QC</div>
            <div class="kpi-value font-mono">32 Bundles</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Pass Rate</div>
            <div class="kpi-value font-mono text-success">96.8%</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">DHU %</div>
            <div class="kpi-value font-mono text-warning">2.15%</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Repair Pieces</div>
            <div class="kpi-value font-mono text-danger">14 Pcs</div>
        </div>
    </div>

    <div class="table-card">
        <div class="filters-bar">
            <input type="text" class="form-control" placeholder="Search Bundle ID / Style">
            <select class="form-control"><option value="">Sewing Line</option></select>
            <select class="form-control"><option value="">Buyer</option></select>
            <select class="form-control"><option value="">Style</option></select>
            <select class="form-control"><option value="">Operation</option></select>
            <select class="form-control"><option value="">Inspector</option></select>
            <select class="form-control"><option value="">Result</option></select>
            <input type="date" class="form-control">
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Bundle ID</th>
                        <th>Line</th>
                        <th>Style</th>
                        <th>Checked Pieces</th>
                        <th>Defects</th>
                        <th>DHU %</th>
                        <th>Result</th>
                        <th>Inspector</th>
                        <th>Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($qc_logs as $log)
                        <tr>
                            <td class="font-mono">{{ $log->bundle->bundle_number ?? 'Unknown' }}</td>
                            <td>{{ $log->line_number ?? 'Line 01' }}</td>
                            <td>{{ $log->bundle->cutOrder->style ?? 'STY-0000' }}</td>
                            <td class="font-mono">{{ $log->qty_passed + $log->qty_rejected }}</td>
                            <td class="font-mono">{{ $log->qty_rejected }}</td>
                            @php
                                $total = $log->qty_passed + $log->qty_rejected;
                                $dhu = $total > 0 ? ($log->qty_rejected / $total) * 100 : 0;
                            @endphp
                            <td class="font-mono">{{ number_format($dhu, 2) }}%</td>
                            <td>
                                @if($log->qty_rejected == 0)
                                    <span class="badge badge-success">Pass</span>
                                @elseif($log->qty_rejected > 0)
                                    <span class="badge badge-danger">Repair</span>
                                @else
                                    <span class="badge badge-warning">Pending</span>
                                @endif
                            </td>
                            <td>{{ $log->operator_name ?? 'Inspector' }}</td>
                            <td class="font-mono">{{ $log->scanned_at ? \Carbon\Carbon::parse($log->scanned_at)->format('H:i') : '-' }}</td>
                            <td>
                                <a href="{{ route('sewing-qc.show', $log) }}" class="btn btn-sm btn-outline">View Details</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4 text-muted">No Sewing QC records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-top">
            {{ $qc_logs->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<style>
    /* CSS conforming to design requirements */
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

    .font-mono {
        font-family: var(--ops-mono);
    }

    .text-success { color: var(--success); }
    .text-danger { color: var(--danger); }
    .text-warning { color: var(--warning); }
    
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

    .page-description {
        margin: 4px 0 0;
        color: #64748b;
        font-size: 0.875rem;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        padding: 8px 16px;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 6px;
        border: 1px solid transparent;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-primary {
        background-color: var(--track-green);
        color: white;
    }

    .btn-outline {
        background-color: white;
        border-color: var(--border);
        color: var(--charcoal);
    }

    .btn-sm {
        padding: 4px 8px;
        font-size: 0.75rem;
    }

    .btn-success { background-color: var(--success); color: white; }
    .btn-warning { background-color: var(--warning); color: white; }
    .btn-danger { background-color: var(--danger); color: white; }
    .btn-dark { background-color: var(--dark); color: white; }

    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }

    .kpi-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 20px;
    }

    .kpi-label {
        font-size: 0.875rem;
        color: #64748b;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .kpi-value {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--dark);
    }

    .table-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: 8px;
        overflow: hidden;
    }

    .filters-bar {
        padding: 16px;
        border-bottom: 1px solid var(--border);
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .form-control {
        padding: 8px 12px;
        border: 1px solid var(--border);
        border-radius: 6px;
        font-size: 0.875rem;
        font-family: inherit;
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

    .table th {
        background-color: #f8fafc;
        font-weight: 600;
        color: #475569;
    }

    .badge {
        padding: 4px 8px;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-success { background: #dcfce7; color: #166534; }
    .badge-danger { background: #fee2e2; color: #991b1b; }
    .badge-warning { background: #fef3c7; color: #92400e; }
    .badge-info { background: #e0f2fe; color: #075985; }

</style>
@endsection
