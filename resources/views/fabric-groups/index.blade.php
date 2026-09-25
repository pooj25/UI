@extends('layouts.app')
@section('title', 'Fabric Groups')
@section('page-title', 'Fabric Groups')

@section('content')
<div class="section-header">
    <h4><i class="bi bi-collection me-2 text-primary"></i>Fabric Groups</h4>
    <a href="{{ route('fabric-groups.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>New Group
    </a>
</div>

<!-- Filters -->
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" action="{{ route('fabric-groups.index') }}" class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                        placeholder="Search by code or name...">
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
                <a href="{{ route('fabric-groups.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($groups->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-collection d-block mb-3" style="font-size:2.5rem;color:#c7d2fe;"></i>
                <p class="mb-1 fw-500">No fabric groups found</p>
                <small>Create your first fabric group to organize fabrics.</small>
                <div class="mt-3">
                    <a href="{{ route('fabric-groups.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i>Create Group
                    </a>
                </div>
            </div>
        @else
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Group Code</th>
                            <th>Group Name</th>
                            <th>Fabrics</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groups as $group)
                        <tr>
                            <td class="text-muted" style="font-size:0.78rem;">{{ $loop->iteration + ($groups->currentPage() - 1) * $groups->perPage() }}</td>
                            <td><code style="color:#7c3aed;font-size:0.8rem;">{{ $group->group_code }}</code></td>
                            <td style="font-weight:500;">{{ $group->group_name }}</td>
                            <td>
                                <span class="badge" style="background:#f0edff;color:#4f46e5;font-size:0.78rem;padding:0.25rem 0.65rem;border-radius:20px;">
                                    {{ $group->fabrics_count }} fabric{{ $group->fabrics_count !== 1 ? 's' : '' }}
                                </span>
                            </td>
                            <td style="font-size:0.82rem;color:#6b7280;max-width:200px;">{{ Str::limit($group->description, 50) ?? '—' }}</td>
                            <td>
                                @if($group->status === 'active')
                                    <span class="badge-active">Active</span>
                                @else
                                    <span class="badge-inactive">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('fabric-groups.show', $group) }}" class="btn-action btn-view" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('fabric-groups.edit', $group) }}" class="btn-action btn-edit" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('fabric-groups.destroy', $group) }}" class="d-inline"
                                          onsubmit="return confirm('Delete group {{ addslashes($group->group_name) }}?')">
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
                    Showing {{ $groups->firstItem() }}–{{ $groups->lastItem() }} of {{ $groups->total() }} groups
                </small>
                {{ $groups->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
