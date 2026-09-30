@extends('layouts.app')
@section('title', 'Bill of Materials')
@section('page-title', 'Bill of Materials')

@push('styles')
<style>
    .kpi-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; margin-bottom: 1.5rem; }
    .kpi-card { background: #fff; border: 1px solid var(--border-color); border-radius: 8px; padding: 1.25rem; box-shadow: 0 1px 2px rgba(0,0,0,0.02); }
    .kpi-label { font-size: 0.78rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; }
    .kpi-val { font-size: 2rem; font-weight: 700; color: var(--text-main); font-family: var(--ops-mono); line-height: 1; }
    .kpi-sub { font-size: 0.75rem; font-weight: 600; margin-top: 0.4rem; }

    .action-btn-primary {
        background: var(--primary); color: #fff; padding: 0.5rem 1.25rem; border-radius: 6px;
        font-weight: 600; font-size: 0.85rem; text-decoration: none; display: inline-flex;
        align-items: center; gap: 0.5rem; border: none; cursor: pointer; transition: background 0.2s;
    }
    .action-btn-primary:hover { background: var(--primary-dark); color: #fff; }

    .filters-strip {
        display: flex; gap: 0.9rem; background: #fff; padding: 1rem;
        border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 1.5rem;
        align-items: flex-end; flex-wrap: wrap;
    }
    .filter-group { flex: 1; min-width: 140px; }
    .filter-group label { display: block; font-size: 0.7rem; font-weight: 700; color: var(--text-muted); margin-bottom: 0.3rem; text-transform: uppercase; letter-spacing: 0.05em; }
    .filter-group input, .filter-group select {
        width: 100%; border: 1px solid #cbd5e1; border-radius: 6px;
        padding: 0.45rem 0.7rem; font-size: 0.85rem; color: var(--text-main); background: #fff;
    }
    .filter-group input:focus, .filter-group select:focus { border-color: var(--primary); outline: none; box-shadow: 0 0 0 2px rgba(21,128,61,0.1); }

    .ops-badge { padding: 0.3rem 0.6rem; border-radius: 4px; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; border: 1px solid transparent; display: inline-block; white-space: nowrap; }
    .badge-draft         { background: #f1f5f9; color: #475569; border-color: #e2e8f0; }
    .badge-active        { background: #f0fdf4; color: #166534; border-color: #bbf7d0; }
    .badge-pending-review { background: #fffbeb; color: #92400e; border-color: #fde68a; }
    .badge-frozen        { background: #eff6ff; color: #1e40af; border-color: #bfdbfe; }
    .badge-closed        { background: #f8fafc; color: #94a3b8; border-color: #e2e8f0; }

    .comp-type-chip { padding: 0.2rem 0.55rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600; background: #f1f5f9; color: #334155; border: 1px solid #e2e8f0; }

    .font-mono { font-family: var(--ops-mono); font-variant-numeric: tabular-nums; }

    .tbl-btn {
        background: transparent; border: 1px solid #cbd5e1; border-radius: 4px;
        padding: 0.25rem 0.55rem; font-size: 0.72rem; font-weight: 600; color: var(--text-main);
        cursor: pointer; display: inline-flex; align-items: center; gap: 0.25rem; transition: all 0.15s;
    }
    .tbl-btn:hover { background: #f8fafc; border-color: #94a3b8; }
    .tbl-btn-primary { color: var(--primary); border-color: rgba(21,128,61,0.35); }
    .tbl-btn-primary:hover { background: #f0fdf4; border-color: var(--primary); }

    @media (max-width: 1200px) { .kpi-grid { grid-template-columns: repeat(2, 1fr); } }
</style>
@endpush

@section('content')

{{-- ── Page Header ──────────────────────────────────────── --}}
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-0 fw-bold" style="color:var(--text-main);">Bill of Materials</h4>
        <div class="text-muted mt-1" style="font-size:0.85rem;">Manage fabric, lining, trims, consumption and wastage for each style.</div>
    </div>
    <button class="action-btn-primary" data-bs-toggle="modal" data-bs-target="#newBomModal"><i class="bi bi-plus-lg"></i> New BOM</button>
</div>

<!-- New BOM Modal -->
<div class="modal fade" id="newBomModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Create New Bill of Materials</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('bom.store') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">BOM Code</label>
                            <input type="text" class="form-control font-mono" name="bom_code" placeholder="BOM-XXXX" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Style Code</label>
                            <input type="text" class="form-control" name="style_code" placeholder="e.g. ST-VNK-001" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Buyer Name</label>
                            <input type="text" class="form-control" name="buyer_name" placeholder="e.g. H&M Global">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Season</label>
                            <select class="form-select" name="season">
                                <option value="SS26">SS26</option>
                                <option value="AW26">AW26</option>
                                <option value="SS25">SS25</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Garment Type</label>
                            <input type="text" class="form-control" name="garment_type" placeholder="e.g. V-Neck Tee">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background:var(--primary);border-color:var(--primary);">Create BOM</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ── KPI Cards ────────────────────────────────────────── --}}
<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-label">Active BOMs</div>
        <div class="kpi-val">34</div>
        <div class="kpi-sub" style="color:var(--primary);"><i class="bi bi-check-circle"></i> Approved & in use</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Styles Covered</div>
        <div class="kpi-val">21</div>
        <div class="kpi-sub" style="color:#1e40af;"><i class="bi bi-palette"></i> Unique garment styles</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Fabric Components</div>
        <div class="kpi-val">118</div>
        <div class="kpi-sub" style="color:#b45309;"><i class="bi bi-layers"></i> Across all active BOMs</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">BOMs Pending Review</div>
        <div class="kpi-val">5</div>
        <div class="kpi-sub" style="color:#b91c1c;"><i class="bi bi-clock-history"></i> Awaiting approval</div>
    </div>
</div>

{{-- ── Filter Bar ───────────────────────────────────────── --}}
<div class="filters-strip">
    <div class="filter-group" style="flex:2; min-width:200px;">
        <label>Search Style / BOM</label>
        <div style="position:relative;">
            <i class="bi bi-search" style="position:absolute;left:0.6rem;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:0.85rem;"></i>
            <input type="text" style="padding-left:2rem;" placeholder="BOM number, style code or description…">
        </div>
    </div>
    <div class="filter-group">
        <label>Component Type</label>
        <select>
            <option>All Types</option>
            <option>Main Fabric</option>
            <option>Lining</option>
            <option>Interlining</option>
            <option>Trim</option>
            <option>Button</option>
            <option>Zipper</option>
            <option>Label</option>
        </select>
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
        </select>
    </div>
    <div class="filter-group">
        <label>Status</label>
        <select>
            <option>All Statuses</option>
            <option>Draft</option>
            <option>Active</option>
            <option>Pending Review</option>
            <option>Frozen</option>
            <option>Closed</option>
        </select>
    </div>
</div>

{{-- ── BOM Table ────────────────────────────────────────── --}}
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>BOM No</th>
                    <th>Style</th>
                    <th>Buyer</th>
                    <th>Component Type</th>
                    <th>Fabric / Trim Code</th>
                    <th>Colour</th>
                    <th class="text-end">Consumption</th>
                    <th class="text-end">Wastage %</th>
                    <th class="text-end">Req. Qty</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>

                @forelse($boms as $bom)
                <tr>
                    <td class="font-mono" style="color:var(--primary);font-weight:700;">{{ $bom->bom_code }}</td>
                    <td>
                        <div class="fw-bold">{{ $bom->garment_type }}</div>
                        <div class="font-mono" style="font-size:0.72rem;color:var(--text-muted);">{{ $bom->style_code }}</div>
                    </td>
                    <td>{{ $bom->buyer_name }}</td>
                    <td colspan="6" class="text-muted fst-italic">BOM items loaded dynamically in details</td>
                    <td><span class="ops-badge badge-active">{{ $bom->status }}</span></td>
                    <td class="text-end">
                        <div class="d-flex gap-1 justify-content-end">
                            <a href="{{ route('bom.show', $bom) }}" class="tbl-btn tbl-btn-primary"><i class="bi bi-box-arrow-up-right"></i> Open</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center py-4 text-muted">No BOMs found.</td>
                </tr>
                @endforelse

                {{-- Row 2: Lining --}}


            </tbody>
        </table>
    </div>

    <div style="padding:0.85rem 1.25rem;border-top:1px solid var(--border-color);display:flex;align-items:center;justify-content:space-between;background:#fafafa;border-radius:0 0 8px 8px;">
        <div class="font-mono text-muted" style="font-size:0.78rem;">Showing 6 of 34 BOM lines</div>
        <div class="d-flex gap-2">
            <button class="tbl-btn" disabled>← Prev</button>
            <button class="tbl-btn tbl-btn-primary">Next →</button>
        </div>
    </div>
</div>

@endsection
