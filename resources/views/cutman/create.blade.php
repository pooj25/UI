@extends('layouts.app')
@section('title', 'New Cut Order')
@section('page-title', 'New Cut Order')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0" style="font-weight:600;">
                    <i class="bi bi-scissors me-2" style="color:#0891b2;"></i>Plan Cut Order
                </h6>
                <span class="badge" style="background:#e0f2fe;color:#0284c7;font-size:0.85rem;padding:0.4rem 0.9rem;border-radius:20px;font-weight:700;">
                    {{ $cutOrderNo }}
                </span>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('cutman.store') }}">
                    @csrf

                    @if($issuedReservations->isEmpty())
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>There are no issued Fabric Reservations ready for cutting. Please issue rolls from the Fabric Store first.
                        </div>
                    @endif

                    <div class="row g-3 mb-4">
                        <div class="col-12">
                            <label class="form-label">Select Issued Fabric Reservation <span class="text-danger">*</span></label>
                            <select name="fabric_reservation_id" class="form-select @error('fabric_reservation_id') is-invalid @enderror">
                                <option value="">Select an issued reservation...</option>
                                @foreach($issuedReservations as $res)
                                    <option value="{{ $res->id }}" {{ old('fabric_reservation_id') == $res->id ? 'selected' : '' }}>
                                        {{ $res->reservation_no }} — Lay Model: {{ $res->layModel ? $res->layModel->lay_model_code : 'None' }} ({{ $res->rolls->count() }} rolls)
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted d-block mt-1">Rolls from this reservation will be automatically assigned to the Cut Order.</small>
                            @error('fabric_reservation_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Planned Garment Quantity <span class="text-danger">*</span></label>
                            <input type="number" min="1" name="planned_qty"
                                class="form-control @error('planned_qty') is-invalid @enderror"
                                value="{{ old('planned_qty') }}" placeholder="e.g. 500">
                            @error('planned_qty')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Planned Cut Date <span class="text-danger">*</span></label>
                            <input type="date" name="planned_date"
                                class="form-control @error('planned_date') is-invalid @enderror"
                                value="{{ old('planned_date', date('Y-m-d')) }}">
                            @error('planned_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label">Remarks</label>
                            <input type="text" name="remarks" class="form-control" value="{{ old('remarks') }}" placeholder="Special instructions for cutting...">
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary" style="background:linear-gradient(135deg,#0891b2,#06b6d4);border:none;" {{ $issuedReservations->isEmpty() ? 'disabled' : '' }}>
                            <i class="bi bi-check-lg me-1"></i>Create Cut Order
                        </button>
                        <a href="{{ route('cutman.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
