@extends('layouts.app')
@section('title', 'Record Sewing')
@section('page-title', 'Record Sewing Production')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-light">
                <h6 class="mb-0" style="font-weight:600;"><i class="bi bi-scissors me-2 text-primary"></i>Bundle Info</h6>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-3 text-muted" style="font-size:0.85rem; font-weight:600;">Bundle No</div>
                    <div class="col-sm-9" style="font-weight:700; color:#111827;">{{ $bundle->bundle_no }}</div>
                </div>
                <div class="row mb-4">
                    <div class="col-sm-3 text-muted" style="font-size:0.85rem; font-weight:600;">Size & Quantity</div>
                    <div class="col-sm-9"><span class="badge bg-secondary me-2">{{ $bundle->size }}</span> <strong>{{ $bundle->quantity }}</strong> pieces</div>
                </div>
                <div class="row mb-4">
                    <div class="col-sm-3 text-muted" style="font-size:0.85rem; font-weight:600;">Cut Order</div>
                    <div class="col-sm-9">{{ $bundle->cutOrder->cut_order_no }} ({{ $bundle->cutOrder->layModel?->lay_model_code }})</div>
                </div>

                <hr>

                <h6 style="font-weight:600;" class="mb-3">Record Production</h6>
                <form method="POST" action="{{ route('sewing.store', $bundle) }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Line Number</label>
                            <input type="text" name="line_number" class="form-control" placeholder="e.g. Line 1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Operator Name</label>
                            <input type="text" name="operator_name" class="form-control" placeholder="e.g. John Doe" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Operation</label>
                            <select name="operation" class="form-select" required>
                                <option value="">Select operation...</option>
                                <option value="Side Seam">Side Seam</option>
                                <option value="Sleeve Attach">Sleeve Attach</option>
                                <option value="Collar Attach">Collar Attach</option>
                                <option value="Hemming">Hemming</option>
                                <option value="Full Assembly">Full Assembly</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-success">Pieces Passed</label>
                            <input type="number" min="0" max="{{ $bundle->quantity }}" name="qty_passed" class="form-control border-success" value="{{ $bundle->quantity }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-danger">Pieces Rejected</label>
                            <input type="number" min="0" name="qty_rejected" class="form-control border-danger" value="0" required>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary w-100" style="background:linear-gradient(135deg,#8b5cf6,#6d28d9);border:none;">
                                <i class="bi bi-check-circle me-1"></i> Save Production Record
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
