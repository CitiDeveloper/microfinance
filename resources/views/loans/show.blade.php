{{-- resources/views/loans/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Loan Details')
<style>
       
        
        .status-badge {
            font-size: 0.75rem;
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
        }
        
        .loan-amount {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .info-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
        }
        
        .info-value {
            font-size: 1rem;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .borrower-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--secondary-color), #2980b9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: white;
            font-size: 2rem;
        }
        
        .action-btn {
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .guarantor-item {
            border-left: 3px solid var(--success-color);
            padding-left: 1rem;
        }
        
        .breadcrumb {
            background-color: transparent;
            padding: 0;
        }
        
        .breadcrumb-item a {
            text-decoration: none;
            color: var(--secondary-color);
        }
        
        .stat-card {
            text-align: center;
            padding: 1.5rem;
        }
        
        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        
        .stat-label {
            font-size: 0.8rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .progress-container {
            background-color: #e9ecef;
            border-radius: 10px;
            height: 8px;
            margin: 1rem 0;
        }
        
        .progress-bar {
            border-radius: 10px;
            height: 100%;
        }
        
        @media (max-width: 768px) {
            .loan-amount {
                font-size: 1.5rem;
            }
            
            .card-header h5 {
                font-size: 1rem;
            }
        }
    </style>
@section('content')
<div class="container-fluid py-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1 text-dark">Loan Details</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('loans.index') }}" class="text-decoration-none">Loans</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $loan->loan_application_id }}</li>
                    </ol>
                </nav>
            </div>
            <div class="btn-group">
                <a href="{{ route('loans.edit', $loan->id) }}" class="btn btn-primary action-btn">
                    <i class="bi bi-pencil-square me-2"></i>Edit Loan
                </a>
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split action-btn" data-bs-toggle="dropdown">
                    <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-printer me-2"></i>Print Details</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-file-pdf me-2"></i>Export PDF</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete Loan</a></li>
                </ul>
            </div>
        </div>

        <!-- Status Alert -->
        @php
            $statusColors = [
                'active' => 'success',
                'pending' => 'warning',
                'rejected' => 'danger',
                'completed' => 'info'
            ];
            $statusColor = $statusColors[strtolower($loan->loanStatus->name)] ?? 'secondary';
        @endphp
        <div class="alert alert-{{ $statusColor }} d-flex justify-content-between align-items-center shadow-sm rounded mb-4">
            <div class="d-flex align-items-center">
                <i class="bi bi-info-circle me-2 fs-5"></i>
                <div>
                    <strong class="me-2">Status:</strong> 
                    <span class="badge status-badge bg-{{ $statusColor }}">{{ $loan->loanStatus->name }}</span>
                </div>
            </div>
            <div>
                <small class="text-muted">Application ID: {{ $loan->loan_application_id }}</small>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Loan Summary Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="stat-value text-primary">{{ number_format($loan->loan_principal_amount, 2) }}</div>
                            <div class="stat-label">Principal Amount</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="stat-value text-success">{{ $loan->loan_interest }}%</div>
                            <div class="stat-label">Interest Rate</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="stat-value text-info">{{ $loan->loan_duration }}</div>
                            <div class="stat-label">Duration ({{ $loan->loan_duration_period }})</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="stat-value text-warning">{{ $loan->loan_num_of_repayments }}</div>
                            <div class="stat-label">Repayments</div>
                        </div>
                    </div>
                </div>

                <!-- Loan Information Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0 d-flex align-items-center fw-bold">
                            <i class="bi bi-info-circle me-2"></i> Loan Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="info-label">Loan Title</div>
                                <div class="info-value">{{ $loan->loan_title ?? 'N/A' }}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-label">Loan Product</div>
                                <div class="info-value">{{ $loan->loanProduct->name }}</div>
                            </div>
                        </div>

                        @if($loan->loan_description)
                            <div class="mt-3">
                                <div class="info-label">Description</div>
                                <p class="mb-0">{{ $loan->loan_description }}</p>
                            </div>
                        @endif

                        <div class="row g-3 mt-3">
                            <div class="col-md-4">
                                <div class="info-label">Principal Amount</div>
                                <div class="loan-amount">{{ number_format($loan->loan_principal_amount, 2) }}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">Interest Rate</div>
                                <div class="info-value">{{ $loan->loan_interest }}% <small class="text-muted">({{ $loan->loan_interest_method }})</small></div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">Released Date</div>
                                <div class="info-value">{{ $loan->loan_released_date->format('M d, Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Repayment Schedule Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0 d-flex align-items-center fw-bold">
                            <i class="bi bi-calendar-check me-2"></i> Repayment Schedule
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="info-label">Duration</div>
                                <div class="info-value">{{ $loan->loan_duration }} {{ $loan->loan_duration_period }}</div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-label">Number of Repayments</div>
                                <div class="info-value">{{ $loan->loan_num_of_repayments }}</div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-label">Payment Scheme</div>
                                <div class="info-value">{{ $loan->afterMaturityPaymentScheme->name }}</div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-label">Interest Period</div>
                                <div class="info-value">{{ $loan->loan_interest_period }}</div>
                            </div>
                        </div>

                        @if($loan->loan_first_repayment_date)
                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <div class="info-label">First Repayment Date</div>
                                <div class="info-value">{{ $loan->loan_first_repayment_date->format('M d, Y') }}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-label">First Repayment Amount</div>
                                <div class="info-value">{{ $loan->first_repayment_amount ? number_format($loan->first_repayment_amount, 2) : 'N/A' }}</div>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Repayment Progress -->
                        <div class="mt-4">
                            <div class="d-flex justify-content-between mb-1">
                                <div class="info-label">Repayment Progress</div>
                                <div class="info-label">65% Complete</div>
                            </div>
                            <div class="progress-container">
                                <div class="progress-bar bg-success" style="width: 65%"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">Paid: ₱15,250.00</small>
                                <small class="text-muted">Remaining: ₱8,250.00</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Advanced Settings Card -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0 d-flex align-items-center fw-bold">
                            <i class="bi bi-gear me-2"></i> Advanced Settings
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="info-label">Decimal Places Handling</div>
                                <div class="info-value">{{ str_replace('_', ' ', $loan->loan_decimal_places) }}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-label">Automatic Payments</div>
                                <span class="badge status-badge bg-{{ $loan->automatic_payments ? 'success' : 'secondary' }}">
                                    {{ $loan->automatic_payments ? 'Enabled' : 'Disabled' }}
                                </span>
                            </div>
                        </div>

                        @if($loan->loan_balloon_repayment_amount)
                        <div class="mt-3">
                            <div class="info-label">Balloon Repayment Amount</div>
                            <div class="info-value text-danger">{{ number_format($loan->loan_balloon_repayment_amount, 2) }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="col-lg-4">
                <!-- Borrower Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0 fw-bold text-center">
                            <i class="bi bi-person me-2"></i> Borrower
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="borrower-avatar">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <h6 class="fw-semibold mb-1">{{ $loan->borrower->name }}</h6>
                        <p class="text-muted small mb-3">Member since {{ $loan->loan_released_date->subMonths(6)->format('M Y') }}</p>
                        
                        <div class="d-grid gap-2">
                            <a href="#" class="btn btn-outline-primary action-btn">
                                <i class="bi bi-eye me-2"></i>View Profile
                            </a>
                            <a href="#" class="btn btn-outline-secondary action-btn">
                                <i class="bi bi-envelope me-2"></i>Send Message
                            </a>
                        </div>
                        
                        <hr class="my-3">
                        
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="fw-bold">5</div>
                                <div class="small text-muted">Loans</div>
                            </div>
                            <div class="col-6">
                                <div class="fw-bold text-success">98%</div>
                                <div class="small text-muted">Repayment Rate</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Guarantors Card -->
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-people me-2"></i> Guarantors</h5>
                        <span class="badge bg-secondary">{{ $loan->guarantors->count() }}</span>
                    </div>
                    <div class="card-body">
                        @if($loan->guarantors->count())
                            <div class="list-group list-group-flush">
                                @foreach($loan->guarantors as $guarantor)
                                <div class="list-group-item px-0 py-3 guarantor-item">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width:40px; height:40px;">
                                            <i class="bi bi-person text-muted"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">{{ $guarantor->name }}</h6>
                                            <small class="text-muted">{{ $guarantor->email }}</small>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary border-0" type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>View</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="bi bi-envelope me-2"></i>Message</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-people display-4 text-muted"></i>
                                <p class="text-muted mt-2 mb-0">No guarantors assigned</p>
                            </div>
                        @endif
                        <a href="#" class="btn btn-outline-success action-btn w-100 mt-3">
                            <i class="bi bi-plus-circle me-2"></i>Add Guarantor
                        </a>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-lightning me-2"></i> Quick Actions</h5>
                    </div>
                    <div class="card-body d-grid gap-2">
                        <button class="btn btn-success action-btn">
                            <i class="bi bi-cash-coin me-2"></i>Record Payment
                        </button>
                        <button class="btn btn-warning action-btn">
                            <i class="bi bi-clock-history me-2"></i>View Payment History
                        </button>
                        <button class="btn btn-info action-btn">
                            <i class="bi bi-graph-up me-2"></i>Generate Report
                        </button>
                        <button class="btn btn-outline-primary action-btn">
                            <i class="bi bi-calendar-plus me-2"></i>Schedule Reminder
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
