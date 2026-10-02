@extends('layouts.app')
@section('title', 'Buyers & Style Orders')
@section('page-title', 'Buyers & Orders')

@push('styles')
<style>
    /* ── KPI Row ─────────────────────────── */
    .kpi-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; margin-bottom: 1.5rem; }
    .kpi-card { background: #fff; border: 1px solid var(--border-color); border-radius: 8px; padding: 1.25rem; box-shadow: 0 1px 2px rgba(0,0,0,0.02); }
    .kpi-label { font-size: 0.78rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; }
    .kpi-val { font-size: 2rem; font-weight: 700; color: var(--text-main); font-family: var(--ops-mono); line-height: 1; }
    .kpi-sub { font-size: 0.75rem; font-weight: 600; margin-top: 0.4rem; }

    /* ── Action Buttons ──────────────────── */
    .action-btn-primary {
        background: var(--primary); color: #fff; padding: 0.5rem 1.25rem; border-radius: 6px;
        font-weight: 600; font-size: 0.85rem; text-decoration: none; display: inline-flex;
        align-items: center; gap: 0.5rem; border: none; cursor: pointer; transition: background 0.2s;
    }
    .action-btn-primary:hover { background: var(--primary-dark); color: #fff; }

    /* ── Filter Strip ────────────────────── */
    .filters-strip {
        display: flex; gap: 0.9rem; background: #fff; padding: 1rem;
        border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 1.5rem;
        align-items: flex-end; flex-wrap: wrap;
    }
    .filter-group { flex: 1; min-width: 140px; }
    .filter-group label { display: block; font-size: 0.7rem; font-weight: 700; color: var(--text-muted); margin-bottom: 0.3rem; text-transform: uppercase; letter-spacing: 0.05em; }
    .filter-group input, .filter-group select {
        width: 100%; border: 1px solid #cbd5e1; border-radius: 6px;
        padding: 0.45rem 0.7rem; font-size: 0.85rem; color: var(--text-main);
        background: #fff; transition: border-color 0.15s;
    }
    .filter-group input:focus, .filter-group select:focus { border-color: var(--primary); outline: none; box-shadow: 0 0 0 2px rgba(21,128,61,0.1); }

    /* ── Status Badges ───────────────────── */
    .ops-badge { padding: 0.3rem 0.6rem; border-radius: 4px; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; border: 1px solid transparent; display: inline-block; white-space: nowrap; }
    .badge-open          { background: #f0fdf4; color: #166534; border-color: #bbf7d0; }
    .badge-fabric-pending { background: #fffbeb; color: #92400e; border-color: #fde68a; }
    .badge-ready-to-cut  { background: #eff6ff; color: #1e40af; border-color: #bfdbfe; }
    .badge-in-production  { background: #faf5ff; color: #6b21a8; border-color: #e9d5ff; }
    .badge-packed        { background: #ecfdf5; color: #065f46; border-color: #6ee7b7; }
    .badge-closed        { background: #f1f5f9; color: #475569; border-color: #e2e8f0; }
    .badge-late          { background: #fef2f2; color: #991b1b; border-color: #fecaca; }

    /* ── Font Mono ───────────────────────── */
    .font-mono { font-family: var(--ops-mono); font-variant-numeric: tabular-nums; }

    /* ── Table Actions ───────────────────── */
    .tbl-btn {
        background: transparent; border: 1px solid #cbd5e1; border-radius: 4px;
        padding: 0.25rem 0.55rem; font-size: 0.72rem; font-weight: 600; color: var(--text-main);
        cursor: pointer; display: inline-flex; align-items: center; gap: 0.25rem; transition: all 0.15s; white-space: nowrap;
    }
    .tbl-btn:hover { background: #f8fafc; border-color: #94a3b8; }
    .tbl-btn-primary { color: var(--primary); border-color: rgba(21,128,61,0.35); }
    .tbl-btn-primary:hover { background: #f0fdf4; border-color: var(--primary); }

    /* ── Empty State ─────────────────────── */
    .empty-state { padding: 3rem 1rem; text-align: center; }
    .empty-state-icon { font-size: 2.5rem; color: #cbd5e1; margin-bottom: 0.75rem; }
    .empty-state p { color: var(--text-muted); font-size: 0.9rem; margin: 0 0 1rem; }

    @media (max-width: 1200px) {
        .kpi-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>
@endpush

@section('content')

{{-- ── Page Header ─────────────────────────────────────── --}}
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-0 fw-bold" style="color:var(--text-main);">Buyers & Style Orders</h4>
        <div class="text-muted mt-1" style="font-size:0.85rem;">Manage buyer POs, styles, colourways and production delivery status.</div>
    </div>
    <div class="d-flex gap-2">
        <button class="action-btn-primary" data-bs-toggle="modal" data-bs-target="#newOrderModal">
            <i class="bi bi-plus-lg"></i> New Order
        </button>
    </div>
</div>

<!-- New Order Modal -->
<div class="modal fade" id="newOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Create New Buyer Purchase Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('buyers.store') }}" method="POST" id="newOrderForm">
                @csrf
                <div class="modal-body py-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Buyer Name</label>
                            <select class="form-select" name="buyer_id" required>
                                <option value="">Select Buyer...</option>
                                @foreach($buyers as $buyer)
                                    <option value="{{ $buyer->id }}">{{ $buyer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">PO Number</label>
                            <input type="text" class="form-control font-mono" name="po_number" placeholder="PO-2026-XXXX" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Style Name</label>
                            <input type="text" class="form-control" name="style_name" placeholder="e.g. V-Neck Tee" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Style Code</label>
                            <input type="text" class="form-control" name="style_code" placeholder="e.g. ST-VNK-001" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Colour</label>
                            <input type="text" class="form-control" name="colour" placeholder="e.g. Navy Blue">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Season</label>
                            <select class="form-select" name="season">
                                <option value="SS26">SS26</option>
                                <option value="AW26">AW26</option>
                                <option value="SS25">SS25</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Order Quantity (Pcs)</label>
                            <input type="number" class="form-control font-mono" name="order_qty" placeholder="10000" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Target Delivery Date</label>
                            <input type="date" class="form-control font-mono" name="delivery_date" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background:var(--primary);border-color:var(--primary);">Create Order</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ── KPI Cards ────────────────────────────────────────── --}}
<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-label">Open Orders</div>
        <div class="kpi-val">18</div>
        <div class="kpi-sub" style="color:var(--primary);"><i class="bi bi-file-earmark-text"></i> Active purchase orders</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Pcs on Order</div>
        <div class="kpi-val">84,200</div>
        <div class="kpi-sub" style="color:#1e40af;"><i class="bi bi-stack"></i> Total garment pieces</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Fabric Not Reserved</div>
        <div class="kpi-val">6</div>
        <div class="kpi-sub" style="color:#b45309;"><i class="bi bi-exclamation-triangle"></i> Orders need fabric</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Late to Cut</div>
        <div class="kpi-val">3</div>
        <div class="kpi-sub" style="color:#b91c1c;"><i class="bi bi-alarm"></i> Past cut start date</div>
    </div>
</div>

{{-- ── Filter Bar ───────────────────────────────────────── --}}
<div class="filters-strip">
    <div class="filter-group" style="flex:2; min-width: 200px;">
        <label>Search PO / Style</label>
        <div style="position:relative;">
            <i class="bi bi-search" style="position:absolute; left:0.6rem; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:0.85rem;"></i>
            <input type="text" style="padding-left:2rem;" placeholder="PO number, style code or description…">
        </div>
    </div>
    <div class="filter-group">
        <label>Buyer</label>
        <select>
            <option>All Buyers</option>
            <option>H&M Global</option>
            <option>Marks & Spencer</option>
            <option>Zara / Inditex</option>
            <option>Next Plc</option>
            <option>Primark</option>
        </select>
    </div>
    <div class="filter-group">
        <label>Season</label>
        <select>
            <option>All Seasons</option>
            <option>SS26</option>
            <option>AW26</option>
            <option>SS25</option>
            <option>AW25</option>
        </select>
    </div>
    <div class="filter-group">
        <label>Status</label>
        <select>
            <option>All Statuses</option>
            <option>Open</option>
            <option>Fabric Pending</option>
            <option>Ready to Cut</option>
            <option>In Production</option>
            <option>Packed</option>
            <option>Closed</option>
            <option>Late</option>
        </select>
    </div>
    <div class="filter-group">
        <label>Delivery Week</label>
        <select>
            <option>All Weeks</option>
            <option>Wk 40 – 2026</option>
            <option>Wk 41 – 2026</option>
            <option>Wk 42 – 2026</option>
            <option>Wk 43 – 2026</option>
            <option>Wk 44 – 2026</option>
        </select>
    </div>
</div>

{{-- ── Orders Table ─────────────────────────────────────── --}}
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>PO Number</th>
                    <th>Buyer</th>
                    <th>Style</th>
                    <th>Colour</th>
                    <th>Season</th>
                    <th class="text-end">Order Qty</th>
                    <th>Delivery</th>
                    <th>Cut Status</th>
                    <th>Pack Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>

                @forelse($purchaseOrders as $po)
                <tr>
                    <td class="font-mono" style="color:var(--primary); font-weight:700;">{{ $po->po_number }}</td>
                    <td class="fw-bold">{{ $po->buyer ? $po->buyer->name : 'N/A' }}</td>
                    <td>
                        <div class="fw-bold" style="color:var(--text-main);">{{ $po->style_name }}</div>
                        <div class="font-mono" style="font-size:0.72rem; color:var(--text-muted);">{{ $po->style_code }}</div>
                    </td>
                    <td>
                        <span style="display:inline-flex; align-items:center; gap:0.4rem;">
                            {{ $po->colour ?? 'N/A' }}
                        </span>
                    </td>
                    <td class="font-mono text-muted">{{ $po->season }}</td>
                    <td class="font-mono text-end fw-bold">{{ number_format($po->order_qty) }}</td>
                    <td class="font-mono text-muted">{{ $po->delivery_date }}</td>
                    <td><span class="ops-badge badge-ready-to-cut">Ready to Cut</span></td>
                    <td><span class="ops-badge badge-open">{{ $po->status }}</span></td>
                    <td class="text-end">
                        <div class="d-flex gap-1 justify-content-end">
                            <button class="tbl-btn tbl-btn-primary real-action" data-bs-toggle="modal" data-bs-target="#editPOModal-{{ $po->id }}"><i class="bi bi-pencil"></i> Edit</button>
                            <form action="{{ route('buyers.destroy', $po->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this purchase order?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="tbl-btn" style="color:var(--brand-red);"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>

                <!-- Edit PO Modal -->
                <div class="modal fade" id="editPOModal-{{ $po->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header border-bottom-0 pb-0">
                                <h5 class="modal-title fw-bold">Edit Purchase Order</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('buyers.update', $po->id) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="modal-body py-3 text-start">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Buyer</label>
                                            <select class="form-select" name="buyer_id" required>
                                                @foreach($buyers as $b)
                                                    <option value="{{ $b->id }}" {{ $po->buyer_id == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">PO Number</label>
                                            <input type="text" class="form-control" name="po_number" value="{{ $po->po_number }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Style Name</label>
                                            <input type="text" class="form-control" name="style_name" value="{{ $po->style_name }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Style Code</label>
                                            <input type="text" class="form-control" name="style_code" value="{{ $po->style_code }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Season</label>
                                            <input type="text" class="form-control" name="season" value="{{ $po->season }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Order Qty</label>
                                            <input type="number" class="form-control" name="order_qty" value="{{ $po->order_qty }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Delivery Date</label>
                                            <input type="date" class="form-control" name="delivery_date" value="{{ $po->delivery_date }}" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Status</label>
                                            <select class="form-select" name="status">
                                                @foreach(['Open', 'Fabric Pending', 'Ready to Cut', 'In Production', 'Packed', 'Closed', 'Late'] as $status)
                                                    <option value="{{ $status }}" {{ $po->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-top-0 pt-0">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary" style="background:var(--brand-green);border-color:var(--brand-green);">Update Order</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-4 text-muted">No purchase orders found.</td>
                </tr>
                @endforelse

                {{-- Row 2 --}}


            </tbody>
        </table>
    </div>

    {{-- Footer / Pagination Strip --}}
    <div style="padding: 0.85rem 1.25rem; border-top: 1px solid var(--border-color); display:flex; align-items:center; justify-content:space-between; background:#fafafa; border-radius: 0 0 8px 8px;">
        <div class="font-mono text-muted" style="font-size:0.78rem;">Showing 6 of 18 orders</div>
        <div class="d-flex gap-2">
            <button class="tbl-btn" disabled>← Prev</button>
            <button class="tbl-btn tbl-btn-primary">Next →</button>
        </div>
    </div>
</div>

@endsection
