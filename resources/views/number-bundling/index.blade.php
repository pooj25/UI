@extends('layouts.app')
@section('title', 'Number Bundling')
@section('page-title', 'Number Bundling')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0" style="font-weight:600;"><i class="bi bi-collection me-2 text-primary"></i>Ready for Bundling</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Cut Order No</th>
                        <th>Lay Model</th>
                        <th>Status</th>
                        <th>Bundles Generated</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($cutOrders as $order)
                    <tr>
                        <td style="font-weight:600; color:#111827;">{{ $order->cut_order_no }}</td>
                        <td>{{ $order->layModel?->lay_model_code ?? '—' }}</td>
                        <td>
                            @if($order->bundles->count() > 0)
                                <span class="badge bg-success">Bundled</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        <td>{{ $order->bundles->count() }} bundles</td>
                        <td class="text-end">
                            @if($order->bundles->count() == 0)
                                <a href="{{ route('number-bundling.create', $order) }}" class="btn btn-sm btn-primary" style="background:linear-gradient(135deg,#0ea5e9,#0284c7);border:none;">
                                    Generate Bundles
                                </a>
                            @else
                                <a href="{{ route('number-bundling.print-qr', $order) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-printer me-1"></i> Print QR Tags
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No completed cut orders available for bundling.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
