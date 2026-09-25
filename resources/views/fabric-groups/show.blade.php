@extends('layouts.app')
@section('title', $fabricGroup->group_name)
@section('page-title', $fabricGroup->group_name)

@section('content')
<div class="row g-3">
    <div class="col-lg-8">
        <!-- Group Info -->
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-0" style="font-weight:700;">{{ $fabricGroup->group_name }}</h6>
                    <code style="font-size:0.78rem;color:#7c3aed;">{{ $fabricGroup->group_code }}</code>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('fabric-groups.edit', $fabricGroup) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                    <form method="POST" action="{{ route('fabric-groups.destroy', $fabricGroup) }}"
                          onsubmit="return confirm('Delete this fabric group?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash me-1"></i>Delete</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div style="background:#faf9ff;border-radius:10px;padding:0.85rem 1rem;border:1px solid #ede9ff;">
                            <div style="font-size:0.72rem;color:#6b7280;font-weight:600;text-transform:uppercase;letter-spacing:0.04em;margin-bottom:0.25rem;">Status</div>
                            @if($fabricGroup->status === 'active')
                                <span class="badge-active">Active</span>
                            @else
                                <span class="badge-inactive">Inactive</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div style="background:#faf9ff;border-radius:10px;padding:0.85rem 1rem;border:1px solid #ede9ff;">
                            <div style="font-size:0.72rem;color:#6b7280;font-weight:600;text-transform:uppercase;letter-spacing:0.04em;margin-bottom:0.25rem;">Total Fabrics</div>
                            <div style="font-weight:600;color:#4f46e5;font-size:1.25rem;">{{ $fabricGroup->fabrics->count() }}</div>
                        </div>
                    </div>
                    @if($fabricGroup->description)
                    <div class="col-12">
                        <div style="background:#faf9ff;border-radius:10px;padding:0.85rem 1rem;border:1px solid #ede9ff;">
                            <div style="font-size:0.72rem;color:#6b7280;font-weight:600;text-transform:uppercase;letter-spacing:0.04em;margin-bottom:0.25rem;">Description</div>
                            <div style="color:#374151;font-size:0.875rem;">{{ $fabricGroup->description }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Fabrics in this Group -->
        <div class="card mt-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0" style="font-weight:600;"><i class="bi bi-layers me-2 text-primary"></i>Fabrics in this Group</h6>
            </div>
            <div class="card-body p-0">
                @if($fabricGroup->fabrics->isEmpty())
                    <div class="text-center py-4 text-muted" style="font-size:0.85rem;">
                        <i class="bi bi-inbox d-block mb-2" style="font-size:1.5rem;"></i>No fabrics in this group yet.
                    </div>
                @else
                    <table class="table mb-0">
                        <thead>
                            <tr><th>Code</th><th>Name</th><th>Type</th><th>GSM</th><th>Width</th><th>Status</th><th>Action</th></tr>
                        </thead>
                        <tbody>
                            @foreach($fabricGroup->fabrics as $fabric)
                            <tr>
                                <td><code style="color:#4f46e5;font-size:0.8rem;">{{ $fabric->fabric_code }}</code></td>
                                <td style="font-weight:500;">{{ $fabric->fabric_name }}</td>
                                <td><span class="badge" style="background:#f0edff;color:#4f46e5;font-size:0.72rem;">{{ $fabric->fabric_type }}</span></td>
                                <td>{{ $fabric->gsm ?? '—' }}</td>
                                <td>{{ $fabric->width ?? '—' }}</td>
                                <td>
                                    @if($fabric->status === 'active')
                                        <span class="badge-active">Active</span>
                                    @else
                                        <span class="badge-inactive">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('fabric-groups.remove-fabric', [$fabricGroup, $fabric]) }}"
                                          onsubmit="return confirm('Remove {{ addslashes($fabric->fabric_name) }} from this group?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete" title="Remove from group">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <!-- Add Fabric to Group -->
        @if($availableFabrics->isNotEmpty())
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0" style="font-weight:600;"><i class="bi bi-plus-circle me-2 text-success"></i>Add Fabric to Group</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('fabric-groups.add-fabric', $fabricGroup) }}" class="d-flex gap-2">
                    @csrf
                    <select name="fabric_id" class="form-select" required>
                        <option value="">Select a fabric to add...</option>
                        @foreach($availableFabrics as $f)
                            <option value="{{ $f->id }}">{{ $f->fabric_code }} — {{ $f->fabric_name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-success btn-sm" style="white-space:nowrap;">
                        <i class="bi bi-plus-lg me-1"></i>Add
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <!-- Lay Models using this group -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0" style="font-weight:600;"><i class="bi bi-intersect me-2" style="color:#0891b2;"></i>Lay Models</h6>
            </div>
            <div class="card-body p-0">
                @if($fabricGroup->layModels->isEmpty())
                    <div class="text-center py-4 text-muted" style="font-size:0.82rem;">
                        <i class="bi bi-inbox d-block mb-1" style="font-size:1.3rem;"></i>No lay models yet
                    </div>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach($fabricGroup->layModels as $lm)
                            <li class="list-group-item d-flex align-items-center justify-content-between px-3 py-2">
                                <div>
                                    <div style="font-weight:500;font-size:0.85rem;">{{ $lm->lay_model_name }}</div>
                                    <code style="font-size:0.75rem;color:#0891b2;">{{ $lm->lay_model_code }}</code>
                                </div>
                                <a href="{{ route('lay-models.show', $lm) }}" class="btn-action btn-view"><i class="bi bi-eye"></i></a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <div style="font-size:0.78rem;color:#6b7280;">
                    <div class="mb-1"><i class="bi bi-clock me-1"></i>Created: {{ $fabricGroup->created_at->format('d M Y, H:i') }}</div>
                    <div><i class="bi bi-arrow-clockwise me-1"></i>Updated: {{ $fabricGroup->updated_at->format('d M Y, H:i') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
