@extends('layouts.app')
@section('title', 'Create Lay Model')
@section('page-title', 'Create Lay Model')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0" style="font-weight:600;"><i class="bi bi-plus-circle me-2" style="color:#0891b2;"></i>New Lay Model</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('lay-models.store') }}" id="lay-model-form">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Lay Model Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('lay_model_code') is-invalid @enderror"
                                name="lay_model_code" value="{{ old('lay_model_code') }}" placeholder="e.g. LM-001">
                            @error('lay_model_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Lay Model Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('lay_model_name') is-invalid @enderror"
                                name="lay_model_name" value="{{ old('lay_model_name') }}" placeholder="e.g. Men's T-Shirt Lay">
                            @error('lay_model_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Fabric Group -->
                        <div class="col-md-6">
                            <label class="form-label">Fabric Group <span class="text-danger">*</span></label>
                            <select class="form-select @error('fabric_group_id') is-invalid @enderror"
                                name="fabric_group_id" id="fabric_group_id">
                                <option value="">Select fabric group...</option>
                                @foreach($fabricGroups as $group)
                                    <option value="{{ $group->id }}" {{ old('fabric_group_id') == $group->id ? 'selected' : '' }}>
                                        {{ $group->group_code }} — {{ $group->group_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('fabric_group_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Fabric (filtered by group via AJAX) -->
                        <div class="col-md-6">
                            <label class="form-label">Fabric <span class="text-danger">*</span>
                                <small class="text-muted" id="fabric-hint">(select a fabric group first)</small>
                            </label>
                            <select class="form-select @error('fabric_id') is-invalid @enderror"
                                name="fabric_id" id="fabric_id" disabled>
                                <option value="">Select fabric...</option>
                            </select>
                            <div id="fabric-loading" class="text-muted mt-1" style="font-size:0.78rem;display:none;">
                                <i class="bi bi-hourglass-split me-1"></i>Loading fabrics...
                            </div>
                            @error('fabric_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <!-- Lay Parameters -->
                        <div class="col-12"><hr class="my-1"><p class="text-muted mb-0" style="font-size:0.78rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;">Lay Parameters</p></div>

                        <div class="col-md-4">
                            <label class="form-label">Lay Length <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" class="form-control @error('lay_length') is-invalid @enderror"
                                name="lay_length" value="{{ old('lay_length') }}" placeholder="e.g. 12.50">
                            @error('lay_length')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Lay Width <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" class="form-control @error('lay_width') is-invalid @enderror"
                                name="lay_width" value="{{ old('lay_width') }}" placeholder="e.g. 72">
                            @error('lay_width')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Number of Plies <span class="text-danger">*</span></label>
                            <input type="number" min="1" class="form-control @error('number_of_plies') is-invalid @enderror"
                                name="number_of_plies" value="{{ old('number_of_plies') }}" placeholder="e.g. 50">
                            @error('number_of_plies')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Garment Size</label>
                            <input type="text" class="form-control @error('garment_size') is-invalid @enderror"
                                name="garment_size" value="{{ old('garment_size') }}" placeholder="e.g. L, XL, XXL">
                            @error('garment_size')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Marker Length</label>
                            <input type="number" step="0.01" min="0" class="form-control @error('marker_length') is-invalid @enderror"
                                name="marker_length" value="{{ old('marker_length') }}" placeholder="e.g. 11.80">
                            @error('marker_length')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Marker Width</label>
                            <input type="number" step="0.01" min="0" class="form-control @error('marker_width') is-invalid @enderror"
                                name="marker_width" value="{{ old('marker_width') }}" placeholder="e.g. 68">
                            @error('marker_width')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status">
                                <option value="active"   {{ old('status','active') === 'active'   ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                name="description" rows="2" placeholder="Optional description...">{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <hr class="my-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary" style="background:linear-gradient(135deg,#0891b2,#06b6d4);border-color:#0891b2;">
                            <i class="bi bi-check-lg me-1"></i>Save Lay Model
                        </button>
                        <a href="{{ route('lay-models.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const groupSelect  = document.getElementById('fabric_group_id');
const fabricSelect = document.getElementById('fabric_id');
const fabricHint   = document.getElementById('fabric-hint');
const fabricLoading = document.getElementById('fabric-loading');
const oldFabricId  = '{{ old("fabric_id") }}';

groupSelect.addEventListener('change', function () {
    const groupId = this.value;
    fabricSelect.innerHTML = '<option value="">Select fabric...</option>';
    fabricSelect.disabled = true;

    if (!groupId) {
        fabricHint.textContent = '(select a fabric group first)';
        return;
    }

    fabricLoading.style.display = 'block';
    fabricHint.textContent = '';

    fetch(`{{ route('api.fabrics-by-group') }}?fabric_group_id=${groupId}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(fabrics => {
        fabricLoading.style.display = 'none';
        if (fabrics.length === 0) {
            fabricHint.textContent = '(no fabrics in this group)';
            return;
        }
        fabrics.forEach(f => {
            const opt = document.createElement('option');
            opt.value = f.id;
            opt.textContent = `${f.fabric_code} — ${f.fabric_name}`;
            if (f.id == oldFabricId) opt.selected = true;
            fabricSelect.appendChild(opt);
        });
        fabricSelect.disabled = false;
        fabricHint.textContent = `(${fabrics.length} fabric(s) available)`;
    })
    .catch(() => {
        fabricLoading.style.display = 'none';
        fabricHint.textContent = '(error loading fabrics)';
    });
});

// Trigger on page load if old value exists
if (groupSelect.value) groupSelect.dispatchEvent(new Event('change'));
</script>
@endpush
@endsection
