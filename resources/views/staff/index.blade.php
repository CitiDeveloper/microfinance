@extends('layouts.app')

@section('title', 'Staff Management')
<style>
    .card {
        border-radius: 0.75rem;
    }
    .card-header {
        border-radius: 0.75rem 0.75rem 0 0 !important;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    .table th {
        border-top: none;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
    }
    .staff-row:hover {
        background-color: rgba(0,123,255,0.02);
        transform: translateY(-1px);
        transition: all 0.2s ease;
    }
    .badge {
        font-weight: 500;
    }
    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
</style>
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="h4 mb-0 text-primary fw-bold">
                            <i class="fas fa-users me-2"></i>Staff Members
                        </h3>
                        <p class="text-muted mb-0 mt-1">Manage your staff members and their information</p>
                    </div>
                    <div class="card-tools">
                        <a href="{{ route('staff.create') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus me-2"></i> Add New Staff
                        </a>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <!-- Search and Filters -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" placeholder="Search staff members..." id="searchInput">
                                <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="btn-group">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-filter me-1"></i> Filter
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">All Roles</a></li>
                                    <li><a class="dropdown-item" href="#">Active Only</a></li>
                                    <li><a class="dropdown-item" href="#">By Branch</a></li>
                                </ul>
                            </div>
                            <button class="btn btn-outline-secondary ms-2">
                                <i class="fas fa-download me-1"></i> Export
                            </button>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-3">
                            <div class="card bg-primary text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title text-white-50">Total Staff</h6>
                                            <h3 class="mb-0">{{ $staff->total() }}</h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-users fa-2x text-white-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-3">
                            <div class="card bg-success text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title text-white-50">Active</h6>
                                            <h3 class="mb-0">{{ $staff->count() }}</h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-user-check fa-2x text-white-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-3">
                            <div class="card bg-info text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title text-white-50">Admins</h6>
                                            <h3 class="mb-0">{{ $staff->where('role.name', 'Admin')->count() }}</h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-user-shield fa-2x text-white-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-3">
                            <div class="card bg-warning text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title text-white-50">This Month</h6>
                                            <h3 class="mb-0">0</h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-calendar-plus fa-2x text-white-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Staff Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="staffTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                        </div>
                                    </th>
                                    <th>
                                        <a href="#" class="text-decoration-none text-dark d-flex align-items-center">
                                            ID <i class="fas fa-sort ms-1 small"></i>
                                        </a>
                                    </th>
                                    <th>Staff Member</th>
                                    <th>Contact</th>
                                    <th>Role</th>
                                    <th>Branch</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($staff as $member)
                                <tr class="staff-row">
                                    <td class="ps-4">
                                        <div class="form-check">
                                            <input class="form-check-input row-checkbox" type="checkbox" value="{{ $member->id }}">
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-primary">#{{ $member->id }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0 fw-bold">{{ $member->full_name }}</h6>
                                                <small class="text-muted text-capitalize">{{ $member->staff_gender }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div class="mb-1">
                                                <i class="fas fa-envelope text-muted me-2"></i>
                                                <a href="mailto:{{ $member->staff_email }}" class="text-decoration-none">
                                                    {{ $member->staff_email }}
                                                </a>
                                            </div>
                                            @if($member->staff_mobile)
                                            <div>
                                                <i class="fas fa-phone text-muted me-2"></i>
                                                <small class="text-muted">{{ $member->staff_mobile }}</small>
                                            </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                                            {{ $member->role->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $member->payrollBranch->name ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success rounded-pill px-3">
                                            <i class="fas fa-circle me-1 small"></i> Active
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('staff.show', $member) }}" 
                                               class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                               data-bs-toggle="tooltip" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('staff.edit', $member) }}" 
                                               class="btn btn-sm btn-outline-warning rounded-pill px-3"
                                               data-bs-toggle="tooltip" title="Edit Staff">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('staff.destroy', $member) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                        data-bs-toggle="tooltip" 
                                                        title="Delete Staff"
                                                        onclick="return confirm('Are you sure you want to delete this staff member?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Bulk Actions & Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="d-none" id="bulkActions">
                            <div class="btn-group">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    Bulk Actions
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-envelope me-2"></i> Send Email</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-tag me-2"></i> Change Role</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i> Delete Selected</a></li>
                                </ul>
                            </div>
                            <span class="ms-2 text-muted small" id="selectedCount">0 selected</span>
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <span class="text-muted me-3 small">Showing {{ $staff->firstItem() ?? 0 }}-{{ $staff->lastItem() ?? 0 }} of {{ $staff->total() }} items</span>
                            <nav aria-label="Staff pagination">
                            {{ $staff->links('pagination::bootstrap-4') }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->


<!-- JavaScript for Interactive Features -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const clearSearch = document.getElementById('clearSearch');
    const staffRows = document.querySelectorAll('.staff-row');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        staffRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
    
    clearSearch.addEventListener('click', function() {
        searchInput.value = '';
        staffRows.forEach(row => row.style.display = '');
    });
    
    // Bulk selection
    const selectAll = document.getElementById('selectAll');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');
    
    selectAll.addEventListener('change', function() {
        const isChecked = this.checked;
        rowCheckboxes.forEach(checkbox => {
            checkbox.checked = isChecked;
        });
        updateBulkActions();
    });
    
    rowCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActions);
    });
    
    function updateBulkActions() {
        const checkedCount = document.querySelectorAll('.row-checkbox:checked').length;
        
        if (checkedCount > 0) {
            bulkActions.classList.remove('d-none');
            selectedCount.textContent = `${checkedCount} selected`;
            selectAll.checked = checkedCount === rowCheckboxes.length;
        } else {
            bulkActions.classList.add('d-none');
        }
    }
    
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection