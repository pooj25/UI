@extends('layouts.app')
@section('title', 'Sewing Production Logs')
@section('page-title', 'Sewing Production Logs')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0" style="font-weight:600;"><i class="bi bi-activity me-2 text-primary"></i>Recent Sewing Activity</h6>
        <a href="{{ route('sewing.scan') }}" class="btn btn-sm btn-primary" style="background:linear-gradient(135deg,#8b5cf6,#6d28d9);border:none;">
            <i class="bi bi-qr-code-scan me-1"></i> Scan Bundle
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Scan Time</th>
                        <th>Bundle No</th>
                        <th>Line & Operator</th>
                        <th>Operation</th>
                        <th>Passed</th>
                        <th>Rejected</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($productions as $prod)
                    <tr>
                        <td class="text-muted" style="font-size:0.85rem;">{{ $prod->scanned_at->format('d M Y, H:i') }}</td>
                        <td style="font-weight:600; color:#111827;">{{ $prod->bundle->bundle_no }} <span class="badge bg-secondary ms-1">{{ $prod->bundle->size }}</span></td>
                        <td>
                            <div><strong style="color:#4b5563;">{{ $prod->line_number }}</strong></div>
                            <div style="font-size:0.8rem; color:#6b7280;">{{ $prod->operator_name }}</div>
                        </td>
                        <td>{{ $prod->operation }}</td>
                        <td class="text-success" style="font-weight:600;">{{ $prod->qty_passed }}</td>
                        <td class="{{ $prod->qty_rejected > 0 ? 'text-danger' : 'text-muted' }}" style="font-weight:600;">{{ $prod->qty_rejected }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No sewing production logs recorded yet.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
