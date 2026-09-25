@extends('layouts.app')
@section('title', 'Lay Models')
@section('page-title', 'Lay Models')

@section('content')
<div class="section-header">
    <h4><i class="bi bi-intersect me-2" style="color:#0891b2;"></i>Lay Models</h4>
    <a href="{{ route('lay-models.create') }}" class="btn btn-primary" style="background:linear-gradient(135deg,#0891b2,#06b6d4);border-color:#0891b2;">
        <i class="bi bi-plus-lg me-1"></i>New Lay Model
    </a>
</div>

<!-- Filters -->
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" action="{{ route('lay-models.index') }}" class="row g-2 align-items-center">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                        placeholder="Search code, name, or size...">
                </div>
            </div>
            <div class="col-md-3">
                <select name="fabric_group_id" class="form-select">
                    <option value="">All Fabric Groups</option>
                    @foreach($fabricGroups as $group)
                        <option value="{{ $group->id }}" {{ request('fabric_group_id') == $group->id ? 'selected' : '' }}>
                            {{ $group->group_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-auto d-flex gap-2">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('lay-models.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($layModels->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-intersect d-block mb-3" style="font-size:2.5rem;color:#a5f3fc;"></i>
                <p class="mb-1 fw-500">No lay models found</p>
                <small>Create your first lay model to begin production planning.</small>
                <div class="mt-3">
                    <a href="{{ route('lay-models.create') }}" class="btn btn-sm" style="background:#0891b2;color:#fff;">
                        <i class="bi bi-plus-lg me-1"></i>Create Lay Model
                    </a>
                </div>
            </div>
        @else
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Fabric Group</th>
                            <th>Fabric</th>
                            <th>Lay Length</th>
                            <th>Plies</th>
                            <th>Size</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($layModels as $lm)
                        <tr>
                            <td class="text-muted" style="font-size:0.78rem;">{{ $loop->iteration + ($layModels->currentPage() - 1) * $layModels->perPage() }}</td>
                            <td><code style="color:#0891b2;font-size:0.8rem;">{{ $lm->lay_model_code }}</code></td>
                            <td style="font-weight:500;">{{ $lm->lay_model_name }}</td>
                            <td>
                                @if($lm->fabricGroup)
                                    <a href="{{ route('fabric-groups.show', $lm->fabricGroup) }}" style="color:#7c3aed;font-size:0.82rem;text-decoration:none;">
                                        {{ $lm->fabricGroup->group_code }}
                                    </a>
                                @else —
                                @endif
                            </td>
                            <td style="font-size:0.82rem;">{{ $lm->fabric?->fabric_code ?? '—' }}</td>
                            <td>{{ $lm->lay_length }}</td>
                            <td>{{ $lm->number_of_plies }}</td>
                            <td>{{ $lm->garment_size ?? '—' }}</td>
                            <td>
                                @if($lm->status === 'active')
                                    <span class="badge-active">Active</span>
                                @else
                                    <span class="badge-inactive">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('lay-models.show', $lm) }}" class="btn-action btn-view" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('lay-models.edit', $lm) }}" class="btn-action btn-edit" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('lay-models.destroy', $lm) }}" class="d-inline"
                                          onsubmit="return confirm('Delete lay model {{ addslashes($lm->lay_model_name) }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex align-items-center justify-content-between p-3">
                <small class="text-muted">
                    Showing {{ $layModels->firstItem() }}–{{ $layModels->lastItem() }} of {{ $layModels->total() }} lay models
                </small>
                {{ $layModels->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
