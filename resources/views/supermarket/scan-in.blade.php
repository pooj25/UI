@extends('layouts.app')
@section('title', 'Super Market - Scan In')
@section('page-title', 'Receive Bundle to Super Market')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-light">
                <h6 class="mb-0" style="font-weight:600;"><i class="bi bi-box-arrow-in-down me-2 text-primary"></i>Scan In (Receive to Storage)</h6>
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <form method="POST" action="{{ route('supermarket.store-in') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-primary" style="font-weight:600;">Scan Bundle QR</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-qr-code-scan"></i></span>
                            <input type="text" name="bundle_no" class="form-control" placeholder="e.g. BNDL-CO1-M-XXXX" required autofocus>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Bin / Rack Location</label>
                        <input type="text" name="bin_location" class="form-control" placeholder="e.g. Rack-A1" required>
                        <small class="text-muted">Specify where you are physically storing this bundle.</small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" style="background:linear-gradient(135deg,#3b82f6,#2563eb);border:none;">
                        <i class="bi bi-check-circle me-1"></i> Receive Bundle
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
