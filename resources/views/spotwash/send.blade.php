@extends('layouts.app')
@section('title', 'Spotwash - Send Garments')
@section('page-title', 'Send Garments to Spotwash')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0" style="font-weight:600;"><i class="bi bi-droplet-half me-2 text-info"></i>Log Stain Issue</h6>
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <form method="POST" action="{{ route('spotwash.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label text-info" style="font-weight:600;">Scan Bundle QR</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-qr-code-scan"></i></span>
                                <input type="text" name="bundle_no" class="form-control" placeholder="e.g. BNDL-CO1-M-XXXX" required autofocus>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mt-3">
                            <label class="form-label">Quantity Sent</label>
                            <input type="number" name="quantity_sent" class="form-control" min="1" required>
                            <small class="text-muted">How many pieces have stains?</small>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label class="form-label">Stain Type / Reason</label>
                            <input type="text" name="stain_type" class="form-control" placeholder="e.g. Machine Oil, Dust, Ink" required>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-info text-white w-100" style="background:linear-gradient(135deg,#06b6d4,#0891b2);border:none;">
                                <i class="bi bi-send-check me-1"></i> Send to Wash Department
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
