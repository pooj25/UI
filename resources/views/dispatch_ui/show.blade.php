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
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .back-link {
        color: var(--text-muted);
        text-decoration: none;
        font-size: 1rem;
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
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary:hover {
        background-color: var(--track-green-hover);
    }

    .btn-secondary {
        background-color: white;
        color: var(--text-main);
        border: 1px solid var(--border-color);
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-secondary:hover {
        background-color: #f9fafb;
    }

    .header-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .header-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
    }

    .header-item {
        margin-bottom: 1rem;
    }
    .header-item:last-child {
        margin-bottom: 0;
    }

    .header-label {
        color: var(--text-muted);
        font-size: 0.75rem;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .header-value {
        font-size: 1rem;
    }

    .badge {
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-block;
    }
    .badge-primary { background: #bfdbfe; color: #1e40af; }

    .section-title {
        font-size: 1.125rem;
        font-weight: 600;
        margin-bottom: 1rem;
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
    
    .actions-bar {
        display: flex;
        gap: 1rem;
    }
</style>

<div class="page-header">
    <div class="page-title">
        <h1>
            <a href="{{ route('dispatch-ui.index') ?? '#' }}" class="back-link">←</a>
            Shipment Details <span class="ops-mono" style="font-size: 1.25rem; color: var(--text-muted);">SHP-2026-019</span>
        </h1>
    </div>
    <div class="actions-bar">
        <button class="btn-secondary">Print Gate Pass Slip</button>
        <button class="btn-secondary">Export Packing Manifest</button>
        <button class="btn-primary">Confirm Container Seal & Dispatch</button>
    </div>
</div>

<div class="header-card">
    <div class="header-grid">
        <div>
            <div class="header-item">
                <div class="header-label">Shipment ID</div>
                <div class="header-value ops-mono">SHP-2026-019</div>
            </div>
            <div class="header-item">
                <div class="header-label">Gate Pass No</div>
                <div class="header-value ops-mono">GP-2026-904</div>
            </div>
        </div>
        <div>
            <div class="header-item">
                <div class="header-label">PO / Buyer</div>
                <div class="header-value">
                    <span class="ops-mono">PO-9912</span><br>
                    Nordic Apparel
                </div>
            </div>
            <div class="header-item">
                <div class="header-label">Destination</div>
                <div class="header-value">Hamburg Port, Germany</div>
            </div>
        </div>
        <div>
            <div class="header-item">
                <div class="header-label">Container No</div>
                <div class="header-value ops-mono">MSCU-884920-1</div>
            </div>
            <div class="header-item">
                <div class="header-label">Transport Details</div>
                <div class="header-value">
                    R. Verma<br>
                    <span class="ops-mono">MH-04-AZ-8812</span>
                </div>
            </div>
        </div>
        <div>
             <div class="header-item">
                <div class="header-label">Status</div>
                <div class="header-value"><span class="badge badge-primary">Loaded</span></div>
            </div>
        </div>
    </div>
</div>

<div class="section-title">Carton Packing List</div>

<div class="table-card">
    <table class="table">
        <thead>
            <tr>
                <th>Carton ID</th>
                <th>Pack ID</th>
                <th>Style / Colour</th>
                <th>Assortment Ratio</th>
                <th>Weights (Gross / Net)</th>
                <th>Volume (CBM)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="ops-mono">CTN-2026-042</td>
                <td class="ops-mono">PACK-2026-0104</td>
                <td>SS26-Tee / Navy Blue</td>
                <td class="ops-mono">S:1 M:2 L:2 XL:1</td>
                <td>
                    <div class="ops-mono">14.2 kg</div>
                    <div class="ops-mono" style="color: var(--text-muted); font-size: 0.75rem;">12.8 kg (Net)</div>
                </td>
                <td class="ops-mono">0.08</td>
                <td><span class="badge badge-primary">Loaded</span></td>
            </tr>
             <tr>
                <td class="ops-mono">CTN-2026-043</td>
                <td class="ops-mono">PACK-2026-0105</td>
                <td>SS26-Tee / Heather Grey</td>
                <td class="ops-mono">S:2 M:3 L:1</td>
                <td>
                    <div class="ops-mono">15.1 kg</div>
                    <div class="ops-mono" style="color: var(--text-muted); font-size: 0.75rem;">13.5 kg (Net)</div>
                </td>
                <td class="ops-mono">0.08</td>
                <td><span class="badge badge-primary">Loaded</span></td>
            </tr>
             <tr>
                <td class="ops-mono">CTN-2026-044</td>
                <td class="ops-mono">PACK-2026-0106</td>
                <td>SS26-Tee / Black</td>
                <td class="ops-mono">S:1 M:2 L:2 XL:1</td>
                <td>
                    <div class="ops-mono">14.2 kg</div>
                    <div class="ops-mono" style="color: var(--text-muted); font-size: 0.75rem;">12.8 kg (Net)</div>
                </td>
                <td class="ops-mono">0.08</td>
                <td><span class="badge badge-primary">Loaded</span></td>
            </tr>
        </tbody>
    </table>
</div>

@endsection
