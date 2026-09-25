@extends('layouts.app')
@section('title', 'Create Fabric Group')
@section('page-title', 'Create Fabric Group')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0" style="font-weight:600;"><i class="bi bi-plus-circle me-2" style="color:#7c3aed;"></i>New Fabric Group</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('fabric-groups.store') }}" id="fg-create-form">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Group Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('group_code') is-invalid @enderror"
                                name="group_code" value="{{ old('group_code') }}" placeholder="e.g. FG-001">
                            @error('group_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Group Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('group_name') is-invalid @enderror"
                                name="group_name" value="{{ old('group_name') }}" placeholder="e.g. Cotton Knitted Fabrics">
                            @error('group_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                name="description" rows="2" placeholder="Optional description...">{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status">
                                <option value="active"   {{ old('status','active') === 'active'   ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <hr class="my-3">

                    <!-- Select Fabrics -->
                    <div>
                        <label class="form-label">
                            Select Fabrics <span class="text-danger">*</span>
                            <small class="text-muted ms-1">(at least one required)</small>
                        </label>
                        @error('fabrics')
                            <div class="alert alert-danger py-2 mb-2" style="font-size:0.82rem;">
                                <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                            </div>
                        @enderror

                        <div class="mb-2 d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAll()">Select All</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAll()">Deselect All</button>
                            <input type="text" class="form-control form-control-sm ms-auto" id="fabric-search-filter"
                                placeholder="Filter fabrics..." style="max-width:220px;" oninput="filterFabrics(this.value)">
                        </div>

                        <div class="border rounded" style="max-height:280px;overflow-y:auto;background:#faf9ff;" id="fabric-list">
                            @forelse($fabrics as $fabric)
                            <div class="fabric-item d-flex align-items-center px-3 py-2 border-bottom"
                                 data-name="{{ strtolower($fabric->fabric_name) }}" data-code="{{ strtolower($fabric->fabric_code) }}">
                                <div class="form-check mb-0 flex-grow-1">
                                    <input class="form-check-input fabric-checkbox" type="checkbox"
                                        name="fabrics[]" value="{{ $fabric->id }}" id="fab_{{ $fabric->id }}"
                                        {{ in_array($fabric->id, old('fabrics', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label w-100" for="fab_{{ $fabric->id }}" style="cursor:pointer;">
                                        <span style="font-weight:500;font-size:0.875rem;">{{ $fabric->fabric_name }}</span>
                                        <small class="text-muted ms-2">{{ $fabric->fabric_code }}</small>
                                    </label>
                                </div>
                                <div class="ms-2 text-end" style="min-width:90px;">
                                    <span class="badge" style="background:#f0edff;color:#6366f1;font-size:0.72rem;">{{ $fabric->fabric_type }}</span>
                                    @if($fabric->gsm)<small class="text-muted d-block" style="font-size:0.7rem;">{{ $fabric->gsm }} GSM</small>@endif
                                </div>
                            </div>
                            @empty
                                <div class="text-center py-4 text-muted" style="font-size:0.85rem;">
                                    <i class="bi bi-exclamation-circle me-1"></i>No active fabrics available. Create fabrics first.
                                </div>
                            @endforelse
                        </div>

                        <div class="mt-2" id="selected-count" style="font-size:0.78rem;color:#6b7280;"></div>
                    </div>

                    <hr class="my-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Save Group</button>
                        <a href="{{ route('fabric-groups.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateCount() {
    const checked = document.querySelectorAll('.fabric-checkbox:checked').length;
    const el = document.getElementById('selected-count');
    el.textContent = checked > 0 ? `${checked} fabric(s) selected` : 'No fabrics selected';
    el.style.color = checked > 0 ? '#059669' : '#dc2626';
}
function selectAll() {
    document.querySelectorAll('.fabric-item:not([style*="display: none"]) .fabric-checkbox').forEach(cb => cb.checked = true);
    updateCount();
}
function deselectAll() {
    document.querySelectorAll('.fabric-checkbox').forEach(cb => cb.checked = false);
    updateCount();
}
function filterFabrics(val) {
    val = val.toLowerCase();
    document.querySelectorAll('.fabric-item').forEach(item => {
        const match = item.dataset.name.includes(val) || item.dataset.code.includes(val);
        item.style.display = match ? '' : 'none';
    });
}
document.querySelectorAll('.fabric-checkbox').forEach(cb => cb.addEventListener('change', updateCount));
updateCount();
</script>
@endpush
@endsection
