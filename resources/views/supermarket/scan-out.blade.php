@extends('layouts.app')
@section('title', 'Super Market - Scan Out')
@section('page-title', 'Issue Bundle from Super Market')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0" style="font-weight:600;"><i class="bi bi-box-arrow-up me-2 text-success"></i>Scan Out (Issue to Floor)</h6>
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <form method="POST" action="{{ route('supermarket.store-out') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-success" style="font-weight:600;">Scan Bundle QR</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-qr-code-scan"></i></span>
                            <input type="text" name="bundle_no" class="form-control" placeholder="e.g. BNDL-CO1-M-XXXX" required autofocus>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Issue To (Line/Operator)</label>
                        <input type="text" name="issued_to_line" class="form-control" placeholder="e.g. Sewing Line 1" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100" style="background:linear-gradient(135deg,#10b981,#059669);border:none;">
                        <i class="bi bi-arrow-right-circle me-1"></i> Issue Bundle
                    </button>
                    <div class="text-center mt-3">
                        <a href="{{ route('supermarket.index') }}" class="text-muted" style="text-decoration:none;font-size:0.9rem;">Back to Inventory</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
