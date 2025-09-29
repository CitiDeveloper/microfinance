@extends('layouts.app')

@section('title', 'Loan Details')
<style>
.progress-circle {
    position: relative;
    display: inline-block;
    border-radius: 50%;
    background: conic-gradient(#28a745 {{ $loan->progress_percentage * 3.6 }}deg, #e9ecef 0deg);
}

.progress-circle::before {
    content: '';
    position: absolute;
    top: 10px;
    left: 10px;
    right: 10px;
    bottom: 10px;
    background: white;
    border-radius: 50%;
}

.progress-circle-value {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-weight: bold;
    font-size: 1.2rem;
    color: #28a745;
}
</style>
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
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Combined Loan Summary & Repayment Schedule -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-info-circle mr-2"></i>Loan Summary & Repayment Schedule
                        <span class="text-black"><small>Loan ID: {{ $loan->loan_application_id }}</small></span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Loan Summary -->
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3"><i class="fas fa-file-invoice mr-2"></i>Loan Details</h6>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="font-weight-bold text-muted small">Principal Amount</label>
                                    <p class="h5 text-primary mb-0">{{ number_format($loan->loan_principal_amount, 2) }}</p>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="font-weight-bold text-muted small">Interest Rate</label>
                                    <p class="h5 text-success mb-0">{{ $loan->loan_interest }}%</p>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="font-weight-bold text-muted small">Duration</label>
                                    <p class="h5 text-info mb-0">{{ $loan->loan_duration }} {{ $loan->loan_duration_period }}</p>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="font-weight-bold text-muted small">Repayments</label>
                                    <p class="h5 text-warning mb-0">{{ $loan->loan_num_of_repayments }}</p>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="font-weight-bold text-muted small">Loan Product</label>
                                    <p class="mb-0 text-dark">{{ $loan->loanProduct->loan_product_name }}</p>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="font-weight-bold text-muted small">Loan Status</label>
                                    <p class="mb-0 text-dark">
                                        <span class="badge bg-{{ $statusColor }}">{{ $loan->loanStatus->name }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Repayment Progress -->
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3"><i class="fas fa-chart-line mr-2"></i>Repayment Progress</h6>
                            <div class="text-center mb-4">
                                <div class="position-relative d-inline-block">
                                    <div class="progress-circle" data-percentage="{{ $loan->progress_percentage }}" 
                                         style="width: 120px; height: 120px;">
                                        <span class="progress-circle-value">{{ $loan->progress_percentage }}%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="font-weight-bold text-success">{{ number_format($loan->amount_paid, 2) }}</div>
                                    <div class="small text-muted">Paid</div>
                                </div>
                                <div class="col-4">
                                    <div class="font-weight-bold text-warning">{{ number_format($loan->remaining_balance, 2) }}</div>
                                    <div class="small text-muted">Remaining</div>
                                </div>
                                <div class="col-4">
                                    <div class="font-weight-bold text-primary">{{ number_format($loan->total_amount, 2) }}</div>
                                    <div class="small text-muted">Total</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Schedule Details -->
                    <div class="row mt-3">
                        <div class="col-md-4 mb-3">
                            <label class="font-weight-bold text-muted small">Payment Scheme</label>
                            <p class="mb-0 text-dark">{{ $loan->afterMaturityPaymentScheme->name ?? 'N/A' }}</p>
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
                </div>
            </div>

            <!-- Payment Schedule Table -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-calendar-alt mr-2"></i>Payment Schedule
                    </h5>
                    <span class="badge bg-primary">{{ $loan->paymentSchedules->count() }} Installments</span>
                </div>
                <div class="card-body">
                    @if($loan->paymentSchedules->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Due Date</th>
                                        <th>Principal</th>
                                        <th>Interest</th>
                                        <th>Total Due</th>
                                        <th>Status</th>
                                        <th>Paid Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($loan->paymentSchedules as $schedule)
                                    @php
                                        $isOverdue = !$schedule->is_paid && $schedule->due_date->lt(now());
                                        $rowClass = $isOverdue ? 'table-warning' : ($schedule->is_paid ? 'table-success' : '');
                                    @endphp
                                    <tr class="{{ $rowClass }}">
                                        <td class="font-weight-bold">{{ $schedule->installment_number }}</td>
                                        <td>
                                            {{ $schedule->due_date->format('M d, Y') }}
                                            @if($isOverdue)
                                                <span class="badge bg-danger ms-1">Overdue</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($schedule->principal_amount, 2) }}</td>
                                        <td>{{ number_format($schedule->interest_amount, 2) }}</td>
                                        <td class="font-weight-bold">{{ number_format($schedule->total_amount, 2) }}</td>
                                        <td>
                                            @if($schedule->is_paid)
                                                <span class="badge bg-success">Paid</span>
                                            @elseif($isOverdue)
                                                <span class="badge bg-danger">Overdue</span>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $schedule->paid_date ? $schedule->paid_date->format('M d, Y') : '-' }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No payment schedule found for this loan.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Repayment History Table -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-money-bill-wave mr-2"></i>Repayment History
                    </h5>
                    <span class="badge bg-primary">{{ $loan->repayments->count() }} Payments</span>
                </div>
                <div class="card-body">
                    @if($loan->repayments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
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
                                        <td>{{ number_format($repayment->amount, 2) }}</td>
                                        <td>{{ number_format($repayment->principal_paid, 2) }}</td>
                                        <td>{{ number_format($repayment->interest_paid, 2) }}</td>
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
                                            <a href="{{ route('repayments.show', $repayment) }}" class="btn btn-sm btn-outline-primary"> 
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
                            <p class="text-muted">No repayment records found for this loan.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Loan Collaterals Table -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-shield-alt mr-2"></i>Loan Collaterals
                    </h5>
                    <span class="badge bg-primary">{{ $loan->collaterals->count() }} Collaterals</span>
                </div>
                <div class="card-body">
                    @if($loan->collaterals->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
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
                                        <td>{{ number_format($collateral->estimated_value, 2) }}</td>
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
                                            <a href="{{ route('collateral.show', $collateral) }}" class="btn btn-sm btn-outline-primary">
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
                            <i class="fas fa-shield-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No collateral records found for this loan.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Guarantors Table -->
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-users mr-2"></i>Guarantors
                    </h5>
                    <span class="badge bg-primary">{{ $loan->guarantors->count() }} Guarantors</span>
                </div>
                <div class="card-body">
                    @if($loan->guarantors->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Relationship</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($loan->guarantors as $guarantor)
                                    <tr>
                                        <td class="font-weight-bold">{{ $guarantor->name }}</td>
                                        <td>{{ $guarantor->email }}</td>
                                        <td>{{ $guarantor->phone ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $guarantor->relationship ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('guarantors.show', $guarantor) }}" class="btn btn-sm btn-outline-primary">
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
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No guarantors assigned to this loan.</p>
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
                    <h5 class="mb-0 text-primary text-center">
                        <i class="fas fa-user mr-2"></i>Borrower Information
                    </h5>
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

            <!-- System Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-info-circle mr-2"></i>System Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <label class="font-weight-bold text-muted small">Created</label>
                        <p class="mb-0 text-dark small">{{ $loan->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div class="mb-2">
                        <label class="font-weight-bold text-muted small">Updated</label>
                        <p class="mb-0 text-dark small">{{ $loan->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div class="mb-0">
                        <label class="font-weight-bold text-muted small">Application ID</label>
                        <p class="mb-0 text-dark small">{{ $loan->loan_application_id }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-bolt mr-2"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-success btn-sm">
                            <i class="fas fa-cash-register mr-1"></i>Record Payment
                        </button>
                        <button class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-history mr-1"></i>Payment History
                        </button>
                        <button class="btn btn-outline-info btn-sm">
                            <i class="fas fa-chart-bar mr-1"></i>Generate Report
                        </button>
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-bell mr-1"></i>Schedule Reminder
                        </button>
                        <button class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-print mr-1"></i>Print Schedule
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection