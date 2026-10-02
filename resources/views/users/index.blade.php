@extends('layouts.app')
@section('title', 'Users & Shift Access')
@section('page-title', 'Users & Access')

@push('styles')
<style>
    .kpi-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; margin-bottom: 1.5rem; }
    .kpi-card { background: #fff; border: 1px solid var(--border-color); border-radius: 8px; padding: 1.25rem; box-shadow: 0 1px 2px rgba(0,0,0,0.02); }
    .kpi-label { font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; }
    .kpi-val { font-size: 2rem; font-weight: 700; color: var(--text-main); font-family: var(--ops-mono); }
    .kpi-sub { font-size: 0.75rem; color: var(--primary); font-weight: 600; margin-top: 0.25rem; }

    .action-btn { background: var(--primary); color: #fff; padding: 0.5rem 1.25rem; border-radius: 6px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; border: 1px solid var(--primary); transition: background 0.2s; }
    .action-btn:hover { background: var(--primary-dark); color: #fff; border-color: var(--primary-dark); }

    .ops-badge { padding: 0.35rem 0.65rem; border-radius: 4px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.03em; border: 1px solid transparent; display: inline-block; }
    .badge-active { background: #f0fdf4; color: #166534; border-color: #bbf7d0; }
    .badge-on-shift { background: #eff6ff; color: #1e40af; border-color: #bfdbfe; }
    .badge-inactive { background: #f1f5f9; color: #475569; border-color: #e2e8f0; }
    .badge-suspended { background: #fef2f2; color: #991b1b; border-color: #fecaca; }

    .font-mono { font-family: var(--ops-mono); font-variant-numeric: tabular-nums; }
    .section-title { font-size: 1rem; font-weight: 700; color: var(--text-main); margin-bottom: 1rem; display: flex; justify-content: space-between; align-items: center; }

    .filters-strip { display: flex; gap: 1rem; background: #fff; padding: 1rem; border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 1.5rem; align-items: flex-end; }
    .filter-group { flex: 1; }
    .filter-group label { display: block; font-size: 0.75rem; font-weight: 600; color: var(--text-muted); margin-bottom: 0.3rem; text-transform: uppercase; }
    .filter-group input, .filter-group select { width: 100%; border: 1px solid #cbd5e1; border-radius: 6px; padding: 0.5rem; font-size: 0.85rem; color: var(--text-main); }
    .filter-group input:focus, .filter-group select:focus { border-color: var(--primary); outline: none; box-shadow: 0 0 0 2px rgba(21,128,61,0.1); }
    
    .table-action-btn { background: transparent; border: 1px solid #cbd5e1; border-radius: 4px; padding: 0.25rem 0.5rem; font-size: 0.75rem; font-weight: 600; color: var(--text-main); cursor: pointer; display: inline-flex; align-items: center; gap: 0.25rem; transition: all 0.15s; }
    .table-action-btn:hover { background: #f8fafc; border-color: #94a3b8; }
    .table-action-danger { color: #b91c1c; border-color: #fca5a5; }
    .table-action-danger:hover { background: #fef2f2; border-color: #f87171; }

    @media (max-width: 1024px) {
        .kpi-grid { grid-template-columns: repeat(2, 1fr); }
        .filters-strip { flex-wrap: wrap; }
        .filter-group { min-width: 200px; }
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold" style="color:var(--text-main);">Users & Shift Access</h4>
        <div class="text-muted mt-1" style="font-size:0.85rem;">Manage factory users, roles and shift access.</div>
    </div>
    <div>
        <button class="action-btn" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="bi bi-person-plus-fill"></i> Add User
        </button>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Add New System User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('users.store') }}" method="POST" id="addUserForm">
                @csrf
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="name" placeholder="e.g. Rajesh Verma" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select" name="role" required>
                            <option value="">Select Role...</option>
                            <option value="Admin">Admin</option>
                            <option value="Manager">Manager</option>
                            <option value="Supervisor">Supervisor</option>
                            <option value="Operator">Operator</option>
                            <option value="QC Inspector">QC Inspector</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Line / Zone Assignment</label>
                        <select class="form-select" name="line_zone">
                            <option value="Warehouse">Warehouse</option>
                            <option value="Cutting Floor">Cutting Floor</option>
                            <option value="Sewing Line A">Sewing Line A</option>
                            <option value="Packing">Packing</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email / Username</label>
                        <input type="email" class="form-control" name="email" placeholder="user@tracktech.com" required>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background:var(--primary);border-color:var(--primary);">Save User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- KPI Cards -->
<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-label">Active Users</div>
        <div class="kpi-val">142</div>
        <div class="kpi-sub"><i class="bi bi-check-circle"></i> Enabled accounts</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Users On Shift</div>
        <div class="kpi-val">68</div>
        <div class="kpi-sub" style="color:#1e40af;"><i class="bi bi-person-workspace"></i> Currently clocked in</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Scan Devices</div>
        <div class="kpi-val">24</div>
        <div class="kpi-sub" style="color:#b45309;"><i class="bi bi-upc-scan"></i> Authorized tablets/scanners</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Failed Logins</div>
        <div class="kpi-val">3</div>
        <div class="kpi-sub" style="color:#b91c1c;"><i class="bi bi-shield-exclamation"></i> Security alerts today</div>
    </div>
</div>

<!-- Filters Strip -->
<div class="filters-strip">
    <div class="filter-group" style="flex: 2;">
        <label>Search Users</label>
        <div class="input-group">
            <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
            <input type="text" class="form-control border-start-0 ps-0" placeholder="Search by name, ID or email...">
        </div>
    </div>
    <div class="filter-group">
        <label>Role</label>
        <select>
            <option>All Roles</option>
            <option>Admin</option>
            <option>Manager</option>
            <option>Supervisor</option>
            <option>Operator</option>
            <option>QC Inspector</option>
        </select>
    </div>
    <div class="filter-group">
        <label>Line / Zone</label>
        <select>
            <option>All Lines</option>
            <option>Warehouse</option>
            <option>Cutting Floor</option>
            <option>Sewing Line A</option>
            <option>Sewing Line B</option>
            <option>Packing</option>
        </select>
    </div>
    <div class="filter-group">
        <label>Status</label>
        <select>
            <option>All Statuses</option>
            <option>Active</option>
            <option>On Shift</option>
            <option>Inactive</option>
            <option>Suspended</option>
        </select>
    </div>
</div>

<!-- Users Table -->
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Line / Zone</th>
                    <th>Last Login</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="font-mono text-muted">USR-{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td class="fw-bold">{{ $user->name }}</td>
                    <td>{{ $user->role ?? 'N/A' }}</td>
                    <td class="text-muted">{{ $user->line_zone ?? 'N/A' }}</td>
                    <td class="font-mono text-muted">{{ $user->last_login ?? 'N/A' }}</td>
                    <td>
                        @if($user->status === 'ACTIVE')
                            <span class="ops-badge badge-active">Active</span>
                        @elseif($user->status === 'ON SHIFT')
                            <span class="ops-badge badge-on-shift">On Shift</span>
                        @elseif($user->status === 'INACTIVE')
                            <span class="ops-badge badge-inactive">Inactive</span>
                        @elseif($user->status === 'SUSPENDED')
                            <span class="ops-badge badge-suspended">Suspended</span>
                        @else
                            <span class="ops-badge badge-inactive">{{ $user->status }}</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <button class="table-action-btn real-action" data-bs-toggle="modal" data-bs-target="#editUserModal-{{ $user->id }}">
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Disable this user?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="table-action-btn table-action-danger real-action"><i class="bi bi-ban"></i> Disable</button>
                        </form>
                    </td>
                </tr>

                <!-- Edit User Modal -->
                <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header border-bottom-0 pb-0">
                                <h5 class="modal-title fw-bold">Edit System User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('users.update', $user) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="modal-body py-3 text-start">
                                    <div class="mb-3">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Role</label>
                                        <select class="form-select" name="role" required>
                                            @foreach(['Admin','Manager','Supervisor','Operator','QC Inspector'] as $r)
                                                <option value="{{ $r }}" {{ $user->role == $r ? 'selected' : '' }}>{{ $r }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Line / Zone Assignment</label>
                                        <select class="form-select" name="line_zone">
                                            @foreach(['Warehouse','Cutting Floor','Sewing Line A','Packing'] as $lz)
                                                <option value="{{ $lz }}" {{ $user->line_zone == $lz ? 'selected' : '' }}>{{ $lz }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email / Username</label>
                                        <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Employee ID</label>
                                        <input type="text" class="form-control" name="employee_id" value="{{ $user->employee_id }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select class="form-select" name="status" required>
                                            @foreach(['ACTIVE','INACTIVE','ON SHIFT','SUSPENDED'] as $st)
                                                <option value="{{ $st }}" {{ $user->status == $st ? 'selected' : '' }}>{{ ucfirst(strtolower($st)) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password (Leave blank to keep current)</label>
                                        <input type="password" class="form-control" name="password" placeholder="••••••••">
                                    </div>
                                </div>
                                <div class="modal-footer border-top-0 pt-0">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary" style="background:var(--primary);border-color:var(--primary);">Update User</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
