@extends('layouts.app')

@section('page-title', 'Panel Inspection')

@section('content')
<style>
    :root {
        --track-green: #15803d;
        --track-green-hover: #166534;
        --track-green-light: #dcfce7;
        --charcoal: #1f2937;
        --canvas: #f4f6f8;
        --border: #e2e8f0;
        --text-main: #334155;
        --text-muted: #64748b;
        --white: #ffffff;
        
        --success-bg: #dcfce7;
        --success-text: #166534;
        --warning-bg: #fef08a;
        --warning-text: #854d0e;
        --danger-bg: #fee2e2;
        --danger-text: #991b1b;
        --info-bg: #e0f2fe;
        --info-text: #075985;
        
        --ops-mono: 'IBM Plex Mono', monospace;
    }

    body {
        font-family: 'DM Sans', sans-serif;
        background-color: var(--canvas);
        color: var(--text-main);
    }

    .ops-mono {
        font-family: var(--ops-mono);
    }

    /* Header Card */
    .header-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .header-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 2rem;
        flex: 1;
    }

    .info-group {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .info-label {
        font-size: 0.75rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
    }

    .info-val {
        font-size: 1rem;
        font-weight: 500;
        color: var(--charcoal);
    }

    .header-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        border: 1px solid transparent;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background-color: var(--track-green);
        color: var(--white);
    }

    .btn-primary:hover {
        background-color: var(--track-green-hover);
    }

    .btn-outline {
        border-color: var(--border);
        background-color: var(--white);
        color: var(--text-main);
    }

    .btn-outline:hover {
        background-color: #f8fafc;
    }

    .btn-danger-outline {
        border-color: var(--danger-text);
        color: var(--danger-text);
        background: var(--white);
    }

    .btn-danger-outline:hover {
        background: var(--danger-bg);
    }
    
    .btn-warning-outline {
        border-color: var(--warning-text);
        color: var(--warning-text);
        background: var(--white);
    }

    .btn-warning-outline:hover {
        background: var(--warning-bg);
    }

    /* Main Content Layout */
    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
    }

    @media (max-width: 1024px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    .card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .card-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border);
        background: #f8fafc;
        font-weight: 600;
        color: var(--charcoal);
    }

    /* Table */
    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
    }

    .data-table th {
        background-color: #f8fafc;
        border-bottom: 1px solid var(--border);
        padding: 0.75rem 1rem;
        text-align: left;
        font-weight: 600;
        color: var(--charcoal);
    }

    .data-table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--border);
        color: var(--text-main);
    }

    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.625rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-success { background-color: var(--success-bg); color: var(--success-text); }
    .badge-warning { background-color: var(--warning-bg); color: var(--warning-text); }
    .badge-danger { background-color: var(--danger-bg); color: var(--danger-text); }

    /* Visual Layout */
    .visual-layout {
        padding: 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1.5rem;
    }

    .garment-svg {
        max-width: 100%;
        height: auto;
    }

    .legend {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        justify-content: center;
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }
    .dot-pass { background: var(--success-text); }
    .dot-spot { background: var(--warning-text); }
    .dot-recut { background: var(--danger-text); }

</style>

<div class="header-card">
    <div class="header-info-grid">
        <div class="info-group">
            <span class="info-label">Audit ID</span>
            <span class="info-val ops-mono">AUD-2026-0104</span>
        </div>
        <div class="info-group">
            <span class="info-label">Bundle ID</span>
            <span class="info-val ops-mono">BND-2026-0891</span>
        </div>
        <div class="info-group">
            <span class="info-label">Cut ID</span>
            <span class="info-val ops-mono">CUT-2026-042</span>
        </div>
        <div class="info-group">
            <span class="info-label">Date</span>
            <span class="info-val ops-mono">2026-09-30</span>
        </div>
        <div class="info-group">
            <span class="info-label">Inspector</span>
            <span class="info-val">R. Sharma</span>
        </div>
        <div class="info-group">
            <span class="info-label">Table</span>
            <span class="info-val ops-mono">TBL-04</span>
        </div>
    </div>
    <div class="header-actions">
        <button class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 2-2-0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            Approve & Send to Supermarket
        </button>
    </div>
</div>

<div class="content-grid">
    <div class="card">
        <div class="card-header">
            Panel Component Breakdown
        </div>
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Panel Component</th>
                        <th>Inspected Pcs</th>
                        <th>Defects Found</th>
                        <th>Defect Count</th>
                        <th>Severity</th>
                        <th>Disposition</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Front Body</td>
                        <td class="ops-mono">100</td>
                        <td>Oil Spot</td>
                        <td class="ops-mono">2</td>
                        <td><span class="badge badge-warning">Minor</span></td>
                        <td>Clean at Spotwash</td>
                    </tr>
                    <tr>
                        <td>Back Body</td>
                        <td class="ops-mono">100</td>
                        <td>-</td>
                        <td class="ops-mono">0</td>
                        <td>-</td>
                        <td>Pass</td>
                    </tr>
                    <tr>
                        <td>Left Sleeve</td>
                        <td class="ops-mono">100</td>
                        <td>Mis-cut</td>
                        <td class="ops-mono">1</td>
                        <td><span class="badge badge-danger">Major</span></td>
                        <td>Recut Required</td>
                    </tr>
                    <tr>
                        <td>Right Sleeve</td>
                        <td class="ops-mono">100</td>
                        <td>-</td>
                        <td class="ops-mono">0</td>
                        <td>-</td>
                        <td>Pass</td>
                    </tr>
                    <tr>
                        <td>Rib Collar</td>
                        <td class="ops-mono">100</td>
                        <td>Shading</td>
                        <td class="ops-mono">5</td>
                        <td><span class="badge badge-warning">Minor</span></td>
                        <td>Pass (Within Tolerance)</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Visual Garment Panel Layout
        </div>
        <div class="visual-layout">
            <!-- Simplified abstract CSS/SVG representation of panels -->
            <svg class="garment-svg" viewBox="0 0 200 200" width="200" height="200">
                <!-- Back Body (Passed) -->
                <path d="M 60 40 L 140 40 L 150 180 L 50 180 Z" fill="#dcfce7" stroke="#166534" stroke-width="2" />
                <text x="100" y="110" font-family="sans-serif" font-size="10" text-anchor="middle" fill="#166534">BACK</text>

                <!-- Front Body (Spotwash - Warning) -->
                <path d="M 70 50 L 130 50 L 140 170 L 60 170 Z" fill="#fef08a" stroke="#854d0e" stroke-width="2" />
                <text x="100" y="125" font-family="sans-serif" font-size="10" text-anchor="middle" fill="#854d0e">FRONT</text>
                <circle cx="90" cy="140" r="4" fill="#854d0e" /> <!-- Oil spot indicator -->

                <!-- Left Sleeve (Recut - Danger) -->
                <path d="M 55 45 L 20 100 L 40 110 L 65 60 Z" fill="#fee2e2" stroke="#991b1b" stroke-width="2" />
                <text x="40" y="75" font-family="sans-serif" font-size="8" text-anchor="middle" fill="#991b1b" transform="rotate(-60 40 75)">L SLV</text>
                <line x1="25" y1="100" x2="35" y2="105" stroke="#991b1b" stroke-width="2" /> <!-- Miscut indicator -->

                <!-- Right Sleeve (Passed) -->
                <path d="M 145 45 L 180 100 L 160 110 L 135 60 Z" fill="#dcfce7" stroke="#166534" stroke-width="2" />
                <text x="160" y="75" font-family="sans-serif" font-size="8" text-anchor="middle" fill="#166534" transform="rotate(60 160 75)">R SLV</text>

                <!-- Collar (Warning - Shading) -->
                <path d="M 70 35 Q 100 50 130 35 L 135 45 Q 100 60 65 45 Z" fill="#fef08a" stroke="#854d0e" stroke-width="2" />
            </svg>

            <div class="legend">
                <div class="legend-item"><div class="dot dot-pass"></div> Passed</div>
                <div class="legend-item"><div class="dot dot-spot"></div> Spotwash</div>
                <div class="legend-item"><div class="dot dot-recut"></div> Recut</div>
            </div>
            
            <div style="display: flex; gap: 0.5rem; flex-direction: column; width: 100%; margin-top: 1rem;">
                 <button class="btn btn-warning-outline" style="justify-content: center; width: 100%;">
                    Send to Spotwash
                </button>
                <button class="btn btn-danger-outline" style="justify-content: center; width: 100%;">
                    Request Recut Panels
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
