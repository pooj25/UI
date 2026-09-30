@extends('layouts.app')
@section('title', 'Record Panel Inspection')
@section('page-title', 'Record Panel Inspection')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-light">
                <h6 class="mb-0" style="font-weight:600;"><i class="bi bi-search-heart me-2 text-primary"></i>Panel Quality Check</h6>
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <form method="POST" action="{{ route('panel-inspection.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Completed Cut Order</label>
                            <select name="cut_order_id" class="form-select" required>
                                <option value="">Select Cut Order...</option>
                                @foreach($cutOrders as $order)
                                    <option value="{{ $order->id }}">{{ $order->cut_order_no }} ({{ $order->planned_qty }} pcs)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Inspector Name</label>
                            <input type="text" name="inspector_name" class="form-control" placeholder="e.g. Quality Team A" required>
                        </div>
                        
                        <div class="col-12 mt-4"><hr></div>
                        <h6 style="font-weight:600; color:#374151;">Inspection Results</h6>
                        
                        <div class="col-md-4">
                            <label class="form-label">Total Panels Checked</label>
                            <input type="number" id="total" name="total_panels_checked" class="form-control" min="1" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-success">Panels Passed</label>
                            <input type="number" id="passed" name="panels_passed" class="form-control border-success" min="0" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-danger">Panels Rejected</label>
                            <input type="number" id="rejected" name="panels_rejected" class="form-control border-danger" min="0" required>
                        </div>
                        
                        <div class="col-md-12 mt-3" id="defect-reason-div" style="display: none;">
                            <label class="form-label text-danger">Defect Reason (for rejected panels)</label>
                            <input type="text" name="defect_reason" class="form-control" placeholder="e.g. Fabric flaw, miscut, measurement issue">
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary" style="background:linear-gradient(135deg,#f59e0b,#d97706);border:none;">
                                <i class="bi bi-check-circle me-1"></i> Save Inspection Record
                            </button>
                            <a href="{{ route('panel-inspection.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const rejectedInput = document.getElementById('rejected');
    const defectDiv = document.getElementById('defect-reason-div');
    
    rejectedInput.addEventListener('input', function() {
        if (parseInt(this.value) > 0) {
            defectDiv.style.display = 'block';
            defectDiv.querySelector('input').setAttribute('required', 'required');
        } else {
            defectDiv.style.display = 'none';
            defectDiv.querySelector('input').removeAttribute('required');
        }
    });
</script>
@endpush
@endsection
