@extends('layouts.app')

@section('title', 'Repayment Details')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-gradient-primary text-white py-3 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape bg-white bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="fas fa-receipt fa-lg text-white"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-semibold">Repayment Details</h4>
                            <p class="mb-0 opacity-8">Transaction #{{ $repayment->receipt_number ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('repayments.index') }}" class="btn btn-light btn-sm rounded-pill px-3">
                            <i class="fas fa-arrow-left me-2"></i>Back to List
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="row g-4">
                <!-- Left Column -->
                <div class="col-lg-8">
                    <!-- Basic Information Card -->
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-transparent border-bottom py-3">
                            <h6 class="mb-0 fw-semibold text-primary">
                                <i class="fas fa-info-circle me-2"></i>Basic Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted small mb-1">Receipt Number</label>
                                    <p class="mb-0 fw-semibold">{{ $repayment->receipt_number ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small mb-1">Transaction Reference</label>
                                    <p class="mb-0 fw-semibold">{{ $repayment->transaction_reference ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small mb-1">Status</label>
                                    <div>
                                        <span class="badge bg-{{ $repayment->status === 'posted' ? 'success' : ($repayment->status === 'pending' ? 'warning' : 'danger') }} rounded-pill px-3 py-2">
                                            <i class="fas fa-circle me-1 small"></i>
                                            {{ ucfirst($repayment->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small mb-1">Payment Date</label>
                                    <p class="mb-0 fw-semibold">{{ $repayment->payment_date->format('M d, Y') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small mb-1">Posted At</label>
                                    <p class="mb-0 fw-semibold">{{ $repayment->posted_at ? $repayment->posted_at->format('M d, Y H:i') : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <!-- Amount Summary Card -->
                    <div class="card shadow-sm border-0  bg-opacity-10">
                        <div class="card-header bg-transparent border-bottom py-3">
                            <h6 class="mb-0 fw-semibold text-primary">
                                Total Amount
                            </h6>
                        </div>
                        <div class="card-body text-center py-4">
                            <h2 class="text-success fw-bold mb-0">Ksh. {{ number_format($repayment->amount, 2) }}</h2>
                            <p class="text-muted small mb-0">Total Payment Received</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Breakdown -->
            <div class="row g-4 mt-2">
                <!-- Amount Breakdown -->
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-transparent border-bottom py-3">
                            <h6 class="mb-0 fw-semibold text-primary">
                                <i class="fas fa-chart-pie me-2"></i>Amount Breakdown
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="vstack gap-3">
                                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                    <span class="text-muted">Principal Paid</span>
                                    <span class="fw-semibold">Ksh. {{ number_format($repayment->principal_paid, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                    <span class="text-muted">Interest Paid</span>
                                    <span class="fw-semibold">Ksh. {{ number_format($repayment->interest_paid, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                    <span class="text-muted">Fees Paid</span>
                                    <span class="fw-semibold">Ksh. {{ number_format($repayment->fees_paid, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                    <span class="text-muted">Penalty Paid</span>
                                    <span class="fw-semibold">Ksh. {{ number_format($repayment->penalty_paid, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                    <span class="text-muted text-danger">Waiver Amount</span>
                                    <span class="fw-semibold text-danger">-Ksh. {{ number_format($repayment->waiver_amount, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center py-2 pt-3 border-top">
                                    <span class="fw-semibold text-primary">Total Allocated</span>
                                    <span class="fw-bold text-primary">Ksh. {{ number_format($repayment->total_allocated, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Details -->
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-transparent border-bottom py-3">
                            <h6 class="mb-0 fw-semibold text-primary">
                                <i class="fas fa-credit-card me-2"></i>Payment Details
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="vstack gap-3">
                                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                    <span class="text-muted">Payment Method</span>
                                    <span class="fw-semibold">{{ $repayment->paymentMethod->name ?? 'N/A' }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                    <span class="text-muted">Bank Account</span>
                                    <span class="fw-semibold">{{ $repayment->paymentAccount->account_name ?? 'N/A' }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                    <span class="text-muted">Reconciled</span>
                                    <span class="badge bg-{{ $repayment->is_reconciled ? 'success' : 'secondary' }} rounded-pill px-3">
                                        {{ $repayment->is_reconciled ? 'Yes' : 'No' }}
                                    </span>
                                </div>
                                @if($repayment->outstanding_balance)
                                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                    <span class="text-muted">Outstanding Balance</span>
                                    <span class="fw-semibold">Ksh. {{ number_format($repayment->outstanding_balance, 2) }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Parties -->
            <div class="row g-4 mt-2">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-transparent border-bottom py-3">
                            <h6 class="mb-0 fw-semibold text-primary">
                                <i class="fas fa-users me-2"></i>Related Parties
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-3 text-center">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="icon-shape bg-primary bg-opacity-10 rounded-circle p-3 mb-2 mx-auto">
                                            <i class="fas fa-user fa-lg text-primary"></i>
                                        </div>
                                        <label class="form-label text-muted small mb-1">Borrower</label>
                                        <p class="mb-0 fw-semibold">{{ $repayment->borrower->full_name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-3 text-center">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="icon-shape bg-info bg-opacity-10 rounded-circle p-3 mb-2 mx-auto">
                                            <i class="fas fa-file-invoice-dollar fa-lg text-info"></i>
                                        </div>
                                        <label class="form-label text-muted small mb-1">Loan Number</label>
                                        <p class="mb-0 fw-semibold">{{ $repayment->loan->loan_application_id ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-3 text-center">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="icon-shape bg-warning bg-opacity-10 rounded-circle p-3 mb-2 mx-auto">
                                            <i class="fas fa-code-branch fa-lg text-warning"></i>
                                        </div>
                                        <label class="form-label text-muted small mb-1">Branch</label>
                                        <p class="mb-0 fw-semibold">{{ $repayment->branch->branch_name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-3 text-center">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="icon-shape bg-success bg-opacity-10 rounded-circle p-3 mb-2 mx-auto">
                                            <i class="fas fa-user-tie fa-lg text-success"></i>
                                        </div>
                                        <label class="form-label text-muted small mb-1">Collected By</label>
                                        <p class="mb-0 fw-semibold">{{ $repayment->collector->full_name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            @if($repayment->notes)
            <div class="row g-4 mt-2">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-transparent border-bottom py-3">
                            <h6 class="mb-0 fw-semibold text-primary">
                                <i class="fas fa-sticky-note me-2"></i>Notes
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="bg-light rounded-3 p-3">
                                <p class="mb-0 text-dark">{{ $repayment->notes }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="row g-4 mt-2">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex gap-2 flex-wrap">
                                @if(!$repayment->isPosted())
                                    <a href="{{ route('repayments.edit', $repayment) }}" class="btn btn-warning rounded-pill px-4">
                                        <i class="fas fa-edit me-2"></i>Edit Repayment
                                    </a>
                                @endif
                                
                                @if($repayment->isPosted() && $repayment->status !== 'reversed')
                                    <button type="button" class="btn btn-danger rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#reverseModal">
                                        <i class="fas fa-undo me-2"></i>Reverse Repayment
                                    </button>
                                @endif

                                @if(!$repayment->isPosted())
                                    <form action="{{ route('repayments.destroy', $repayment) }}" method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this repayment? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger rounded-pill px-4">
                                            <i class="fas fa-trash me-2"></i>Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reverse Modal -->
@if($repayment->isPosted() && $repayment->status !== 'reversed')
<div class="modal fade" id="reverseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <div class="d-flex align-items-center">
                    <div class="icon-shape bg-white bg-opacity-10 rounded-circle p-2 me-3">
                        <i class="fas fa-undo fa-lg text-white"></i>
                    </div>
                    <h5 class="modal-title">Reverse Repayment</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('repayments.update', $repayment) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="reversed">
                <div class="modal-body">
                    <div class="mb-4">
                        <label for="reversal_reason" class="form-label fw-semibold">Reason for Reversal</label>
                        <textarea class="form-control rounded-3" id="reversal_reason" name="reversal_reason" rows="3" 
                                  placeholder="Please provide a reason for reversing this repayment..." required></textarea>
                    </div>
                    <div class="alert alert-warning border-0 rounded-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-3 fa-lg"></i>
                            <div>
                                <h6 class="alert-heading mb-1">Warning</h6>
                                <p class="mb-0 small">This action cannot be undone. The repayment will be marked as reversed and all related transactions will be adjusted.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4">
                        <i class="fas fa-undo me-2"></i>Confirm Reversal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<style>
.icon-shape {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.card {
    transition: transform 0.2s ease-in-out;
}
.card:hover {
    transform: translateY(-2px);
}
.border-bottom {
    border-color: #e9ecef !important;
}
</style>
@endsection