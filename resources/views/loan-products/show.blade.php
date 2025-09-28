@extends('layouts.app')

@section('title', 'Loan Product Details')
<style>
    .card {
        border-radius: 0.5rem;
    }

    .card-header {
        border-radius: 0.5rem 0.5rem 0 0 !important;
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
    }

    .form-label {
        font-size: 0.8rem;
    }
</style>
@section('content')
    <div class="container-fluid py-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold text-primary">{{ $loanProduct->loan_product_name }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('loan-products.index') }}">Loan Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Details</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="{{ route('loan-products.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to List
                </a>
                <a href="#" class="btn btn-primary ms-2">
                    <i class="bi bi-pencil-square me-2"></i>Edit Product
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Left Column - Basic Information -->
            <div class="col-lg-4 mb-4">
                <!-- Basic Information Card -->
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="card-title mb-0"><i class="bi bi-info-circle me-2"></i>Basic Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label text-muted small mb-1">Product Name</label>
                            <p class="mb-0 fw-semibold">{{ $loanProduct->loan_product_name }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small mb-1">Status</label>
                            <p class="mb-0">
                                <span class="badge bg-{{ $loanProduct->is_active ? 'success' : 'secondary' }}">
                                    {{ $loanProduct->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small mb-1">Loan Status</label>
                            <p class="mb-0">{{ $loanProduct->loanStatus?->name ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <label class="form-label text-muted small mb-1">Available Branches</label>
                            <div>
                                @forelse($loanProduct->branches as $branch)
                                    <span class="badge bg-light text-dark border me-1 mb-1">{{ $branch->name }}</span>
                                @empty
                                    <span class="text-muted">No branches assigned</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Middle Column - Financial Details -->
            <div class="col-lg-4 mb-4">
                <!-- Principal Amount Card -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-success text-white py-3">
                        <h5 class="card-title mb-0"><i class="bi bi-currency-dollar me-2"></i>Loan Principal</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-4 border-end">
                                <label class="form-label text-muted small mb-1">Minimum</label>
                                <p class="mb-0 fw-bold text-success">
                                    {{ number_format($loanProduct->min_loan_principal_amount, 2) }}</p>
                            </div>
                            <div class="col-4 border-end">
                                <label class="form-label text-muted small mb-1">Default</label>
                                <p class="mb-0 fw-bold">{{ number_format($loanProduct->default_loan_principal_amount, 2) }}
                                </p>
                            </div>
                            <div class="col-4">
                                <label class="form-label text-muted small mb-1">Maximum</label>
                                <p class="mb-0 fw-bold text-danger">
                                    {{ number_format($loanProduct->max_loan_principal_amount, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Interest Details Card -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-warning text-dark py-3">
                        <h5 class="card-title mb-0"><i class="bi bi-percent me-2"></i>Loan Interest</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center mb-3">
                            <div class="col-4 border-end">
                                <label class="form-label text-muted small mb-1">Min</label>
                                <p class="mb-0 fw-bold text-success">
                                    {{ number_format($loanProduct->min_loan_interest, 4) }}%</p>
                            </div>
                            <div class="col-4 border-end">
                                <label class="form-label text-muted small mb-1">Default</label>
                                <p class="mb-0 fw-bold">{{ number_format($loanProduct->default_loan_interest, 4) }}%</p>
                            </div>
                            <div class="col-4">
                                <label class="form-label text-muted small mb-1">Max</label>
                                <p class="mb-0 fw-bold text-danger">
                                    {{ number_format($loanProduct->max_loan_interest, 4) }}%</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-2">
                                <label class="form-label text-muted small mb-1">Interest Method</label>
                                <p class="mb-0 fw-semibold">{{ ucfirst($loanProduct->loan_interest_method) }}</p>
                            </div>
                            <div class="col-12 mb-2">
                                <label class="form-label text-muted small mb-1">Interest Type</label>
                                <p class="mb-0 fw-semibold">{{ ucfirst($loanProduct->loan_interest_type) }}</p>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted small mb-1">Interest Period</label>
                                <p class="mb-0 fw-semibold">{{ ucfirst($loanProduct->loan_interest_period) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Duration & Repayment -->
            <div class="col-lg-4 mb-4">
                <!-- Loan Duration Card -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-info text-white py-3">
                        <h5 class="card-title mb-0"><i class="bi bi-calendar-range me-2"></i>Loan Duration</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-4 border-end">
                                <label class="form-label text-muted small mb-1">Minimum</label>
                                <p class="mb-0 fw-bold text-success">{{ $loanProduct->min_loan_duration }}
                                    {{ $loanProduct->loan_duration_period }}</p>
                            </div>
                            <div class="col-4 border-end">
                                <label class="form-label text-muted small mb-1">Default</label>
                                <p class="mb-0 fw-bold">{{ $loanProduct->default_loan_duration }}
                                    {{ $loanProduct->loan_duration_period }}</p>
                            </div>
                            <div class="col-4">
                                <label class="form-label text-muted small mb-1">Maximum</label>
                                <p class="mb-0 fw-bold text-danger">{{ $loanProduct->max_loan_duration }}
                                    {{ $loanProduct->loan_duration_period }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Repayment Information Card -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white py-3">
                        <h5 class="card-title mb-0"><i class="bi bi-arrow-repeat me-2"></i>Repayment Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label text-muted small mb-2">Number of Repayments</label>
                            <div class="row text-center">
                                <div class="col-4 border-end">
                                    <p class="mb-0 fw-bold text-success">{{ $loanProduct->min_loan_num_of_repayments }}
                                    </p>
                                    <small class="text-muted">Min</small>
                                </div>
                                <div class="col-4 border-end">
                                    <p class="mb-0 fw-bold">{{ $loanProduct->default_loan_num_of_repayments }}</p>
                                    <small class="text-muted">Default</small>
                                </div>
                                <div class="col-4">
                                    <p class="mb-0 fw-bold text-danger">{{ $loanProduct->max_loan_num_of_repayments }}</p>
                                    <small class="text-muted">Max</small>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="form-label text-muted small mb-1">Repayment Order</label>
                            <p class="mb-0">
                                @if (is_array($loanProduct->repayment_order))
                                    @foreach ($loanProduct->repayment_order as $order)
                                        <span class="badge bg-light text-dark border me-1">{{ $order }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Parameters Card -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-secondary text-white py-3">
                        <h5 class="card-title mb-0"><i class="bi bi-gear me-2"></i>Additional Parameters</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted small mb-1">Decimal Places</label>
                                <p class="mb-0 fw-semibold">{{ $loanProduct->loan_decimal_places }}</p>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted small mb-1">Enable Parameters</label>
                                <p class="mb-0">
                                    <span
                                        class="badge bg-{{ $loanProduct->loan_enable_parameters ? 'success' : 'secondary' }}">
                                        {{ $loanProduct->loan_enable_parameters ? 'Yes' : 'No' }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted small mb-1">Stop Duplicate Repayments</label>
                                <p class="mb-0">
                                    <span
                                        class="badge bg-{{ $loanProduct->stop_loan_duplicate_repayments ? 'success' : 'secondary' }}">
                                        {{ $loanProduct->stop_loan_duplicate_repayments ? 'Yes' : 'No' }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted small mb-1">Automatic Payments</label>
                                <p class="mb-0">
                                    <span
                                        class="badge bg-{{ $loanProduct->automatic_payments ? 'success' : 'secondary' }}">
                                        {{ $loanProduct->automatic_payments ? 'Enabled' : 'Disabled' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
