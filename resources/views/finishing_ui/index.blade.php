@extends('layouts.app')

@section('page-title', 'Finishing')

@section('content')
<style>
    :root {
        --track-green: #15803d;
        --canvas: #f4f6f8;
        --border-color: #e2e8f0;
        --text-main: #334155;
        --text-muted: #64748b;
        --ops-mono: 'IBM Plex Mono', monospace;
        --danger: #dc2626;
        --warning: #f59e0b;
        --success: #10b981;
        --info: #3b82f6;
        --primary: #4f46e5;
    }

    .finishing-container {
        font-family: 'DM Sans', sans-serif;
        background-color: var(--canvas);
        color: var(--text-main);
        padding: 1.5rem;
    }

    .mono {
        font-family: var(--ops-mono);
    }

    .header-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .header-bar h1 {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
    }
    
    .header-bar p {
        color: var(--text-muted);
        margin: 0.25rem 0 0 0;
        font-size: 0.875rem;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-weight: 500;
        font-size: 0.875rem;
        cursor: pointer;
        text-decoration: none;
        border: 1px solid transparent;
        transition: all 0.2s;
    }

    .btn-primary {
        background-color: var(--track-green);
        color: white;
    }

    .btn-primary:hover {
        background-color: #166534;
    }
    
    .btn-outline {
        background-color: white;
        border-color: var(--border-color);
        color: var(--text-main);
    }
    
    .btn-outline:hover {
        background-color: #f8fafc;
    }

    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .kpi-card {
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 1.25rem;
    }

    .kpi-card h3 {
        font-size: 0.875rem;
        color: var(--text-muted);
        margin: 0 0 0.5rem 0;
        font-weight: 500;
    }

    .kpi-card .value {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
    }
    
    .kpi-card.alert {
        border-color: var(--warning);
        background-color: #fef3c7;
    }
    
    .kpi-card.alert h3 {
        color: #b45309;
    }
    
    .kpi-card.alert .value {
        color: #92400e;
    }

    .filter-section {
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .filter-input {
        padding: 0.5rem;
        border: 1px solid var(--border-color);
        border-radius: 0.375rem;
        font-family: inherit;
        font-size: 0.875rem;
        min-width: 150px;
        flex: 1;
    }

    .table-container {
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    th, td {
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
        font-size: 0.875rem;
    }

    th {
        background-color: #f8fafc;
        font-weight: 600;
        color: var(--text-muted);
    }

    .badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .badge-warning { background-color: #fef3c7; color: #92400e; }
    .badge-info { background-color: #dbeafe; color: #1e40af; }
    .badge-primary { background-color: #e0e7ff; color: #3730a3; }
    .badge-success { background-color: #d1fae5; color: #065f46; }
    .badge-secondary { background-color: #f1f5f9; color: #475569; }
    .badge-danger { background-color: #fee2e2; color: #991b1b; }
    
    .actions {
        display: flex;
        gap: 0.5rem;
    }

</style>

<div class="finishing-container">
    <div class="header-bar">
        <div>
            <h1>Finishing</h1>
            <p>Track thread trimming, pressing, folding and finishing output.</p>
        </div>
        <a href="{{ route('finishing-ui.scan') ?? '#' }}" class="btn btn-primary">Scan Bundle</a>
    </div>

    <div class="kpi-grid">
        <div class="kpi-card">
            <h3>Bundles in Finishing</h3>
            <p class="value">94 Bundles</p>
        </div>
        <div class="kpi-card">
            <h3>Pieces Pressed</h3>
            <p class="value">3,100 Pcs</p>
        </div>
        <div class="kpi-card">
            <h3>Pieces Folded</h3>
            <p class="value">2,850 Pcs</p>
        </div>
        <div class="kpi-card alert">
            <h3>Waiting Final QC</h3>
            <p class="value">18 Bundles</p>
            <p style="font-size:0.75rem; color:#b45309; margin-top:0.25rem;">3 bundles waiting > 4 hours</p>
        </div>
    </div>

    <div class="filter-section">
        <input type="text" class="filter-input" placeholder="Search Bundle ID / Style">
        <select class="filter-input">
            <option value="">All Buyers</option>
            <option value="zara">Zara</option>
            <option value="h&m">H&M</option>
        </select>
        <select class="filter-input">
            <option value="">All Styles</option>
        </select>
        <select class="filter-input">
            <option value="">All Sizes</option>
        </select>
        <select class="filter-input">
            <option value="">All Operations</option>
        </select>
        <select class="filter-input">
            <option value="">All Statuses</option>
        </select>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Bundle ID</th>
                    <th>Style</th>
                    <th>Size</th>
                    <th>Pieces</th>
                    <th>Current Operation</th>
                    <th>Operator</th>
                    <th>Start Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
                @forelse($finishings as $finishing)
                <tr>
                    <td class="mono">{{ $finishing->bundle_id ?? 'Unknown' }}</td>
                    <td>{{ $finishing->style ?? '-' }}</td>
                    <td>-</td>
                    <td class="mono">-</td>
                    <td>
                        @if($finishing->qc_status != 'Pending')
                            Final QC
                        @elseif($finishing->folding_status != 'Pending')
                            Folding
                        @elseif($finishing->ironing_status != 'Pending')
                            Pressing
                        @elseif($finishing->washing_status != 'Pending')
                            Washing
                        @else
                            Thread Trim
                        @endif
                    </td>
                    <td>-</td>
                    <td class="mono">{{ $finishing->created_at ? $finishing->created_at->format('H:i A') : '-' }}</td>
                    <td>
                        @if($finishing->qc_status == 'Passed')
                            <span class="badge badge-success">QC Passed</span>
                        @else
                            <span class="badge badge-primary">In Progress</span>
                        @endif
                    </td>
                    <td class="actions">
                        <a href="{{ route('finishing-ui.show', $finishing) }}" class="btn btn-outline">View Details</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4" style="color:var(--text-muted)">No finishing records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 1rem;">
        {{ $finishings->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
