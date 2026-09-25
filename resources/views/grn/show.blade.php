@extends('layouts.app')
@section('title', $grn->grn_number)
@section('page-title', $grn->grn_number)

@section('content')
<div class="row g-3">
    {{-- Left: GRN Info + Rolls --}}
    <div class="col-lg-8">

        {{-- GRN Header Card --}}
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-0" style="font-weight:700;">{{ $grn->grn_number }}</h6>
                    <small class="text-muted">Invoice: {{ $grn->invoice_number }}</small>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('grn.print-labels', $grn) }}" target="_blank"
                       class="btn btn-sm" style="background:rgba(16,185,129,.1);color:#059669;border:1px solid rgba(16,185,129,.3);">
                        <i class="bi bi-printer me-1"></i>Print All QR Labels
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @php
                        $info = [
                            'Supplier'      => $grn->supplier_name,
                            'Fabric'        => $grn->fabric?->fabric_code . ' — ' . $grn->fabric?->fabric_name,
                            'Received Date' => $grn->received_date->format('d M Y'),
                            'Rack Location' => $grn->rack_location ?? '—',
                        ];
                    @endphp
                    @foreach($info as $label => $val)
                    <div class="col-md-6">
                        <div style="background:#f0f9ff;border-radius:10px;padding:.75rem 1rem;border:1px solid #bae6fd;">
                            <div style="font-size:.7rem;color:#6b7280;font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:.2rem;">{{ $label }}</div>
                            <div style="font-weight:600;color:#0c4a6e;font-size:.875rem;">{{ $val }}</div>
                        </div>
                    </div>
                    @endforeach
                    @if($grn->remarks)
                    <div class="col-12">
                        <div style="background:#f0f9ff;border-radius:10px;padding:.75rem 1rem;border:1px solid #bae6fd;">
                            <div style="font-size:.7rem;color:#6b7280;font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:.2rem;">Remarks</div>
                            <div style="font-size:.875rem;color:#374151;">{{ $grn->remarks }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Rolls Table --}}
        <div class="card mt-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0" style="font-weight:600;">
                    <i class="bi bi-stack me-2" style="color:#0891b2;"></i>Rolls
                    <span class="badge ms-1" style="background:#e0f2fe;color:#0891b2;font-size:.75rem;">{{ $grn->rolls->count() }}</span>
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Roll No.</th>
                                <th>Weight (KG)</th>
                                <th>Length (m)</th>
                                <th>Width (in)</th>
                                <th>Status</th>
                                <th>Inspection</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($grn->rolls as $i => $roll)
                            <tr>
                                <td class="text-muted" style="font-size:.78rem;">{{ $i+1 }}</td>
                                <td><code style="color:#0891b2;font-size:.82rem;">{{ $roll->roll_number }}</code></td>
                                <td>{{ $roll->roll_weight ?? '—' }}</td>
                                <td>{{ $roll->roll_length ?? '—' }}</td>
                                <td>{{ $roll->actual_width ?? '—' }}</td>
                                <td>
                                    <span style="background:{{ $roll->statusColor() }}1a;color:{{ $roll->statusColor() }};padding:.25rem .6rem;border-radius:20px;font-size:.72rem;font-weight:600;">
                                        {{ $roll->statusLabel() }}
                                    </span>
                                </td>
                                <td style="font-size:.78rem;">
                                    @if($roll->inspection)
                                        <span class="{{ $roll->inspection->overall_result==='Pass' ? 'badge-active' : 'badge-inactive' }}">
                                            {{ $roll->inspection->overall_result }}
                                        </span>
                                        <small class="text-muted d-block">DHU: {{ $roll->inspection->dhu_percent }}%</small>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('grn.print-single-label', $roll) }}" target="_blank"
                                           class="btn-action" title="Print QR Label"
                                           style="background:rgba(16,185,129,.1);color:#059669;">
                                            <i class="bi bi-qr-code"></i>
                                        </a>
                                        @if(!$roll->inspection)
                                        <a href="{{ route('grn.inspect-roll', $roll) }}"
                                           class="btn-action btn-edit" title="Inspect Roll">
                                            <i class="bi bi-clipboard2-check"></i>
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Right: Summary --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header"><h6 class="mb-0" style="font-weight:600;"><i class="bi bi-bar-chart me-2 text-primary"></i>Roll Summary</h6></div>
            <div class="card-body">
                @php
                    $statusCounts = $grn->rolls->groupBy('status');
                    $totalWeight  = $grn->rolls->sum('roll_weight');
                    $totalLength  = $grn->rolls->sum('roll_length');
                @endphp
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1" style="font-size:.82rem;">
                        <span class="text-muted">Total Rolls</span><strong>{{ $grn->rolls->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-1" style="font-size:.82rem;">
                        <span class="text-muted">Total Weight</span><strong>{{ number_format($totalWeight,2) }} KG</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-1" style="font-size:.82rem;">
                        <span class="text-muted">Total Length</span><strong>{{ number_format($totalLength,2) }} m</strong>
                    </div>
                </div>
                <hr>
                <div style="font-size:.78rem;font-weight:600;text-transform:uppercase;letter-spacing:.04em;color:#6b7280;margin-bottom:.5rem;">By Status</div>
                @foreach(\App\Models\GrnRoll::$statuses as $key => $label)
                    @php $cnt = $statusCounts->get($key)?->count() ?? 0; @endphp
                    @if($cnt > 0)
                    <div class="d-flex justify-content-between mb-1" style="font-size:.82rem;">
                        <span style="color:{{ \App\Models\GrnRoll::$statusColors[$key] }};">● {{ $label }}</span>
                        <strong>{{ $cnt }}</strong>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body" style="font-size:.78rem;color:#6b7280;">
                <div class="mb-1"><i class="bi bi-clock me-1"></i>Created: {{ $grn->created_at->format('d M Y, H:i') }}</div>
                <div><i class="bi bi-arrow-clockwise me-1"></i>Updated: {{ $grn->updated_at->format('d M Y, H:i') }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
