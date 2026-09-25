@extends('layouts.app')
@section('title', $fabric->fabric_name)
@section('page-title', $fabric->fabric_name)

@section('content')
<div class="row g-3">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-0" style="font-weight:700;">{{ $fabric->fabric_name }}</h6>
                    <code style="font-size:0.78rem;color:#4f46e5;">{{ $fabric->fabric_code }}</code>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('fabrics.edit', $fabric) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                    <form method="POST" action="{{ route('fabrics.destroy', $fabric) }}"
                          onsubmit="return confirm('Delete this fabric?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash me-1"></i>Delete
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @php
                        $details = [
                            'Fabric Type'   => $fabric->fabric_type,
                            'Composition'   => $fabric->composition ?? '—',
                            'Color'         => $fabric->color ?? '—',
                            'GSM'           => $fabric->gsm ?? '—',
                            'Width'         => $fabric->width ?? '—',
                            'Unit'          => $fabric->unit ?? '—',
                        ];
                    @endphp
                    @foreach($details as $label => $value)
                    <div class="col-md-6">
                        <div style="background:#faf9ff;border-radius:10px;padding:0.85rem 1rem;border:1px solid #ede9ff;">
                            <div style="font-size:0.72rem;color:#6b7280;font-weight:600;text-transform:uppercase;letter-spacing:0.04em;margin-bottom:0.25rem;">{{ $label }}</div>
                            <div style="font-weight:600;color:#1e1b4b;">{{ $value }}</div>
                        </div>
                    </div>
                    @endforeach
                    <div class="col-md-6">
                        <div style="background:#faf9ff;border-radius:10px;padding:0.85rem 1rem;border:1px solid #ede9ff;">
                            <div style="font-size:0.72rem;color:#6b7280;font-weight:600;text-transform:uppercase;letter-spacing:0.04em;margin-bottom:0.25rem;">Status</div>
                            @if($fabric->status === 'active')
                                <span class="badge-active">Active</span>
                            @else
                                <span class="badge-inactive">Inactive</span>
                            @endif
                        </div>
                    </div>
                    @if($fabric->description)
                    <div class="col-12">
                        <div style="background:#faf9ff;border-radius:10px;padding:0.85rem 1rem;border:1px solid #ede9ff;">
                            <div style="font-size:0.72rem;color:#6b7280;font-weight:600;text-transform:uppercase;letter-spacing:0.04em;margin-bottom:0.25rem;">Description</div>
                            <div style="color:#374151;font-size:0.875rem;">{{ $fabric->description }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Fabric Groups this fabric belongs to -->
        @if($fabric->groups->isNotEmpty())
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0" style="font-weight:600;"><i class="bi bi-collection me-2 text-primary"></i>Fabric Groups</h6>
            </div>
            <div class="card-body d-flex flex-wrap gap-2">
                @foreach($fabric->groups as $group)
                    <a href="{{ route('fabric-groups.show', $group) }}"
                       class="badge text-decoration-none"
                       style="background:#f0edff;color:#4f46e5;font-size:0.82rem;padding:0.4rem 0.75rem;border-radius:20px;font-weight:500;">
                        {{ $group->group_code }} — {{ $group->group_name }}
                    </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <!-- Lay Models using this fabric -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0" style="font-weight:600;"><i class="bi bi-intersect me-2" style="color:#0891b2;"></i>Lay Models</h6>
            </div>
            <div class="card-body p-0">
                @if($fabric->layModels->isEmpty())
                    <div class="text-center py-4 text-muted" style="font-size:0.82rem;">
                        <i class="bi bi-inbox d-block mb-1" style="font-size:1.3rem;"></i>No lay models yet
                    </div>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach($fabric->layModels as $lm)
                            <li class="list-group-item d-flex align-items-center justify-content-between px-3 py-2">
                                <div>
                                    <div style="font-weight:500;font-size:0.85rem;">{{ $lm->lay_model_name }}</div>
                                    <code style="font-size:0.75rem;color:#0891b2;">{{ $lm->lay_model_code }}</code>
                                </div>
                                <a href="{{ route('lay-models.show', $lm) }}" class="btn-action btn-view">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <!-- Timestamps -->
        <div class="card mt-3">
            <div class="card-body">
                <div style="font-size:0.78rem;color:#6b7280;">
                    <div class="mb-1"><i class="bi bi-clock me-1"></i>Created: {{ $fabric->created_at->format('d M Y, H:i') }}</div>
                    <div><i class="bi bi-arrow-clockwise me-1"></i>Updated: {{ $fabric->updated_at->format('d M Y, H:i') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
