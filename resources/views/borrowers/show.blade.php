@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1 text-gray-800">Borrower Details</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('borrowers.index') }}">Borrowers</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $borrower->full_name }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="btn-group">
                    <a href="{{ route('borrowers.edit', $borrower) }}" class="btn btn-warning">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                    <a href="{{ route('borrowers.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Borrower Information Card -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm h-1001">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 text-primary"><i class="fas fa-user-circle mr-2"></i>Borrower Information</h5>
                </div>
                <div class="card-body p-0">
                    <!-- Personal Information Section -->
                    <div class="p-4 border-bottom">
                        <h6 class="font-weight-bold text-uppercase text-muted small mb-3">Personal Information</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold text-muted small">Full Name</label>
                                <p class="mb-0 text-dark">{{ $borrower->full_name }}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold text-muted small">Unique Number</label>
                                <p class="mb-0 text-dark">{{ $borrower->unique_number ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold text-muted small">Date of Birth</label>
                                <p class="mb-0 text-dark">{{ $borrower->date_of_birth ? $borrower->date_of_birth->format('M d, Y') : 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold text-muted small">Gender</label>
                                <p class="mb-0 text-dark">{{ $borrower->gender ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold text-muted small">Title</label>
                                <p class="mb-0 text-dark">{{ $borrower->title ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information Section -->
                    <div class="p-4">
                        <h6 class="font-weight-bold text-uppercase text-muted small mb-3">Contact Information</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold text-muted small">Mobile</label>
                                <p class="mb-0 text-dark">{{ $borrower->mobile ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold text-muted small">Email</label>
                                <p class="mb-0 text-dark">{{ $borrower->email ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold text-muted small">Landline</label>
                                <p class="mb-0 text-dark">{{ $borrower->landline ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Address Information Card -->
            <div class="card shadow-sm mb-4 mt-1">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#addressInfo" style="cursor: pointer;">
                    <h6 class="mb-0 text-primary"><i class="fas fa-map-marker-alt mr-2"></i>Address Information</h6>
                    <i class="fas fa-chevron-down small text-muted d-lg-none"></i>
                </div>
                <div class="collapse d-lg-block" id="addressInfo">
                    <div class="card-body p-4">
                        <h6 class="font-weight-bold text-uppercase text-muted small mb-3">Address Details</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold text-muted small">Address</label>
                                <p class="mb-0 text-dark">{{ $borrower->address ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold text-muted small">City</label>
                                <p class="mb-0 text-dark">{{ $borrower->city ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold text-muted small">County</label>
                                <p class="mb-0 text-dark">{{ $borrower->county ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold text-muted small">Province/State</label>
                                <p class="mb-0 text-dark">{{ $borrower->province ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold text-muted small">Zipcode</label>
                                <p class="mb-0 text-dark">{{ $borrower->zipcode ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Cards -->
        <div class="col-lg-4 mb-4">
            <!-- Employment & Financial (Collapsible on small devices) -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#employmentInfo" style="cursor: pointer;">
                    <h6 class="mb-0 text-primary"><i class="fas fa-briefcase mr-2"></i>Employment & Financial</h6>
                    <i class="fas fa-chevron-down small text-muted d-lg-none"></i>
                </div>
                <div class="collapse d-lg-block" id="employmentInfo">
                    <div class="card-body">
                        <div class="mb-3"><label class="font-weight-bold text-muted small">Working Status</label><p class="mb-0 text-dark">{{ $borrower->working_status ?? 'N/A' }}</p></div>
                        <div class="mb-3">
                            <label class="font-weight-bold text-muted small">Credit Score</label>
                            <p class="mb-0">
                                @if($borrower->credit_score)
                                    <span class="badge bg-{{ $borrower->credit_score >= 700 ? 'success' : ($borrower->credit_score >= 600 ? 'warning' : 'danger') }}">
                                        {{ $borrower->credit_score }}
                                    </span>
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                        <div><label class="font-weight-bold text-muted small">Business Name</label><p class="mb-0 text-dark">{{ $borrower->business_name ?? 'N/A' }}</p></div>
                    </div>
                </div>
            </div>

            <!-- Description Card -->
            @if($borrower->description)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 text-primary"><i class="fas fa-file-alt mr-2"></i>Description</h6>
                </div>
                <div class="card-body">
                    <p class="mb-0 text-dark">{{ $borrower->description }}</p>
                </div>
            </div>
            @endif

            <!-- System Information Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 text-primary"><i class="fas fa-info-circle mr-2"></i>System Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="font-weight-bold text-muted small">Created</label>
                        <p class="mb-0 text-dark">{{ $borrower->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div class="mb-0">
                        <label class="font-weight-bold text-muted small">Updated</label>
                        <p class="mb-0 text-dark">{{ $borrower->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loans Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary"><i class="fas fa-money-bill-wave mr-2"></i>Loan History</h5>
                    <span class="badge bg-primary">{{ $borrower->loans->count() }} Loans</span>
                </div>
                <div class="card-body">
                    @if($borrower->loans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Loan Title</th>
                                        <th>Principal Amount</th>
                                        <th>Interest Rate</th>
                                        <th>Status</th>
                                        <th>Released Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($borrower->loans as $loan)
                                    <tr>
                                        <td class="font-weight-bold">{{ $loan->loan_title }}</td>
                                        <td>${{ number_format($loan->loan_principal_amount, 2) }}</td>
                                        <td>{{ $loan->loan_interest }}%</td>
                                        <td>
                                            @php
                                                $statusClass = 'secondary';
                                                if($loan->loanStatus) {
                                                    if($loan->loanStatus->id == 1) $statusClass = 'success';
                                                    if($loan->loanStatus->id == 3) $statusClass = 'danger';
                                                    if($loan->loanStatus->id == 8) $statusClass = 'warning';
                                                }
                                            @endphp
                                            <span class="badge bg-{{ $statusClass }}">
                                                {{ $loan->loanStatus->name ?? 'Unknown' }}
                                            </span>
                                        </td>
                                        <td>{{ $loan->loan_released_date ? $loan->loan_released_date->format('M d, Y') : 'N/A' }}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-money-bill-wave fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No loans found for this borrower.</p>
                            <a href="#" class="btn btn-primary">
                                <i class="fas fa-plus mr-1"></i> Create New Loan
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection