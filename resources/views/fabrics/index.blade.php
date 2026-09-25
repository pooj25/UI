@extends('layouts.app')
@section('title', 'Fabrics')
@section('page-title', 'Fabric Master')

@section('content')
<div class="section-header">
    <h4><i class="bi bi-layers me-2 text-primary"></i>Fabrics</h4>
    <a href="{{ route('fabrics.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>New Fabric
    </a>
</div>

<!-- Filters -->
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" action="{{ route('fabrics.index') }}" class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                        placeholder="Search by code, name, type or color...">
                </div>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-auto d-flex gap-2">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('fabrics.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($fabrics->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-layers d-block mb-3" style="font-size:2.5rem;color:#c7d2fe;"></i>
                <p class="mb-1 fw-500">No fabrics found</p>
                <small>Create your first fabric to get started.</small>
                <div class="mt-3">
                    <a href="{{ route('fabrics.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i>Create Fabric
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
                            <th>Type</th>
                            <th>Composition</th>
                            <th>GSM</th>
                            <th>Width</th>
                            <th>Unit</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fabrics as $fabric)
                        <tr>
                            <td class="text-muted" style="font-size:0.78rem;">{{ $loop->iteration + ($fabrics->currentPage() - 1) * $fabrics->perPage() }}</td>
                            <td><code style="color:#4f46e5;font-size:0.8rem;">{{ $fabric->fabric_code }}</code></td>
                            <td style="font-weight:500;">{{ $fabric->fabric_name }}</td>
                            <td><span class="badge" style="background:#f0edff;color:#4f46e5;font-weight:500;font-size:0.75rem;">{{ $fabric->fabric_type }}</span></td>
                            <td style="font-size:0.82rem;color:#6b7280;">{{ $fabric->composition ?? '—' }}</td>
                            <td>{{ $fabric->gsm ?? '—' }}</td>
                            <td>{{ $fabric->width ?? '—' }}</td>
                            <td style="font-size:0.82rem;">{{ $fabric->unit ?? '—' }}</td>
                            <td>
                                @if($fabric->status === 'active')
                                    <span class="badge-active">Active</span>
                                @else
                                    <span class="badge-inactive">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('fabrics.show', $fabric) }}" class="btn-action btn-view" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('fabrics.edit', $fabric) }}" class="btn-action btn-edit" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('fabrics.destroy', $fabric) }}" class="d-inline"
                                          onsubmit="return confirm('Delete fabric {{ addslashes($fabric->fabric_name) }}? This cannot be undone.')">
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
                    Showing {{ $fabrics->firstItem() }}–{{ $fabrics->lastItem() }} of {{ $fabrics->total() }} fabrics
                </small>
                {{ $fabrics->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
