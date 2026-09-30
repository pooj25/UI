@extends('layouts.app')

@section('title', 'Group Detail — GRP-007')
@section('page-title', 'Fabric Groups')

@push('styles')
<style>
    :root {
        --tt-green: #15803d;
        --tt-green-hover: #166534;
        --tt-canvas: #f4f6f8;
        --tt-charcoal: #1f2937;
        --tt-border: #e5e7eb;
        --font-sans: 'DM Sans', sans-serif;
        --font-mono: 'IBM Plex Mono', monospace;
    }
    body {
        background-color: var(--tt-canvas);
        font-family: var(--font-sans);
        color: var(--tt-charcoal);
    }
    .font-mono {
        font-family: var(--font-mono);
    }
    
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #6b7280;
        text-decoration: none;
        font-size: 0.9rem;
        margin-bottom: 16px;
        transition: color 0.2s;
    }
    .back-link:hover {
        color: var(--tt-charcoal);
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
    }
    .page-header h1 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
    }
    .header-actions {
        display: flex;
        gap: 12px;
    }
    
    .btn {
        background: white;
        border: 1px solid var(--tt-border);
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        color: #374151;
        transition: all 0.2s;
    }
    .btn:hover {
        background: #f9fafb;
    }
    .btn-primary {
        background: var(--tt-green);
        color: white;
        border-color: var(--tt-green);
    }
    .btn-primary:hover {
        background: var(--tt-green-hover);
        color: white;
    }

    .group-header-card {
        background: white;
        border: 1px solid var(--tt-border);
        border-radius: 8px;
        padding: 24px;
        margin-bottom: 32px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        position: relative;
    }
    .group-header-card .status-absolute {
        position: absolute;
        top: 24px;
        right: 24px;
    }
    
    .meta-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
        margin-bottom: 16px;
    }
    .meta-item label {
        display: block;
        font-size: 0.8rem;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 4px;
    }
    .meta-item .val {
        font-size: 1rem;
        font-weight: 500;
        color: var(--tt-charcoal);
    }
    .meta-item .val.group-code {
        color: var(--tt-green);
        font-weight: 600;
    }
    .group-desc {
        color: #4b5563;
        font-size: 0.95rem;
        padding-top: 16px;
        border-top: 1px solid var(--tt-border);
        margin: 0;
    }

    .ops-badge {
        padding: 4px 8px;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }
    .badge-active { background: #dcfce7; color: #166534; }
    .badge-draft { background: #f3f4f6; color: #374151; }

    .member-count-badge {
        background-color: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        margin-left: 12px;
        vertical-align: middle;
    }

    .section-header {
        margin-bottom: 16px;
        display: flex;
        align-items: center;
    }
    .section-header h2 {
        font-size: 1.25rem;
        margin: 0;
        font-weight: 600;
    }

    .table-container {
        background: white;
        border: 1px solid var(--tt-border);
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 32px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }
    th, td {
        padding: 12px 16px;
        border-bottom: 1px solid var(--tt-border);
        font-size: 0.9rem;
    }
    th {
        background: #f9fafb;
        font-weight: 600;
        color: #374151;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
    }
    tr:last-child td {
        border-bottom: none;
    }
    tr:hover {
        background-color: #f9fafb;
    }

    .tbl-btn {
        background: white;
        border: 1px solid var(--tt-border);
        color: #374151;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.8rem;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.2s;
    }
    .tbl-btn:hover {
        background: #f9fafb;
        border-color: #d1d5db;
    }
    .tbl-btn-danger {
        color: #dc2626;
        border-color: #fca5a5;
        background: #fef2f2;
    }
    .tbl-btn-danger:hover {
        background: #fee2e2;
        border-color: #f87171;
    }
</style>
@endpush

@section('content')
<a href="{{ route('fabric-groups-manager.index') }}" class="back-link">← Fabric Groups</a>

<div class="page-header">
    <h1>H&M Jersey Collection — GRP-007</h1>
    <div class="header-actions">
        <button class="btn">Add Fabric</button>
        <button class="btn">Link Style</button>
        <button class="btn">Archive</button>
    </div>
</div>

<div class="group-header-card">
    <div class="status-absolute">
        <span class="ops-badge badge-active">Active</span>
    </div>
    <div class="meta-grid">
        <div class="meta-item">
            <label>Group Code</label>
            <div class="val group-code font-mono">GRP-007</div>
        </div>
        <div class="meta-item">
            <label>Group Name</label>
            <div class="val">H&M Jersey Collection</div>
        </div>
        <div class="meta-item">
            <label>Created</label>
            <div class="val font-mono">2026-02-10</div>
        </div>
        <div class="meta-item">
            <label>Status</label>
            <div class="val"><span class="ops-badge badge-active">Active</span></div>
        </div>
    </div>
    <p class="group-desc">A collection of single jersey and interlock fabrics for H&M basic garment styles.</p>
</div>

<div class="section-header">
    <h2>Member Fabrics</h2>
    <span class="member-count-badge">6 Fabrics</span>
</div>
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Fabric Code</th>
                <th>Fabric Name</th>
                <th>Composition</th>
                <th>Width</th>
                <th>GSM</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="font-mono">FAB-CTN-220</td>
                <td>Cotton Jersey</td>
                <td>100% Cotton</td>
                <td class="font-mono">180 cm</td>
                <td class="font-mono">220</td>
                <td><span class="ops-badge badge-active">Active</span></td>
                <td><button class="tbl-btn tbl-btn-danger">Remove</button></td>
            </tr>
            <tr>
                <td class="font-mono">FAB-RIB-160</td>
                <td>Rib Knit</td>
                <td>95% Cotton/5% Elastane</td>
                <td class="font-mono">100 cm</td>
                <td class="font-mono">160</td>
                <td><span class="ops-badge badge-active">Active</span></td>
                <td><button class="tbl-btn tbl-btn-danger">Remove</button></td>
            </tr>
            <tr>
                <td class="font-mono">FAB-ITL-090</td>
                <td>Interlock</td>
                <td>100% Cotton</td>
                <td class="font-mono">170 cm</td>
                <td class="font-mono">090</td>
                <td><span class="ops-badge badge-active">Active</span></td>
                <td><button class="tbl-btn tbl-btn-danger">Remove</button></td>
            </tr>
            <tr>
                <td class="font-mono">FAB-CTN-180</td>
                <td>Light Jersey</td>
                <td>100% Cotton</td>
                <td class="font-mono">165 cm</td>
                <td class="font-mono">180</td>
                <td><span class="ops-badge badge-active">Active</span></td>
                <td><button class="tbl-btn tbl-btn-danger">Remove</button></td>
            </tr>
            <tr>
                <td class="font-mono">FAB-PES-200</td>
                <td>Poly Jersey</td>
                <td>100% Polyester</td>
                <td class="font-mono">175 cm</td>
                <td class="font-mono">200</td>
                <td><span class="ops-badge badge-draft">Draft</span></td>
                <td><button class="tbl-btn tbl-btn-danger">Remove</button></td>
            </tr>
            <tr>
                <td class="font-mono">FAB-CTN-240</td>
                <td>Heavy Jersey</td>
                <td>100% Cotton</td>
                <td class="font-mono">180 cm</td>
                <td class="font-mono">240</td>
                <td><span class="ops-badge badge-active">Active</span></td>
                <td><button class="tbl-btn tbl-btn-danger">Remove</button></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="section-header">
    <h2>Linked Styles</h2>
    <span class="member-count-badge">8 Styles</span>
</div>
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Style Code</th>
                <th>Style Name</th>
                <th>Buyer</th>
                <th>Season</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="font-mono">ST-VNK-001</td>
                <td>V-Neck Tee</td>
                <td>H&M Global</td>
                <td>SS26</td>
                <td>In Production</td>
            </tr>
            <tr>
                <td class="font-mono">ST-POL-003</td>
                <td>Basic Polo</td>
                <td>H&M Global</td>
                <td>SS26</td>
                <td>In Production</td>
            </tr>
            <tr>
                <td class="font-mono">ST-OVS-019</td>
                <td>Oversized Tee</td>
                <td>H&M Global</td>
                <td>AW26</td>
                <td>Planning</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
