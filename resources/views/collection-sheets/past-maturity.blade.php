@extends('layouts.app')

@section('title', 'Past Maturity Loans')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-primary">
                            <i class="fas fa-clock me-2"></i>Past Maturity Loans
                        </h4>
                        <a href="{{ route('collection-sheets.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Create Collection Sheet
                        </a>
                    </div>
                </div>
                
                <div class="card-body p-0">
                     @if($pastMaturityLoans->count() > 0)
                    <div class="card-footer bg-light">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="card border-0 shadow-none bg-light-danger">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-md bg-danger rounded-circle d-flex align-items-center justify-content-center me-3">
                                                <i class="fas fa-money-bill-wave text-white"></i>
                                            </div>
                                            <div>
                                                <p class="text-muted mb-1">Total Outstanding</p>
                                                <h3 class="mb-0 text-dark">{{ ucfirst($systemSettings->currency) }} {{ number_format($summary['total_outstanding'], 2) }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-0 shadow-none bg-light-warning">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-md bg-warning rounded-circle d-flex align-items-center justify-content-center me-3">
                                                <i class="fas fa-file-invoice text-white"></i>
                                            </div>
                                            <div>
                                                <p class="text-muted mb-1">Total Loans</p>
                                                <h3 class="mb-0 text-dark">{{ $summary['total_loans'] }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-0 shadow-none bg-light-info">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-md bg-info rounded-circle d-flex align-items-center justify-content-center me-3">
                                                <i class="fas fa-calendar-times text-white"></i>
                                            </div>
                                            <div>
                                                <p class="text-muted mb-1">Oldest Maturity</p>
                                                <h6 class="mb-0 text-dark">
                                                    {{ $summary['oldest_maturity'] ? $summary['oldest_maturity']->format('M d, Y') : 'N/A' }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                    @if($pastMaturityLoans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Borrower</th>
                                        <th>Loan ID</th>
                                        <th>Product</th>
                                        <th>Outstanding Balance</th>
                                        <th>Maturity Date</th>
                                        <th>Days Past Due</th>
                                        <th>Status</th>
                                        <th class="text-end pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pastMaturityLoans as $loan)
                                        @php
                                            $daysPastDue = $loan->loan_due_date->diffInDays(Carbon\Carbon::today());
                                            $urgencyLevel = $daysPastDue > 30 ? 'high' : ($daysPastDue > 15 ? 'medium' : 'low');
                                        @endphp
                                        <tr class="align-middle">
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center me-3">
                                                        <i class="fas fa-user text-muted"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $loan->borrower->full_name }}</h6>
                                                        <small class="text-muted">Client</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="fw-semibold text-dark">{{ $loan->loan_application_id }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark border">{{ $loan->loanProduct->loan_product_name ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-dark">{{ number_format($loan->outstanding_balance, 2) }}</span>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $loan->loan_due_date->format('M d, Y') }}</span>
                                            </td>
                                            <td>
                                                @if($urgencyLevel === 'high')
                                                    <span class="badge bg-danger px-3 py-2">
                                                        <i class="fas fa-exclamation-triangle me-1"></i>{{ $daysPastDue }} days
                                                    </span>
                                                @elseif($urgencyLevel === 'medium')
                                                    <span class="badge bg-warning px-3 py-2 text-dark">
                                                        <i class="fas fa-clock me-1"></i>{{ $daysPastDue }} days
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary px-3 py-2">
                                                        {{ $daysPastDue }} days
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-light-warning text-warning border border-warning px-3 py-2">
                                                    <i class="fas fa-calendar-times me-1"></i>Past Maturity
                                                </span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('loans.show', $loan) }}" class="btn btn-sm btn-outline-primary rounded-start">
                                                        <i class="fas fa-eye me-1"></i>View
                                                    </a>
                                                    <button class="btn btn-sm btn-outline-warning rounded-end" 
                                                            onclick="alert('Collection action would go here')">
                                                        <i class="fas fa-hand-holding-usd me-1"></i>Collect
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="py-5">
                                <i class="fas fa-check-circle fa-4x text-success mb-4"></i>
                                <h3 class="text-success mb-3">No Past Maturity Loans</h3>
                                <p class="text-muted mb-4">All loans are within their maturity period.</p>
                                <a href="{{ route('loans.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-1"></i>Back to All Loans
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
                
               
            </div>
        </div>
    </div>
</div>

<style>
.avatar-sm {
    width: 36px;
    height: 36px;
}
.avatar-md {
    width: 48px;
    height: 48px;
}
.card {
    border-radius: 12px;
}
.table th {
    border-top: none;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
}
.bg-light-danger {
    background-color: rgba(220, 53, 69, 0.1) !important;
}
.bg-light-warning {
    background-color: rgba(255, 193, 7, 0.1) !important;
}
.bg-light-info {
    background-color: rgba(23, 162, 184, 0.1) !important;
}
</style>
@endsection