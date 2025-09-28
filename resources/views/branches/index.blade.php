@extends('layouts.app')
<style>
.card {
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.card-header {
    border-bottom: 1px solid #e3e6f0;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #6e707e;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table td {
    vertical-align: middle;
    border-color: #e3e6f0;
}

.badge {
    font-weight: 500;
}

.btn-group .btn {
    border-radius: 0.35rem;
    margin: 0 2px;
}

.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

.text-xs {
    font-size: 0.7rem;
}

.text-gray-800 {
    color: #5a5c69 !important;
}

.text-gray-300 {
    color: #dddfeb !important;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

.h-100 {
    height: 100% !important;
}

.py-2 {
    padding-top: 0.5rem !important;
    padding-bottom: 0.5rem !important;
}

/* Hover effects */
.table-hover tbody tr:hover {
    background-color: #f8f9fc;
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

.btn {
    transition: all 0.15s ease;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card-tools {
        flex-direction: column;
        gap: 10px;
    }
    
    .card-tools .input-group {
        width: 100% !important;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }
}
</style>
@section('content')
<div class="content-wrapper">
    <!-- Page Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row align-items-center mb-4">
                <div class="col-sm-6">
                    <div class="d-flex align-items-center">
                        <h4 class="m-0 text-dark fw-bold">Branches Management</h4>
                        <span class="badge bg-primary ms-3 fs-6">{{ $branches->count() }} branches</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="d-flex justify-content-end">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a></li>
                            <li class="breadcrumb-item active text-muted">Branches</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow-sm h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total Branches</div>
                                    <div class="h5 mb-0 fw-bold text-gray-800">{{ $branches->count() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-code-branch fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow-sm h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs fw-bold text-success text-uppercase mb-1">Active Branches</div>
                                    <div class="h5 mb-0 fw-bold text-gray-800">{{ $branches->where('is_active', true)->count() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow-sm h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs fw-bold text-info text-uppercase mb-1">Total Staff</div>
                                    <div class="h5 mb-0 fw-bold text-gray-800">{{ $branches->sum('staff_count') }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow-sm h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs fw-bold text-warning text-uppercase mb-1">Active Loans</div>
                                    <div class="h5 mb-0 fw-bold text-gray-800">{{ $branches->sum('loans_count') }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-hand-holding-usd fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Card -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title mb-0 fw-bold text-dark">Branches Overview</h3>
                                <div class="card-tools d-flex gap-2">
                                    <div class="input-group input-group-sm" style="width: 200px;">
                                        <input type="text" name="table_search" class="form-control" placeholder="Search branches...">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <a href="{{ route('branches.create') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-2">
                                        <i class="fas fa-plus"></i>
                                        <span>Add New Branch</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body p-0">
                            <!-- Alert Messages -->
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show m-3 rounded" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show m-3 rounded" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                                </div>
                                            </th>
                                            <th class="fw-semibold">Branch Name</th>
                                            <th class="fw-semibold">Open Date</th>
                                            <th class="fw-semibold">Country</th>
                                            <th class="fw-semibold text-center">Staff</th>
                                            <th class="fw-semibold text-center">Borrowers</th>
                                            <th class="fw-semibold text-center">Loans</th>
                                            <th class="fw-semibold text-center">Status</th>
                                            <th class="fw-semibold text-end pe-4">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($branches as $branch)
                                        <tr class="align-middle">
                                            <td class="ps-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="{{ $branch->id }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                        <i class="fas fa-code-branch text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark">{{ $branch->branch_name }}</div>
                                                        <small class="text-muted">ID: {{ $branch->id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-dark">{{ $branch->formatted_open_date }}</div>
                                                <small class="text-muted">{{ $branch->branch_open_date->diffForHumans() }}</small>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                                    <span class="text-dark">{{ $branch->branch_country ?? 'N/A' }}</span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-3 py-2">
                                                    <i class="fas fa-users me-1"></i>
                                                    {{ $branch->staff_count }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3 py-2">
                                                    <i class="fas fa-user-friends me-1"></i>
                                                    {{ $branch->borrowers_count }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2">
                                                    <i class="fas fa-hand-holding-usd me-1"></i>
                                                    {{ $branch->loans_count }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge rounded-pill bg-{{ $branch->is_active ? 'success' : 'danger' }} bg-opacity-10 text-{{ $branch->is_active ? 'success' : 'danger' }} border border-{{ $branch->is_active ? 'success' : 'danger' }} border-opacity-25 px-3 py-2">
                                                    <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                                                    {{ $branch->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('branches.show', $branch) }}" class="btn btn-outline-info btn-sm" data-bs-toggle="tooltip" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('branches.edit', $branch) }}" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" title="Edit Branch">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('branches.destroy', $branch) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this branch?')" data-bs-toggle="tooltip" title="Delete Branch">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-5">
                                                <div class="py-4">
                                                    <i class="fas fa-code-branch fa-3x text-muted mb-3"></i>
                                                    <h5 class="text-muted">No branches found</h5>
                                                    <p class="text-muted mb-4">Get started by creating your first branch</p>
                                                    <a href="{{ route('branches.create') }}" class="btn btn-primary">
                                                        <i class="fas fa-plus me-2"></i>Create First Branch
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            @if($branches->hasPages())
                            <div class="card-footer bg-white border-0 py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted">
                                        Showing {{ $branches->firstItem() }} to {{ $branches->lastItem() }} of {{ $branches->total() }} entries
                                    </div>
                                    <nav>
                                        {{ $branches->links() }}
                                    </nav>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Custom CSS -->


<!-- JavaScript for interactive elements -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all checkbox functionality
    const selectAll = document.getElementById('selectAll');
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('tbody .form-check-input');
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
        });
    }
    
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection