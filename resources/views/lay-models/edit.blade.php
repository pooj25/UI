@extends('layouts.app')
@section('title', 'Edit Lay Model')
@section('page-title', 'Edit Lay Model')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0" style="font-weight:600;"><i class="bi bi-pencil me-2 text-warning"></i>Edit Lay Model</h6>
                <code style="color:#0891b2;">{{ $layModel->lay_model_code }}</code>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('lay-models.update', $layModel) }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Lay Model Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('lay_model_code') is-invalid @enderror"
                                name="lay_model_code" value="{{ old('lay_model_code', $layModel->lay_model_code) }}">
                            @error('lay_model_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Lay Model Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('lay_model_name') is-invalid @enderror"
                                name="lay_model_name" value="{{ old('lay_model_name', $layModel->lay_model_name) }}">
                            @error('lay_model_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fabric Group <span class="text-danger">*</span></label>
                            <select class="form-select @error('fabric_group_id') is-invalid @enderror"
                                name="fabric_group_id" id="fabric_group_id">
                                <option value="">Select fabric group...</option>
                                @foreach($fabricGroups as $group)
                                    <option value="{{ $group->id }}" {{ old('fabric_group_id', $layModel->fabric_group_id) == $group->id ? 'selected' : '' }}>
                                        {{ $group->group_code }} — {{ $group->group_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('fabric_group_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fabric <span class="text-danger">*</span>
                                <small class="text-muted" id="fabric-hint"></small>
                            </label>
                            <select class="form-select @error('fabric_id') is-invalid @enderror"
                                name="fabric_id" id="fabric_id">
                                <option value="">Select fabric...</option>
                                @foreach($fabrics as $f)
                                    <option value="{{ $f->id }}" {{ old('fabric_id', $layModel->fabric_id) == $f->id ? 'selected' : '' }}>
                                        {{ $f->fabric_code }} — {{ $f->fabric_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('fabric_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12"><hr class="my-1"><p class="text-muted mb-0" style="font-size:0.78rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;">Lay Parameters</p></div>

                        <div class="col-md-4">
                            <label class="form-label">Lay Length <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" class="form-control @error('lay_length') is-invalid @enderror"
                                name="lay_length" value="{{ old('lay_length', $layModel->lay_length) }}">
                            @error('lay_length')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Lay Width <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" class="form-control @error('lay_width') is-invalid @enderror"
                                name="lay_width" value="{{ old('lay_width', $layModel->lay_width) }}">
                            @error('lay_width')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Number of Plies <span class="text-danger">*</span></label>
                            <input type="number" min="1" class="form-control @error('number_of_plies') is-invalid @enderror"
                                name="number_of_plies" value="{{ old('number_of_plies', $layModel->number_of_plies) }}">
                            @error('number_of_plies')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Garment Size</label>
                            <input type="text" class="form-control @error('garment_size') is-invalid @enderror"
                                name="garment_size" value="{{ old('garment_size', $layModel->garment_size) }}">
                            @error('garment_size')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Marker Length</label>
                            <input type="number" step="0.01" min="0" class="form-control @error('marker_length') is-invalid @enderror"
                                name="marker_length" value="{{ old('marker_length', $layModel->marker_length) }}">
                            @error('marker_length')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Marker Width</label>
                            <input type="number" step="0.01" min="0" class="form-control @error('marker_width') is-invalid @enderror"
                                name="marker_width" value="{{ old('marker_width', $layModel->marker_width) }}">
                            @error('marker_width')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status">
                                <option value="active"   {{ old('status', $layModel->status) === 'active'   ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $layModel->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                name="description" rows="2">{{ old('description', $layModel->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <hr class="my-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary" style="background:linear-gradient(135deg,#0891b2,#06b6d4);border-color:#0891b2;">
                            <i class="bi bi-check-lg me-1"></i>Update Lay Model
                        </button>
                        <a href="{{ route('lay-models.show', $layModel) }}" class="btn btn-outline-secondary">Cancel</a>
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
const oldFabricId  = '{{ old("fabric_id", $layModel->fabric_id) }}';

groupSelect.addEventListener('change', function () {
    const groupId = this.value;
    fabricSelect.innerHTML = '<option value="">Select fabric...</option>';
    fabricSelect.disabled = true;
    if (!groupId) return;

    fetch(`{{ route('api.fabrics-by-group') }}?fabric_group_id=${groupId}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(fabrics => {
        fabrics.forEach(f => {
            const opt = document.createElement('option');
            opt.value = f.id;
            opt.textContent = `${f.fabric_code} — ${f.fabric_name}`;
            if (f.id == oldFabricId) opt.selected = true;
            fabricSelect.appendChild(opt);
        });
        fabricSelect.disabled = fabrics.length === 0;
        fabricHint.textContent = fabrics.length > 0 ? `(${fabrics.length} available)` : '(none in group)';
    });
});

// If group already selected on load, populate fabrics
if (groupSelect.value && fabricSelect.options.length <= 1) {
    groupSelect.dispatchEvent(new Event('change'));
} else {
    fabricSelect.disabled = false;
}
</script>
@endpush
@endsection
