@extends('layouts.app')
@section('title', 'Scan Bundle')
@section('page-title', 'Scan Bundle for Sewing')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card text-center" style="border:2px dashed #8b5cf6;">
            <div class="card-body py-5">
                <i class="bi bi-qr-code-scan mb-3" style="font-size:3rem; color:#8b5cf6;"></i>
                <h5 style="font-weight:700;">Scan Bundle QR</h5>
                <p class="text-muted" style="font-size:0.9rem;">Scan the QR code on the bundle ticket to record sewing production.</p>
                
                <form method="POST" action="{{ route('sewing.process-scan') }}" class="mt-4">
                    @csrf
                    <div class="input-group input-group-lg mx-auto" style="max-width: 400px;">
                        <input type="text" name="bundle_no" class="form-control text-center" placeholder="e.g. BNDL-CO1-S-ABCD" required autofocus>
                        <button class="btn btn-primary" type="submit" style="background:#8b5cf6; border:none;"><i class="bi bi-arrow-right"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
