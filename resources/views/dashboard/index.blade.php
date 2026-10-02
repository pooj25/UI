@extends('layouts.app')
@section('title', 'Control Room')
@section('page-title', 'Control Room')

@push('styles')
<style>
    .command-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid var(--border-color);
        border-radius: 18px;
        padding: 1.15rem 1.35rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
    }
    .eyebrow {
        color: var(--primary);
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        font-weight: 700;
        margin-bottom: 0.3rem;
    }
    .command-header h4 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--text-main);
    }
    .header-right {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        flex-wrap: wrap;
        justify-content: flex-end;
    }
    .header-time {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        font-size: 0.8rem;
        color: var(--text-muted);
        background: rgba(148, 163, 184, 0.08);
        border: 1px solid rgba(148, 163, 184, 0.18);
        border-radius: 999px;
        padding: 0.55rem 0.8rem;
        font-weight: 600;
    }
    .scan-btn {
        background: linear-gradient(135deg, var(--text-main) 0%, #334155 100%);
        color: #fff;
        padding: 0.72rem 1.25rem;
        border-radius: 10px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 10px 18px rgba(15, 23, 42, 0.12);
    }
    .scan-btn:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 14px 22px rgba(15, 23, 42, 0.12);
    }

    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1.2rem;
        margin-bottom: 1.5rem;
    }
    .kpi-card {
        position: relative;
        overflow: hidden;
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.15rem 1.2rem 1rem;
        box-shadow: 0 10px 20px rgba(15, 23, 42, 0.03);
    }
    .kpi-card::before {
        content: "";
        position: absolute;
        inset: 0 auto 0 0;
        width: 4px;
        background: var(--primary);
        border-radius: 16px 0 0 16px;
    }
    .kpi-card.primary::before { background: linear-gradient(180deg, #34d399 0%, #15803d 100%); }
    .kpi-card.warning::before { background: linear-gradient(180deg, #fbbf24 0%, #d97706 100%); }
    .kpi-card.danger::before { background: linear-gradient(180deg, #f87171 0%, #dc2626 100%); }
    .kpi-card.accent::before { background: linear-gradient(180deg, #60a5fa 0%, #2563eb 100%); }
    .kpi-top {
        display: flex; align-items: center; justify-content: space-between; gap: 0.75rem;
        margin-bottom: 0.9rem;
    }
    .kpi-label {
        font-size: 0.73rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.08em;
        line-height: 1.4;
    }
    .kpi-icon {
        display: inline-flex;
        width: 38px;
        height: 38px;
        border-radius: 12px;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        background: rgba(21, 128, 61, 0.09);
        color: var(--primary);
    }
    .kpi-card.warning .kpi-icon { background: rgba(217, 119, 6, 0.08); color: #b45309; }
    .kpi-card.danger .kpi-icon { background: rgba(220, 38, 38, 0.08); color: #b91c1c; }
    .kpi-card.accent .kpi-icon { background: rgba(37, 99, 235, 0.08); color: #1d4ed8; }
    .kpi-val {
        font-size: clamp(1.6rem, 2vw, 2.2rem);
        font-weight: 800;
        color: var(--text-main);
        font-family: var(--ops-mono);
        line-height: 1.2;
        margin-bottom: 0.35rem;
    }
    .kpi-sub {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.75rem;
        color: var(--primary);
        font-weight: 700;
    }
    .kpi-card.warning .kpi-sub { color: #b45309; }
    .kpi-card.danger .kpi-sub { color: #b91c1c; }

    .workflow-strip {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 0.85rem;
        background: linear-gradient(180deg, rgba(255,255,255,0.95), rgba(248,250,252,0.9));
        border: 1px solid var(--border-color);
        border-radius: 18px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 8px 18px rgba(15, 23, 42, 0.03);
    }
    .workflow-step {
        position: relative;
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 0.9rem 0.8rem;
        text-align: center;
    }
    .workflow-step.active {
        border-color: rgba(21, 128, 61, 0.2);
        background: linear-gradient(180deg, rgba(220,252,231,0.6), rgba(255,255,255,1));
    }
    .workflow-step::before {
        content: "";
        width: 10px;
        height: 10px;
        display: block;
        margin: 0 auto 0.6rem;
        border-radius: 50%;
        background: linear-gradient(180deg, #a7f3d0, #22c55e);
        box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.12);
    }
    .workflow-step-title {
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 0.3rem;
    }
    .workflow-step-val {
        font-size: 1.45rem;
        font-weight: 800;
        color: var(--text-main);
        font-family: var(--ops-mono);
        margin-bottom: 0.1rem;
    }
    .workflow-step-meta {
        color: var(--text-muted);
        font-size: 0.7rem;
        font-weight: 600;
    }

    .ops-badge {
        padding: 0.38rem 0.65rem;
        border-radius: 999px;
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        border: 1px solid transparent;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .badge-available { background: #ecfdf5; color: #166534; border-color: #bbf7d0; }
    .badge-reserved { background: #fffbeb; color: #b45309; border-color: #fde68a; }
    .badge-qc-hold { background: #fff7ed; color: #c2410c; border-color: #fed7aa; }
    .badge-qc-fail { background: #fef2f2; color: #b91c1c; border-color: #fecaca; }
    .badge-in-process { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
    .badge-closed { background: #f1f5f9; color: #475569; border-color: #e2e8f0; }

    .font-mono { font-family: var(--ops-mono); font-variant-numeric: tabular-nums; }
    .section-title {
        font-size: 1rem;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .section-title .badge {
        padding: 0.45rem 0.7rem;
        border-radius: 999px;
        font-size: 0.7rem;
    }

    @media (max-width: 1024px) {
        .kpi-grid { grid-template-columns: repeat(2, 1fr); }
        .workflow-strip { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 640px) {
        .command-header { flex-direction: column; align-items: flex-start; }
        .header-right { width: 100%; justify-content: space-between; }
        .kpi-grid, .workflow-strip { grid-template-columns: 1fr; }
        .command-header h4 { font-size: 1.45rem; }
    }
</style>
@endpush

@section('page-title', 'Control Room')

@section('content')
<div class="command-header">
    <div>
        <div class="eyebrow">Operations command center</div>
        <h4>Today's Operations</h4>
    </div>
    <div class="header-right">
        <div class="header-time">
            <i class="bi bi-clock-history"></i>
            {{ now()->format('D, M d • H:i') }}
        </div>
        <a href="{{ route('grn.scan') }}" class="scan-btn">
            <i class="bi bi-upc-scan"></i> Universal Scan
        </a>
    </div>
</div>

<div class="kpi-grid">
    <div class="kpi-card primary">
        <div class="kpi-top">
            <div class="kpi-label">Available Fabric (m)</div>
            <span class="kpi-icon"><i class="bi bi-boxes"></i></span>
        </div>
        <div class="kpi-val">12,450.00</div>
        <div class="kpi-sub"><i class="bi bi-arrow-up-right"></i> +450m received today</div>
    </div>
    <div class="kpi-card warning">
        <div class="kpi-top">
            <div class="kpi-label">Reserved Fabric (m)</div>
            <span class="kpi-icon"><i class="bi bi-pin-angle"></i></span>
        </div>
        <div class="kpi-val">8,200.50</div>
        <div class="kpi-sub"><i class="bi bi-arrow-right"></i> Active allocations</div>
    </div>
    <div class="kpi-card danger">
        <div class="kpi-top">
            <div class="kpi-label">Rolls in QC</div>
            <span class="kpi-icon"><i class="bi bi-shield-exclamation"></i></span>
        </div>
        <div class="kpi-val">24</div>
        <div class="kpi-sub"><i class="bi bi-exclamation-circle"></i> 3 pending action</div>
    </div>
    <div class="kpi-card accent">
        <div class="kpi-top">
            <div class="kpi-label">Bundles Waiting Sewing</div>
            <span class="kpi-icon"><i class="bi bi-clipboard-check"></i></span>
        </div>
        <div class="kpi-val">3,150</div>
        <div class="kpi-sub"><i class="bi bi-check-circle"></i> In Super Market</div>
    </div>
</div>

<div class="workflow-strip">
    <div class="workflow-step active">
        <div class="workflow-step-title">Received</div>
        <div class="workflow-step-val">42</div>
        <div class="workflow-step-meta">Rolls</div>
    </div>
    <div class="workflow-step">
        <div class="workflow-step-title">QC</div>
        <div class="workflow-step-val">38</div>
        <div class="workflow-step-meta">Inspected</div>
    </div>
    <div class="workflow-step">
        <div class="workflow-step-title">Cut</div>
        <div class="workflow-step-val">124</div>
        <div class="workflow-step-meta">Bundles</div>
    </div>
    <div class="workflow-step">
        <div class="workflow-step-title">Sewing</div>
        <div class="workflow-step-val">85</div>
        <div class="workflow-step-meta">Out</div>
    </div>
    <div class="workflow-step">
        <div class="workflow-step-title">Packed</div>
        <div class="workflow-step-val">60</div>
        <div class="workflow-step-meta">Ready</div>
    </div>
</div>

<div class="row">
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
                            <td class="font-mono">--</td>
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