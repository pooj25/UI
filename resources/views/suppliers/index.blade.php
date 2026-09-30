@extends('layouts.app')

@section('title', 'Suppliers & Mills')
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

    /* Page Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    .header-content h2 {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0 0 0.25rem 0;
        color: var(--text-main);
    }
    .header-content p {
        margin: 0;
        color: var(--text-muted);
        font-size: 0.875rem;
    }

    /* Buttons */
    .action-btn-primary {
        background-color: var(--brand-green);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-weight: 500;
        font-size: 0.875rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        text-decoration: none;
        transition: background-color 0.2s;
    }
    .action-btn-primary:hover {
        background-color: var(--brand-green-hover);
        color: white;
    }

    /* KPIs */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .kpi-card {
        background-color: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 1.25rem;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .kpi-label {
        font-size: 0.875rem;
        color: var(--text-muted);
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    .kpi-val {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 0.25rem;
    }
    .kpi-val span.unit {
        font-size: 1rem;
        font-weight: 500;
        color: var(--text-muted);
        margin-left: 0.25rem;
    }
    .kpi-sub {
        font-size: 0.75rem;
    }
    .kpi-sub.green { color: #15803d; }
    .kpi-sub.blue { color: #1d4ed8; }
    .kpi-sub.amber { color: #b45309; }
    .kpi-sub.red { color: #b91c1c; }

    /* Filters */
    .filters-strip {
        background-color: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 1rem;
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        align-items: flex-end;
    }
    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.375rem;
        flex: 1;
    }
    .filter-group label {
        font-size: 0.75rem;
        font-weight: 500;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .filter-group input, .filter-group select {
        padding: 0.5rem;
        border: 1px solid var(--border-color);
        border-radius: 0.375rem;
        font-size: 0.875rem;
        outline: none;
    }
    .filter-group input:focus, .filter-group select:focus {
        border-color: var(--brand-green);
        box-shadow: 0 0 0 1px var(--brand-green);
    }

    /* Table */
    .table-container {
        background-color: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        overflow: hidden;
        margin-bottom: 1.5rem;
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
    
    .supplier-name {
        font-weight: 600;
        color: var(--text-main);
    }
    .mill-name {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 0.125rem;
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
    .badge-on-hold {
        background-color: #fef2f2;
        color: #991b1b;
        border-color: #fecaca;
    }
    .badge-review {
        background-color: #fffbeb;
        color: #b45309;
        border-color: #fde68a;
    }
    .badge-inactive {
        background-color: #f3f4f6;
        color: #374151;
        border-color: #e5e7eb;
    }

    /* Table Buttons */
    .tbl-btn {
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-main);
        padding: 0.25rem 0.625rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }
    .tbl-btn:hover {
        background-color: #f9fafb;
    }
    .tbl-btn-primary {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
    }
    .tbl-btn-primary:hover {
        background: #dcfce7;
    }

    /* Fail Rate Colors */
    .fail-rate-good { color: #166534; font-weight: 600; }
    .fail-rate-warn { color: #b45309; font-weight: 600; }
    .fail-rate-bad { color: #b91c1c; font-weight: 600; }

    /* Pagination Footer */
    .pagination-footer {
        padding: 1rem;
        background-color: #f9fafb;
        border-top: 1px solid var(--border-color);
        font-size: 0.875rem;
        color: var(--text-muted);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="header-content">
        <h2>Suppliers & Mills</h2>
        <p>Manage fabric suppliers, mills, lead times and quality performance.</p>
    </div>
    <a href="#" class="action-btn-primary" data-bs-toggle="modal" data-bs-target="#newSupplierModal">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        New Supplier
    </a>
</div>

<!-- New Supplier Modal -->
<div class="modal fade" id="newSupplierModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Create New Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('suppliers.store') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Supplier Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Supplier Code</label>
                            <input type="text" class="form-control font-mono" name="code" placeholder="SUP-XXXX" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="category">
                                <option value="Fabric Mill">Fabric Mill</option>
                                <option value="Trim Supplier">Trim Supplier</option>
                                <option value="Dyeing House">Dyeing House</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contact Person</label>
                            <input type="text" class="form-control" name="contact_person">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background:var(--brand-green);border-color:var(--brand-green);">Create Supplier</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-label">Active Suppliers</div>
        <div class="kpi-val font-mono">22</div>
        <div class="kpi-sub green">Approved vendors</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Active Mills</div>
        <div class="kpi-val font-mono">14</div>
        <div class="kpi-sub blue">Production facilities</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Average Lead Time</div>
        <div class="kpi-val font-mono">18<span class="unit">days</span></div>
        <div class="kpi-sub amber">Across all suppliers</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Suppliers on Hold</div>
        <div class="kpi-val font-mono">2</div>
        <div class="kpi-sub red">Pending resolution</div>
    </div>
</div>

<div class="filters-strip">
    <div class="filter-group" style="flex: 2;">
        <label>Search</label>
        <input type="text" placeholder="Supplier or mill name…">
    </div>
    <div class="filter-group">
        <label>Country</label>
        <select>
            <option>All Countries</option>
            <option>India</option>
            <option>Bangladesh</option>
            <option>China</option>
            <option>Sri Lanka</option>
            <option>Vietnam</option>
            <option>Turkey</option>
        </select>
    </div>
    <div class="filter-group">
        <label>Status</label>
        <select>
            <option>All</option>
            <option>Active</option>
            <option>On Hold</option>
            <option>Review</option>
            <option>Inactive</option>
        </select>
    </div>
    <div class="filter-group">
        <label>Quality Status</label>
        <select>
            <option>All</option>
            <option>Good (<5% fail)</option>
            <option>Watch (5-15%)</option>
            <option>Poor (>15%)</option>
        </select>
    </div>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Supplier / Mill</th>
                <th>Country</th>
                <th>Lead Time</th>
                <th>Last GRN</th>
                <th>Fail Rate</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suppliers as $supplier)
            <tr>
                <td>
                    <div class="supplier-name">{{ $supplier->name }}</div>
                    <div class="mill-name">{{ $supplier->code }}</div>
                </td>
                <td>{{ $supplier->city ?? 'N/A' }}</td>
                <td class="font-mono">N/A</td>
                <td class="font-mono">N/A</td>
                <td class="font-mono fail-rate-good">0.0%</td>
                <td><span class="ops-badge badge-active">{{ $supplier->status }}</span></td>
                <td>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('suppliers.show', $supplier) }}" class="tbl-btn tbl-btn-primary">Open</a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-4 text-muted">No suppliers found.</td>
            </tr>
            @endforelse

        </tbody>
    </table>
    <div class="pagination-footer">
        <div>Showing 6 of 22 suppliers</div>
        <div>
            <!-- Pagination mock -->
        </div>
    </div>
</div>
@endsection
