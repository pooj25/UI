@extends('layouts.app')
@section('title', 'Inspect Roll — ' . $roll->roll_number)
@section('page-title', 'Fabric Inspection')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        {{-- Roll Info Banner --}}
        <div class="card mb-3" style="border:1.5px solid #bae6fd;background:#f0f9ff;">
            <div class="card-body py-2">
                <div class="d-flex align-items-center gap-3" style="flex-wrap:wrap;">
                    <div>
                        <div style="font-size:.7rem;color:#0891b2;font-weight:600;text-transform:uppercase;">Roll</div>
                        <code style="color:#0891b2;font-size:1rem;font-weight:700;">{{ $roll->roll_number }}</code>
                    </div>
                    <div class="vr"></div>
                    <div>
                        <div style="font-size:.7rem;color:#0891b2;font-weight:600;text-transform:uppercase;">GRN</div>
                        <span style="font-weight:600;">{{ $roll->grn->grn_number }}</span>
                    </div>
                    <div class="vr"></div>
                    <div>
                        <div style="font-size:.7rem;color:#0891b2;font-weight:600;text-transform:uppercase;">Fabric</div>
                        <span style="font-weight:600;">{{ $roll->grn->fabric?->fabric_code }} — {{ $roll->grn->fabric?->fabric_name }}</span>
                    </div>
                    <div class="vr"></div>
                    <div>
                        <div style="font-size:.7rem;color:#0891b2;font-weight:600;text-transform:uppercase;">Supplier</div>
                        <span style="font-weight:600;">{{ $roll->grn->supplier_name }}</span>
                    </div>
                    @if($roll->actual_width)
                    <div class="vr"></div>
                    <div>
                        <div style="font-size:.7rem;color:#0891b2;font-weight:600;text-transform:uppercase;">Declared Width</div>
                        <span style="font-weight:600;">{{ $roll->actual_width }}"</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6 class="mb-0" style="font-weight:600;">
                    <i class="bi bi-clipboard2-check me-2 text-primary"></i>Inspection Form
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('grn.store-inspection', $roll) }}">
                    @csrf
                    <div class="row g-3">

                        {{-- Inspector & Date --}}
                        <div class="col-md-6">
                            <label class="form-label">Inspected By <span class="text-danger">*</span></label>
                            <input type="text" name="inspected_by"
                                class="form-control @error('inspected_by') is-invalid @enderror"
                                value="{{ old('inspected_by') }}" placeholder="Inspector name">
                            @error('inspected_by')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Inspection Date <span class="text-danger">*</span></label>
                            <input type="date" name="inspection_date"
                                class="form-control @error('inspection_date') is-invalid @enderror"
                                value="{{ old('inspection_date', date('Y-m-d')) }}">
                            @error('inspection_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Shade --}}
                        <div class="col-12">
                            <div style="background:#fafafa;border-radius:10px;border:1px solid #e5e7eb;padding:1rem;">
                                <div style="font-weight:600;font-size:.85rem;margin-bottom:.75rem;color:#374151;">
                                    <i class="bi bi-palette me-2 text-primary"></i>Shade
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-3">
                                        <label class="form-label">Result <span class="text-danger">*</span></label>
                                        <select name="shade_result" class="form-select @error('shade_result') is-invalid @enderror">
                                            <option value="OK" {{ old('shade_result','OK')==='OK' ? 'selected':'' }}>✅ OK</option>
                                            <option value="NG" {{ old('shade_result')==='NG' ? 'selected':'' }}>❌ NG (Not Good)</option>
                                        </select>
                                        @error('shade_result')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-9">
                                        <label class="form-label">Shade Notes</label>
                                        <input type="text" name="shade_notes" class="form-control"
                                            value="{{ old('shade_notes') }}" placeholder="e.g. Slight shade variation at edge">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Shrinkage --}}
                        <div class="col-12">
                            <div style="background:#fafafa;border-radius:10px;border:1px solid #e5e7eb;padding:1rem;">
                                <div style="font-weight:600;font-size:.85rem;margin-bottom:.75rem;color:#374151;">
                                    <i class="bi bi-arrows-collapse me-2" style="color:#7c3aed;"></i>Shrinkage
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <label class="form-label">Warp Shrinkage (%)</label>
                                        <input type="number" step="0.01" min="0" max="100"
                                            name="shrinkage_warp" class="form-control"
                                            value="{{ old('shrinkage_warp') }}" placeholder="e.g. 3.5">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Weft Shrinkage (%)</label>
                                        <input type="number" step="0.01" min="0" max="100"
                                            name="shrinkage_weft" class="form-control"
                                            value="{{ old('shrinkage_weft') }}" placeholder="e.g. 2.0">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Width & DHU --}}
                        <div class="col-md-4">
                            <label class="form-label">Measured Width (inches)</label>
                            <input type="number" step="0.01" min="0" name="width_result" class="form-control"
                                value="{{ old('width_result') }}" placeholder="e.g. 71.5">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Defects Found <span class="text-danger">*</span></label>
                            <input type="number" min="0" name="defects_found" id="defects"
                                class="form-control @error('defects_found') is-invalid @enderror"
                                value="{{ old('defects_found', 0) }}" oninput="calcDhu()">
                            @error('defects_found')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Pieces Inspected <span class="text-danger">*</span></label>
                            <input type="number" min="1" name="pieces_inspected" id="pieces"
                                class="form-control @error('pieces_inspected') is-invalid @enderror"
                                value="{{ old('pieces_inspected', 1) }}" oninput="calcDhu()">
                            @error('pieces_inspected')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- DHU Display --}}
                        <div class="col-12">
                            <div style="background:linear-gradient(135deg,#f0f9ff,#e0f2fe);border-radius:10px;border:1px solid #bae6fd;padding:.85rem 1rem;display:flex;align-items:center;gap:1rem;">
                                <div>
                                    <div style="font-size:.7rem;font-weight:600;text-transform:uppercase;letter-spacing:.04em;color:#0891b2;">DHU %</div>
                                    <div id="dhu-display" style="font-size:1.8rem;font-weight:700;color:#0c4a6e;line-height:1;">0.00%</div>
                                </div>
                                <div style="font-size:.78rem;color:#0891b2;">
                                    <strong>Formula:</strong> (Defects ÷ Pieces Inspected) × 100
                                </div>
                            </div>
                        </div>

                        {{-- Overall Result --}}
                        <div class="col-md-6">
                            <label class="form-label">Overall Result <span class="text-danger">*</span></label>
                            <select name="overall_result" class="form-select @error('overall_result') is-invalid @enderror">
                                <option value="Pass"        {{ old('overall_result','Pass')==='Pass'        ? 'selected':'' }}>✅ Pass — Move to Stock</option>
                                <option value="Conditional" {{ old('overall_result')==='Conditional' ? 'selected':'' }}>⚠️ Conditional — Hold</option>
                                <option value="Fail"        {{ old('overall_result')==='Fail'        ? 'selected':'' }}>❌ Fail — Reject</option>
                            </select>
                            @error('overall_result')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Remarks</label>
                            <input type="text" name="remarks" class="form-control"
                                value="{{ old('remarks') }}" placeholder="Any additional notes...">
                        </div>
                    </div>

                    <hr class="my-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Submit Inspection
                        </button>
                        <a href="{{ route('grn.show', $roll->grn_id) }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function calcDhu() {
    const d = parseFloat(document.getElementById('defects').value) || 0;
    const p = parseFloat(document.getElementById('pieces').value)  || 1;
    const dhu = p > 0 ? ((d / p) * 100).toFixed(2) : '0.00';
    document.getElementById('dhu-display').textContent = dhu + '%';
    const el = document.getElementById('dhu-display');
    el.style.color = dhu > 10 ? '#ef4444' : dhu > 5 ? '#f59e0b' : '#059669';
}
calcDhu();
</script>
@endpush
@endsection
