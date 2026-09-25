@extends('layouts.app')
@section('title', 'Cut Order ' . $cutman->cut_order_no)
@section('page-title', 'Cut Order Details')

@section('content')
<div class="row g-3">
    {{-- Left: Details & Rolls --}}
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-0" style="font-weight:700;color:#0891b2;">{{ $cutman->cut_order_no }}</h6>
                    <small class="text-muted">Planned for {{ $cutman->planned_date->format('d M Y') }}</small>
                </div>
                <span style="background:{{ $cutman->statusColor() }}1a;color:{{ $cutman->statusColor() }};padding:.3rem .8rem;border-radius:20px;font-size:.8rem;font-weight:600;">
                    {{ ucfirst($cutman->status) }}
                </span>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div style="font-size:.7rem;color:#6b7280;font-weight:600;text-transform:uppercase;">Reservation</div>
                        <div style="font-weight:600;color:#111827;">{{ $cutman->fabricReservation?->reservation_no }}</div>
                    </div>
                    <div class="col-md-4">
                        <div style="font-size:.7rem;color:#6b7280;font-weight:600;text-transform:uppercase;">Lay Model</div>
                        <div style="font-weight:600;color:#111827;">{{ $cutman->layModel ? $cutman->layModel->lay_model_code : '—' }}</div>
                    </div>
                    <div class="col-md-4">
                        <div style="font-size:.7rem;color:#6b7280;font-weight:600;text-transform:uppercase;">Planned Qty</div>
                        <div style="font-weight:600;color:#111827;">{{ $cutman->planned_qty }} pcs</div>
                    </div>
                    @if($cutman->remarks)
                    <div class="col-12">
                        <div style="font-size:.7rem;color:#6b7280;font-weight:600;text-transform:uppercase;">Remarks</div>
                        <div style="font-size:.85rem;color:#374151;background:#f9fafb;padding:.5rem;border-radius:6px;">{{ $cutman->remarks }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0" style="font-weight:600;"><i class="bi bi-stack me-2" style="color:#0891b2;"></i>Roll Usage</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Roll No.</th>
                                <th>Fabric</th>
                                <th>Total Length</th>
                                <th>Used Length (m)</th>
                                <th>Used Weight (KG)</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($cutman->rolls as $i => $roll)
                            <tr>
                                <td class="text-muted" style="font-size:.75rem;">{{ $i+1 }}</td>
                                <td><code style="color:#0369a1;font-size:.82rem;">{{ $roll->roll_number }}</code></td>
                                <td style="font-weight:500;">{{ $roll->grn->fabric?->fabric_code }}</td>
                                <td>{{ $roll->roll_length ?? '—' }} m</td>
                                <td>
                                    @if($roll->pivot->used_length !== null)
                                        <span class="text-success" style="font-weight:600;">{{ $roll->pivot->used_length }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($roll->pivot->used_weight !== null)
                                        <span class="text-success" style="font-weight:600;">{{ $roll->pivot->used_weight }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Right: Actions & Scan --}}
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header"><h6 class="mb-0" style="font-weight:600;"><i class="bi bi-lightning-charge me-2 text-warning"></i>Actions</h6></div>
            <div class="card-body">
                @if($cutman->status === 'planned')
                    <p class="text-muted" style="font-size:0.85rem;">Ready to start cutting? Start the order to begin scanning rolls and recording usage.</p>
                    <form method="POST" action="{{ route('cutman.start', $cutman) }}">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100" style="background:linear-gradient(135deg,#f59e0b,#d97706);border:none;">
                            <i class="bi bi-play-circle me-1"></i>Start Cutting
                        </button>
                    </form>
                @elseif($cutman->status === 'cutting')
                    <p class="text-muted" style="font-size:0.85rem;">Cutting is in progress. Once all rolls are processed, mark this order as complete.</p>
                    <form method="POST" action="{{ route('cutman.complete', $cutman) }}" onsubmit="return confirm('Are you sure you are done cutting?');">
                        @csrf
                        <button type="submit" class="btn btn-success w-100" style="background:linear-gradient(135deg,#10b981,#059669);border:none;">
                            <i class="bi bi-check-all me-1"></i>Complete Cut Order
                        </button>
                    </form>
                @elseif($cutman->status === 'completed')
                    <div class="alert alert-success py-2 mb-0" style="font-size:0.85rem;">
                        <i class="bi bi-check-circle-fill me-2"></i>Cutting completed. Ready for numbering/bundling.
                    </div>
                @endif
            </div>
        </div>

        @if($cutman->status === 'cutting')
        <div class="card" style="border:2px solid #0891b2;">
            <div class="card-header" style="background:linear-gradient(135deg,#0891b2,#06b6d4);color:#fff;">
                <h6 class="mb-0" style="font-weight:600;"><i class="bi bi-qr-code-scan me-2"></i>Record Roll Usage</h6>
            </div>
            <div class="card-body">
                <p class="text-muted" style="font-size:0.8rem;">Select a roll to record the exact length and weight consumed during this cut.</p>
                
                {{-- In a real scenario, this could be a QR scan field that looks up the roll. 
                     For simplicity here, we use a dropdown of the attached rolls. --}}
                
                <form id="usage-form" method="POST" action="">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Select Roll</label>
                        <select id="roll-select" class="form-select" onchange="updateFormAction()" required>
                            <option value="">Choose a roll...</option>
                            @foreach($cutman->rolls as $roll)
                                <option value="{{ $roll->id }}">{{ $roll->roll_number }} (Max: {{ $roll->roll_length ?? '?' }}m)</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label">Used Length (m)</label>
                            <input type="number" step="0.01" min="0" name="used_length" class="form-control" required placeholder="0.00">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Used Weight (KG)</label>
                            <input type="number" step="0.01" min="0" name="used_weight" class="form-control" required placeholder="0.00">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" style="background:linear-gradient(135deg,#0891b2,#06b6d4);border:none;">
                        <i class="bi bi-save me-1"></i>Save Usage
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function updateFormAction() {
    const rollId = document.getElementById('roll-select').value;
    const form = document.getElementById('usage-form');
    if (rollId) {
        form.action = `/cutman/{{ $cutman->id }}/roll/${rollId}`;
    } else {
        form.action = "";
    }
}
</script>
@endpush
@endsection
