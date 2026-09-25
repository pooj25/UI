@extends('layouts.app')
@section('title', 'Create Fabric')
@section('page-title', 'Create Fabric')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0" style="font-weight:600;"><i class="bi bi-plus-circle me-2 text-primary"></i>New Fabric</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('fabrics.store') }}" id="fabric-create-form">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Fabric Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('fabric_code') is-invalid @enderror"
                                name="fabric_code" value="{{ old('fabric_code') }}" placeholder="e.g. FAB-001">
                            @error('fabric_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fabric Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('fabric_name') is-invalid @enderror"
                                name="fabric_name" value="{{ old('fabric_name') }}" placeholder="e.g. Cotton Single Jersey">
                            @error('fabric_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fabric Type <span class="text-danger">*</span></label>
                            <select class="form-select @error('fabric_type') is-invalid @enderror" name="fabric_type">
                                <option value="">Select type...</option>
                                @foreach(['Knitted','Woven','Non-Woven','Denim','Fleece','Other'] as $type)
                                    <option value="{{ $type }}" {{ old('fabric_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                            @error('fabric_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Composition</label>
                            <input type="text" class="form-control @error('composition') is-invalid @enderror"
                                name="composition" value="{{ old('composition') }}" placeholder="e.g. 100% Cotton">
                            @error('composition')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Color</label>
                            <input type="text" class="form-control @error('color') is-invalid @enderror"
                                name="color" value="{{ old('color') }}" placeholder="e.g. Black">
                            @error('color')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">GSM</label>
                            <input type="number" step="0.01" min="0" class="form-control @error('gsm') is-invalid @enderror"
                                name="gsm" value="{{ old('gsm') }}" placeholder="e.g. 180">
                            @error('gsm')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Width</label>
                            <input type="number" step="0.01" min="0" class="form-control @error('width') is-invalid @enderror"
                                name="width" value="{{ old('width') }}" placeholder="e.g. 72">
                            @error('width')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Unit</label>
                            <select class="form-select @error('unit') is-invalid @enderror" name="unit">
                                <option value="">Select unit...</option>
                                @foreach(['KG','Meter','Yard','Roll'] as $unit)
                                    <option value="{{ $unit }}" {{ old('unit') === $unit ? 'selected' : '' }}>{{ $unit }}</option>
                                @endforeach
                            </select>
                            @error('unit')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                                name="description" rows="3" placeholder="Optional description...">{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <hr class="my-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Save Fabric</button>
                        <a href="{{ route('fabrics.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
