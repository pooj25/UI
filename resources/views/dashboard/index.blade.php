@extends('layouts.app')
@section('title', 'Control Room')
@section('page-title', 'Control Room')

@push('styles')
<style>
    .kpi-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; margin-bottom: 1.5rem; }
    .kpi-card { background: #fff; border: 1px solid var(--border-color); border-radius: 8px; padding: 1.25rem; box-shadow: 0 1px 2px rgba(0,0,0,0.02); }
    .kpi-label { font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; }
    .kpi-val { font-size: 2rem; font-weight: 700; color: var(--text-main); font-family: var(--ops-mono); }
    .kpi-sub { font-size: 0.75rem; color: var(--primary); font-weight: 600; margin-top: 0.25rem; }

    .workflow-strip { display: flex; align-items: center; background: #fff; border: 1px solid var(--border-color); border-radius: 8px; overflow: hidden; margin-bottom: 1.5rem; }
    .workflow-step { flex: 1; padding: 1rem; border-right: 1px solid var(--border-color); text-align: center; }
    .workflow-step:last-child { border-right: none; }
    .workflow-step-title { font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.25rem; }
    .workflow-step-val { font-size: 1.1rem; font-weight: 700; color: var(--text-main); font-family: var(--ops-mono); }

    .scan-btn { background: var(--text-main); color: #fff; padding: 0.5rem 1.25rem; border-radius: 6px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; transition: background 0.2s; }
    .scan-btn:hover { background: #0f172a; color: #fff; }

    .ops-badge { padding: 0.35rem 0.65rem; border-radius: 4px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.03em; border: 1px solid transparent; }
    .badge-available { background: #f0fdf4; color: #166534; border-color: #bbf7d0; }
    .badge-reserved { background: #fffbeb; color: #b45309; border-color: #fde68a; }
    .badge-qc-hold { background: #fef2f2; color: #991b1b; border-color: #fecaca; }
    .badge-qc-fail { background: #fee2e2; color: #b91c1c; border-color: #fca5a5; }
    .badge-in-process { background: #eff6ff; color: #1e40af; border-color: #bfdbfe; }
    .badge-closed { background: #f1f5f9; color: #475569; border-color: #e2e8f0; }

    .font-mono { font-family: var(--ops-mono); font-variant-numeric: tabular-nums; }
    .section-title { font-size: 1rem; font-weight: 700; color: var(--text-main); margin-bottom: 1rem; display: flex; justify-content: space-between; align-items: center; }
    
    @media (max-width: 1024px) {
        .kpi-grid { grid-template-columns: repeat(2, 1fr); }
        .workflow-strip { flex-direction: column; }
        .workflow-step { border-right: none; border-bottom: 1px solid var(--border-color); width: 100%; }
        .workflow-step:last-child { border-bottom: none; }
    }
</style>
@endpush

@section('page-title', 'Control Room')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold" style="color:var(--text-main);">Today's Operations</h4>
        <div class="text-muted font-mono mt-1" style="font-size:0.8rem;">{{ now()->format('Y-m-d H:i') }}</div>
    </div>
    <div>
        <a href="{{ route('grn.scan') }}" class="scan-btn">
            <i class="bi bi-upc-scan"></i> Universal Scan
        </a>
    </div>
</div>

<!-- KPI Cards -->
<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-label">Available Fabric (m)</div>
        <div class="kpi-val">12,450.00</div> <!-- Mocked data per spec for UI demo -->
        <div class="kpi-sub"><i class="bi bi-arrow-up-right"></i> +450m received today</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Reserved Fabric (m)</div>
        <div class="kpi-val">8,200.50</div>
        <div class="kpi-sub" style="color:#b45309;"><i class="bi bi-arrow-right"></i> Active allocations</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Rolls in QC</div>
        <div class="kpi-val">24</div>
        <div class="kpi-sub" style="color:#b91c1c;"><i class="bi bi-exclamation-circle"></i> 3 pending action</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Bundles Waiting Sewing (pcs)</div>
        <div class="kpi-val">3,150</div>
        <div class="kpi-sub"><i class="bi bi-check-circle"></i> In Super Market</div>
    </div>
</div>

<!-- Workflow Strip -->
<div class="workflow-strip">
    <div class="workflow-step">
        <div class="workflow-step-title">Received (Rolls)</div>
        <div class="workflow-step-val">42</div>
    </div>
    <div class="workflow-step">
        <div class="workflow-step-title">QC Inspected</div>
        <div class="workflow-step-val">38</div>
    </div>
    <div class="workflow-step">
        <div class="workflow-step-title">Cut (Bundles)</div>
        <div class="workflow-step-val">124</div>
    </div>
    <div class="workflow-step">
        <div class="workflow-step-title">Sewing Out</div>
        <div class="workflow-step-val">85</div>
    </div>
    <div class="workflow-step">
        <div class="workflow-step-title">Packed</div>
        <div class="workflow-step-val">60</div>
    </div>
</div>

<div class="row">
    <!-- Exception Queue -->
    <div class="col-lg-12 mb-4">
        <div class="section-title">
            <span>Exception Queue</span>
            <span class="badge bg-danger text-white">4 Pending</span>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Process</th>
                            <th>ID</th>
                            <th>Style / PO</th>
                            <th>Issue</th>
                            <th>Owner</th>
                            <th>Age</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Mock data for UI demonstration as backend doesn't provide this yet -->
                        <tr>
                            <td class="font-mono text-muted">08:15</td>
                            <td><span class="ops-badge badge-qc-fail">QC Fail</span></td>
                            <td class="font-mono text-primary fw-bold">RL-40912</td>
                            <td>PO-2099 / Style-A</td>
                            <td class="fw-bold text-danger">Color shading variant</td>
                            <td>QC Team</td>
                            <td class="font-mono text-muted">2h 10m</td>
                        </tr>
                        <tr>
                            <td class="font-mono text-muted">09:30</td>
                            <td><span class="ops-badge badge-qc-hold">QC Hold</span></td>
                            <td class="font-mono text-primary fw-bold">RL-40915</td>
                            <td>PO-2104 / Style-B</td>
                            <td class="fw-bold text-warning">Width shortage</td>
                            <td>Manager</td>
                            <td class="font-mono text-muted">55m</td>
                        </tr>
                        <tr>
                            <td class="font-mono text-muted">10:05</td>
                            <td><span class="ops-badge badge-reserved">Reserved</span></td>
                            <td class="font-mono text-primary fw-bold">BNDL-001</td>
                            <td>PO-2099 / Style-A</td>
                            <td class="fw-bold text-warning">Missing components</td>
                            <td>Trim Store</td>
                            <td class="font-mono text-muted">20m</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Today's Fabric Receipts (Using Real Data where possible) -->
    <div class="col-lg-12">
        <div class="section-title">
            <span>Today's Fabric Receipts</span>
            <a href="{{ route('grn.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Receipt Date</th>
                            <th>Fabric Code</th>
                            <th>Fabric Name</th>
                            <th>Total Rolls</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentFabrics as $fabric)
                        <tr>
                            <td class="font-mono text-muted">{{ $fabric->created_at->format('Y-m-d') }}</td>
                            <td class="font-mono text-primary fw-bold">{{ $fabric->fabric_code }}</td>
                            <td class="fw-bold">{{ $fabric->fabric_name }}</td>
                            <td class="font-mono">--</td> <!-- Field doesn't exist directly on Fabric model without relationship loading -->
                            <td>
                                @if($fabric->status === 'active')
                                    <span class="ops-badge badge-available">Available</span>
                                @else
                                    <span class="ops-badge badge-closed">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No recent fabric receipts.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
