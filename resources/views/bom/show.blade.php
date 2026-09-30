@extends('layouts.app')
@section('title', 'BOM Detail — V-Neck Tee')
@section('page-title', 'BOM Detail')

@push('styles')
<style>
    .font-mono { font-family: var(--ops-mono); font-variant-numeric: tabular-nums; }

    .bom-header-card { background: #fff; border: 1px solid var(--border-color); border-radius: 8px; padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: 0 1px 2px rgba(0,0,0,0.02); }
    .bom-meta-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 1.25rem; }
    .bom-meta-item label { display: block; font-size: 0.7rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.3rem; }
    .bom-meta-item .val { font-size: 0.92rem; font-weight: 600; color: var(--text-main); }
    .bom-meta-item .val-mono { font-family: var(--ops-mono); font-size: 0.88rem; font-weight: 700; color: var(--primary); }

    .ops-badge { padding: 0.3rem 0.6rem; border-radius: 4px; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; border: 1px solid transparent; display: inline-block; }
    .badge-active { background: #f0fdf4; color: #166534; border-color: #bbf7d0; }
    .badge-draft { background: #f1f5f9; color: #475569; border-color: #e2e8f0; }
    .badge-pending-review { background: #fffbeb; color: #92400e; border-color: #fde68a; }
    .badge-frozen { background: #eff6ff; color: #1e40af; border-color: #bfdbfe; }

    .comp-type-chip { padding: 0.2rem 0.55rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600; background: #f1f5f9; color: #334155; border: 1px solid #e2e8f0; }

    .tbl-btn { background: transparent; border: 1px solid #cbd5e1; border-radius: 4px; padding: 0.25rem 0.55rem; font-size: 0.72rem; font-weight: 600; color: var(--text-main); cursor: pointer; display: inline-flex; align-items: center; gap: 0.25rem; transition: all 0.15s; }
    .tbl-btn:hover { background: #f8fafc; border-color: #94a3b8; }
    .tbl-btn-primary { color: var(--primary); border-color: rgba(21,128,61,0.35); }
    .tbl-btn-primary:hover { background: #f0fdf4; border-color: var(--primary); }

    .summary-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-top: 1.5rem; }
    .summary-box { background: #f8fafc; border: 1px solid var(--border-color); border-radius: 6px; padding: 1rem; }
    .summary-box label { font-size: 0.72rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 0.3rem; }
    .summary-box .sum-val { font-family: var(--ops-mono); font-size: 1.25rem; font-weight: 700; color: var(--text-main); }

    @media (max-width: 1024px) {
        .bom-meta-grid { grid-template-columns: repeat(3, 1fr); }
        .summary-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>
@endpush

@section('content')

{{-- ── Breadcrumb & Actions ───────────────────────────── --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <div class="text-muted mb-1" style="font-size:0.82rem;">
            <a href="{{ route('bom.index') }}" style="color:var(--primary);text-decoration:none;font-weight:600;">
                <i class="bi bi-arrow-left me-1"></i>Bill of Materials
            </a>
            <span class="mx-2 text-muted">›</span>
            <span class="font-mono fw-bold">BOM-0041</span>
        </div>
        <h4 class="mb-0 fw-bold" style="color:var(--text-main);">V-Neck Tee — BOM Detail</h4>
    </div>
    <div class="d-flex gap-2">
        <button class="tbl-btn"><i class="bi bi-copy"></i> Copy BOM</button>
        <button class="tbl-btn"><i class="bi bi-snow2"></i> Freeze</button>
        <button class="tbl-btn tbl-btn-primary"><i class="bi bi-plus-lg"></i> Add Line</button>
    </div>
</div>

{{-- ── Style / BOM Header Info ──────────────────────────── --}}
<div class="bom-header-card">
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <div class="font-mono text-muted" style="font-size:0.78rem; margin-bottom:0.2rem;">BOM-0041</div>
            <div class="fw-bold" style="font-size:1.15rem; color:var(--text-main);">V-Neck Tee</div>
        </div>
        <span class="ops-badge badge-active">Active</span>
    </div>
    <div class="bom-meta-grid">
        <div class="bom-meta-item">
            <label>Style Code</label>
            <div class="val-mono">ST-VNK-001</div>
        </div>
        <div class="bom-meta-item">
            <label>Buyer</label>
            <div class="val">H&M Global</div>
        </div>
        <div class="bom-meta-item">
            <label>Season</label>
            <div class="val font-mono">SS26</div>
        </div>
        <div class="bom-meta-item">
            <label>PO Reference</label>
            <div class="val-mono">PO-2026-0099</div>
        </div>
        <div class="bom-meta-item">
            <label>Order Qty</label>
            <div class="val font-mono">12,400 pcs</div>
        </div>
    </div>
</div>

{{-- ── Components Table ─────────────────────────────────── --}}
<div class="d-flex justify-content-between align-items-center mb-2">
    <div class="fw-bold" style="font-size:0.95rem; color:var(--text-main);">Component Lines</div>
    <button class="tbl-btn tbl-btn-primary"><i class="bi bi-plus-lg"></i> Add Line</button>
</div>
<div class="card border-0 shadow-sm mb-3">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Component Type</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Colour</th>
                    <th class="text-end">Unit Cons.</th>
                    <th class="text-end">Wastage %</th>
                    <th class="text-end">Total w/ Wastage</th>
                    <th class="text-end">Req. Qty</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="font-mono text-muted">01</td>
                    <td><span class="comp-type-chip">Main Fabric</span></td>
                    <td class="font-mono" style="color:#334155; font-weight:700;">FAB-CTN-220</td>
                    <td>100% Cotton Jersey, 220 GSM</td>
                    <td><span style="display:inline-flex;align-items:center;gap:0.4rem;"><span style="width:10px;height:10px;border-radius:2px;background:#1d4ed8;display:inline-block;"></span> Navy Blue</span></td>
                    <td class="font-mono text-end">1.450 m</td>
                    <td class="font-mono text-end">8.00%</td>
                    <td class="font-mono text-end">1.566 m</td>
                    <td class="font-mono text-end fw-bold">19,418 m</td>
                    <td class="text-end">
                        <button class="tbl-btn"><i class="bi bi-pencil"></i></button>
                        <button class="tbl-btn" style="color:#b91c1c;border-color:#fca5a5;"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td class="font-mono text-muted">02</td>
                    <td><span class="comp-type-chip" style="background:#eff6ff;color:#1e40af;border-color:#bfdbfe;">Lining</span></td>
                    <td class="font-mono" style="color:#334155; font-weight:700;">LIN-VIS-050</td>
                    <td>Viscose Lining, 50 GSM</td>
                    <td><span style="display:inline-flex;align-items:center;gap:0.4rem;"><span style="width:10px;height:10px;border-radius:2px;background:#1d4ed8;display:inline-block;"></span> Navy Blue</span></td>
                    <td class="font-mono text-end">0.300 m</td>
                    <td class="font-mono text-end">5.00%</td>
                    <td class="font-mono text-end">0.315 m</td>
                    <td class="font-mono text-end fw-bold">3,906 m</td>
                    <td class="text-end">
                        <button class="tbl-btn"><i class="bi bi-pencil"></i></button>
                        <button class="tbl-btn" style="color:#b91c1c;border-color:#fca5a5;"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td class="font-mono text-muted">03</td>
                    <td><span class="comp-type-chip" style="background:#faf5ff;color:#6b21a8;border-color:#e9d5ff;">Trim</span></td>
                    <td class="font-mono" style="color:#334155; font-weight:700;">TRM-NTG-01</td>
                    <td>Neck Tape, 12mm Grosgrain</td>
                    <td><span style="display:inline-flex;align-items:center;gap:0.4rem;"><span style="width:10px;height:10px;border-radius:2px;background:#1d4ed8;display:inline-block;"></span> Navy Blue</span></td>
                    <td class="font-mono text-end">0.45 m</td>
                    <td class="font-mono text-end">3.00%</td>
                    <td class="font-mono text-end">0.464 m</td>
                    <td class="font-mono text-end fw-bold">5,750 m</td>
                    <td class="text-end">
                        <button class="tbl-btn"><i class="bi bi-pencil"></i></button>
                        <button class="tbl-btn" style="color:#b91c1c;border-color:#fca5a5;"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td class="font-mono text-muted">04</td>
                    <td><span class="comp-type-chip" style="background:#faf5ff;color:#6b21a8;border-color:#e9d5ff;">Label</span></td>
                    <td class="font-mono" style="color:#334155; font-weight:700;">LBL-MAIN-HM</td>
                    <td>H&M Main Woven Label</td>
                    <td><span style="display:inline-flex;align-items:center;gap:0.4rem;"><span style="width:10px;height:10px;border-radius:2px;background:#e5e7eb;display:inline-block;"></span> White/Black</span></td>
                    <td class="font-mono text-end">1 pcs</td>
                    <td class="font-mono text-end">2.00%</td>
                    <td class="font-mono text-end">1.020 pcs</td>
                    <td class="font-mono text-end fw-bold">12,648 pcs</td>
                    <td class="text-end">
                        <button class="tbl-btn"><i class="bi bi-pencil"></i></button>
                        <button class="tbl-btn" style="color:#b91c1c;border-color:#fca5a5;"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- ── Total Material Summary ────────────────────────────── --}}
<div class="fw-bold mb-2" style="font-size:0.95rem; color:var(--text-main);">Total Material Requirement</div>
<div class="summary-grid">
    <div class="summary-box">
        <label>Main Fabric Required</label>
        <div class="sum-val">19,418 m</div>
        <div style="font-size:0.75rem; color:var(--text-muted); margin-top:0.25rem;">Including 8% wastage for 12,400 pcs</div>
    </div>
    <div class="summary-box">
        <label>Lining Required</label>
        <div class="sum-val">3,906 m</div>
        <div style="font-size:0.75rem; color:var(--text-muted); margin-top:0.25rem;">Including 5% wastage</div>
    </div>
    <div class="summary-box">
        <label>Total Trim (Neck Tape)</label>
        <div class="sum-val">5,750 m</div>
        <div style="font-size:0.75rem; color:var(--text-muted); margin-top:0.25rem;">Including 3% wastage</div>
    </div>
</div>

@endsection
