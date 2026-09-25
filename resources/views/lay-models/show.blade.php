@extends('layouts.app')
@section('title', $layModel->lay_model_name)
@section('page-title', $layModel->lay_model_name)

@section('content')
<div class="row g-3">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-0" style="font-weight:700;">{{ $layModel->lay_model_name }}</h6>
                    <code style="font-size:0.78rem;color:#0891b2;">{{ $layModel->lay_model_code }}</code>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('lay-models.edit', $layModel) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                    <form method="POST" action="{{ route('lay-models.destroy', $layModel) }}"
                          onsubmit="return confirm('Delete this lay model?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash me-1"></i>Delete</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <!-- Relationship breadcrumb -->
                <div class="d-flex align-items-center gap-2 mb-3 p-3" style="background:#f0f9ff;border-radius:10px;border:1px solid #bae6fd;">
                    <a href="{{ route('fabric-groups.show', $layModel->fabricGroup) }}"
                       class="text-decoration-none" style="color:#0891b2;font-weight:600;font-size:0.85rem;">
                        <i class="bi bi-collection me-1"></i>{{ $layModel->fabricGroup?->group_name }}
                    </a>
                    <i class="bi bi-chevron-right text-muted" style="font-size:0.75rem;"></i>
                    <a href="{{ route('fabrics.show', $layModel->fabric) }}"
                       class="text-decoration-none" style="color:#4f46e5;font-weight:600;font-size:0.85rem;">
                        <i class="bi bi-layers me-1"></i>{{ $layModel->fabric?->fabric_name }}
                    </a>
                    <i class="bi bi-chevron-right text-muted" style="font-size:0.75rem;"></i>
                    <span style="color:#374151;font-weight:600;font-size:0.85rem;">
                        <i class="bi bi-intersect me-1"></i>{{ $layModel->lay_model_name }}
                    </span>
                </div>

                <div class="row g-3">
                    @php
                    $params = [
                        'Lay Length'      => $layModel->lay_length,
                        'Lay Width'       => $layModel->lay_width,
                        'Number of Plies' => $layModel->number_of_plies,
                        'Garment Size'    => $layModel->garment_size ?? '—',
                        'Marker Length'   => $layModel->marker_length ?? '—',
                        'Marker Width'    => $layModel->marker_width  ?? '—',
                    ];
                    @endphp
                    @foreach($params as $label => $val)
                    <div class="col-md-4">
                        <div style="background:#faf9ff;border-radius:10px;padding:0.85rem 1rem;border:1px solid #ede9ff;">
                            <div style="font-size:0.72rem;color:#6b7280;font-weight:600;text-transform:uppercase;letter-spacing:0.04em;margin-bottom:0.25rem;">{{ $label }}</div>
                            <div style="font-weight:700;color:#1e1b4b;font-size:1.05rem;">{{ $val }}</div>
                        </div>
                    </div>
                    @endforeach
                    <div class="col-md-4">
                        <div style="background:#faf9ff;border-radius:10px;padding:0.85rem 1rem;border:1px solid #ede9ff;">
                            <div style="font-size:0.72rem;color:#6b7280;font-weight:600;text-transform:uppercase;letter-spacing:0.04em;margin-bottom:0.25rem;">Status</div>
                            @if($layModel->status === 'active')
                                <span class="badge-active">Active</span>
                            @else
                                <span class="badge-inactive">Inactive</span>
                            @endif
                        </div>
                    </div>
                    @if($layModel->description)
                    <div class="col-12">
                        <div style="background:#faf9ff;border-radius:10px;padding:0.85rem 1rem;border:1px solid #ede9ff;">
                            <div style="font-size:0.72rem;color:#6b7280;font-weight:600;text-transform:uppercase;letter-spacing:0.04em;margin-bottom:0.25rem;">Description</div>
                            <div style="color:#374151;font-size:0.875rem;">{{ $layModel->description }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Related info -->
        <div class="card">
            <div class="card-header"><h6 class="mb-0" style="font-weight:600;"><i class="bi bi-diagram-3 me-2 text-primary"></i>Relationships</h6></div>
            <div class="card-body">
                <div class="mb-3">
                    <div style="font-size:0.72rem;color:#6b7280;font-weight:600;text-transform:uppercase;letter-spacing:0.04em;">Fabric Group</div>
                    <div class="mt-1">
                        <a href="{{ route('fabric-groups.show', $layModel->fabricGroup) }}" class="text-decoration-none">
                            <span style="background:#f5f3ff;color:#7c3aed;padding:0.35rem 0.75rem;border-radius:8px;font-size:0.85rem;font-weight:600;display:inline-block;">
                                {{ $layModel->fabricGroup?->group_code }} — {{ $layModel->fabricGroup?->group_name }}
                            </span>
                        </a>
                    </div>
                </div>
                <div>
                    <div style="font-size:0.72rem;color:#6b7280;font-weight:600;text-transform:uppercase;letter-spacing:0.04em;">Fabric</div>
                    <div class="mt-1">
                        <a href="{{ route('fabrics.show', $layModel->fabric) }}" class="text-decoration-none">
                            <span style="background:#f0edff;color:#4f46e5;padding:0.35rem 0.75rem;border-radius:8px;font-size:0.85rem;font-weight:600;display:inline-block;">
                                {{ $layModel->fabric?->fabric_code }} — {{ $layModel->fabric?->fabric_name }}
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body">
                <div style="font-size:0.78rem;color:#6b7280;">
                    <div class="mb-1"><i class="bi bi-clock me-1"></i>Created: {{ $layModel->created_at->format('d M Y, H:i') }}</div>
                    <div><i class="bi bi-arrow-clockwise me-1"></i>Updated: {{ $layModel->updated_at->format('d M Y, H:i') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
