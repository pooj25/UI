@extends('layouts.app')
@section('title', 'Fabric Reservations')
@section('page-title', 'Fabric Reservations')

@section('content')
<div class="section-header">
    <h4><i class="bi bi-cart me-2" style="color:var(--primary);"></i>Fabric Reservations</h4>
    <a href="{{ route('fabric-reserve.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>New Reservation
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
                        placeholder="Reservation No, Requested By...">
                </div>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="pending"   {{ request('status')==='pending'   ? 'selected':'' }}>Pending</option>
                    <option value="approved"  {{ request('status')==='approved'  ? 'selected':'' }}>Approved</option>
                    <option value="issued"    {{ request('status')==='issued'    ? 'selected':'' }}>Issued</option>
                    <option value="cancelled" {{ request('status')==='cancelled' ? 'selected':'' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-auto d-flex gap-2">
                <button class="btn btn-primary">Filter</button>
                <a href="{{ route('fabric-reserve.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($reservations->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-cart-x d-block mb-3" style="font-size:2.5rem;color:#d1d5db;"></i>
                <p class="mb-1 fw-500">No Reservations yet</p>
                <small>Create a reservation to request fabric for cutting.</small>
            </div>
        @else
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Reservation No.</th>
                            <th>Lay Model</th>
                            <th>Requested By</th>
                            <th>Date</th>
                            <th>Rolls</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($reservations as $res)
                        <tr>
                            <td><code style="color:var(--primary);font-size:0.82rem;">{{ $res->reservation_no }}</code></td>
                            <td style="font-size:0.82rem;font-weight:500;">
                                {{ $res->layModel ? $res->layModel->lay_model_code : '—' }}
                            </td>
                            <td>{{ $res->requested_by }}</td>
                            <td style="font-size:0.82rem;">{{ $res->request_date->format('d M Y') }}</td>
                            <td>
                                <span class="badge" style="background:#e0f2fe;color:#0369a1;font-size:0.75rem;padding:0.25rem 0.65rem;border-radius:20px;">
                                    {{ $res->rolls->count() }} roll(s)
                                </span>
                            </td>
                            <td>
                                <span style="background:{{ $res->statusColor() }}1a;color:{{ $res->statusColor() }};padding:.25rem .65rem;border-radius:20px;font-size:.72rem;font-weight:600;">
                                    {{ ucfirst($res->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('fabric-reserve.show', $res) }}" class="btn-action btn-view" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex align-items-center justify-content-between p-3">
                <small class="text-muted">Showing {{ $reservations->firstItem() }}–{{ $reservations->lastItem() }} of {{ $reservations->total() }}</small>
                {{ $reservations->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
