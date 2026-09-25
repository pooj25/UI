@extends('layouts.app')
@section('title', 'QR Scan')
@section('page-title', 'Scan QR Code')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">

        {{-- Scan / Search form --}}
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0" style="font-weight:600;">
                    <i class="bi bi-qr-code-scan me-2 text-primary"></i>Look Up a Roll by QR Code
                </h6>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('grn.scan') }}" class="d-flex gap-2">
                    <input type="text" name="qr" class="form-control"
                        value="{{ request('qr') }}"
                        placeholder="Scan or type QR code here… (e.g. GRN-0001:R-001:ABCDEF)"
                        autofocus>
                    <button type="submit" class="btn btn-primary" style="white-space:nowrap;">
                        <i class="bi bi-search me-1"></i>Look Up
                    </button>
                </form>
                <p class="text-muted mt-2 mb-0" style="font-size:.78rem;">
                    <i class="bi bi-info-circle me-1"></i>
                    Point a barcode scanner at a QR label — it will auto-type the code and search.
                </p>
            </div>
        </div>

        {{-- Result --}}
        @if(request('qr'))
            @if(!$roll)
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-exclamation-triangle-fill d-block mb-3" style="font-size:2.5rem;color:#f59e0b;"></i>
                        <h5 style="color:#92400e;">QR Code Not Found</h5>
                        <p class="text-muted mb-0" style="font-size:.875rem;">
                            No roll matched: <code>{{ request('qr') }}</code>
                        </p>
                    </div>
                </div>
            @else
                {{-- Roll Card --}}
                <div class="card" style="border:2px solid #0891b2;">
                    <div class="card-header" style="background:linear-gradient(135deg,#0891b2,#06b6d4);color:#fff;">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div style="font-size:.75rem;opacity:.8;">ROLL FOUND</div>
                                <h5 class="mb-0 fw-700">{{ $roll->roll_number }}</h5>
                            </div>
                            <span style="background:rgba(255,255,255,.2);padding:.3rem .8rem;border-radius:20px;font-size:.8rem;font-weight:600;">
                                {{ $roll->statusLabel() }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @php
                                $details = [
                                    'GRN Number'    => $roll->grn->grn_number,
                                    'Invoice'       => $roll->grn->invoice_number,
                                    'Supplier'      => $roll->grn->supplier_name,
                                    'Fabric'        => ($roll->grn->fabric?->fabric_code ?? '—') . ' — ' . ($roll->grn->fabric?->fabric_name ?? '—'),
                                    'Weight'        => $roll->roll_weight ? $roll->roll_weight . ' KG' : '—',
                                    'Length'        => $roll->roll_length ? $roll->roll_length . ' m'  : '—',
                                    'Width'         => $roll->actual_width ? $roll->actual_width . '"'  : '—',
                                    'Received Date' => $roll->grn->received_date->format('d M Y'),
                                    'Rack'          => $roll->grn->rack_location ?? '—',
                                ];
                            @endphp
                            @foreach($details as $label => $val)
                            <div class="col-md-6">
                                <div style="background:#f0f9ff;border-radius:8px;padding:.65rem .85rem;border:1px solid #bae6fd;">
                                    <div style="font-size:.68rem;color:#0891b2;font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:.15rem;">{{ $label }}</div>
                                    <div style="font-weight:600;color:#0c4a6e;font-size:.85rem;">{{ $val }}</div>
                                </div>
                            </div>
                            @endforeach

                            {{-- Inspection Result --}}
                            @if($roll->inspection)
                            <div class="col-12">
                                <div style="background:{{ $roll->inspection->overall_result==='Pass' ? 'rgba(16,185,129,.08)' : ($roll->inspection->overall_result==='Fail' ? 'rgba(239,68,68,.08)' : 'rgba(245,158,11,.08)') }};border-radius:10px;border:1px solid {{ $roll->inspection->overall_result==='Pass' ? '#6ee7b7' : ($roll->inspection->overall_result==='Fail' ? '#fca5a5' : '#fcd34d') }};padding:.85rem 1rem;">
                                    <div style="font-weight:600;font-size:.85rem;margin-bottom:.5rem;">
                                        Inspection Result:
                                        <span style="color:{{ $roll->inspection->overall_result==='Pass' ? '#059669' : ($roll->inspection->overall_result==='Fail' ? '#dc2626' : '#b45309') }};">
                                            {{ $roll->inspection->overall_result==='Pass' ? '✅' : ($roll->inspection->overall_result==='Fail' ? '❌' : '⚠️') }}
                                            {{ $roll->inspection->overall_result }}
                                        </span>
                                    </div>
                                    <div class="row g-2" style="font-size:.8rem;">
                                        <div class="col-4">Shade: <strong>{{ $roll->inspection->shade_result }}</strong></div>
                                        <div class="col-4">DHU: <strong>{{ $roll->inspection->dhu_percent }}%</strong></div>
                                        <div class="col-4">Inspector: <strong>{{ $roll->inspection->inspected_by }}</strong></div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="col-12">
                                <div class="d-flex align-items-center justify-content-between" style="background:#fffbeb;border:1px solid #fcd34d;border-radius:10px;padding:.75rem 1rem;">
                                    <span style="color:#92400e;font-size:.85rem;"><i class="bi bi-exclamation-circle me-2"></i>Not yet inspected</span>
                                    <a href="{{ route('grn.inspect-roll', $roll) }}" class="btn btn-sm btn-warning" style="font-size:.8rem;">
                                        <i class="bi bi-clipboard2-check me-1"></i>Inspect Now
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>

                        <hr class="mt-3 mb-2">
                        <div class="d-flex gap-2">
                            <a href="{{ route('grn.show', $roll->grn_id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye me-1"></i>View GRN
                            </a>
                            <a href="{{ route('grn.print-single-label', $roll) }}" target="_blank" class="btn btn-sm" style="background:rgba(16,185,129,.1);color:#059669;border:1px solid rgba(16,185,129,.3);">
                                <i class="bi bi-printer me-1"></i>Reprint Label
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        @else
            {{-- Empty state --}}
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-qr-code d-block mb-3" style="font-size:3rem;color:#c7d2fe;"></i>
                    <p class="text-muted mb-0">Scan a QR label or enter a QR code above to look up a fabric roll instantly.</p>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
// Auto-submit when scanner input completes (most scanners send Enter)
document.querySelector('input[name="qr"]').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') { e.preventDefault(); this.form.submit(); }
});
</script>
@endpush
@endsection
