@extends('layouts.app')

@section('title', 'Fabric Master')
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

    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .kpi-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        padding: 1.25rem;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }

    .kpi-label {
        font-size: 0.875rem;
        color: var(--text-muted);
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .kpi-val {
        font-family: var(--ops-mono);
        font-size: 1.75rem;
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 0.25rem;
    }

    .kpi-sub {
        font-size: 0.75rem;
    }
    .kpi-sub.green { color: #16a34a; }
    .kpi-sub.blue { color: #2563eb; }
    .kpi-sub.amber { color: #d97706; }
    .kpi-sub.red { color: #dc2626; }

    .action-btn-primary {
        background-color: var(--primary);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
    }
    .action-btn-primary:hover {
        background-color: #166534;
    }

    .filters-strip {
        background: var(--surface);
        padding: 1rem;
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        flex: 1;
        min-width: 150px;
    }

    .filter-group label {
        font-size: 0.75rem;
        font-weight: 500;
        color: var(--text-muted);
    }

    .filter-group input,
    .filter-group select {
        padding: 0.5rem;
        border: 1px solid var(--border);
        border-radius: 0.375rem;
        font-size: 0.875rem;
    }

    .search-input {
        position: relative;
    }
    .search-input input {
        width: 100%;
        padding-left: 2rem;
    }
    .search-input::before {
        content: "🔍";
        position: absolute;
        left: 0.5rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.875rem;
        color: var(--text-muted);
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
    .badge-review { background: #fef3c7; color: #92400e; }
    .badge-archived { background: #e2e8f0; color: #64748b; }

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

    .actions-cell {
        display: flex;
        gap: 0.5rem;
    }

    .tbl-btn {
        padding: 0.25rem 0.5rem;
        border: 1px solid var(--border);
        border-radius: 0.25rem;
        background: white;
        color: var(--text-main);
        font-size: 0.75rem;
        cursor: pointer;
        text-decoration: none;
    }

    .tbl-btn-primary {
        background: var(--primary);
        color: white;
        border: 1px solid var(--primary);
    }

    .pagination-footer {
        padding: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid var(--border);
        font-size: 0.875rem;
        color: var(--text-muted);
    }
    .pagination-btns {
        display: flex;
        gap: 0.5rem;
    }
    .pagination-btns button {
        padding: 0.25rem 0.5rem;
        border: 1px solid var(--border);
        background: white;
        border-radius: 0.25rem;
        cursor: pointer;
    }
    .pagination-btns button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }
    .page-header h1 {
        margin: 0 0 0.25rem 0;
        font-size: 1.5rem;
    }
    .page-header p {
        margin: 0;
        color: var(--text-muted);
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <div>
        <h1>Fabric Master</h1>
        <p>Manage fabric construction, composition, width, GSM and mill specifications.</p>
    </div>
    <button class="action-btn-primary">
        <span>+</span> New Fabric
    </button>
</div>

<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-label">Active Fabrics</div>
        <div class="kpi-val">89</div>
        <div class="kpi-sub green">Ready for use</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Fabric Constructions</div>
        <div class="kpi-val">7</div>
        <div class="kpi-sub blue">Unique constructions</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Default Mills</div>
        <div class="kpi-val">12</div>
        <div class="kpi-sub amber">Assigned suppliers</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Fabrics to Review</div>
        <div class="kpi-val">4</div>
        <div class="kpi-sub red">Pending approval</div>
    </div>
</div>

<div class="filters-strip">
    <div class="filter-group search-input" style="flex: 2;">
        <label>Search</label>
        <input type="text" placeholder="Fabric code or name&hellip;">
    </div>
    <div class="filter-group">
        <label>Construction</label>
        <select>
            <option>All</option>
            <option>Single Jersey</option>
            <option>Interlock</option>
            <option>Rib</option>
            <option>Fleece</option>
            <option>Woven</option>
            <option>Twill</option>
            <option>Poplin</option>
        </select>
    </div>
    <div class="filter-group">
        <label>Composition</label>
        <select>
            <option>All</option>
            <option>100% Cotton</option>
            <option>60% Cotton/40% Polyester</option>
            <option>95% Cotton/5% Elastane</option>
            <option>100% Polyester</option>
        </select>
    </div>
    <div class="filter-group">
        <label>Default Mill</label>
        <select>
            <option>All Mills</option>
            <option>Sunrise Textiles</option>
            <option>Delta Mills</option>
            <option>Apex Fabrics</option>
            <option>Polytech Mills</option>
        </select>
    </div>
    <div class="filter-group">
        <label>Status</label>
        <select>
            <option>All</option>
            <option>Active</option>
            <option>Draft</option>
            <option>Review</option>
            <option>Archived</option>
        </select>
    </div>
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
                <th>Construction</th>
                <th>Default Mill</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="font-mono code-cell">FAB-CTN-220</td>
                <td>Cotton Jersey</td>
                <td>100% Cotton</td>
                <td class="font-mono">180 cm</td>
                <td class="font-mono">220</td>
                <td>Single Jersey</td>
                <td>Sunrise Textiles</td>
                <td><span class="ops-badge badge-active">Active</span></td>
                <td class="actions-cell">
                    <a href="{{ route('fabric-master.show') }}" class="tbl-btn tbl-btn-primary">Open</a>
                    <button class="tbl-btn">Edit</button>
                    <button class="tbl-btn">Archive</button>
                </td>
            </tr>
            <tr>
                <td class="font-mono code-cell">FAB-OXF-110</td>
                <td>Oxford Shirting</td>
                <td>60/40 Cotton/Poly</td>
                <td class="font-mono">150 cm</td>
                <td class="font-mono">110</td>
                <td>Woven</td>
                <td>Delta Mills</td>
                <td><span class="ops-badge badge-active">Active</span></td>
                <td class="actions-cell">
                    <a href="{{ route('fabric-master.show') }}" class="tbl-btn tbl-btn-primary">Open</a>
                    <button class="tbl-btn">Edit</button>
                    <button class="tbl-btn">Archive</button>
                </td>
            </tr>
            <tr>
                <td class="font-mono code-cell">FAB-LIN-080</td>
                <td>Linen Twill</td>
                <td>100% Linen</td>
                <td class="font-mono">145 cm</td>
                <td class="font-mono">080</td>
                <td>Twill</td>
                <td>Apex Fabrics</td>
                <td><span class="ops-badge badge-review">Review</span></td>
                <td class="actions-cell">
                    <a href="{{ route('fabric-master.show') }}" class="tbl-btn tbl-btn-primary">Open</a>
                    <button class="tbl-btn">Edit</button>
                    <button class="tbl-btn">Archive</button>
                </td>
            </tr>
            <tr>
                <td class="font-mono code-cell">FAB-RIB-160</td>
                <td>Rib Knit</td>
                <td>95% Cotton/5% Elastane</td>
                <td class="font-mono">100 cm</td>
                <td class="font-mono">160</td>
                <td>Rib</td>
                <td>Sunrise Textiles</td>
                <td><span class="ops-badge badge-active">Active</span></td>
                <td class="actions-cell">
                    <a href="{{ route('fabric-master.show') }}" class="tbl-btn tbl-btn-primary">Open</a>
                    <button class="tbl-btn">Edit</button>
                    <button class="tbl-btn">Archive</button>
                </td>
            </tr>
            <tr>
                <td class="font-mono code-cell">FAB-FLC-340</td>
                <td>Heavy Fleece</td>
                <td>100% Polyester</td>
                <td class="font-mono">165 cm</td>
                <td class="font-mono">340</td>
                <td>Fleece</td>
                <td>Polytech Mills</td>
                <td><span class="ops-badge badge-draft">Draft</span></td>
                <td class="actions-cell">
                    <a href="{{ route('fabric-master.show') }}" class="tbl-btn tbl-btn-primary">Open</a>
                    <button class="tbl-btn">Edit</button>
                    <button class="tbl-btn">Archive</button>
                </td>
            </tr>
            <tr>
                <td class="font-mono code-cell">FAB-ITL-090</td>
                <td>Interlock</td>
                <td>100% Cotton</td>
                <td class="font-mono">170 cm</td>
                <td class="font-mono">090</td>
                <td>Interlock</td>
                <td>Delta Mills</td>
                <td><span class="ops-badge badge-archived">Archived</span></td>
                <td class="actions-cell">
                    <a href="{{ route('fabric-master.show') }}" class="tbl-btn tbl-btn-primary">Open</a>
                    <button class="tbl-btn">Edit</button>
                    <button class="tbl-btn">Archive</button>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="pagination-footer">
        <div>Showing 6 of 89 fabrics</div>
        <div class="pagination-btns">
            <button disabled>Prev</button>
            <button>Next</button>
        </div>
    </div>
</div>
@endsection
