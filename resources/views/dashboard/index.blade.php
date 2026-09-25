@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card stat-card-green">
            <div class="stat-icon" style="background:rgba(255,255,255,0.18);">
                <i class="bi bi-layers-fill text-white"></i>
            </div>
            <div class="stat-value">{{ $stats['total_fabrics'] }}</div>
            <div class="stat-label">Total Fabrics</div>
            <div class="mt-2" style="font-size:0.73rem;opacity:0.85;">
                <i class="bi bi-check-circle me-1"></i>{{ $stats['active_fabrics'] }} active
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card stat-card-teal">
            <div class="stat-icon" style="background:rgba(255,255,255,0.18);">
                <i class="bi bi-collection-fill text-white"></i>
            </div>
            <div class="stat-value">{{ $stats['total_fabric_groups'] }}</div>
            <div class="stat-label">Fabric Groups</div>
            <div class="mt-2" style="font-size:0.73rem;opacity:0.85;">
                <i class="bi bi-check-circle me-1"></i>{{ $stats['active_groups'] }} active
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card stat-card-slate">
            <div class="stat-icon" style="background:rgba(255,255,255,0.18);">
                <i class="bi bi-intersect text-white"></i>
            </div>
            <div class="stat-value">{{ $stats['total_lay_models'] }}</div>
            <div class="stat-label">Lay Models</div>
            <div class="mt-2" style="font-size:0.73rem;opacity:0.85;">
                <i class="bi bi-check-circle me-1"></i>{{ $stats['active_lay_models'] }} active
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card stat-card-amber">
            <div class="stat-icon" style="background:rgba(255,255,255,0.18);">
                <i class="bi bi-box-seam text-white"></i>
            </div>
            @php
                $grnCount  = \App\Models\Grn::count();
                $rollCount = \App\Models\GrnRoll::count();
            @endphp
            <div class="stat-value">{{ $grnCount }}</div>
            <div class="stat-label">GRNs Created</div>
            <div class="mt-2" style="font-size:0.73rem;opacity:0.85;">
                <i class="bi bi-stack me-1"></i>{{ $rollCount }} total rolls
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- Recent Fabrics --}}
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0" style="font-weight:600;">
                    <i class="bi bi-layers me-2" style="color:var(--primary);"></i>Recent Fabrics
                </h6>
                <a href="{{ route('fabrics.index') }}" class="btn btn-sm btn-outline-primary" style="font-size:0.75rem;">View All</a>
            </div>
            <div class="card-body p-0">
                @if($recentFabrics->isEmpty())
                    <div class="text-center py-4 text-muted" style="font-size:0.85rem;">
                        <i class="bi bi-inbox d-block mb-2" style="font-size:1.5rem;"></i>No fabrics yet
                    </div>
                @else
                    <table class="table mb-0">
                        <thead><tr>
                            <th>Code</th><th>Name</th><th>Type</th><th>Status</th>
                        </tr></thead>
                        <tbody>
                        @foreach($recentFabrics as $fabric)
                            <tr>
                                <td><code style="font-size:0.78rem;color:var(--primary);">{{ $fabric->fabric_code }}</code></td>
                                <td style="font-weight:500;font-size:0.82rem;">{{ $fabric->fabric_name }}</td>
                                <td><span style="font-size:0.75rem;color:#6b7280;">{{ $fabric->fabric_type }}</span></td>
                                <td>
                                    <span class="{{ $fabric->status === 'active' ? 'badge-active' : 'badge-inactive' }}">
                                        {{ ucfirst($fabric->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    {{-- Recent Lay Models --}}
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0" style="font-weight:600;">
                    <i class="bi bi-intersect me-2" style="color:#0f766e;"></i>Recent Lay Models
                </h6>
                <a href="{{ route('lay-models.index') }}" class="btn btn-sm btn-outline-primary" style="font-size:0.75rem;">View All</a>
            </div>
            <div class="card-body p-0">
                @if($recentLayModels->isEmpty())
                    <div class="text-center py-4 text-muted" style="font-size:0.85rem;">
                        <i class="bi bi-inbox d-block mb-2" style="font-size:1.5rem;"></i>No lay models yet
                    </div>
                @else
                    <table class="table mb-0">
                        <thead><tr>
                            <th>Code</th><th>Name</th><th>Group</th><th>Status</th>
                        </tr></thead>
                        <tbody>
                        @foreach($recentLayModels as $lm)
                            <tr>
                                <td><code style="font-size:0.78rem;color:#0f766e;">{{ $lm->lay_model_code }}</code></td>
                                <td style="font-weight:500;font-size:0.82rem;">{{ Str::limit($lm->lay_model_name, 22) }}</td>
                                <td><span style="font-size:0.75rem;color:#6b7280;">{{ $lm->fabricGroup?->group_code }}</span></td>
                                <td>
                                    <span class="{{ $lm->status === 'active' ? 'badge-active' : 'badge-inactive' }}">
                                        {{ ucfirst($lm->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="row g-3 mt-1">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0" style="font-weight:600;">
                    <i class="bi bi-lightning-charge-fill me-2" style="color:#d97706;"></i>Quick Actions
                </h6>
            </div>
            <div class="card-body d-flex gap-3 flex-wrap">
                <a href="{{ route('grn.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>New GRN
                </a>
                <a href="{{ route('fabrics.create') }}" class="btn btn-outline-primary">
                    <i class="bi bi-plus-lg me-1"></i>New Fabric
                </a>
                <a href="{{ route('fabric-groups.create') }}" class="btn btn-outline-primary">
                    <i class="bi bi-plus-lg me-1"></i>New Fabric Group
                </a>
                <a href="{{ route('lay-models.create') }}" class="btn btn-outline-primary">
                    <i class="bi bi-plus-lg me-1"></i>New Lay Model
                </a>
                <a href="{{ route('grn.scan') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-qr-code-scan me-1"></i>Scan QR
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
