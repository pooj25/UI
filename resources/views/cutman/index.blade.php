@extends('layouts.app')
@section('title', 'Cut Orders')
@section('page-title', 'Cutting Planning & Orders')

@section('content')
<div class="section-header">
    <h4><i class="bi bi-scissors me-2" style="color:#0891b2;"></i>Cutting Orders</h4>
    <a href="{{ route('cutman.create') }}" class="btn btn-primary" style="background:linear-gradient(135deg,#0891b2,#06b6d4);border:none;">
        <i class="bi bi-plus-lg me-1"></i>New Cut Order
    </a>
</div>

{{-- Filters --}}
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                        placeholder="Cut Order No...">
                </div>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="planned"   {{ request('status')==='planned'   ? 'selected':'' }}>Planned</option>
                    <option value="cutting"   {{ request('status')==='cutting'   ? 'selected':'' }}>In Progress</option>
                    <option value="completed" {{ request('status')==='completed' ? 'selected':'' }}>Completed</option>
                </select>
            </div>
            <div class="col-auto d-flex gap-2">
                <button class="btn btn-primary">Filter</button>
                <a href="{{ route('cutman.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($cutOrders->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-scissors d-block mb-3" style="font-size:2.5rem;color:#cffafe;"></i>
                <p class="mb-1 fw-500">No Cut Orders yet</p>
                <small>Create a cut order from an issued fabric reservation.</small>
            </div>
        @else
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Cut Order No.</th>
                            <th>Reservation</th>
                            <th>Lay Model</th>
                            <th>Planned Qty</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($cutOrders as $co)
                        <tr>
                            <td><code style="color:#0891b2;font-size:0.82rem;">{{ $co->cut_order_no }}</code></td>
                            <td><span style="font-size:0.75rem;color:#6b7280;">{{ $co->fabricReservation?->reservation_no }}</span></td>
                            <td style="font-size:0.82rem;font-weight:500;">
                                {{ $co->layModel ? $co->layModel->lay_model_code : '—' }}
                            </td>
                            <td>{{ $co->planned_qty }}</td>
                            <td style="font-size:0.82rem;">{{ $co->planned_date->format('d M Y') }}</td>
                            <td>
                                <span style="background:{{ $co->statusColor() }}1a;color:{{ $co->statusColor() }};padding:.25rem .65rem;border-radius:20px;font-size:.72rem;font-weight:600;">
                                    {{ ucfirst($co->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('cutman.show', $co) }}" class="btn-action btn-view" title="View / Scan">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex align-items-center justify-content-between p-3">
                <small class="text-muted">Showing {{ $cutOrders->firstItem() }}–{{ $cutOrders->lastItem() }} of {{ $cutOrders->total() }}</small>
                {{ $cutOrders->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
