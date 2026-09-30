@extends('layouts.app')
@section('title', 'Super Market (WIP)')
@section('page-title', 'Super Market (WIP)')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0" style="font-weight:600;"><i class="bi bi-shop me-2 text-primary"></i>Super Market Inventory</h6>
        <div>
            <a href="{{ route('supermarket.scan-in') }}" class="btn btn-sm btn-primary me-2" style="background:linear-gradient(135deg,#3b82f6,#2563eb);border:none;">
                <i class="bi bi-box-arrow-in-down me-1"></i> Scan In (Receive)
            </a>
            <a href="{{ route('supermarket.scan-out') }}" class="btn btn-sm btn-success" style="background:linear-gradient(135deg,#10b981,#059669);border:none;">
                <i class="bi bi-box-arrow-up me-1"></i> Scan Out (Issue)
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date Received</th>
                        <th>Bundle No</th>
                        <th>Bin Location</th>
                        <th>Size</th>
                        <th>Status</th>
                        <th>Issued To</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($superMarkets as $sm)
                    <tr>
                        <td class="text-muted" style="font-size:0.85rem;">{{ $sm->created_at->format('d M Y, H:i') }}</td>
                        <td style="font-weight:700; color:#111827;">{{ $sm->bundle->bundle_no }}</td>
                        <td><span class="badge bg-primary bg-opacity-10 text-primary">{{ $sm->bin_location }}</span></td>
                        <td>{{ $sm->bundle->size }}</td>
                        <td>
                            @if($sm->status == 'in_storage')
                                <span class="badge bg-warning text-dark">In Storage</span>
                            @else
                                <span class="badge bg-success">Issued</span>
                            @endif
                        </td>
                        <td class="text-muted">{{ $sm->issued_to_line ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Super market is currently empty.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
