@extends('layouts.app')
@section('title', 'Spotwash Department')
@section('page-title', 'Spotwash Tracking')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0" style="font-weight:600;"><i class="bi bi-droplet me-2 text-info"></i>Items in Spotwash</h6>
        <a href="{{ route('spotwash.send') }}" class="btn btn-sm btn-info text-white" style="background:linear-gradient(135deg,#06b6d4,#0891b2);border:none;">
            <i class="bi bi-send me-1"></i> Send to Wash
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date Sent</th>
                        <th>Bundle No</th>
                        <th>Qty Sent</th>
                        <th>Stain Type</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($spotwashes as $wash)
                    <tr>
                        <td class="text-muted" style="font-size:0.85rem;">{{ $wash->created_at->format('d M Y, H:i') }}</td>
                        <td style="font-weight:700; color:#111827;">{{ $wash->bundle->bundle_no }}</td>
                        <td>{{ $wash->quantity_sent }}</td>
                        <td class="text-danger">{{ $wash->stain_type }}</td>
                        <td>
                            @if($wash->status == 'in_wash')
                                <span class="badge bg-warning text-dark">In Wash</span>
                            @elseif($wash->status == 'cleaned')
                                <span class="badge bg-success">Cleaned</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td class="text-end">
                            @if($wash->status == 'in_wash')
                                <form method="POST" action="{{ route('spotwash.cleaned', $wash) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-check2-circle"></i> Mark Clean
                                    </button>
                                </form>
                            @else
                                <span class="text-muted" style="font-size:0.85rem;">Completed</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No items currently in spotwash.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
