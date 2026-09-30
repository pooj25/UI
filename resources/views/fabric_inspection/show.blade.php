@extends('layouts.app')
@section('title', 'Inspection — RL-40901')
@section('page-title', 'Fabric Inspection')

@push('styles')
<style>
    /* Track Tech Design System - Shared */
    :root {
        --primary: #15803d;
        --primary-dark: #166534;
        --sidebar: #1e2329;
        --canvas: #f4f6f8;
        --surface: #ffffff;
        --border: #e2e8f0;
        --text-main: #0f172a;
        --text-muted: #64748b;
        --ops-mono: 'IBM Plex Mono', monospace;
        --ops-sans: 'DM Sans', sans-serif;
    }

    body {
        font-family: var(--ops-sans);
        background-color: var(--canvas);
        color: var(--text-main);
    }

    .font-mono { font-family: var(--ops-mono); }
    
    .back-link {
        display: inline-block;
        margin-bottom: 1rem;
        color: var(--text-muted);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.95rem;
    }
    .back-link:hover { color: var(--primary); }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 2rem;
    }

    .page-title-group h2 {
        margin: 0;
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-main);
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
    }

    .tbl-btn {
        background: var(--surface);
        border: 1px solid var(--border);
        padding: 0.5rem 1rem;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-main);
        text-decoration: none;
        display: inline-block;
    }
    .tbl-btn:hover { background-color: #f8fafc; }

    .tbl-btn-primary {
        background-color: #f0fdf4;
        color: var(--primary);
        border-color: #bbf7d0;
    }
    .tbl-btn-primary:hover { background-color: #dcfce7; }
    
    .tbl-btn-danger {
        color: #b91c1c;
        border-color: #fca5a5;
        background-color: #fef2f2;
    }
    .tbl-btn-danger:hover { background-color: #fee2e2; }

    .tbl-btn-amber {
        color: #b45309;
        border-color: #fde68a;
        background-color: #fffbeb;
    }
    .tbl-btn-amber:hover { background-color: #fef3c7; }

    .ops-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.35rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .badge-pass { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }

    /* Roll Identity Card */
    .identity-card {
        background-color: var(--surface);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .identity-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .identity-header h3 {
        margin: 0;
        font-size: 1.6rem;
        color: var(--primary);
    }

    .meta-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .meta-item { display: flex; flex-direction: column; gap: 0.25rem; }
    .meta-label { font-size: 0.8rem; font-weight: 600; color: var(--text-muted); }
    .meta-value { font-size: 0.95rem; font-weight: 500; color: var(--text-main); }
    .meta-value.green { color: var(--primary); font-weight: 700; }
    
    .meta-row-2 { border-top: 1px solid var(--border); padding-top: 1.5rem; }

    /* Points Summary */
    .summary-boxes {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .summary-box {
        flex: 1;
        background-color: var(--surface);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 1.25rem;
        text-align: center;
    }

    .summary-box .label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-muted);
        margin-bottom: 0.5rem;
    }

    .summary-box .value {
        font-size: 1.6rem;
        font-weight: 700;
        font-family: var(--ops-mono);
        color: var(--text-main);
    }
    .summary-box .value.blue { color: #0284c7; }

    /* Sections Shared */
    .section-title {
        font-size: 1.15rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--text-main);
    }

    .panel {
        background-color: var(--surface);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    /* Defect Entry Form */
    .compact-form {
        display: flex;
        align-items: center;
        gap: 1rem;
        background-color: #f8fafc;
        padding: 1rem;
        border-radius: 6px;
        border: 1px solid var(--border);
        margin-bottom: 1.5rem;
    }

    .form-group { display: flex; flex-direction: column; gap: 0.4rem; }
    .form-group label { font-size: 0.8rem; font-weight: 600; color: var(--text-muted); }
    .form-group input, .form-group select {
        padding: 0.5rem 0.75rem;
        border: 1px solid var(--border);
        border-radius: 4px;
        font-family: var(--ops-sans);
        font-size: 0.9rem;
    }
    .pos-input { width: 80px; font-family: var(--ops-mono) !important; }
    
    .compact-form .action-wrapper {
        margin-top: 1.4rem;
    }

    /* Table */
    table { width: 100%; border-collapse: collapse; text-align: left; }
    thead th {
        background-color: #f8fafc;
        padding: 0.75rem 1rem;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-muted);
        border-bottom: 1px solid var(--border);
        border-top: 1px solid var(--border);
    }
    tbody td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--border);
        font-size: 0.95rem;
    }
    .total-row td {
        font-weight: 700;
        background-color: #f8fafc;
        border-bottom: none;
    }
    .btn-remove {
        background: none;
        border: none;
        color: #b91c1c;
        font-weight: 700;
        font-size: 1.1rem;
        cursor: pointer;
    }
    .btn-remove:hover { color: #991b1b; }

    /* Shade Compare */
    .shade-boxes { display: flex; gap: 1rem; }
    .shade-box {
        flex: 1;
        background-color: var(--surface);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .shade-box-label { font-weight: 600; font-size: 0.9rem; }
    .shade-box-val.matched { color: #166534; font-weight: 700; }
    .shade-box-val.muted { color: var(--text-muted); }

    /* Sign-off */
    .signoff-form {
        display: flex;
        gap: 1rem;
        align-items: flex-end;
    }
    .signoff-form input, .signoff-form select {
        background-color: #f8fafc;
        color: var(--text-muted);
    }
    .btn-disabled {
        background-color: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        font-weight: 600;
        opacity: 0.7;
        cursor: not-allowed;
    }

    /* Evidence Upload */
    .upload-area {
        border: 2px dashed var(--border);
        border-radius: 8px;
        padding: 2.5rem;
        text-align: center;
        background-color: #f8fafc;
        cursor: pointer;
    }
    .upload-area:hover { border-color: #cbd5e1; }
    .upload-area i { font-size: 2.5rem; color: var(--text-muted); margin-bottom: 0.5rem; display: block; }
    .upload-area .upload-text { font-weight: 600; margin-bottom: 0.25rem; }
    .upload-area .upload-sub { font-size: 0.85rem; color: var(--text-muted); }

</style>
@endpush

<a href="{{ route('fabric-inspection.index') }}" class="back-link">&larr; Fabric Inspection</a>

<div class="page-header">
    <div class="page-title-group">
        <h2>Inspection Record &mdash; RL-40901</h2>
    </div>
    <div class="header-actions">
        <button class="tbl-btn tbl-btn-primary">Pass</button>
        <button class="tbl-btn tbl-btn-danger">Fail</button>
        <button class="tbl-btn tbl-btn-amber">Hold</button>
        <button class="tbl-btn">Print QC Sticker</button>
    </div>
</div>

<div class="identity-card">
    <div class="identity-header">
        <h3 class="font-mono">RL-40901</h3>
        <span class="ops-badge badge-pass">Pass</span>
    </div>
    
    <div class="meta-grid">
        <div class="meta-item">
            <span class="meta-label">Fabric Code</span>
            <span class="meta-value font-mono" style="color: var(--primary); font-weight: 600;">FAB-CTN-220</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Fabric Name</span>
            <span class="meta-value">Cotton Jersey</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Shade</span>
            <span class="meta-value">Navy Blue</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Inspector</span>
            <span class="meta-value">Anita Desai</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Inspection Date</span>
            <span class="meta-value font-mono">2026-09-30</span>
        </div>
    </div>
    
    <div class="meta-grid meta-row-2" style="margin-bottom: 0;">
        <div class="meta-item">
            <span class="meta-label">GRN</span>
            <span class="meta-value font-mono">GRN-2026-0881</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Mill Lot</span>
            <span class="meta-value font-mono">LOT-ST-0881-A</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Roll Length</span>
            <span class="meta-value font-mono" style="font-weight: 700;">120.50 m</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Usable Meters</span>
            <span class="meta-value font-mono green">120.50 m</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Result</span>
            <span class="meta-value"><span class="ops-badge badge-pass" style="padding: 0.2rem 0.5rem; font-size: 0.75rem;">Pass</span></span>
        </div>
    </div>
</div>

<div class="summary-boxes">
    <div class="summary-box">
        <div class="label">Total Defect Points</div>
        <div class="value">22</div>
    </div>
    <div class="summary-box">
        <div class="label">Roll Length</div>
        <div class="value">120.50 m</div>
    </div>
    <div class="summary-box">
        <div class="label">Points / 100m</div>
        <div class="value blue">18.2 pts</div>
    </div>
</div>

<div class="panel">
    <h3 class="section-title">4-Point Inspection &mdash; Defect Log</h3>
    
    <div class="compact-form">
        <div class="form-group">
            <label>Position (m)</label>
            <input type="number" step="0.01" class="pos-input" placeholder="0.00">
        </div>
        <div class="form-group" style="flex: 1;">
            <label>Defect Type</label>
            <select>
                <option>Hole</option>
                <option>Stain</option>
                <option>Weaving Defect</option>
                <option>Shade Variation</option>
                <option>Tear</option>
                <option>Missing Pick</option>
                <option>Float</option>
            </select>
        </div>
        <div class="form-group">
            <label>Points</label>
            <select>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
            </select>
        </div>
        <div class="action-wrapper">
            <button class="tbl-btn tbl-btn-primary">+ Add</button>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Position (m)</th>
                <th>Defect Type</th>
                <th>Points</th>
                <th>Added By</th>
                <th style="text-align: center;">Remove</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="font-mono">1</td>
                <td class="font-mono">14.50 m</td>
                <td>Weaving Defect</td>
                <td class="font-mono">2 pts</td>
                <td>Anita Desai</td>
                <td style="text-align: center;"><button class="btn-remove">&times;</button></td>
            </tr>
            <tr>
                <td class="font-mono">2</td>
                <td class="font-mono">38.20 m</td>
                <td>Stain</td>
                <td class="font-mono">4 pts</td>
                <td>Anita Desai</td>
                <td style="text-align: center;"><button class="btn-remove">&times;</button></td>
            </tr>
            <tr>
                <td class="font-mono">3</td>
                <td class="font-mono">67.00 m</td>
                <td>Float</td>
                <td class="font-mono">2 pts</td>
                <td>Anita Desai</td>
                <td style="text-align: center;"><button class="btn-remove">&times;</button></td>
            </tr>
            <tr>
                <td class="font-mono">4</td>
                <td class="font-mono">98.75 m</td>
                <td>Weaving Defect</td>
                <td class="font-mono">4 pts</td>
                <td>Anita Desai</td>
                <td style="text-align: center;"><button class="btn-remove">&times;</button></td>
            </tr>
            <tr class="total-row">
                <td colspan="3" style="text-align: right;">Total:</td>
                <td class="font-mono">12 pts</td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="panel">
    <h3 class="section-title">Shade Status</h3>
    <div class="shade-boxes">
        <div class="shade-box">
            <span class="shade-box-label">Shade Card Match</span>
            <span class="shade-box-val matched">&check; Matched</span>
        </div>
        <div class="shade-box">
            <span class="shade-box-label">Shade Band</span>
            <span class="shade-box-val muted">Within tolerance</span>
        </div>
    </div>
</div>

<div class="panel">
    <h3 class="section-title">Inspector Sign-off</h3>
    <div class="signoff-form">
        <div class="form-group" style="flex: 1;">
            <label>Inspector</label>
            <input type="text" value="Anita Desai" readonly>
        </div>
        <div class="form-group" style="flex: 1;">
            <label>Date</label>
            <input type="text" class="font-mono" value="2026-09-30" readonly>
        </div>
        <div class="form-group" style="flex: 1;">
            <label>Result</label>
            <select disabled>
                <option selected>Pass</option>
            </select>
        </div>
        <div class="action-wrapper" style="margin-bottom: 0.1rem;">
            <button class="btn-disabled" disabled>Confirmed</button>
        </div>
    </div>
</div>

<div class="panel" style="margin-bottom: 0;">
    <h3 class="section-title">Evidence (Optional)</h3>
    <div class="upload-area">
        <i class="bi bi-image"></i>
        <div class="upload-text">Drag &amp; drop inspection photo or click to upload</div>
        <div class="upload-sub">Supports JPG, PNG up to 5MB</div>
    </div>
</div>
