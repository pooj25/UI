@extends('layouts.app')
@section('title', 'Pack Garments')
@section('page-title', 'Pack Garments')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-light">
                <h6 class="mb-0" style="font-weight:600;"><i class="bi bi-box-seam me-2 text-primary"></i>Scan Bundle & Pack Carton</h6>
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <form method="POST" action="{{ route('packing.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label text-primary" style="font-weight:600;">Scan Bundle QR</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-qr-code-scan"></i></span>
                                <input type="text" name="bundle_no" class="form-control" placeholder="e.g. BNDL-CO1-M-XXXX" required autofocus>
                            </div>
                            <small class="text-muted">Scan the finished bundle ticket to pack it.</small>
                        </div>
                        
                        <div class="col-12"><hr></div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Quantity to Pack</label>
                            <input type="number" name="quantity_packed" class="form-control" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Packed By (Operator Name)</label>
                            <input type="text" name="packed_by" class="form-control" placeholder="e.g. Packer Team B" required>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary w-100" style="background:linear-gradient(135deg,#10b981,#059669);border:none;">
                                <i class="bi bi-box me-1"></i> Pack & Generate Carton Label
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
