@extends('layouts.app')
@section('title', 'GRN — Goods Receipt Note')
@section('page-title', 'GRN — Goods Receipt Note')

@section('content')
<div class="section-header">
    <h4><i class="bi bi-box-seam me-2" style="color:#0891b2;"></i>Goods Receipt Notes</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('grn.scan') }}" class="btn btn-outline-primary">
            <i class="bi bi-qr-code-scan me-1"></i>Scan QR
        </a>
        <a href="{{ route('grn.create') }}" class="btn btn-primary" style="background:linear-gradient(135deg,#0891b2,#06b6d4);border-color:#0891b2;">
            <i class="bi bi-plus-lg me-1"></i>New GRN
        </a>
    </div>
</div>

{{-- Summary Cards --}}
<div class="row g-3 mb-4">
    @php
        $total      = \App\Models\Grn::count();
        $open       = \App\Models\Grn::where('status','open')->count();
        $rollsTotal = \App\Models\GrnRoll::count();
        $inStock    = \App\Models\GrnRoll::where('status','in_stock')->count();
        $pending    = \App\Models\GrnRoll::where('status','pending_inspection')->count();
    @endphp
    <div class="col-md-3">
        <div class="card text-center py-3">
            <div style="font-size:1.8rem;font-weight:700;color:#0891b2;">{{ $total }}</div>
            <div style="font-size:0.78rem;color:#6b7280;font-weight:600;">Total GRNs</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center py-3">
            <div style="font-size:1.8rem;font-weight:700;color:#10b981;">{{ $rollsTotal }}</div>
            <div style="font-size:0.78rem;color:#6b7280;font-weight:600;">Total Rolls</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center py-3">
            <div style="font-size:1.8rem;font-weight:700;color:#10b981;">{{ $inStock }}</div>
            <div style="font-size:0.78rem;color:#6b7280;font-weight:600;">In Stock</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center py-3">
            <div style="font-size:1.8rem;font-weight:700;color:#f59e0b;">{{ $pending }}</div>
            <div style="font-size:0.78rem;color:#6b7280;font-weight:600;">Pending Inspection</div>
        </div>
    </div>
</div>

{{-- Filters --}}
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                        placeholder="GRN number, invoice, supplier...">
                </div>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All</option>
                    <option value="open"      {{ request('status')==='open'      ? 'selected':'' }}>Open</option>
                    <option value="closed"    {{ request('status')==='closed'    ? 'selected':'' }}>Closed</option>
                    <option value="cancelled" {{ request('status')==='cancelled' ? 'selected':'' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-auto d-flex gap-2">
                <button class="btn btn-primary">Filter</button>
                <a href="{{ route('grn.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($grns->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-box-seam d-block mb-3" style="font-size:2.5rem;color:#a5f3fc;"></i>
                <p class="mb-1 fw-500">No GRNs yet</p>
                <small>Create a GRN when fabric rolls arrive from the supplier.</small>
                <div class="mt-3">
                    <a href="{{ route('grn.create') }}" class="btn btn-sm" style="background:#0891b2;color:#fff;">
                        <i class="bi bi-plus-lg me-1"></i>Create GRN
                    </a>
                </div>
            </div>
        @else
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>GRN No.</th>
                            <th>Invoice No.</th>
                            <th>Supplier</th>
                            <th>Fabric</th>
                            <th>Date</th>
                            <th>Rolls</th>
                            <th>Rack</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($grns as $grn)
                        <tr>
                            <td><code style="color:#0891b2;font-size:0.82rem;">{{ $grn->grn_number }}</code></td>
                            <td style="font-size:0.82rem;">{{ $grn->invoice_number }}</td>
                            <td style="font-weight:500;">{{ $grn->supplier_name }}</td>
                            <td>
                                <span style="font-size:0.78rem;color:#4f46e5;">
                                    {{ $grn->fabric?->fabric_code }}
                                </span>
                            </td>
                            <td style="font-size:0.82rem;">{{ $grn->received_date->format('d M Y') }}</td>
                            <td>
                                <span class="badge" style="background:#e0f2fe;color:#0891b2;font-size:0.75rem;padding:0.25rem 0.65rem;border-radius:20px;">
                                    {{ $grn->rolls_count }} roll{{ $grn->rolls_count != 1 ? 's' : '' }}
                                </span>
                            </td>
                            <td style="font-size:0.82rem;color:#6b7280;">{{ $grn->rack_location ?? '—' }}</td>
                            <td>
                                @php
                                    $sc = ['open'=>'#10b981','closed'=>'#6b7280','cancelled'=>'#ef4444'];
                                    $sbg= ['open'=>'rgba(16,185,129,.1)','closed'=>'rgba(107,114,128,.1)','cancelled'=>'rgba(239,68,68,.1)'];
                                @endphp
                                <span style="background:{{ $sbg[$grn->status]??'#eee' }};color:{{ $sc[$grn->status]??'#333' }};padding:.25rem .65rem;border-radius:20px;font-size:.72rem;font-weight:600;">
                                    {{ ucfirst($grn->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('grn.show', $grn) }}" class="btn-action btn-view" title="View"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('grn.print-labels', $grn) }}" class="btn-action" title="Print Labels"
                                       style="background:rgba(16,185,129,.1);color:#059669;" target="_blank">
                                        <i class="bi bi-printer"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex align-items-center justify-content-between p-3">
                <small class="text-muted">Showing {{ $grns->firstItem() }}–{{ $grns->lastItem() }} of {{ $grns->total() }} GRNs</small>
                {{ $grns->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
