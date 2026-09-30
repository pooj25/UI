@extends('layouts.app')

@section('page-title', 'Finishing Details')

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
    }
    
    .mono {
        font-family: var(--ops-mono);
    }

    .card {
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .header-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
    }
    
    .info-group label {
        display: block;
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .info-group div {
        font-weight: 500;
    }

    .progress-bar {
        display: flex;
        justify-content: space-between;
        margin: 2rem 0;
        position: relative;
    }
    
    .progress-bar::before {
        content: '';
        position: absolute;
        top: 15px;
        left: 0;
        right: 0;
        height: 2px;
        background-color: var(--border-color);
        z-index: 0;
    }
    
    .step {
        position: relative;
        z-index: 1;
        text-align: center;
        background: white;
        padding: 0 10px;
    }
    
    .step-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: white;
        border: 2px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.5rem;
        font-weight: bold;
        font-size: 0.875rem;
    }
    
    .step.completed .step-circle {
        background-color: var(--track-green);
        border-color: var(--track-green);
        color: white;
    }
    
    .step.active .step-circle {
        border-color: var(--track-green);
        color: var(--track-green);
    }
    
    .step-label {
        font-size: 0.75rem;
        font-weight: 500;
    }

    .workflow-card {
        border: 1px solid var(--border-color);
        border-radius: 0.375rem;
        padding: 1rem;
        margin-bottom: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .workflow-card h4 {
        margin: 0 0 0.5rem 0;
        font-size: 1rem;
    }

    .workflow-details {
        display: flex;
        gap: 1.5rem;
        font-size: 0.875rem;
        color: var(--text-muted);
    }

    .btn-primary {
        background-color: var(--track-green);
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 0.375rem;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
    }
    
    .alert-danger {
        background-color: #fef2f2;
        border: 1px solid #f87171;
        color: #991b1b;
        padding: 1rem;
        border-radius: 0.375rem;
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
    }

</style>

<div class="finishing-container">
    <div style="margin-bottom: 1rem;">
        <a href="{{ route('finishing-ui.index') ?? '#' }}" style="color:var(--text-muted); text-decoration:none;">&larr; Back to Finishing</a>
    </div>

    <!-- Exception Alert Example -->
    <div class="alert-danger" style="display:none;">
        <strong>Aging Exception:</strong> This bundle has been waiting for Pressing for over 4 hours.
    </div>

    <div class="card">
        <div class="header-info">
            <div class="info-group">
                <label>Bundle ID</label>
                <div class="mono">BND-2026-0891</div>
            </div>
            <div class="info-group">
                <label>Style</label>
                <div>STY-9012</div>
            </div>
            <div class="info-group">
                <label>Colour</label>
                <div>Navy</div>
            </div>
            <div class="info-group">
                <label>Size</label>
                <div>M</div>
            </div>
            <div class="info-group">
                <label>Pieces</label>
                <div class="mono">50</div>
            </div>
            <div class="info-group">
                <label>Operator</label>
                <div>S. Varma</div>
            </div>
            <div class="info-group">
                <label>Current Op</label>
                <div>Pressing</div>
            </div>
            <div class="info-group">
                <label>Start Time</label>
                <div class="mono">10:15 AM</div>
            </div>
            <div class="info-group">
                <label>Status</label>
                <div><span style="color: #4f46e5; font-weight: 600;">In Progress</span></div>
            </div>
        </div>
    </div>

    <div class="card">
        <h3 style="margin-top:0;">Progress</h3>
        <div class="progress-bar">
            <div class="step completed">
                <div class="step-circle">&#10003;</div>
                <div class="step-label">Sewing Completed</div>
            </div>
            <div class="step completed">
                <div class="step-circle">&#10003;</div>
                <div class="step-label">Thread Trim</div>
            </div>
            <div class="step active">
                <div class="step-circle">3</div>
                <div class="step-label">Pressing</div>
            </div>
            <div class="step">
                <div class="step-circle">4</div>
                <div class="step-label">Folding</div>
            </div>
            <div class="step">
                <div class="step-circle">5</div>
                <div class="step-label">Final QC</div>
            </div>
        </div>
    </div>

    <div class="card">
        <h3 style="margin-top:0;">Workflow Operations</h3>
        
        <div class="workflow-card">
            <div>
                <h4>1. Thread Trimming</h4>
                <div class="workflow-details">
                    <span>Operator: K. Patel</span>
                    <span class="mono">Start: 09:30 AM</span>
                    <span class="mono">End: 10:00 AM</span>
                    <span class="mono">Pieces: 50/50</span>
                </div>
            </div>
            <div>
                <span style="color: var(--track-green); font-weight:600;">Completed</span>
            </div>
        </div>

        <div class="workflow-card" style="border-color: #4f46e5; background-color: #e0e7ff33;">
            <div>
                <h4>2. Pressing</h4>
                <div class="workflow-details">
                    <span>Operator: S. Varma</span>
                    <span class="mono">Start: 10:15 AM</span>
                    <span class="mono">End: --</span>
                    <span class="mono">Pieces: --/50</span>
                </div>
            </div>
            <div>
                <span style="color: #4f46e5; font-weight:600;">In Progress</span>
            </div>
        </div>

        <div class="workflow-card">
            <div>
                <h4>3. Folding</h4>
                <div class="workflow-details">
                    <span>Operator: --</span>
                    <span class="mono">Start: --</span>
                    <span class="mono">End: --</span>
                    <span class="mono">Pieces: 0/50</span>
                </div>
            </div>
            <div>
                <span style="color: var(--text-muted); font-weight:600;">Pending</span>
            </div>
        </div>
        
        <div class="workflow-card">
            <div>
                <h4>4. Final QC Handoff</h4>
            </div>
            <div>
                <span style="color: var(--text-muted); font-weight:600;">Pending</span>
            </div>
        </div>
        
        <div style="margin-top: 1.5rem; text-align: right;">
            <button class="btn-primary">Send to Final Inspection</button>
        </div>
    </div>

</div>
@endsection
