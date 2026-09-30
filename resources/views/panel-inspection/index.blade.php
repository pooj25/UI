@extends('layouts.app')
@section('title', 'Panel Inspection Logs')
@section('page-title', 'Panel Inspection Logs')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0" style="font-weight:600;"><i class="bi bi-search me-2 text-primary"></i>Recent Panel Inspections</h6>
        <a href="{{ route('panel-inspection.create') }}" class="btn btn-sm btn-primary" style="background:linear-gradient(135deg,#f59e0b,#d97706);border:none;">
            <i class="bi bi-plus-lg me-1"></i> Record Inspection
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Cut Order</th>
                        <th>Inspector</th>
                        <th>Total Checked</th>
                        <th>Passed</th>
                        <th>Rejected</th>
                        <th>Defect Reason</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($inspections as $ins)
                    <tr>
                        <td class="text-muted" style="font-size:0.85rem;">{{ $ins->created_at->format('d M Y, H:i') }}</td>
                        <td style="font-weight:600; color:#111827;">{{ $ins->cutOrder->cut_order_no }}</td>
                        <td>{{ $ins->inspector_name }}</td>
                        <td>{{ $ins->total_panels_checked }}</td>
                        <td class="text-success" style="font-weight:600;">{{ $ins->panels_passed }}</td>
                        <td class="{{ $ins->panels_rejected > 0 ? 'text-danger' : 'text-muted' }}" style="font-weight:600;">{{ $ins->panels_rejected }}</td>
                        <td style="font-size:0.85rem;" class="text-danger">{{ $ins->defect_reason ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No panel inspections recorded yet.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
