@extends('layouts.app')

@section('title', 'Supplier Detail — Sunrise Textiles')
@section('page-title', 'Suppliers & Mills')

@push('styles')
<style>
    /* Clean Light ERP Base Typography & Variables */
    :root {
        --brand-green: #15803d;
        --brand-green-hover: #166534;
        --text-main: #1f2937;
        --text-muted: #6b7280;
        --bg-canvas: #f4f6f8;
        --bg-surface: #ffffff;
        --border-color: #e5e7eb;
    }

    body {
        font-family: 'DM Sans', sans-serif;
        background-color: var(--bg-canvas);
        color: var(--text-main);
    }
    
    .font-mono {
        font-family: 'IBM Plex Mono', monospace;
    }

    /* Page Navigation/Header */
    .back-link {
        display: inline-flex;
        align-items: center;
        color: var(--text-muted);
        text-decoration: none;
        font-size: 0.875rem;
        margin-bottom: 1rem;
        font-weight: 500;
    }
    .back-link:hover {
        color: var(--text-main);
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    .header-content h2 {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
        color: var(--text-main);
    }
    
    .header-actions {
        display: flex;
        gap: 0.75rem;
    }

    /* Badges */
    .ops-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.625rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        border: 1px solid transparent;
    }
    .badge-active {
        background-color: #f0fdf4;
        color: #166534;
        border-color: #bbf7d0;
    }
    .badge-failed {
        background-color: #fef2f2;
        color: #991b1b;
        border-color: #fecaca;
    }

    /* Table Buttons */
    .tbl-btn {
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-main);
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        background-color: var(--bg-surface);
    }
    .tbl-btn:hover {
        background-color: #f9fafb;
    }
    .tbl-btn-warning {
        background: #fffbeb;
        border: 1px solid #fde68a;
        color: #b45309;
    }
    .tbl-btn-warning:hover {
        background: #fef3c7;
    }

    /* Supplier Header Card */
    .supplier-card {
        background-color: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .card-header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .meta-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .meta-grid:last-child {
        margin-bottom: 0;
        padding-top: 1rem;
        border-top: 1px solid var(--border-color);
    }
    .meta-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    .meta-label {
        font-size: 0.75rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
    }
    .meta-value {
        font-size: 0.875rem;
        color: var(--text-main);
        font-weight: 500;
    }
    .text-green { color: #166534; }
    .text-bold { font-weight: 700; }
    
    /* Quality Summary */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .summary-box {
        background-color: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 1.25rem;
        text-align: center;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .summary-box-label {
        font-size: 0.875rem;
        color: var(--text-muted);
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    .summary-box-val {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-main);
    }

    /* Section Titles */
    .section-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 1rem;
    }

    /* Tables */
    .table-container {
        background-color: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        overflow: hidden;
        margin-bottom: 2rem;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }
    th {
        background-color: #f9fafb;
        padding: 0.75rem 1rem;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid var(--border-color);
    }
    td {
        padding: 0.875rem 1rem;
        font-size: 0.875rem;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
    }
    tr:last-child td {
        border-bottom: none;
    }
</style>
@endpush

@section('content')
<a href="{{ route('suppliers.index') }}" class="back-link">&larr; Suppliers & Mills</a>

<div class="page-header">
    <div class="header-content">
        <h2>Sunrise Textiles &mdash; Mill Detail</h2>
    </div>
    <div class="header-actions">
        <button class="tbl-btn">Edit</button>
        <button class="tbl-btn tbl-btn-warning">Put On Hold</button>
    </div>
</div>

<div class="supplier-card">
    <div class="card-header-flex">
        <span class="ops-badge badge-active">Active</span>
    </div>
    
    <div class="meta-grid">
        <div class="meta-item">
            <span class="meta-label">Supplier Code</span>
            <span class="meta-value font-mono text-green text-bold">SUP-0011</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Supplier Name</span>
            <span class="meta-value">Sunrise Textiles</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Mill Name</span>
            <span class="meta-value">Sunrise Mill 1</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Country</span>
            <span class="meta-value">India</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Lead Time</span>
            <span class="meta-value font-mono">14 days</span>
        </div>
    </div>
    
    <div class="meta-grid">
        <div class="meta-item">
            <span class="meta-label">Contact Person</span>
            <span class="meta-value">Rajesh Mehta</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Email</span>
            <span class="meta-value" style="color: #1d4ed8;">r.mehta@sunrisetextiles.com</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Phone</span>
            <span class="meta-value">+91 99887 76655</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Last GRN Date</span>
            <span class="meta-value font-mono">2026-09-28</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Fail Rate</span>
            <span class="meta-value font-mono text-green text-bold">2.1%</span>
        </div>
    </div>
</div>

<div class="summary-grid">
    <div class="summary-box">
        <div class="summary-box-label">Total GRNs</div>
        <div class="summary-box-val font-mono">142</div>
    </div>
    <div class="summary-box">
        <div class="summary-box-label">Fabric Lots Passed</div>
        <div class="summary-box-val font-mono">139</div>
    </div>
    <div class="summary-box">
        <div class="summary-box-label">Overall Fail Rate</div>
        <div class="summary-box-val font-mono text-green">2.1%</div>
    </div>
</div>

<h3 class="section-title">Recent GRNs</h3>
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>GRN No</th>
                <th>Date</th>
                <th>Fabric</th>
                <th>Rolls</th>
                <th>Total Meters</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="font-mono">GRN-2026-0881</td>
                <td class="font-mono">2026-09-28</td>
                <td class="font-mono">FAB-CTN-220</td>
                <td class="font-mono">24 rolls</td>
                <td class="font-mono">2,880 m</td>
                <td><span class="ops-badge badge-active">Passed</span></td>
            </tr>
            <tr>
                <td class="font-mono">GRN-2026-0854</td>
                <td class="font-mono">2026-09-14</td>
                <td class="font-mono">FAB-RIB-160</td>
                <td class="font-mono">18 rolls</td>
                <td class="font-mono">1,800 m</td>
                <td><span class="ops-badge badge-active">Passed</span></td>
            </tr>
            <tr>
                <td class="font-mono">GRN-2026-0832</td>
                <td class="font-mono">2026-08-30</td>
                <td class="font-mono">FAB-CTN-220</td>
                <td class="font-mono">30 rolls</td>
                <td class="font-mono">3,600 m</td>
                <td><span class="ops-badge badge-active">Passed</span></td>
            </tr>
            <tr>
                <td class="font-mono">GRN-2026-0801</td>
                <td class="font-mono">2026-08-15</td>
                <td class="font-mono">FAB-ITL-090</td>
                <td class="font-mono">12 rolls</td>
                <td class="font-mono">1,440 m</td>
                <td><span class="ops-badge badge-failed">1 Fail</span></td>
            </tr>
        </tbody>
    </table>
</div>

<h3 class="section-title">Supplied Fabrics</h3>
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Fabric Code</th>
                <th>Fabric Name</th>
                <th>Construction</th>
                <th>GSM</th>
                <th>Last Supplied</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="font-mono">FAB-CTN-220</td>
                <td>Cotton Jersey</td>
                <td>Single Jersey</td>
                <td class="font-mono">220</td>
                <td class="font-mono">2026-09-28</td>
            </tr>
            <tr>
                <td class="font-mono">FAB-RIB-160</td>
                <td>Rib Knit</td>
                <td>Rib</td>
                <td class="font-mono">160</td>
                <td class="font-mono">2026-09-14</td>
            </tr>
            <tr>
                <td class="font-mono">FAB-ITL-090</td>
                <td>Interlock</td>
                <td>Interlock</td>
                <td class="font-mono">090</td>
                <td class="font-mono">2026-08-15</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
