@extends('layouts.app')
@section('title', 'Packing Cartons')
@section('page-title', 'Packing Cartons')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0" style="font-weight:600;"><i class="bi bi-box-seam me-2 text-primary"></i>Packed Cartons</h6>
        <a href="{{ route('packing.scan') }}" class="btn btn-sm btn-primary" style="background:linear-gradient(135deg,#10b981,#059669);border:none;">
            <i class="bi bi-upc-scan me-1"></i> Scan to Pack
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Carton No</th>
                        <th>Bundle Source</th>
                        <th>Size</th>
                        <th>Qty Packed</th>
                        <th>Packed By</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($packings as $pack)
                    <tr>
                        <td class="text-muted" style="font-size:0.85rem;">{{ $pack->created_at->format('d M Y, H:i') }}</td>
                        <td style="font-weight:700; color:#111827;">{{ $pack->carton_number }}</td>
                        <td class="text-muted" style="font-size:0.85rem;">{{ $pack->bundle->bundle_no }}</td>
                        <td><span class="badge bg-secondary">{{ $pack->size }}</span></td>
                        <td style="font-weight:600;">{{ $pack->quantity_packed }}</td>
                        <td>{{ $pack->packed_by }}</td>
                        <td class="text-end">
                            <a href="{{ route('packing.print-qr', $pack) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-printer"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No cartons packed yet.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
