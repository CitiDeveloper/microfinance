@extends('layouts.app')

@section('title', 'Collateral Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-shield-alt text-primary me-2"></i>
                Collateral Management
            </h1>
            <p class="text-muted">Manage loan collateral and security assets</p>
        </div>
        <a href="{{ route('collateral.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Register New Collateral
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Collateral
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $collaterals->total() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shield-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Active Collateral
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\CollateralRegister::active()->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Value
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ₦{{ number_format(\App\Models\CollateralRegister::sum('estimated_value'), 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Collateral Table -->
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">Collateral Register</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>ID</th>
                            <th>Loan Number</th>
                            <th>Collateral Type</th>
                            <th>Description</th>
                            <th>Estimated Value</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($collaterals as $collateral)
                        <tr>
                            <td>#{{ $collateral->id }}</td>
                            <td>
                                <strong>{{ $collateral->loan->loan_number ?? 'N/A' }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $collateral->collateral_type }}</span>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 200px;" 
                                     title="{{ $collateral->description }}">
                                    {{ $collateral->description }}
                                </div>
                            </td>
                            <td class="fw-bold text-success">
                                {{ $collateral->formatted_estimated_value }}
                            </td>
                            <td>
                                @php
                                    $statusColors = [
                                        'active' => 'bg-success',
                                        'released' => 'bg-info',
                                        'seized' => 'bg-danger',
                                        'sold' => 'bg-warning'
                                    ];
                                @endphp
                                <span class="badge  {{ $statusColors[$collateral->status] ?? 'bg-secondary' }}">
                                    {{ ucfirst($collateral->status) }}
                                </span>
                            </td>
                            <td>{{ $collateral->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('collateral.show', $collateral) }}" 
                                       class="btn btn-outline-primary" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('collateral.edit', $collateral) }}" 
                                       class="btn btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('collateral.destroy', $collateral) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" 
                                                title="Delete" 
                                                onclick="return confirm('Are you sure you want to delete this collateral?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-shield-alt fa-3x mb-3"></i>
                                    <p>No collateral registered yet.</p>
                                    <a href="{{ route('collateral.create') }}" class="btn btn-primary">
                                        Register First Collateral
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($collaterals->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Showing {{ $collaterals->firstItem() }} to {{ $collaterals->lastItem() }} 
                    of {{ $collaterals->total() }} entries
                </div>
                <nav>
                     {{ $collaterals->links('pagination::bootstrap-4') }}
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection