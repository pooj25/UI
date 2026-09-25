@extends('layouts.app')
@section('title', 'Create GRN')
@section('page-title', 'Create GRN')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-10">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0" style="font-weight:600;">
                    <i class="bi bi-plus-circle me-2" style="color:#0891b2;"></i>New Goods Receipt Note
                </h6>
                <span class="badge" style="background:#e0f2fe;color:#0891b2;font-size:0.85rem;padding:0.4rem 0.9rem;border-radius:20px;font-weight:700;">
                    {{ $grnNumber }}
                </span>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('grn.store') }}" id="grn-form">
                    @csrf

                    {{-- GRN Header --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Invoice Number <span class="text-danger">*</span></label>
                            <input type="text" name="invoice_number"
                                class="form-control @error('invoice_number') is-invalid @enderror"
                                value="{{ old('invoice_number') }}" placeholder="e.g. INV-2024-001">
                            @error('invoice_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Supplier Name <span class="text-danger">*</span></label>
                            <input type="text" name="supplier_name"
                                class="form-control @error('supplier_name') is-invalid @enderror"
                                value="{{ old('supplier_name') }}" placeholder="e.g. ABC Textiles">
                            @error('supplier_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Received Date <span class="text-danger">*</span></label>
                            <input type="date" name="received_date"
                                class="form-control @error('received_date') is-invalid @enderror"
                                value="{{ old('received_date', date('Y-m-d')) }}">
                            @error('received_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fabric <span class="text-danger">*</span></label>
                            <select name="fabric_id" class="form-select @error('fabric_id') is-invalid @enderror">
                                <option value="">Select fabric...</option>
                                @foreach($fabrics as $fabric)
                                    <option value="{{ $fabric->id }}" {{ old('fabric_id') == $fabric->id ? 'selected' : '' }}>
                                        {{ $fabric->fabric_code }} — {{ $fabric->fabric_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('fabric_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rack / Storage Location</label>
                            <input type="text" name="rack_location"
                                class="form-control @error('rack_location') is-invalid @enderror"
                                value="{{ old('rack_location') }}" placeholder="e.g. RACK-A3">
                            @error('rack_location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Remarks</label>
                            <textarea name="remarks" class="form-control" rows="2"
                                placeholder="Any remarks about this delivery...">{{ old('remarks') }}</textarea>
                        </div>
                    </div>

                    <hr>

                    {{-- Roll Details --}}
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="mb-0" style="font-weight:600;color:#0891b2;">
                            <i class="bi bi-stack me-2"></i>Roll Details
                            <small class="text-muted ms-2" style="font-size:0.75rem;font-weight:400;">Add one row per physical roll</small>
                        </h6>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="addRow()">
                            <i class="bi bi-plus-lg me-1"></i>Add Roll
                        </button>
                    </div>

                    @error('rolls')
                        <div class="alert alert-danger py-2 mb-3" style="font-size:0.82rem;">
                            <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                        </div>
                    @enderror

                    <div class="table-responsive mb-3">
                        <table class="table table-bordered" style="font-size:0.85rem;" id="rolls-table">
                            <thead style="background:#f0f9ff;">
                                <tr>
                                    <th style="width:40px;">#</th>
                                    <th>Roll Number <span class="text-danger">*</span></th>
                                    <th>Weight (KG)</th>
                                    <th>Length (m)</th>
                                    <th>Width (in)</th>
                                    <th style="width:50px;"></th>
                                </tr>
                            </thead>
                            <tbody id="rolls-body">
                                <tr data-row="0">
                                    <td class="text-center text-muted row-no">1</td>
                                    <td>
                                        <input type="text" name="rolls[0][roll_number]" class="form-control form-control-sm"
                                            placeholder="e.g. R-001" required>
                                    </td>
                                    <td><input type="number" step="0.01" min="0" name="rolls[0][roll_weight]" class="form-control form-control-sm" placeholder="0.00"></td>
                                    <td><input type="number" step="0.01" min="0" name="rolls[0][roll_length]" class="form-control form-control-sm" placeholder="0.00"></td>
                                    <td><input type="number" step="0.01" min="0" name="rolls[0][actual_width]" class="form-control form-control-sm" placeholder="0.00"></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)" style="padding:2px 8px;">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary" style="background:linear-gradient(135deg,#0891b2,#06b6d4);border-color:#0891b2;">
                            <i class="bi bi-check-lg me-1"></i>Save GRN & Generate QR Codes
                        </button>
                        <a href="{{ route('grn.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let rowCount = 1;

function addRow() {
    const i = rowCount++;
    const tbody = document.getElementById('rolls-body');
    const tr = document.createElement('tr');
    tr.setAttribute('data-row', i);
    tr.innerHTML = `
        <td class="text-center text-muted row-no"></td>
        <td><input type="text" name="rolls[${i}][roll_number]" class="form-control form-control-sm" placeholder="e.g. R-00${i+1}" required></td>
        <td><input type="number" step="0.01" min="0" name="rolls[${i}][roll_weight]" class="form-control form-control-sm" placeholder="0.00"></td>
        <td><input type="number" step="0.01" min="0" name="rolls[${i}][roll_length]" class="form-control form-control-sm" placeholder="0.00"></td>
        <td><input type="number" step="0.01" min="0" name="rolls[${i}][actual_width]" class="form-control form-control-sm" placeholder="0.00"></td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)" style="padding:2px 8px;">
                <i class="bi bi-trash3"></i>
            </button>
        </td>`;
    tbody.appendChild(tr);
    renumber();
}

function removeRow(btn) {
    const rows = document.querySelectorAll('#rolls-body tr');
    if (rows.length <= 1) return;
    btn.closest('tr').remove();
    renumber();
}

function renumber() {
    document.querySelectorAll('#rolls-body tr').forEach((tr, idx) => {
        tr.querySelector('.row-no').textContent = idx + 1;
    });
}
renumber();
</script>
@endpush
@endsection
