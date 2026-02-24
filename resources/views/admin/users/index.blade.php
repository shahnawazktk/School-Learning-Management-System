@extends('layouts.admin.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <div>
            <h1 class="h3 mb-1">Users & Access</h1>
            <p class="text-muted mb-0">Create users and control dashboard access approval for non-admin roles.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge text-bg-warning">Pending: {{ $pendingCount }}</span>
            <span class="badge text-bg-light fs-6">{{ $users->total() }} users</span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @php
        $showCreateUserForm = $errors->any() || old('name') || old('email') || old('role');
    @endphp

    <div class="row g-4">
        <div class="col-12">
            <div class="card admin-card">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Create User</h5>
                    <button
                        class="btn btn-outline-primary btn-sm"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#createUserCollapse"
                        aria-expanded="{{ $showCreateUserForm ? 'true' : 'false' }}"
                        aria-controls="createUserCollapse">
                        Toggle Form
                    </button>
                </div>
                <div class="collapse {{ $showCreateUserForm ? 'show' : '' }}" id="createUserCollapse">
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0 ps-3">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.users.store') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-12 col-lg-6">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label class="form-label">Role</label>
                                    <select name="role" class="form-select" required>
                                        <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select role</option>
                                        <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Student</option>
                                        <option value="teacher" {{ old('role') === 'teacher' ? 'selected' : '' }}>Teacher</option>
                                        <option value="parent" {{ old('role') === 'parent' ? 'selected' : '' }}>Parent</option>
                                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-text mt-2">Student, Teacher, and Parent accounts require admin approval before login.</div>
                            <button type="submit" class="btn btn-primary mt-3">
                                <i class="fas fa-check me-1"></i> Create User
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card admin-card">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-users me-2"></i>Recent Users</h5>
                    <span class="badge text-bg-light">{{ $users->count() }} on this page</span>
                </div>
                <div class="card-body">
                    @php
                        $tabBaseQuery = array_filter(['role' => $role, 'q' => $search], fn ($value) => $value !== '');
                    @endphp

                    <div class="nav nav-pills nav-fill bg-light rounded p-1 mb-3">
                        <a href="{{ route('admin.users', $tabBaseQuery) }}"
                           class="nav-link {{ $approval === '' ? 'active' : 'text-dark' }}">
                            All <span class="badge text-bg-light ms-1">{{ $allCount }}</span>
                        </a>
                        <a href="{{ route('admin.users', array_merge($tabBaseQuery, ['approval' => 'pending'])) }}"
                           class="nav-link {{ $approval === 'pending' ? 'active' : 'text-dark' }}">
                            Pending <span class="badge text-bg-warning ms-1">{{ $pendingCount }}</span>
                        </a>
                        <a href="{{ route('admin.users', array_merge($tabBaseQuery, ['approval' => 'approved'])) }}"
                           class="nav-link {{ $approval === 'approved' ? 'active' : 'text-dark' }}">
                            Approved <span class="badge text-bg-success ms-1">{{ $approvedCount }}</span>
                        </a>
                    </div>

                    <form method="GET" action="{{ route('admin.users') }}" class="row g-2 mb-3">
                        <div class="col-12 col-md-4">
                            <label class="form-label small text-muted mb-1">Role</label>
                            <select name="role" class="form-select">
                                <option value="">All roles</option>
                                <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="teacher" {{ $role === 'teacher' ? 'selected' : '' }}>Teacher</option>
                                <option value="student" {{ $role === 'student' ? 'selected' : '' }}>Student</option>
                                <option value="parent" {{ $role === 'parent' ? 'selected' : '' }}>Parent</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label small text-muted mb-1">Approval</label>
                            <select name="approval" class="form-select">
                                <option value="">All</option>
                                <option value="approved" {{ $approval === 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="pending" {{ $approval === 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label small text-muted mb-1">Search</label>
                            <input type="text" name="q" class="form-control" value="{{ $search }}" placeholder="Name or email">
                        </div>
                        <div class="col-12 d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-filter me-1"></i>Apply Filters
                            </button>
                            <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                        </div>
                    </form>
                    
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="selectAllVisibleBtn">Select All Visible</button>
                            <button type="button" class="btn btn-outline-warning btn-sm" id="selectAllPendingBtn">Select All Pending</button>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-success btn-sm" id="bulkApproveBtn">Approve Selected</button>
                            <button type="button" class="btn btn-outline-danger btn-sm" id="bulkRevokeBtn">Revoke Selected</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:44px;">
                                        <input type="checkbox" id="selectAllCheckbox" class="form-check-input">
                                    </th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Role</th>
                                    <th>Approval</th>
                                    <th>Created</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    @php
                                        $badge = match($user->role) {
                                            'admin' => 'text-bg-danger',
                                            'teacher' => 'text-bg-primary',
                                            'student' => 'text-bg-success',
                                            'parent' => 'text-bg-warning',
                                            default => 'text-bg-secondary'
                                        };
                                        $canManageApproval = $user->role !== 'admin';
                                    @endphp
                                    <tr>
                                        <td class="text-center">
                                            @if($canManageApproval)
                                                <input
                                                    type="checkbox"
                                                    class="form-check-input user-select-checkbox"
                                                    value="{{ $user->id }}"
                                                    data-pending="{{ $user->is_approved ? '0' : '1' }}">
                                            @endif
                                        </td>
                                        <td class="fw-semibold">{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->temporary_password)
                                                <span class="badge text-bg-info">{{ $user->temporary_password }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td><span class="badge {{ $badge }}">{{ ucfirst($user->role) }}</span></td>
                                        <td>
                                            @if($user->role === 'admin')
                                                <span class="badge text-bg-dark">Always Allowed</span>
                                            @elseif($user->is_approved)
                                                <span class="badge text-bg-success">Approved</span>
                                            @else
                                                <span class="badge text-bg-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>{{ optional($user->created_at)->format('M d, Y') ?? 'N/A' }}</td>
                                        <td class="text-end">
                                            @if($canManageApproval)
                                                @if($user->is_approved)
                                                    <form method="POST" action="{{ route('admin.users.revoke', $user) }}" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            Revoke
                                                        </button>
                                                    </form>
                                                @else
                                                    <form method="POST" action="{{ route('admin.users.approve', $user) }}" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            Approve
                                                        </button>
                                                    </form>
                                                @endif
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No users found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <form id="bulkApprovalForm" method="POST" action="{{ route('admin.users.bulk-approval') }}" class="d-none">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="action" id="bulkActionInput">
                        <div id="bulkUserIdsContainer"></div>
                    </form>

                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (() => {
        const createUserCollapseElement = document.getElementById('createUserCollapse');
        if (createUserCollapseElement && !createUserCollapseElement.classList.contains('show')) {
            const mobileQuery = window.matchMedia('(max-width: 991.98px)');
            if (!mobileQuery.matches) {
                const createUserCollapse = new bootstrap.Collapse(createUserCollapseElement, { toggle: false });
                createUserCollapse.show();
            }
        }

        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        const selectAllVisibleBtn = document.getElementById('selectAllVisibleBtn');
        const selectAllPendingBtn = document.getElementById('selectAllPendingBtn');
        const bulkApproveBtn = document.getElementById('bulkApproveBtn');
        const bulkRevokeBtn = document.getElementById('bulkRevokeBtn');
        const bulkForm = document.getElementById('bulkApprovalForm');
        const bulkActionInput = document.getElementById('bulkActionInput');
        const bulkUserIdsContainer = document.getElementById('bulkUserIdsContainer');

        if (!bulkForm) return;

        const getCheckboxes = () => Array.from(document.querySelectorAll('.user-select-checkbox'));

        const getSelectedUserIds = () =>
            getCheckboxes()
                .filter((checkbox) => checkbox.checked)
                .map((checkbox) => checkbox.value);

        const setAll = (checked) => {
            getCheckboxes().forEach((checkbox) => {
                checkbox.checked = checked;
            });
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = checked;
            }
        };

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', (event) => {
                setAll(event.target.checked);
            });
        }

        if (selectAllVisibleBtn) {
            selectAllVisibleBtn.addEventListener('click', () => setAll(true));
        }

        if (selectAllPendingBtn) {
            selectAllPendingBtn.addEventListener('click', () => {
                getCheckboxes().forEach((checkbox) => {
                    checkbox.checked = checkbox.dataset.pending === '1';
                });
                if (selectAllCheckbox) {
                    selectAllCheckbox.checked = false;
                }
            });
        }

        const submitBulk = (action) => {
            const ids = getSelectedUserIds();
            if (ids.length === 0) {
                alert('Please select at least one user.');
                return;
            }

            bulkActionInput.value = action;
            bulkUserIdsContainer.innerHTML = '';

            ids.forEach((id) => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'user_ids[]';
                input.value = id;
                bulkUserIdsContainer.appendChild(input);
            });

            bulkForm.submit();
        };

        if (bulkApproveBtn) {
            bulkApproveBtn.addEventListener('click', () => submitBulk('approve'));
        }

        if (bulkRevokeBtn) {
            bulkRevokeBtn.addEventListener('click', () => submitBulk('revoke'));
        }
    })();
</script>
@endsection
