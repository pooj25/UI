@extends('layouts.app')

@section('title', 'Fabric Detail — FAB-CTN-220')
@section('page-title', 'Fabric Master')

@push('styles')
<style>
    :root {
        --primary: #15803d;
        --surface: #ffffff;
        --border: #e2e8f0;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --ops-mono: 'IBM Plex Mono', monospace;
    }
    
    .font-mono {
        font-family: var(--ops-mono);
    }

    .ops-badge {
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }
    .badge-active { background: #dcfce7; color: #166534; }
    .badge-draft { background: #f1f5f9; color: #475569; }

    .tbl-btn {
        padding: 0.375rem 0.75rem;
        border: 1px solid var(--border);
        border-radius: 0.25rem;
        background: white;
        color: var(--text-main);
        font-size: 0.875rem;
        cursor: pointer;
        text-decoration: none;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .back-link {
        color: var(--text-muted);
        text-decoration: none;
        font-size: 0.875rem;
        display: inline-block;
        margin-bottom: 0.5rem;
    }
    .back-link:hover {
        color: var(--text-main);
    }

    .page-header h1 {
        margin: 0;
        font-size: 1.5rem;
    }

    .header-actions {
        display: flex;
        gap: 0.5rem;
    }

    .bom-header-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .bom-header-card .badge-wrapper {
        margin-bottom: 1rem;
    }

    .meta-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .meta-grid:last-child {
        margin-bottom: 0;
    }

    .meta-label {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-bottom: 0.25rem;
        font-weight: 500;
    }

    .meta-val {
        font-size: 0.875rem;
        color: var(--text-main);
        font-weight: 500;
    }
    
    .meta-val.green {
        color: var(--primary);
    }

    .section-title {
        font-size: 1.125rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .table-container {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    th, td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--border);
        font-size: 0.875rem;
    }

    th {
        background: #f8fafc;
        font-weight: 600;
        color: var(--text-muted);
    }

    .code-cell {
        color: var(--primary);
        font-weight: bold;
    }
</style>
@endpush

@section('content')
<a href="{{ route('fabric-master.index') }}" class="back-link">&larr; Fabric Master</a>

<div class="page-header">
    <h1>Cotton Jersey &mdash; FAB-CTN-220</h1>
    <div class="header-actions">
        <button class="tbl-btn">Edit</button>
        <button class="tbl-btn">Open Groups</button>
        <button class="tbl-btn">Archive</button>
    </div>
</div>

<div class="bom-header-card">
    <div class="badge-wrapper">
        <span class="ops-badge badge-active">Active</span>
    </div>
    
    <div class="meta-grid">
        <div>
            <div class="meta-label">Fabric Code</div>
            <div class="meta-val font-mono green">FAB-CTN-220</div>
        </div>
        <div>
            <div class="meta-label">Fabric Name</div>
            <div class="meta-val">Cotton Jersey</div>
        </div>
        <div>
            <div class="meta-label">Construction</div>
            <div class="meta-val">Single Jersey</div>
        </div>
        <div>
            <div class="meta-label">Default Mill</div>
            <div class="meta-val">Sunrise Textiles</div>
        </div>
        <div>
            <div class="meta-label">Status</div>
            <div class="meta-val">Active</div>
        </div>
    </div>

    <div class="meta-grid">
        <div>
            <div class="meta-label">Composition</div>
            <div class="meta-val">100% Cotton</div>
        </div>
        <div>
            <div class="meta-label">Width</div>
            <div class="meta-val font-mono">180 cm</div>
        </div>
        <div>
            <div class="meta-label">GSM</div>
            <div class="meta-val font-mono">220</div>
        </div>
        <div>
            <div class="meta-label">Weight Tolerance</div>
            <div class="meta-val">&plusmn;5%</div>
        </div>
        <div>
            <div class="meta-label">Created</div>
            <div class="meta-val font-mono">2026-01-15</div>
        </div>
    </div>
</div>

<h2 class="section-title">Linked Fabric Groups</h2>
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Group Code</th>
                <th>Group Name</th>
                <th>Member Count</th>
                <th>Linked Styles</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="font-mono code-cell">GRP-001</td>
                <td>Basic Knits Group</td>
                <td>4 fabrics</td>
                <td>3 styles</td>
                <td><span class="ops-badge badge-active">Active</span></td>
            </tr>
            <tr>
                <td class="font-mono code-cell">GRP-007</td>
                <td>H&amp;M Jersey Collection</td>
                <td>6 fabrics</td>
                <td>8 styles</td>
                <td><span class="ops-badge badge-active">Active</span></td>
            </tr>
            <tr>
                <td class="font-mono code-cell">GRP-012</td>
                <td>AW26 Knit Basics</td>
                <td>3 fabrics</td>
                <td>2 styles</td>
                <td><span class="ops-badge badge-draft">Draft</span></td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
