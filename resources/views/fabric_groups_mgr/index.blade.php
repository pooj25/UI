@extends('layouts.app')

@section('title', 'Fabric Groups')
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
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
    }
    .page-header h1 {
        margin: 0 0 8px 0;
        font-size: 1.5rem;
        font-weight: 600;
    }
    .page-header p {
        margin: 0;
        color: #6b7280;
        font-size: 0.95rem;
    }
    .action-btn-primary {
        background-color: var(--tt-green);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 0.9rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.2s;
    }
    .action-btn-primary:hover {
        background-color: var(--tt-green-hover);
    }
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    .kpi-card {
        background: white;
        border: 1px solid var(--tt-border);
        border-radius: 8px;
        padding: 16px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .kpi-label {
        font-size: 0.85rem;
        color: #6b7280;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .kpi-val {
        font-size: 1.75rem;
        font-weight: 600;
        margin-bottom: 4px;
    }
    .kpi-sub {
        font-size: 0.8rem;
    }
    .kpi-val.green { color: var(--tt-green); }
    .kpi-val.blue { color: #2563eb; }
    .kpi-val.amber { color: #d97706; }
    .kpi-val.red { color: #dc2626; }
    .kpi-sub.green { color: #16a34a; }
    .kpi-sub.blue { color: #2563eb; }
    .kpi-sub.amber { color: #d97706; }
    .kpi-sub.red { color: #dc2626; }

    .filters-strip {
        background: white;
        border: 1px solid var(--tt-border);
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 24px;
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
        align-items: center;
    }
    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .filter-group label {
        font-size: 0.8rem;
        color: #6b7280;
        font-weight: 500;
    }
    .filter-group input, .filter-group select {
        padding: 6px 12px;
        border: 1px solid var(--tt-border);
        border-radius: 4px;
        font-size: 0.9rem;
        font-family: inherit;
        outline: none;
        min-width: 180px;
    }
    .filter-group input:focus, .filter-group select:focus {
        border-color: var(--tt-green);
    }
    .main-table-container {
        background: white;
        border: 1px solid var(--tt-border);
        border-radius: 8px;
        overflow: hidden;
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
    .group-code {
        color: var(--tt-green);
        font-weight: 600;
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
    .badge-review { background: #fef3c7; color: #92400e; }
    .badge-archived { background: #e5e7eb; color: #6b7280; }
    
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
        gap: 4px;
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
        gap: 4px;
        transition: all 0.2s;
    }
    .tbl-btn:hover {
        background: #f9fafb;
        border-color: #d1d5db;
    }
    .tbl-btn-primary {
        background: #f0fdf4;
        border: 1px solid var(--tt-green);
        color: var(--tt-green);
    }
    .tbl-btn-primary:hover {
        background: var(--tt-green);
        color: white;
    }
    .table-actions {
        display: flex;
        gap: 8px;
    }
    .pagination-footer {
        padding: 16px;
        border-top: 1px solid var(--tt-border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #6b7280;
        font-size: 0.85rem;
        background: #f9fafb;
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <div>
        <h1>Fabric Groups</h1>
        <p>Manage compatible fabrics used together for garment production and lay planning.</p>
    </div>
    <a href="#" class="action-btn-primary">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        New Group
    </a>
</div>

<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-label">Active Groups</div>
        <div class="kpi-val green font-mono">18</div>
        <div class="kpi-sub green">In use</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Total Fabrics Linked</div>
        <div class="kpi-val blue font-mono">94</div>
        <div class="kpi-sub blue">Across all groups</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Styles Using Groups</div>
        <div class="kpi-val amber font-mono">31</div>
        <div class="kpi-sub amber">Active style links</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Groups Pending Review</div>
        <div class="kpi-val red font-mono">3</div>
        <div class="kpi-sub red">Awaiting approval</div>
    </div>
</div>

<div class="filters-strip">
    <div class="filter-group">
        <label>Search</label>
        <input type="text" placeholder="Group code or name…">
    </div>
    <div class="filter-group">
        <label>Fabric</label>
        <select>
            <option>All Fabrics</option>
            <option>Cotton Jersey</option>
            <option>Rib Knit</option>
            <option>Interlock</option>
            <option>Poly Jersey</option>
        </select>
    </div>
    <div class="filter-group">
        <label>Style</label>
        <select>
            <option>All Styles</option>
            <option>V-Neck Tee</option>
            <option>Basic Polo</option>
            <option>Oversized Tee</option>
            <option>Crewneck Sweatshirt</option>
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

<div class="main-table-container">
    <table>
        <thead>
            <tr>
                <th>Group Code</th>
                <th>Group Name</th>
                <th>Member Count</th>
                <th>Widths</th>
                <th>Linked Styles</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="font-mono group-code">GRP-001</td>
                <td>Basic Knits Group</td>
                <td><span class="member-count-badge">4 members</span></td>
                <td class="font-mono">150–180 cm</td>
                <td>3 styles</td>
                <td><span class="ops-badge badge-active">Active</span></td>
                <td class="table-actions">
                    <a href="{{ route('fabric-groups-manager.show') }}" class="tbl-btn tbl-btn-primary">Open</a>
                    <button class="tbl-btn">Add Fabric</button>
                    <button class="tbl-btn">Link Style</button>
                </td>
            </tr>
            <tr>
                <td class="font-mono group-code">GRP-007</td>
                <td>H&M Jersey Collection</td>
                <td><span class="member-count-badge">6 members</span></td>
                <td class="font-mono">160–185 cm</td>
                <td>8 styles</td>
                <td><span class="ops-badge badge-active">Active</span></td>
                <td class="table-actions">
                    <a href="{{ route('fabric-groups-manager.show') }}" class="tbl-btn tbl-btn-primary">Open</a>
                    <button class="tbl-btn">Add Fabric</button>
                    <button class="tbl-btn">Link Style</button>
                </td>
            </tr>
            <tr>
                <td class="font-mono group-code">GRP-012</td>
                <td>AW26 Knit Basics</td>
                <td><span class="member-count-badge">3 members</span></td>
                <td class="font-mono">145–165 cm</td>
                <td>2 styles</td>
                <td><span class="ops-badge badge-draft">Draft</span></td>
                <td class="table-actions">
                    <a href="{{ route('fabric-groups-manager.show') }}" class="tbl-btn tbl-btn-primary">Open</a>
                    <button class="tbl-btn">Add Fabric</button>
                    <button class="tbl-btn">Link Style</button>
                </td>
            </tr>
            <tr>
                <td class="font-mono group-code">GRP-015</td>
                <td>Woven Shirting Cluster</td>
                <td><span class="member-count-badge">5 members</span></td>
                <td class="font-mono">140–155 cm</td>
                <td>5 styles</td>
                <td><span class="ops-badge badge-review">Review</span></td>
                <td class="table-actions">
                    <a href="{{ route('fabric-groups-manager.show') }}" class="tbl-btn tbl-btn-primary">Open</a>
                    <button class="tbl-btn">Add Fabric</button>
                    <button class="tbl-btn">Link Style</button>
                </td>
            </tr>
            <tr>
                <td class="font-mono group-code">GRP-018</td>
                <td>Linen & Natural Weaves</td>
                <td><span class="member-count-badge">2 members</span></td>
                <td class="font-mono">140–150 cm</td>
                <td>1 style</td>
                <td><span class="ops-badge badge-active">Active</span></td>
                <td class="table-actions">
                    <a href="{{ route('fabric-groups-manager.show') }}" class="tbl-btn tbl-btn-primary">Open</a>
                    <button class="tbl-btn">Add Fabric</button>
                    <button class="tbl-btn">Link Style</button>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="pagination-footer">
        Showing 5 of 18 groups
    </div>
</div>
@endsection
