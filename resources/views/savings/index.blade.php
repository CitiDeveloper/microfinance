@extends('layouts.app')

@section('title', 'Savings Accounts')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-4 border-bottom-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0 fw-bold text-primary">Savings Accounts</h4>
                            <p class="text-muted mb-0">Manage all savings accounts in one place</p>
                        </div>
                        <div>
                            <a href="{{ route('savings.create') }}" class="btn btn-primary px-4 py-2 rounded-pill fw-semibold">
                                <i class="fas fa-plus me-2"></i> Create New Account
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <!-- Stats Cards -->
                    <div class="row g-3 p-4 border-bottom bg-light rounded-top">
                        <div class="col-md-3">
                            <div class="card border-0 shadow-sm h-100 rounded-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="fas fa-wallet text-primary fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="card-title text-muted mb-1">Total Accounts</h6>
                                            <h4 class="mb-0 fw-bold">{{ $savings->total() }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-0 shadow-sm h-100 rounded-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="fas fa-check-circle text-success fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="card-title text-muted mb-1">Active Accounts</h6>
                                            <h4 class="mb-0 fw-bold">{{ $savings->where('status', 'active')->count() }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-0 shadow-sm h-100 rounded-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="fas fa-pause-circle text-warning fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="card-title text-muted mb-1">Inactive Accounts</h6>
                                            <h4 class="mb-0 fw-bold">{{ $savings->where('status', 'inactive')->count() }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-0 shadow-sm h-100 rounded-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="fas fa-times-circle text-danger fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="card-title text-muted mb-1">Closed Accounts</h6>
                                            <h4 class="mb-0 fw-bold">{{ $savings->where('status', 'closed')->count() }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filters & Search -->
                    <div class="row p-4 border-bottom">
                        <div class="col-md-8">
                            <div class="input-group rounded-pill">
                                <span class="input-group-text bg-transparent border-0 ps-3">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-0 rounded-pill" placeholder="Search accounts...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex gap-2">
                                <select class="form-select rounded-pill">
                                    <option selected>All Statuses</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="closed">Closed</option>
                                </select>
                                <button class="btn btn-outline-secondary rounded-pill">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 ps-4 fw-semibold text-muted text-uppercase small">Account Number</th>
                                    <th class="border-0 fw-semibold text-muted text-uppercase small">Borrower</th>
                                    <th class="border-0 fw-semibold text-muted text-uppercase small">Product</th>
                                    <th class="border-0 fw-semibold text-muted text-uppercase small">Branch</th>
                                    <th class="border-0 fw-semibold text-muted text-uppercase small text-end">Balance</th>
                                    <th class="border-0 fw-semibold text-muted text-uppercase small">Status</th>
                                    <th class="border-0 fw-semibold text-muted text-uppercase small">Opening Date</th>
                                    <th class="border-0 fw-semibold text-muted text-uppercase small text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($savings as $saving)
                                    <tr class="border-bottom">
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                                                    <i class="fas fa-wallet text-primary"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">{{ $saving->account_number }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-info bg-opacity-10 p-2 rounded-circle me-3">
                                                    <i class="fas fa-user text-info"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">{{ $saving->borrower->full_name }}</h6>
                                                    <small class="text-muted">{{ $saving->borrower->member_id ?? 'N/A' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $saving->savingsProduct->name }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $saving->branch->name }}</span>
                                        </td>
                                        <td class="text-end">
                                            <h6 class="mb-0 fw-bold text-success">{{ number_format($saving->balance, 2) }}</h6>
                                        </td>
                                        <td>
                                            @if($saving->status == 'active')
                                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                                                    <i class="fas fa-circle me-1 small"></i> Active
                                                </span>
                                            @elseif($saving->status == 'closed')
                                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2">
                                                    <i class="fas fa-circle me-1 small"></i> Closed
                                                </span>
                                            @else
                                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2">
                                                    <i class="fas fa-circle me-1 small"></i> Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-secondary bg-opacity-10 p-2 rounded-circle me-3">
                                                    <i class="fas fa-calendar text-secondary"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">{{ $saving->opening_date->format('M d, Y') }}</h6>
                                                    <small class="text-muted">{{ $saving->opening_date->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="dropdown">
                                                <button class="btn btn-light btn-sm rounded-pill px-3" type="button" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow-sm rounded-3 py-2">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center py-2" href="{{ route('savings.show', $saving) }}">
                                                            <i class="fas fa-eye text-primary me-2"></i> View Details
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center py-2" href="{{ route('savings.edit', $saving) }}">
                                                            <i class="fas fa-edit text-info me-2"></i> Edit Account
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    {{-- <li>
                                                        <form action="{{ route('savings.destroy', $saving) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item d-flex align-items-center py-2 text-danger" onclick="return confirm('Are you sure you want to delete this account?')">
                                                                <i class="fas fa-trash me-2"></i> Delete Account
                                                            </button>
                                                        </form>
                                                    </li> --}}
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="py-5">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">No savings accounts found</h5>
                                                <p class="text-muted mb-4">Get started by creating your first savings account</p>
                                                <a href="{{ route('savings.create') }}" class="btn btn-primary rounded-pill px-4">
                                                    <i class="fas fa-plus me-2"></i> Create Account
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white py-3 border-top-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Showing {{ $savings->firstItem() ?? 0 }} to {{ $savings->lastItem() ?? 0 }} of {{ $savings->total() }} entries
                        </div>
                        <div>
                            {{ $savings->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: all 0.3s ease;
    }
    
    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }
    
    .table th {
        font-weight: 600;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    
    .table td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
    }
    
    .badge {
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .dropdown-menu {
        border: none;
        min-width: 180px;
    }
    
    .dropdown-item {
        border-radius: 0.375rem;
        margin: 0.125rem 0.5rem;
        width: auto;
    }
    
    .dropdown-item:hover {
        background-color: #f8f9fa;
    }
    
    .input-group:focus-within {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        border-radius: 50rem;
    }
</style>
@endpush