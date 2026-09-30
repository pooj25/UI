@extends('layouts.app')
@section('title', 'Roll Detail — RL-40901')
@section('page-title', 'Roll Inventory')

@push('styles')
<style>
    :root {
        --primary: #15803d;
        --ops-mono: 'IBM Plex Mono', monospace;
        --text-main: #1e2329;
    }
    .page-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1.5rem; }
    .back-link { font-size: 0.88rem; color: #64748b; text-decoration: none; margin-bottom: 0.5rem; display: inline-block; font-weight: 600; }
    .back-link:hover { color: var(--text-main); }
    .roll-title { font-family: var(--ops-mono); color: var(--primary); font-size: 1.6rem; font-weight: 700; margin: 0 0 0.25rem 0; }
    .roll-sub { font-size: 0.88rem; color: #64748b; }
    
    .action-group { display: flex; gap: 0.5rem; }
    .btn { padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.88rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; cursor: pointer; border: 1px solid #cbd5e1; background: #fff; color: var(--text-main); }
    .btn:hover { background: #f8fafc; }
    
    .roll-header-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 1.5rem; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; }
    .roll-id-display { font-family: var(--ops-mono); font-size: 1.8rem; font-weight: 700; color: var(--primary); display: flex; align-items: center; gap: 1rem; }
    
    .ops-badge { display: inline-flex; align-items: center; padding: 0.25rem 0.6rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.02em; }
    .badge-available { background: #dcfce7; color: #166534; }
    
    .qr-large { width: 90px; height: 90px; background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; font-weight: 700; color: #94a3b8; font-family: var(--ops-mono); text-align: center; }
    
    .meta-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 1rem; margin-bottom: 1.5rem; }
    .meta-item { display: flex; flex-direction: column; gap: 0.25rem; }
    .meta-label { font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; }
    .meta-value { font-size: 0.88rem; color: var(--text-main); }
    .font-mono { font-family: var(--ops-mono); }
    .text-green { color: var(--primary); font-weight: 700; }
    
    .meters-summary { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 2rem; }
    .summary-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 1rem; text-align: center; }
    .summary-box .label { font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; margin-bottom: 0.5rem; display: block; }
    .summary-box .val { font-size: 1.25rem; font-family: var(--ops-mono); font-weight: 700; color: var(--text-main); }
    .val.green { color: #15803d; }
    
    .section-title { font-size: 1.1rem; font-weight: 700; color: var(--text-main); margin-bottom: 1rem; margin-top: 2rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem; }
    .empty-state { font-size: 0.88rem; color: #64748b; font-style: italic; }
    
    .timeline { list-style: none; padding: 0; margin: 0; border-left: 2px solid #e2e8f0; margin-left: 0.5rem; }
    .timeline li { position: relative; padding-left: 1.5rem; padding-bottom: 1rem; }
    .timeline li:last-child { padding-bottom: 0; }
    .timeline-dot { position: absolute; left: -0.35rem; top: 0.25rem; width: 0.6rem; height: 0.6rem; border-radius: 50%; background: #94a3b8; }
    .timeline-dot.green { background: #15803d; }
    .timeline-time { font-family: var(--ops-mono); font-size: 0.78rem; color: #64748b; display: block; margin-bottom: 0.25rem; }
    .timeline-desc { font-size: 0.85rem; color: var(--text-main); }
</style>
@endpush

@section('content')
<a href="{{ route('roll-inventory.index') }}" class="back-link">← Roll Inventory</a>
<div class="page-header">
    <div>
        <h1 class="roll-title">RL-40901</h1>
        <div class="roll-sub">Cotton Jersey · LOT-ST-0881-A · Navy</div>
    </div>
    <div class="action-group">
        <button class="btn">Move Location</button>
        <button class="btn">Hold</button>
        <button class="btn">Print Label</button>
        <button class="btn">Open Inspection</button>
    </div>
</div>

<div class="roll-header-card">
    <div class="roll-id-display">
        RL-40901
        <span class="ops-badge badge-available">Available</span>
    </div>
    <div class="qr-large">QR CODE</div>
</div>

<div class="meta-grid">
    <div class="meta-item">
        <span class="meta-label">Fabric Code</span>
        <span class="meta-value font-mono text-green">FAB-CTN-220</span>
    </div>
    <div class="meta-item">
        <span class="meta-label">Fabric Name</span>
        <span class="meta-value">Cotton Jersey</span>
    </div>
    <div class="meta-item">
        <span class="meta-label">Width</span>
        <span class="meta-value font-mono">180 cm</span>
    </div>
    <div class="meta-item">
        <span class="meta-label">Mill Lot</span>
        <span class="meta-value font-mono">LOT-ST-0881-A</span>
    </div>
    <div class="meta-item">
        <span class="meta-label">GRN</span>
        <span class="meta-value font-mono">GRN-2026-0881</span>
    </div>
</div>

<div class="meta-grid">
    <div class="meta-item">
        <span class="meta-label">Received Date</span>
        <span class="meta-value font-mono">2026-09-30</span>
    </div>
    <div class="meta-item">
        <span class="meta-label">Current Location</span>
        <span class="meta-value">Warehouse A</span>
    </div>
    <div class="meta-item">
        <span class="meta-label">Shade</span>
        <span class="meta-value">Navy Blue</span>
    </div>
    <div class="meta-item">
        <span class="meta-label">Supplier</span>
        <span class="meta-value">Sunrise Textiles</span>
    </div>
    <div class="meta-item">
        <span class="meta-label">Status</span>
        <span class="meta-value"><span class="ops-badge badge-available">Available</span></span>
    </div>
</div>

<div class="meters-summary">
    <div class="summary-box">
        <span class="label">Received</span>
        <span class="val">120.50 m</span>
    </div>
    <div class="summary-box">
        <span class="label">Used</span>
        <span class="val">0.00 m</span>
    </div>
    <div class="summary-box">
        <span class="label">Remaining</span>
        <span class="val green">120.50 m</span>
    </div>
</div>

<h2 class="section-title">Reservations</h2>
<div class="empty-state">No active reservations for this roll.</div>

<h2 class="section-title">Movement History</h2>
<ul class="timeline">
    <li>
        <span class="timeline-dot green"></span>
        <span class="timeline-time">2026-09-30 08:15</span>
        <span class="timeline-desc">Received · GRN-2026-0881 · Warehouse A Inward</span>
    </li>
    <li>
        <span class="timeline-dot"></span>
        <span class="timeline-time">2026-09-30 09:42</span>
        <span class="timeline-desc">QR Label Printed · Label ID: LBL-40901</span>
    </li>
    <li>
        <span class="timeline-dot"></span>
        <span class="timeline-time">2026-09-30 10:05</span>
        <span class="timeline-desc">Moved to Warehouse A Shelf-B4</span>
    </li>
</ul>
@endsection
