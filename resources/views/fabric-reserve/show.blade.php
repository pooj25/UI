@extends('layouts.app')
@section('title', 'Reservation ' . $fabricReserve->reservation_no)
@section('page-title', 'Reservation Details')

@section('content')
<div class="row g-3">
    {{-- Left: Details & Rolls --}}
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-0" style="font-weight:700;color:var(--primary);">{{ $fabricReserve->reservation_no }}</h6>
                    <small class="text-muted">Requested on {{ $fabricReserve->request_date->format('d M Y') }}</small>
                </div>
                <span style="background:{{ $fabricReserve->statusColor() }}1a;color:{{ $fabricReserve->statusColor() }};padding:.3rem .8rem;border-radius:20px;font-size:.8rem;font-weight:600;">
                    {{ ucfirst($fabricReserve->status) }}
                </span>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div style="font-size:.7rem;color:#6b7280;font-weight:600;text-transform:uppercase;">Requested By</div>
                        <div style="font-weight:600;color:#111827;">{{ $fabricReserve->requested_by }}</div>
                    </div>
                    <div class="col-md-4">
                        <div style="font-size:.7rem;color:#6b7280;font-weight:600;text-transform:uppercase;">Lay Model</div>
                        <div style="font-weight:600;color:#111827;">{{ $fabricReserve->layModel ? $fabricReserve->layModel->lay_model_code : '—' }}</div>
                    </div>
                    <div class="col-md-4">
                        <div style="font-size:.7rem;color:#6b7280;font-weight:600;text-transform:uppercase;">Rolls Attached</div>
                        <div style="font-weight:600;color:#111827;">{{ $fabricReserve->rolls->count() }}</div>
                    </div>
                    @if($fabricReserve->remarks)
                    <div class="col-12">
                        <div style="font-size:.7rem;color:#6b7280;font-weight:600;text-transform:uppercase;">Remarks</div>
                        <div style="font-size:.85rem;color:#374151;background:#f9fafb;padding:.5rem;border-radius:6px;">{{ $fabricReserve->remarks }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6 class="mb-0" style="font-weight:600;"><i class="bi bi-stack me-2" style="color:var(--primary);"></i>Attached Rolls</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Roll No.</th>
                                <th>Fabric</th>
                                <th>Weight (KG)</th>
                                <th>Length (m)</th>
                                <th>Current Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($fabricReserve->rolls as $i => $roll)
                            <tr>
                                <td class="text-muted" style="font-size:.75rem;">{{ $i+1 }}</td>
                                <td><code style="color:#0369a1;font-size:.82rem;">{{ $roll->roll_number }}</code></td>
                                <td style="font-weight:500;">{{ $roll->grn->fabric?->fabric_code }}</td>
                                <td>{{ $roll->roll_weight ?? '—' }}</td>
                                <td>{{ $roll->roll_length ?? '—' }}</td>
                                <td>
                                    <span style="background:{{ $roll->statusColor() }}1a;color:{{ $roll->statusColor() }};padding:.2rem .5rem;border-radius:4px;font-size:.7rem;font-weight:600;">
                                        {{ $roll->statusLabel() }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Right: Actions --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header"><h6 class="mb-0" style="font-weight:600;"><i class="bi bi-lightning-charge me-2 text-warning"></i>Store Actions</h6></div>
            <div class="card-body">
                @if($fabricReserve->status === 'pending')
                    <p class="text-muted" style="font-size:0.85rem;">Review the request. If everything is correct, approve it to reserve the rolls in the system.</p>
                    <form method="POST" action="{{ route('fabric-reserve.approve', $fabricReserve) }}" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100" style="background:linear-gradient(135deg, #2563eb, #3b82f6);border:none;">
                            <i class="bi bi-check-circle me-1"></i>Approve & Reserve
                        </button>
                    </form>
                @elseif($fabricReserve->status === 'approved')
                    <p class="text-muted" style="font-size:0.85rem;">Rolls are currently reserved. When they are physically moved to the cutting floor, issue them.</p>
                    <form method="POST" action="{{ route('fabric-reserve.issue', $fabricReserve) }}" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100" style="background:linear-gradient(135deg, #059669, #10b981);border:none;">
                            <i class="bi bi-box-arrow-right me-1"></i>Issue to Cutting
                        </button>
                    </form>
                @elseif($fabricReserve->status === 'issued')
                    <div class="alert alert-success py-2 mb-0" style="font-size:0.85rem;">
                        <i class="bi bi-check-circle-fill me-2"></i>Rolls have been issued to the cutting department.
                    </div>
                @elseif($fabricReserve->status === 'cancelled')
                    <div class="alert alert-danger py-2 mb-0" style="font-size:0.85rem;">
                        <i class="bi bi-x-circle-fill me-2"></i>This reservation is cancelled.
                    </div>
                @endif

                @if(in_array($fabricReserve->status, ['pending', 'approved']))
                    <hr>
                    <form method="POST" action="{{ route('fabric-reserve.cancel', $fabricReserve) }}" onsubmit="return confirm('Are you sure you want to cancel this reservation?');">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100 btn-sm">
                            <i class="bi bi-x-circle me-1"></i>Cancel Reservation
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
