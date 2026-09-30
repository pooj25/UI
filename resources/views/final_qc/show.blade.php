@extends('layouts.app')

@section('page-title', 'Final Inspection (AQL) - Details')

@section('content')
<style>
    :root {
        --track-tech-green: #15803d;
        --track-tech-green-hover: #166534;
        --track-tech-charcoal: #334155;
        --track-tech-canvas: #f4f6f8;
        --track-tech-border: #e2e8f0;
        --track-tech-text: #1e293b;
        --ops-mono: 'IBM Plex Mono', monospace;
        --body-font: 'DM Sans', sans-serif;
    }

    body {
        font-family: var(--body-font);
        background-color: var(--track-tech-canvas);
        color: var(--track-tech-text);
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem;
    }
    
    .breadcrumb {
        font-size: 0.875rem;
        color: #64748b;
        margin-bottom: 1rem;
    }
    .breadcrumb a {
        color: var(--track-tech-green);
        text-decoration: none;
    }
    .breadcrumb a:hover {
        text-decoration: underline;
    }

    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .header-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--track-tech-charcoal);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .mono-id {
        font-family: var(--ops-mono);
    }

    .btn {
        padding: 0.5rem 1rem;
        border-radius: 4px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        border: 1px solid transparent;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background-color: var(--track-tech-green);
        color: white;
    }

    .btn-primary:hover {
        background-color: var(--track-tech-green-hover);
    }
    
    .btn-danger {
        background-color: #ef4444;
        color: white;
    }
    
    .btn-danger:hover {
        background-color: #dc2626;
    }
    
    .btn-outline {
        border-color: var(--track-tech-border);
        color: var(--track-tech-charcoal);
        background-color: white;
    }

    .btn-outline:hover {
        background-color: #f8fafc;
    }

    .card {
        background: white;
        border: 1px solid var(--track-tech-border);
        border-radius: 6px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    
    .card-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--track-tech-charcoal);
        margin: 0 0 1rem 0;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--track-tech-border);
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1.25rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .info-label {
        font-size: 0.75rem;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .info-value {
        font-size: 0.95rem;
        color: var(--track-tech-charcoal);
        font-weight: 500;
    }
    
    .info-value.mono {
        font-family: var(--ops-mono);
    }

    .badge {
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        width: max-content;
    }
    .badge-pass { background-color: #dcfce3; color: #166534; }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .summary-box {
        background: #f8fafc;
        border: 1px solid var(--track-tech-border);
        border-radius: 4px;
        padding: 1rem;
        text-align: center;
    }
    
    .summary-box-title {
        font-size: 0.875rem;
        color: #64748b;
        margin-bottom: 0.5rem;
    }
    
    .summary-box-val {
        font-size: 1.5rem;
        font-family: var(--ops-mono);
        font-weight: 700;
        color: var(--track-tech-charcoal);
    }
    
    .result-banner {
        background-color: #dcfce3;
        border: 1px solid #86efac;
        color: #166534;
        padding: 1rem;
        border-radius: 4px;
        font-weight: 600;
        text-align: center;
        letter-spacing: 0.025em;
    }
    
    .danger-banner {
        background-color: #fee2e2;
        border: 1px solid #fca5a5;
        color: #991b1b;
        padding: 1rem;
        border-radius: 4px;
        font-weight: 600;
        text-align: center;
        margin-bottom: 1rem;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
    }

    .data-table th, .data-table td {
        padding: 0.75rem 1rem;
        text-align: left;
        border-bottom: 1px solid var(--track-tech-border);
    }

    .data-table th {
        background-color: #f8fafc;
        font-weight: 600;
        color: #475569;
        white-space: nowrap;
    }

    .data-table td.mono {
        font-family: var(--ops-mono);
        color: #334155;
    }
    
    .workflow-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
    }

    .workflow-actions .btn-danger {
        margin-right: auto;
    }
</style>

<div class="container">
    <div class="breadcrumb">
        <a href="{{ route('final-qc.index') }}">Final Inspection</a> / <span class="mono-id">LOT-2026-088</span>
    </div>

    <div class="header-section">
        <h1 class="header-title">
            Lot Details <span class="mono-id" style="color:#64748b;">#LOT-2026-088</span>
            <span class="badge badge-pass">PASS</span>
        </h1>
        <div class="header-actions">
            <button class="btn btn-outline">Edit Result</button>
        </div>
    </div>

    <div class="card">
        <h2 class="card-title">Lot Information</h2>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">PO Number</span>
                <span class="info-value mono">PO-9912</span>
            </div>
            <div class="info-item">
                <span class="info-label">Buyer</span>
                <span class="info-value">Nordic Apparel</span>
            </div>
            <div class="info-item">
                <span class="info-label">Style</span>
                <span class="info-value">STY-9012</span>
            </div>
            <div class="info-item">
                <span class="info-label">Colour</span>
                <span class="info-value">Navy</span>
            </div>
            <div class="info-item">
                <span class="info-label">Size Range</span>
                <span class="info-value">S-XXL</span>
            </div>
            <div class="info-item">
                <span class="info-label">Offer Quantity</span>
                <span class="info-value mono">2,400 Pcs</span>
            </div>
            <div class="info-item">
                <span class="info-label">Sample Size</span>
                <span class="info-value mono">125 Pcs</span>
            </div>
            <div class="info-item">
                <span class="info-label">Inspection Level</span>
                <span class="info-value">General Level II</span>
            </div>
            <div class="info-item">
                <span class="info-label">AQL Major</span>
                <span class="info-value mono">2.5</span>
            </div>
            <div class="info-item">
                <span class="info-label">AQL Minor</span>
                <span class="info-value mono">4.0</span>
            </div>
            <div class="info-item">
                <span class="info-label">Inspector</span>
                <span class="info-value">V. Rao</span>
            </div>
            <div class="info-item">
                <span class="info-label">Date</span>
                <span class="info-value mono">2026-09-30</span>
            </div>
        </div>
    </div>

    <div class="card">
        <h2 class="card-title">AQL Inspection Summary</h2>
        <div class="summary-grid">
            <div class="summary-box">
                <div class="summary-box-title">Offer Quantity</div>
                <div class="summary-box-val">2,400</div>
            </div>
            <div class="summary-box">
                <div class="summary-box-title">Sample Size</div>
                <div class="summary-box-val">125</div>
            </div>
            <div class="summary-box">
                <div class="summary-box-title">Allowed Major</div>
                <div class="summary-box-val" style="color: #64748b;">3</div>
            </div>
            <div class="summary-box">
                <div class="summary-box-title">Allowed Minor</div>
                <div class="summary-box-val" style="color: #64748b;">7</div>
            </div>
        </div>
        <div class="summary-grid" style="grid-template-columns: repeat(3, 1fr);">
            <div class="summary-box">
                <div class="summary-box-title">Major Defects Found</div>
                <div class="summary-box-val" style="color: #ea580c;">2</div>
            </div>
            <div class="summary-box">
                <div class="summary-box-title">Minor Defects Found</div>
                <div class="summary-box-val" style="color: #ca8a04;">4</div>
            </div>
            <div class="summary-box">
                <div class="summary-box-title">Critical Defects Found</div>
                <div class="summary-box-val" style="color: #16a34a;">0</div>
            </div>
        </div>
        
        <div class="result-banner">
            PASS - RELEASED FOR PACKING
        </div>
    </div>

    <div class="card" style="padding: 0; overflow: hidden;">
        <h2 class="card-title" style="padding: 1.5rem 1.5rem 0 1.5rem; border: none; margin-bottom: 0;">Defects Found</h2>
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Defect ID</th>
                        <th>Defect Type</th>
                        <th>Severity</th>
                        <th>Garment / Sample No</th>
                        <th>Location</th>
                        <th>Quantity</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="mono">DEF-001</td>
                        <td>Open Seam</td>
                        <td>Major</td>
                        <td class="mono">SMP-012</td>
                        <td>Side Seam</td>
                        <td class="mono">1</td>
                        <td>1 inch open</td>
                    </tr>
                    <tr>
                        <td class="mono">DEF-002</td>
                        <td>Broken Stitch</td>
                        <td>Minor</td>
                        <td class="mono">SMP-044</td>
                        <td>Hem</td>
                        <td class="mono">1</td>
                        <td>Skip stitch</td>
                    </tr>
                    <tr>
                        <td class="mono">DEF-003</td>
                        <td>Measurement Out</td>
                        <td>Major</td>
                        <td class="mono">SMP-089</td>
                        <td>Chest</td>
                        <td class="mono">1</td>
                        <td>+1/2 inch out of tolerance</td>
                    </tr>
                    <tr>
                        <td class="mono">DEF-004</td>
                        <td>Stain</td>
                        <td>Minor</td>
                        <td class="mono">SMP-102</td>
                        <td>Front Panel</td>
                        <td class="mono">1</td>
                        <td>Light oil stain</td>
                    </tr>
                    <tr>
                        <td class="mono">DEF-005</td>
                        <td>Fabric Defect</td>
                        <td>Minor</td>
                        <td class="mono">SMP-115</td>
                        <td>Back Panel</td>
                        <td class="mono">1</td>
                        <td>Small slub</td>
                    </tr>
                    <tr>
                        <td class="mono">DEF-006</td>
                        <td>Button / Trims Issue</td>
                        <td>Minor</td>
                        <td class="mono">SMP-121</td>
                        <td>Collar</td>
                        <td class="mono">1</td>
                        <td>Loose button</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="workflow-actions">
        <!-- Example of other states hidden for demo purposes 
        <button class="btn btn-danger">Block from Packing</button>
        -->
        <button class="btn btn-outline">Schedule Re-inspection</button>
        <button class="btn btn-outline">Hold Lot</button>
        <button class="btn btn-primary">Release to Packing</button>
    </div>
</div>
@endsection
