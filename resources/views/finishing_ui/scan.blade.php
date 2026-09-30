@extends('layouts.app')

@section('page-title', 'Scan Bundle')

@section('content')
<style>
    :root {
        --track-green: #15803d;
        --canvas: #f4f6f8;
        --border-color: #e2e8f0;
        --text-main: #334155;
        --text-muted: #64748b;
        --ops-mono: 'IBM Plex Mono', monospace;
    }

    .finishing-container {
        font-family: 'DM Sans', sans-serif;
        background-color: var(--canvas);
        color: var(--text-main);
        padding: 1.5rem;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .mono {
        font-family: var(--ops-mono);
    }

    .scan-card {
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 2rem;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .scan-input {
        width: 100%;
        max-width: 400px;
        padding: 1rem;
        font-size: 1.25rem;
        text-align: center;
        border: 2px dashed var(--border-color);
        border-radius: 0.5rem;
        margin: 1.5rem 0;
        font-family: var(--ops-mono);
        transition: border-color 0.2s;
    }
    
    .scan-input:focus {
        outline: none;
        border-color: var(--track-green);
    }

    .btn-primary {
        background-color: var(--track-green);
        color: white;
        padding: 0.75rem 2rem;
        border: none;
        border-radius: 0.375rem;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        font-size: 1rem;
    }
    
    .btn-primary:hover {
        background-color: #166534;
    }
    
    .quick-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-top: 2rem;
    }
    
    .btn-action {
        background-color: white;
        border: 1px solid var(--border-color);
        padding: 1rem;
        border-radius: 0.375rem;
        font-weight: 500;
        cursor: pointer;
        color: var(--text-main);
        transition: background-color 0.2s;
    }
    
    .btn-action:hover {
        background-color: #f8fafc;
    }

    .last-scanned {
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 1.5rem;
        text-align: left;
    }
    
    .last-scanned h3 {
        margin-top: 0;
        font-size: 1rem;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .last-scanned-details {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

</style>

<div class="finishing-container">
    
    <div style="margin-bottom: 1rem;">
        <a href="{{ route('finishing-ui.index') ?? '#' }}" style="color:var(--text-muted); text-decoration:none;">&larr; Back to Finishing</a>
    </div>

    <div class="scan-card">
        <h2 style="margin-top:0;">Scan Bundle QR Code</h2>
        <p style="color:var(--text-muted);">Use scanner or enter Bundle ID manually</p>
        
        <input type="text" class="scan-input" placeholder="BND-XXXX-XXXX" autofocus>
        
        <div>
            <button class="btn-primary">Scan / Enter</button>
        </div>
        
        <div class="quick-actions">
            <button class="btn-action">Start Operation</button>
            <button class="btn-action">Complete Operation</button>
        </div>
    </div>

    <div class="last-scanned">
        <h3>Last Scanned Bundle</h3>
        <div class="last-scanned-details">
            <div>
                <div style="font-weight: 600;" class="mono">BND-2026-0890</div>
                <div style="font-size: 0.875rem; color: var(--text-muted);">Style: STY-9012 | Size: L</div>
            </div>
            <div style="text-align: right;">
                <span style="display:inline-block; padding: 0.25rem 0.5rem; background-color: #d1fae5; color: #065f46; border-radius: 9999px; font-size: 0.75rem; font-weight:500;">Pressing Completed</span>
                <div style="font-size: 0.75rem; color: var(--text-muted); margin-top:0.25rem;" class="mono">Just now</div>
            </div>
        </div>
    </div>

</div>
@endsection
