@extends('layouts.app')
@section('title', 'Scan Roll')
@section('page-title', 'Roll Inventory')

@push('styles')
<style>
    :root {
        --primary: #15803d;
        --ops-mono: 'IBM Plex Mono', monospace;
        --text-main: #1e2329;
    }
    .back-link { font-size: 0.88rem; color: #64748b; text-decoration: none; margin-bottom: 1.5rem; display: inline-block; font-weight: 600; }
    .back-link:hover { color: var(--text-main); }
    
    .scan-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 2rem; max-width: 480px; margin: 0 auto 2rem auto; text-align: center; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
    .scan-icon { font-size: 2rem; color: var(--primary); margin-bottom: 1rem; }
    .scan-title { font-size: 1.25rem; font-weight: 700; color: var(--text-main); margin: 0 0 0.5rem 0; }
    .scan-sub { font-size: 0.88rem; color: #64748b; margin-bottom: 1.5rem; }
    
    .scan-input { width: 100%; padding: 0.75rem; border: 2px solid #cbd5e1; border-radius: 6px; font-family: var(--ops-mono); font-size: 1rem; color: var(--text-main); text-align: center; margin-bottom: 1rem; box-sizing: border-box; }
    .scan-input:focus { outline: none; border-color: var(--primary); }
    
    .btn-scan { background: var(--primary); color: #fff; padding: 0.75rem; border-radius: 6px; font-size: 1rem; font-weight: 700; width: 100%; border: none; cursor: pointer; }
    .btn-scan:hover { background: #166534; }
    
    .result-section { max-width: 480px; margin: 0 auto; }
    .result-title { display: flex; align-items: center; gap: 0.5rem; font-size: 1.1rem; font-weight: 700; color: var(--text-main); margin-bottom: 1rem; justify-content: center; }
    .result-title i { color: var(--primary); }
    
    .result-card { background: #fff; border: 1px solid #e2e8f0; border-left: 4px solid var(--primary); border-radius: 6px; padding: 1.25rem; }
    .result-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.75rem; }
    .result-id { font-family: var(--ops-mono); font-size: 1.4rem; font-weight: 700; color: var(--primary); }
    
    .ops-badge { display: inline-flex; align-items: center; padding: 0.25rem 0.6rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.02em; }
    .badge-available { background: #dcfce7; color: #166534; }
    
    .meta-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem; }
    .meta-item { display: flex; flex-direction: column; gap: 0.15rem; }
    .meta-label { font-size: 0.75rem; color: #64748b; font-weight: 600; }
    .meta-value { font-size: 0.88rem; color: var(--text-main); }
    .font-mono { font-family: var(--ops-mono); }
    .text-green { color: var(--primary); font-weight: 700; }
    
    .action-row { display: flex; flex-wrap: wrap; gap: 0.5rem; border-top: 1px solid #e2e8f0; padding-top: 1rem; }
    .tbl-btn { background: #fff; border: 1px solid #cbd5e1; color: var(--text-main); padding: 0.4rem 0.75rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600; text-decoration: none; cursor: pointer; flex: 1; text-align: center; }
    .tbl-btn:hover { background: #f8fafc; }
    .tbl-btn-primary { background: var(--primary); color: #fff; border: 1px solid var(--primary); padding: 0.4rem 0.75rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600; text-decoration: none; cursor: pointer; flex: 1; text-align: center; }
    .tbl-btn-primary:hover { background: #166534; }
    
    .scan-note { font-size: 0.75rem; color: #64748b; text-align: center; margin-top: 1rem; }
</style>
@endpush

@section('content')
<a href="{{ route('roll-inventory.index') }}" class="back-link">← Roll Inventory</a>

<div class="scan-card">
    <i class="bi bi-upc-scan scan-icon"></i>
    <h2 class="scan-title">Scan Roll QR</h2>
    <p class="scan-sub">Point scanner at roll QR label or enter Roll ID manually</p>
    
    <input type="text" class="scan-input" placeholder="RL-XXXXX or scan QR…">
    <button class="btn-scan">Scan / Look Up</button>
</div>

<div class="result-section">
    <div class="result-title">
        <i class="bi bi-check-circle-fill"></i> Roll Found
    </div>
    <div class="result-card">
        <div class="result-top">
            <span class="result-id">RL-40901</span>
            <span class="ops-badge badge-available">Available</span>
        </div>
        <div class="meta-grid">
            <div class="meta-item">
                <span class="meta-label">Fabric</span>
                <span class="meta-value">Cotton Jersey <br><span class="font-mono text-sm" style="color:#64748b;">FAB-CTN-220</span></span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Shade/Lot</span>
                <span class="meta-value">LOT-ST-0881-A · Navy</span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Width</span>
                <span class="meta-value font-mono">180 cm</span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Remaining</span>
                <span class="meta-value font-mono text-green">120.50 m</span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Location</span>
                <span class="meta-value">Warehouse A</span>
            </div>
            <div class="meta-item">
                <span class="meta-label">GRN</span>
                <span class="meta-value font-mono">GRN-2026-0881</span>
            </div>
        </div>
        <div class="action-row">
            <a href="{{ route('roll-inventory.show') }}" class="tbl-btn-primary">Open Full Record</a>
            <button class="tbl-btn">Open Inspection</button>
            <button class="tbl-btn">Print Label</button>
            <button class="tbl-btn">Move Location</button>
        </div>
    </div>
    <div class="scan-note">Scanned at 2026-09-30 10:27 · RL-40901</div>
</div>
@endsection
