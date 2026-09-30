@extends('layouts.app')

@section('page-title', 'Sewing / In-line QC Scan')

@section('content')
<div class="page-container scan-page">
    <div class="page-header text-center">
        <h1 class="page-title">Scan Bundle</h1>
        <p class="page-description">Scan the bundle QR code to start QC inspection</p>
    </div>

    <div class="scan-container">
        <!-- Mock Camera Box -->
        <div class="camera-box">
            <div class="scan-overlay">
                <div class="scan-frame"></div>
                <div class="scan-line"></div>
            </div>
            <p class="camera-text">Camera Active... Align QR Code</p>
        </div>

        <!-- Manual Input -->
        <div class="manual-input-box">
            <p>Or enter bundle ID manually:</p>
            <div class="input-group">
                <input type="text" class="form-control font-mono input-lg" placeholder="e.g. BND-2026-0891">
                <button class="btn btn-primary btn-lg">Search</button>
            </div>
        </div>

        <!-- Last Scanned Section -->
        <div class="last-scanned card">
            <div class="card-header">
                <h3>Last Scanned Bundle</h3>
            </div>
            <div class="card-body text-center">
                <h2 class="font-mono text-dark">BND-2026-0891</h2>
                <p class="text-muted">Style: STY-9012 | Line 03</p>
                <div class="quick-actions">
                    <a href="{{ url('sewing-qc/show') }}" class="btn btn-primary w-100 mb-2">Proceed to Inspection</a>
                    <div class="d-flex gap-2">
                        <button class="btn btn-success flex-1">Quick Pass</button>
                        <button class="btn btn-danger flex-1">Quick Reject</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --track-green: #15803d;
        --charcoal: #334155;
        --canvas: #f4f6f8;
        --border: #e2e8f0;
        --success: #16a34a;
        --danger: #dc2626;
        --dark: #0f172a;
        --ops-mono: 'IBM Plex Mono', monospace;
    }

    body {
        font-family: 'DM Sans', sans-serif;
        background-color: var(--canvas);
        color: var(--charcoal);
        margin: 0;
    }

    .font-mono { font-family: var(--ops-mono); }
    .text-center { text-align: center; }
    .text-muted { color: #64748b; }
    .text-dark { color: var(--dark); }
    .mb-2 { margin-bottom: 8px; }
    .w-100 { width: 100%; }
    .flex-1 { flex: 1; }
    .d-flex { display: flex; }
    .gap-2 { gap: 8px; }

    .page-container {
        padding: 24px;
        max-width: 800px;
        margin: 0 auto;
    }

    .page-header {
        margin-bottom: 32px;
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 8px;
    }

    .scan-container {
        background: white;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 32px;
    }

    .camera-box {
        background-color: #0f172a;
        border-radius: 8px;
        height: 300px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin-bottom: 24px;
    }

    .scan-overlay {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .scan-frame {
        width: 200px;
        height: 200px;
        border: 2px dashed rgba(255,255,255,0.5);
        border-radius: 12px;
    }

    .scan-line {
        position: absolute;
        width: 200px;
        height: 2px;
        background-color: #22c55e;
        box-shadow: 0 0 8px #22c55e;
        top: 50%;
        animation: scan 2s infinite ease-in-out;
    }

    @keyframes scan {
        0%, 100% { transform: translateY(-90px); }
        50% { transform: translateY(90px); }
    }

    .camera-text {
        color: white;
        z-index: 10;
        font-size: 0.875rem;
        opacity: 0.7;
        margin-top: 240px;
    }

    .manual-input-box {
        text-align: center;
        margin-bottom: 32px;
        padding-bottom: 32px;
        border-bottom: 1px solid var(--border);
    }

    .input-group {
        display: flex;
        gap: 12px;
        max-width: 400px;
        margin: 12px auto 0;
    }

    .form-control {
        border: 1px solid var(--border);
        border-radius: 6px;
        padding: 12px 16px;
        font-size: 1rem;
        flex: 1;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 16px;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 6px;
        border: 1px solid transparent;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-lg {
        padding: 12px 24px;
        font-size: 1rem;
    }

    .btn-primary { background-color: var(--track-green); color: white; }
    .btn-success { background-color: var(--success); color: white; }
    .btn-danger { background-color: var(--danger); color: white; }

    .card {
        border: 1px solid var(--border);
        border-radius: 8px;
        background: #f8fafc;
    }

    .card-header {
        padding: 16px;
        border-bottom: 1px solid var(--border);
        background: white;
        border-radius: 8px 8px 0 0;
    }

    .card-header h3 {
        margin: 0;
        font-size: 1rem;
        color: var(--dark);
        text-align: center;
    }

    .card-body {
        padding: 24px;
    }

    .quick-actions {
        max-width: 300px;
        margin: 20px auto 0;
    }
</style>
@endsection
