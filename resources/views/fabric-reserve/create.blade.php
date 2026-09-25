@extends('layouts.app')
@section('title', 'New Fabric Reservation')
@section('page-title', 'New Fabric Reservation')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-10">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0" style="font-weight:600;">
                    <i class="bi bi-plus-circle me-2" style="color:var(--primary);"></i>Request Fabric
                </h6>
                <span class="badge" style="background:#e0f2fe;color:#0284c7;font-size:0.85rem;padding:0.4rem 0.9rem;border-radius:20px;font-weight:700;">
                    {{ $reservationNo }}
                </span>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('fabric-reserve.store') }}">
                    @csrf

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Requested By <span class="text-danger">*</span></label>
                            <input type="text" name="requested_by"
                                class="form-control @error('requested_by') is-invalid @enderror"
                                value="{{ old('requested_by', auth()->user()->name) }}">
                            @error('requested_by')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Request Date <span class="text-danger">*</span></label>
                            <input type="date" name="request_date"
                                class="form-control @error('request_date') is-invalid @enderror"
                                value="{{ old('request_date', date('Y-m-d')) }}">
                            @error('request_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Lay Model (Optional)</label>
                            <select name="lay_model_id" class="form-select @error('lay_model_id') is-invalid @enderror">
                                <option value="">No specific model</option>
                                @foreach($layModels as $lm)
                                    <option value="{{ $lm->id }}" {{ old('lay_model_id') == $lm->id ? 'selected' : '' }}>
                                        {{ $lm->lay_model_code }} — {{ $lm->lay_model_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('lay_model_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Remarks</label>
                            <input type="text" name="remarks" class="form-control" value="{{ old('remarks') }}" placeholder="Any special notes...">
                        </div>
                    </div>

                    <h6 class="mb-3" style="font-weight:600;"><i class="bi bi-stack me-2" style="color:var(--primary);"></i>Select Available Rolls</h6>
                    @error('rolls')
                        <div class="alert alert-danger py-2 mb-3"><i class="bi bi-exclamation-circle me-2"></i>{{ $message }}</div>
                    @enderror

                    @if($availableRolls->isEmpty())
                        <div class="alert alert-warning">
                            No rolls currently available in stock. Please inspect and approve GRN rolls first.
                        </div>
                    @else
                        <div class="table-responsive border rounded mb-4" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-hover mb-0">
                                <thead style="position: sticky; top: 0; z-index: 1;">
                                    <tr>
                                        <th style="width: 40px;"></th>
                                        <th>Roll Number</th>
                                        <th>Fabric</th>
                                        <th>Weight (KG)</th>
                                        <th>Length (m)</th>
                                        <th>GRN No.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($availableRolls as $roll)
                                    <tr>
                                        <td>
                                            <input class="form-check-input" type="checkbox" name="rolls[]" value="{{ $roll->id }}"
                                                {{ is_array(old('rolls')) && in_array($roll->id, old('rolls')) ? 'checked' : '' }}>
                                        </td>
                                        <td><code style="font-size:0.85rem;color:#0369a1;">{{ $roll->roll_number }}</code></td>
                                        <td style="font-weight:500;">{{ $roll->grn->fabric?->fabric_code ?? '—' }}</td>
                                        <td>{{ $roll->roll_weight ?? '—' }}</td>
                                        <td>{{ $roll->roll_length ?? '—' }}</td>
                                        <td style="font-size:0.8rem;color:#6b7280;">{{ $roll->grn->grn_number }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary" {{ $availableRolls->isEmpty() ? 'disabled' : '' }}>
                            <i class="bi bi-check-lg me-1"></i>Create Reservation
                        </button>
                        <a href="{{ route('fabric-reserve.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
