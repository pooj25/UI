@extends('layouts.app')

@section('page-title', 'Traceability Pedigree')

@section('content')
<style>
    /* Styling configuration for Traceability Show */
    :root {
        --track-green: #15803d;
        --track-green-hover: #166534;
        --canvas-light: #f4f6f8;
        --border-color: #e2e8f0;
        --text-main: #1f2937;
        --text-muted: #64748b;
        --ops-mono: 'IBM Plex Mono', monospace;
    }
    
    body {
        font-family: 'DM Sans', sans-serif;
        background-color: var(--canvas-light);
        color: var(--text-main);
    }

    .ops-mono {
        font-family: var(--ops-mono);
    }

    .header-card {
        background-color: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .header-info-label {
        font-size: 0.75rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .header-info-value {
        font-weight: 600;
        color: var(--text-main);
    }

    .btn-primary {
        background-color: var(--track-green);
        color: #ffffff;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-weight: 500;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-outline {
        background-color: transparent;
        color: var(--text-main);
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-weight: 500;
        border: 1px solid var(--border-color);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .timeline {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        position: relative;
        padding-left: 1.5rem;
        margin-bottom: 2rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0.4375rem;
        width: 2px;
        background-color: var(--border-color);
    }

    .timeline-item {
        position: relative;
        background-color: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 1rem;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        top: 1.25rem;
        left: -1.375rem;
        width: 0.75rem;
        height: 0.75rem;
        border-radius: 50%;
        background-color: var(--track-green);
        border: 2px solid #ffffff;
    }
    
    .timeline-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.25rem;
    }
    
    .timeline-title {
        font-weight: 600;
        font-size: 1rem;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        background-color: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .data-table th, .data-table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--border-color);
        text-align: left;
    }

    .data-table th {
        background-color: var(--canvas-light);
        font-weight: 600;
        color: var(--text-muted);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
</style>

<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">Traceability Audit Detail</h1>
            <p class="text-sm text-gray-500 mt-1">End-to-end pedigree verification for the selected trace lot.</p>
        </div>
        <div class="flex gap-2">
            <button class="btn-outline">Print Traceability Pedigree QR</button>
            <button class="btn-outline">Verify Digital Custody Signatures</button>
            <button class="btn-primary">Export Full Audit Trace PDF</button>
        </div>
    </div>

    <!-- Info Header Card -->
    <div class="header-card grid grid-cols-2 md:grid-cols-6 gap-6">
        <div>
            <div class="header-info-label">Trace Code</div>
            <div class="header-info-value ops-mono text-lg">TRC-2026-9921</div>
        </div>
        <div>
            <div class="header-info-label">Master PO</div>
            <div class="header-info-value ops-mono">PO-9912</div>
        </div>
        <div>
            <div class="header-info-label">Buyer</div>
            <div class="header-info-value">Nordic Apparel</div>
        </div>
        <div>
            <div class="header-info-label">Garment Style</div>
            <div class="header-info-value">STY-9012 (Men's Polo)</div>
        </div>
        <div>
            <div class="header-info-label">Total Pcs</div>
            <div class="header-info-value ops-mono">6,000</div>
        </div>
        <div>
            <div class="header-info-label">Status</div>
            <div class="header-info-value text-green-700 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                VERIFIED 100% COMPLETE
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Visual Audit Trail Timeline -->
        <div class="lg:col-span-1">
            <h3 class="text-lg font-bold mb-4">Visual Audit Trail</h3>
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-header"><span class="timeline-title">Fabric GRN Inward</span> <span class="ops-mono text-xs text-gray-500">GRN-2026-0881</span></div>
                    <div class="text-sm text-gray-600">Supplier: TexFab Mills</div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-header"><span class="timeline-title">4-Point Inspection</span> <span class="ops-mono text-xs text-gray-500">INSP-2026-014</span></div>
                    <div class="text-sm text-gray-600">Grade A</div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-header"><span class="timeline-title">Fabric Reserve</span> <span class="ops-mono text-xs text-gray-500">RES-2026-092</span></div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-header"><span class="timeline-title">Lay & Marker</span> <span class="ops-mono text-xs text-gray-500">LAY-2026-018</span></div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-header"><span class="timeline-title">Cutman Order</span> <span class="ops-mono text-xs text-gray-500">CUT-2026-042</span></div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-header"><span class="timeline-title">Number Bundling</span> <span class="ops-mono text-xs text-gray-500">BND-2026-0891</span></div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-header"><span class="timeline-title">Panel QC</span> <span class="ops-mono text-xs text-gray-500">AUD-2026-0104</span></div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-header"><span class="timeline-title">Super Market</span> <span class="ops-mono text-xs text-gray-500">BIN-A4-12</span></div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-header"><span class="timeline-title">Sewing Floor</span> <span class="ops-mono text-xs text-gray-500">Line 03</span></div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-header"><span class="timeline-title">In-line QC</span></div>
                    <div class="text-sm text-green-600 font-medium">Pass</div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-header"><span class="timeline-title">Spotwash</span></div>
                    <div class="text-sm text-gray-600">Cleaned</div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-header"><span class="timeline-title">Finishing</span></div>
                    <div class="text-sm text-gray-600">Pressed & Folded</div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-header"><span class="timeline-title">Final AQL QC</span> <span class="ops-mono text-xs text-gray-500">LOT-2026-088</span></div>
                    <div class="text-sm text-green-600 font-medium">PASS</div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-header"><span class="timeline-title">Packing</span> <span class="ops-mono text-xs text-gray-500">PACK-2026-0104</span></div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-header"><span class="timeline-title">Carton Warehouse</span> <span class="ops-mono text-xs text-gray-500">CTN-2026-042</span></div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-header"><span class="timeline-title">Container Dispatch</span> <span class="ops-mono text-xs text-gray-500">SHP-2026-019</span></div>
                </div>
            </div>
        </div>

        <!-- Technical Pedigree Data Matrix -->
        <div class="lg:col-span-2">
            <h3 class="text-lg font-bold mb-4">Technical Pedigree Data Matrix</h3>
            <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white">
                <table class="data-table w-full whitespace-nowrap">
                    <thead>
                        <tr>
                            <th>Stage Name</th>
                            <th>ID Code</th>
                            <th>Date & Time</th>
                            <th>Machine / Station</th>
                            <th>Operator / Auditor</th>
                            <th>Result / Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Rows -->
                        <tr>
                            <td>Fabric GRN Inward</td>
                            <td class="ops-mono">GRN-2026-0881</td>
                            <td class="ops-mono">2026-09-20 08:15 AM</td>
                            <td>Receiving Bay 1</td>
                            <td>John D.</td>
                            <td class="text-green-600 font-medium">Verified</td>
                        </tr>
                        <tr>
                            <td>4-Point Inspection</td>
                            <td class="ops-mono">INSP-2026-014</td>
                            <td class="ops-mono">2026-09-20 10:30 AM</td>
                            <td>Insp Machine 02</td>
                            <td>Maria S.</td>
                            <td>Grade A</td>
                        </tr>
                        <tr>
                            <td>Fabric Reserve</td>
                            <td class="ops-mono">RES-2026-092</td>
                            <td class="ops-mono">2026-09-21 07:00 AM</td>
                            <td>Rack B3</td>
                            <td>Storekeeper</td>
                            <td>Reserved</td>
                        </tr>
                        <tr>
                            <td>Lay & Marker</td>
                            <td class="ops-mono">LAY-2026-018</td>
                            <td class="ops-mono">2026-09-22 09:00 AM</td>
                            <td>CAD Station 1</td>
                            <td>Alex M.</td>
                            <td>Approved</td>
                        </tr>
                        <tr>
                            <td>Cutman Order</td>
                            <td class="ops-mono">CUT-2026-042</td>
                            <td class="ops-mono">2026-09-22 01:15 PM</td>
                            <td>Auto Cutter 03</td>
                            <td>David R.</td>
                            <td>Completed</td>
                        </tr>
                        <tr>
                            <td>Number Bundling</td>
                            <td class="ops-mono">BND-2026-0891</td>
                            <td class="ops-mono">2026-09-22 04:00 PM</td>
                            <td>Table 5</td>
                            <td>Sarah J.</td>
                            <td>Bundled</td>
                        </tr>
                        <tr>
                            <td>Panel QC</td>
                            <td class="ops-mono">AUD-2026-0104</td>
                            <td class="ops-mono">2026-09-23 08:30 AM</td>
                            <td>QC Station A</td>
                            <td>Emma W.</td>
                            <td class="text-green-600 font-medium">Pass</td>
                        </tr>
                        <tr>
                            <td>Super Market</td>
                            <td class="ops-mono">BIN-A4-12</td>
                            <td class="ops-mono">2026-09-23 11:00 AM</td>
                            <td>Bin A4-12</td>
                            <td>Logistics</td>
                            <td>Stored</td>
                        </tr>
                        <tr>
                            <td>Sewing Floor</td>
                            <td class="ops-mono">Line 03</td>
                            <td class="ops-mono">2026-09-24 07:30 AM</td>
                            <td>Line 03</td>
                            <td>Supervisor</td>
                            <td>In Progress</td>
                        </tr>
                        <tr>
                            <td>In-line QC</td>
                            <td class="ops-mono">-</td>
                            <td class="ops-mono">2026-09-24 10:45 AM</td>
                            <td>Line 03 QC</td>
                            <td>Jane L.</td>
                            <td class="text-green-600 font-medium">Pass</td>
                        </tr>
                        <tr>
                            <td>Spotwash</td>
                            <td class="ops-mono">-</td>
                            <td class="ops-mono">2026-09-24 02:20 PM</td>
                            <td>Wash Area 1</td>
                            <td>Tom H.</td>
                            <td>Cleaned</td>
                        </tr>
                        <tr>
                            <td>Finishing</td>
                            <td class="ops-mono">-</td>
                            <td class="ops-mono">2026-09-25 08:00 AM</td>
                            <td>Ironing St 04</td>
                            <td>Lisa K.</td>
                            <td>Pressed & Folded</td>
                        </tr>
                        <tr>
                            <td>Final AQL QC</td>
                            <td class="ops-mono">LOT-2026-088</td>
                            <td class="ops-mono">2026-09-25 11:30 AM</td>
                            <td>AQL Room</td>
                            <td>Auditor P.</td>
                            <td class="text-green-600 font-medium">PASS</td>
                        </tr>
                        <tr>
                            <td>Packing</td>
                            <td class="ops-mono">PACK-2026-0104</td>
                            <td class="ops-mono">2026-09-26 09:15 AM</td>
                            <td>Pack Line 2</td>
                            <td>Packer</td>
                            <td>Packed</td>
                        </tr>
                        <tr>
                            <td>Carton Warehouse</td>
                            <td class="ops-mono">CTN-2026-042</td>
                            <td class="ops-mono">2026-09-26 01:00 PM</td>
                            <td>Zone C</td>
                            <td>Storekeeper</td>
                            <td>Stored</td>
                        </tr>
                        <tr>
                            <td>Container Dispatch</td>
                            <td class="ops-mono">SHP-2026-019</td>
                            <td class="ops-mono">2026-09-27 10:00 AM</td>
                            <td>Bay 4</td>
                            <td>Logistics Mgr</td>
                            <td class="text-green-600 font-medium">Dispatched</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
