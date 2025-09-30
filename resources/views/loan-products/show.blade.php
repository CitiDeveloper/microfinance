@extends('layouts.app')

@section('title', 'Loan Product Details')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 fw-bold text-gray-800">{{ $loanProduct->loan_product_name }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('loan-products.index') }}">Loan Products</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Details</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('loan-products.index') }}" class="btn btn-outline-gray-600">
                        <i class="bi bi-arrow-left me-2"></i>Back to List
                    </a>
                    <a href="#" class="btn btn-primary">
                        <i class="bi bi-pencil-square me-2"></i>Edit Product
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Overview Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                        <i class="bi bi-piggy-bank-fill text-primary fs-2"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h3 class="h5 mb-1">{{ $loanProduct->loan_product_name }}</h3>
                                    <p class="text-muted mb-2">Loan Product Details</p>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-{{ $loanProduct->is_active ? 'success' : 'secondary' }} me-2">
                                            {{ $loanProduct->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                        <span class="text-muted small">
                                            <i class="bi bi-circle-fill me-1 text-{{ $loanProduct->loanStatus ? 'primary' : 'secondary' }}"></i>
                                            {{ $loanProduct->loanStatus?->name ?? 'Status N/A' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <div class="d-flex flex-column flex-md-row justify-content-md-end gap-2">
                                <div class="text-center text-md-start">
                                    <p class="mb-0 fw-semibold text-gray-700">Available Branches</p>
                                    <div class="mt-1">
                                        @forelse($loanProduct->branches as $branch)
                                            <span class="badge bg-light text-dark border me-1 mb-1">{{ $branch->name }}</span>
                                        @empty
                                            <span class="text-muted small">No branches assigned</span>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Cards -->
    <div class="row g-4">
        <!-- Principal Amount Card -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <i class="bi bi-currency-dollar text-primary me-2"></i>Loan Principal
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 text-center">
                        <div class="col-4">
                            <div class="p-2 rounded bg-light">
                                <p class="text-muted small mb-1">Minimum</p>
                                <p class="mb-0 fw-bold text-success fs-5">
                                    {{ number_format($loanProduct->min_loan_principal_amount, 2) }}
                                </p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 rounded bg-light">
                                <p class="text-muted small mb-1">Default</p>
                                <p class="mb-0 fw-bold text-primary fs-5">
                                    {{ number_format($loanProduct->default_loan_principal_amount, 2) }}
                                </p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 rounded bg-light">
                                <p class="text-muted small mb-1">Maximum</p>
                                <p class="mb-0 fw-bold text-danger fs-5">
                                    {{ number_format($loanProduct->max_loan_principal_amount, 2) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Interest Details Card -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-warning bg-opacity-10 border-0 py-3">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <i class="bi bi-percent text-warning me-2"></i>Loan Interest
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 text-center mb-3">
                        <div class="col-4">
                            <div class="p-2 rounded bg-light">
                                <p class="text-muted small mb-1">Minimum</p>
                                <p class="mb-0 fw-bold text-success fs-5">
                                    {{ number_format($loanProduct->min_loan_interest, 4) }}%
                                </p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 rounded bg-light">
                                <p class="text-muted small mb-1">Default</p>
                                <p class="mb-0 fw-bold text-primary fs-5">
                                    {{ number_format($loanProduct->default_loan_interest, 4) }}%
                                </p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 rounded bg-light">
                                <p class="text-muted small mb-1">Maximum</p>
                                <p class="mb-0 fw-bold text-danger fs-5">
                                    {{ number_format($loanProduct->max_loan_interest, 4) }}%
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-2 mt-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Interest Method</span>
                                <span class="fw-semibold">{{ ucfirst($loanProduct->loan_interest_method) }}</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Interest Type</span>
                                <span class="fw-semibold">{{ ucfirst($loanProduct->loan_interest_type) }}</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between py-2">
                                <span class="text-muted">Interest Period</span>
                                <span class="fw-semibold">{{ ucfirst($loanProduct->loan_interest_period) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loan Duration Card -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-info bg-opacity-10 border-0 py-3">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <i class="bi bi-calendar-range text-info me-2"></i>Loan Duration
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 text-center mb-3">
                        <div class="col-4">
                            <div class="p-2 rounded bg-light">
                                <p class="text-muted small mb-1">Minimum</p>
                                <p class="mb-0 fw-bold text-success fs-5">{{ $loanProduct->min_loan_duration }}</p>
                                <small class="text-muted">{{ $loanProduct->loan_duration_period }}</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 rounded bg-light">
                                <p class="text-muted small mb-1">Default</p>
                                <p class="mb-0 fw-bold text-primary fs-5">{{ $loanProduct->default_loan_duration }}</p>
                                <small class="text-muted">{{ $loanProduct->loan_duration_period }}</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 rounded bg-light">
                                <p class="text-muted small mb-1">Maximum</p>
                                <p class="mb-0 fw-bold text-danger fs-5">{{ $loanProduct->max_loan_duration }}</p>
                                <small class="text-muted">{{ $loanProduct->loan_duration_period }}</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Repayment Information -->
                    <div class="mt-4">
                        <h6 class="mb-3 text-gray-700">Repayment Information</h6>
                        <div class="row g-3 text-center mb-3">
                            <div class="col-4">
                                <div class="p-2 rounded bg-light">
                                    <p class="text-muted small mb-1">Min</p>
                                    <p class="mb-0 fw-bold text-success">{{ $loanProduct->min_loan_num_of_repayments }}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 rounded bg-light">
                                    <p class="text-muted small mb-1">Default</p>
                                    <p class="mb-0 fw-bold text-primary">{{ $loanProduct->default_loan_num_of_repayments }}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 rounded bg-light">
                                    <p class="text-muted small mb-1">Max</p>
                                    <p class="mb-0 fw-bold text-danger">{{ $loanProduct->max_loan_num_of_repayments }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <p class="text-muted small mb-2">Repayment Order</p>
                            <div>
                                @if (is_array($loanProduct->repayment_order))
                                    @foreach ($loanProduct->repayment_order as $order)
                                        <span class="badge bg-light text-dark border me-1 mb-1">{{ $order }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted small">N/A</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Parameters Card -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gray-100 border-0 py-3">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <i class="bi bi-gear text-gray-600 me-2"></i>Additional Parameters
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <div class="text-center p-3 rounded bg-light">
                                <p class="text-muted small mb-1">Decimal Places</p>
                                <p class="mb-0 fw-bold text-primary fs-4">{{ $loanProduct->loan_decimal_places }}</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="text-center p-3 rounded bg-light">
                                <p class="text-muted small mb-1">Enable Parameters</p>
                                <span class="badge bg-{{ $loanProduct->loan_enable_parameters ? 'success' : 'secondary' }} fs-6 py-2 px-3">
                                    {{ $loanProduct->loan_enable_parameters ? 'Yes' : 'No' }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="text-center p-3 rounded bg-light">
                                <p class="text-muted small mb-1">Stop Duplicate Repayments</p>
                                <span class="badge bg-{{ $loanProduct->stop_loan_duplicate_repayments ? 'success' : 'secondary' }} fs-6 py-2 px-3">
                                    {{ $loanProduct->stop_loan_duplicate_repayments ? 'Yes' : 'No' }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="text-center p-3 rounded bg-light">
                                <p class="text-muted small mb-1">Automatic Payments</p>
                                <span class="badge bg-{{ $loanProduct->automatic_payments ? 'success' : 'secondary' }} fs-6 py-2 px-3">
                                    {{ $loanProduct->automatic_payments ? 'Enabled' : 'Disabled' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 0.75rem;
        transition: transform 0.2s ease-in-out;
    }
    
    .card:hover {
        transform: translateY(-2px);
    }
    
    .card-header {
        border-radius: 0.75rem 0.75rem 0 0 !important;
        font-weight: 600;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
    }
    
    .bg-opacity-10 {
        background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
    }
    
    .bg-gray-100 {
        background-color: #f8f9fa !important;
    }
    
    .text-gray-600 {
        color: #6c757d !important;
    }
    
    .text-gray-700 {
        color: #495057 !important;
    }
    
    .text-gray-800 {
        color: #343a40 !important;
    }
    
    .btn-outline-gray-600 {
        color: #6c757d;
        border-color: #6c757d;
    }
    
    .btn-outline-gray-600:hover {
        color: #fff;
        background-color: #6c757d;
        border-color: #6c757d;
    }
    
    .border-bottom {
        border-bottom: 1px solid #e9ecef !important;
    }
    
    .page-header {
        padding: 1rem 1.5rem;
        background-color: #fff;
        border-radius: 0.75rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
</style>
@endsection