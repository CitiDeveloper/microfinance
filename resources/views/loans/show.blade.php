{{-- resources/views/loans/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Loan Details')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1 text-gray-800">Loan Details</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('loans.index') }}">Loans</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $loan->loan_application_id }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="btn-group">
                    <a href="{{ route('loans.edit', $loan->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit mr-1"></i> Edit Loan
                    </a>
                    <a href="{{ route('loans.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Back
                    </a>
                </div>
            </div>
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
        $statusColor = $statusColors[strtolower($loan->loanStatus->name)] ?? 'primary';
    @endphp
   

    <div class="row">
        <!-- Left Column - Loan Information -->
        <div class="col-lg-8">
            <!-- Loan Summary -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary"><i class="fas fa-info-circle mr-2"></i>Loan Summary <span class="text-black"><small>Loan ID: {{ $loan->loan_application_id }}</small></span></h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3 text-center">
                            <label class="font-weight-bold text-muted small">Principal Amount</label>
                            <p class="h5 text-primary mb-0">{{ number_format($loan->loan_principal_amount, 2) }}</p>
                        </div>
                        <div class="col-md-3 mb-3 text-center">
                            <label class="font-weight-bold text-muted small">Interest Rate</label>
                            <p class="h5 text-success mb-0">{{ $loan->loan_interest }}%</p>
                        </div>
                        <div class="col-md-3 mb-3 text-center">
                            <label class="font-weight-bold text-muted small">Duration</label>
                            <p class="h5 text-info mb-0">{{ $loan->loan_duration }} {{ $loan->loan_duration_period }}</p>
                        </div>
                        <div class="col-md-3 mb-3 text-center">
                            <label class="font-weight-bold text-muted small">Repayments</label>
                            <p class="h5 text-warning mb-0">{{ $loan->loan_num_of_repayments }}</p>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3 mb-3">
                            <label class="font-weight-bold text-muted small">Loan Title</label>
                            <p class="mb-0 text-dark">{{ $loan->loan_title ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="font-weight-bold text-muted small">Loan Product</label>
                            <p class="mb-0 text-dark">{{ $loan->loanProduct->loan_product_name }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="font-weight-bold text-muted small">Loan Status</label>
                            <p class="mb-0 text-dark"> <span class="badge bg-{{ $statusColor }}">{{ $loan->loanStatus->name }}</span></p>
                        </div>
                    </div>

                    @if($loan->loan_description)
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="font-weight-bold text-muted small">Description</label>
                            <p class="mb-0 text-dark">{{ $loan->loan_description }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Repayment Schedule -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary"><i class="fas fa-calendar-alt mr-2"></i>Repayment Schedule</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="font-weight-bold text-muted small">Payment Scheme</label>
                            <p class="mb-0 text-dark">{{ $loan->afterMaturityPaymentScheme->name }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="font-weight-bold text-muted small">Interest Period</label>
                            <p class="mb-0 text-dark">{{ $loan->loan_interest_period }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="font-weight-bold text-muted small">Released Date</label>
                            <p class="mb-0 text-dark">{{ $loan->loan_released_date->format('M d, Y') }}</p>
                        </div>
                    </div>

                    @if($loan->loan_first_repayment_date)
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-muted small">First Repayment Date</label>
                            <p class="mb-0 text-dark">{{ $loan->loan_first_repayment_date->format('M d, Y') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-muted small">First Repayment Amount</label>
                            <p class="mb-0 text-dark">{{ $loan->first_repayment_amount ? number_format($loan->first_repayment_amount, 2) : 'N/A' }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Repayment Progress -->
                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="font-weight-bold text-muted small">Repayment Progress</span>
                            <span class="font-weight-bold text-muted small">65% Complete</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: 65%"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <small class="text-muted">Paid: ₱15,250.00</small>
                            <small class="text-muted">Remaining: ₱8,250.00</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Repayments Table -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary"><i class="fas fa-money-bill-wave mr-2"></i>Repayment History</h5>
                    <span class="badge bg-primary">{{ $loan->repayments->count() }} Payments</span>
                </div>
                <div class="card-body">
                    @if($loan->repayments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Receipt #</th>
                                        <th>Payment Date</th>
                                        <th>Amount</th>
                                        <th>Principal</th>
                                        <th>Interest</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($loan->repayments as $repayment)
                                    <tr>
                                        <td class="font-weight-bold">{{ $repayment->receipt_number ?? 'N/A' }}</td>
                                        <td>{{ $repayment->payment_date ? $repayment->payment_date->format('M d, Y') : 'N/A' }}</td>
                                        <td>${{ number_format($repayment->amount, 2) }}</td>
                                        <td>${{ number_format($repayment->principal_paid, 2) }}</td>
                                        <td>${{ number_format($repayment->interest_paid, 2) }}</td>
                                        <td>
                                            @php
                                                $statusClass = [
                                                    'pending' => 'warning',
                                                    'posted' => 'success',
                                                    'failed' => 'danger',
                                                    'reversed' => 'secondary'
                                                ][$repayment->status] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $statusClass }}">
                                                {{ ucfirst($repayment->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-money-bill-wave fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No repayment records found for this loan.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Collaterals Table -->
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary"><i class="fas fa-shield-alt mr-2"></i>Loan Collaterals</h5>
                    <span class="badge bg-primary">{{ $loan->collaterals->count() }} Collaterals</span>
                </div>
                <div class="card-body">
                    @if($loan->collaterals->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Estimated Value</th>
                                        <th>Condition</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($loan->collaterals as $collateral)
                                    <tr>
                                        <td class="font-weight-bold">{{ $collateral->collateral_type }}</td>
                                        <td>{{ Str::limit($collateral->description, 50) }}</td>
                                        <td>${{ number_format($collateral->estimated_value, 2) }}</td>
                                        <td>{{ $collateral->condition ?? 'N/A' }}</td>
                                        <td>
                                            @php
                                                $statusClass = [
                                                    'active' => 'success',
                                                    'released' => 'info',
                                                    'seized' => 'warning',
                                                    'sold' => 'secondary'
                                                ][$collateral->status] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $statusClass }}">
                                                {{ ucfirst($collateral->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-shield-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No collateral records found for this loan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="col-lg-4">
            <!-- Borrower Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary text-center"><i class="fas fa-user mr-2"></i>Borrower Information</h5>
                </div>
                <div class="card-body text-center">
                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-user text-white fa-2x"></i>
                    </div>
                    <h6 class="font-weight-bold mb-1">{{ $loan->borrower->name }}</h6>
                    <p class="text-muted small mb-3">Member since {{ $loan->loan_released_date->subMonths(6)->format('M Y') }}</p>
                    
                    <div class="d-grid gap-2 mb-3">
                        <a href="#" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye mr-1"></i>View Profile
                        </a>
                        <a href="#" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-envelope mr-1"></i>Send Message
                        </a>
                    </div>
                    
                    <hr>
                    
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="font-weight-bold">5</div>
                            <div class="small text-muted">Loans</div>
                        </div>
                        <div class="col-6">
                            <div class="font-weight-bold text-success">98%</div>
                            <div class="small text-muted">Repayment Rate</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Guarantors -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 text-primary"><i class="fas fa-users mr-2"></i>Guarantors</h6>
                    <span class="badge bg-secondary">{{ $loan->guarantors->count() }}</span>
                </div>
                <div class="card-body">
                    @if($loan->guarantors->count())
                        <div class="list-group list-group-flush">
                            @foreach($loan->guarantors as $guarantor)
                            <div class="list-group-item px-0 py-2 border-left-3 border-left-success">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="fas fa-user text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 small">{{ $guarantor->name }}</h6>
                                        <small class="text-muted">{{ $guarantor->email }}</small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-users fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0 small">No guarantors assigned</p>
                        </div>
                    @endif
                    <button class="btn btn-outline-success btn-sm w-100 mt-2">
                        <i class="fas fa-plus-circle mr-1"></i>Add Guarantor
                    </button>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 text-primary"><i class="fas fa-bolt mr-2"></i>Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-success btn-sm">
                            <i class="fas fa-cash-register mr-1"></i>Record Payment
                        </button>
                        <button class="btn btn-warning btn-sm">
                            <i class="fas fa-history mr-1"></i>Payment History
                        </button>
                        <button class="btn btn-info btn-sm">
                            <i class="fas fa-chart-bar mr-1"></i>Generate Report
                        </button>
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-bell mr-1"></i>Schedule Reminder
                        </button>
                    </div>
                </div>
            </div>

            <!-- System Information -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 text-primary"><i class="fas fa-info-circle mr-2"></i>System Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <label class="font-weight-bold text-muted small">Created</label>
                        <p class="mb-0 text-dark small">{{ $loan->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div class="mb-0">
                        <label class="font-weight-bold text-muted small">Updated</label>
                        <p class="mb-0 text-dark small">{{ $loan->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection