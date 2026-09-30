@extends('layouts.app')
@section('title', 'Generate Bundles')
@section('page-title', 'Generate Bundles for ' . $cutOrder->cut_order_no)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0" style="font-weight:600;">Bundle Configuration</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('number-bundling.store', $cutOrder) }}">
                    @csrf
                    
                    <div id="bundle-rows">
                        <div class="row g-2 align-items-center mb-3 bundle-row">
                            <div class="col-md-5">
                                <label class="form-label" style="font-size:0.8rem;">Size</label>
                                <input type="text" name="bundles[0][size]" class="form-control" placeholder="e.g. M, L, XL" required>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label" style="font-size:0.8rem;">Quantity (Pieces)</label>
                                <input type="number" min="1" name="bundles[0][quantity]" class="form-control" required>
                            </div>
                            <div class="col-md-2 mt-4 text-end">
                                <button type="button" class="btn btn-sm btn-outline-danger remove-row"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" id="add-row" class="btn btn-sm btn-outline-secondary mb-4">
                        <i class="bi bi-plus-lg me-1"></i> Add Bundle
                    </button>
                    
                    <hr>
                    <button type="submit" class="btn btn-primary" style="background:linear-gradient(135deg,#0ea5e9,#0284c7);border:none;">
                        Generate Bundles
                    </button>
                    <a href="{{ route('number-bundling.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-light border-0">
            <div class="card-body">
                <h6 style="font-weight:600; color:#374151;">Summary</h6>
                <p class="mb-1 text-muted" style="font-size:0.85rem;">Cut Order: <strong class="text-dark">{{ $cutOrder->cut_order_no }}</strong></p>
                <p class="mb-1 text-muted" style="font-size:0.85rem;">Lay Model: <strong class="text-dark">{{ $cutOrder->layModel?->lay_model_code }}</strong></p>
                <p class="mb-0 text-muted" style="font-size:0.85rem;">Planned Qty: <strong class="text-dark">{{ $cutOrder->planned_qty }}</strong> pieces</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let rowIndex = 1;
    document.getElementById('add-row').addEventListener('click', function() {
        const container = document.getElementById('bundle-rows');
        const row = document.createElement('div');
        row.className = 'row g-2 align-items-center mb-3 bundle-row';
        row.innerHTML = `
            <div class="col-md-5">
                <input type="text" name="bundles[${rowIndex}][size]" class="form-control" placeholder="e.g. M, L, XL" required>
            </div>
            <div class="col-md-5">
                <input type="number" min="1" name="bundles[${rowIndex}][quantity]" class="form-control" required>
            </div>
            <div class="col-md-2 text-end">
                <button type="button" class="btn btn-sm btn-outline-danger remove-row"><i class="bi bi-trash"></i></button>
            </div>
        `;
        container.appendChild(row);
        rowIndex++;
    });

    document.getElementById('bundle-rows').addEventListener('click', function(e) {
        if (e.target.closest('.remove-row')) {
            const rows = document.querySelectorAll('.bundle-row');
            if(rows.length > 1) {
                e.target.closest('.bundle-row').remove();
            }
        }
    });
</script>
@endpush
@endsection
