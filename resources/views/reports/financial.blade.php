@extends('reports.layout')

@section('report-title', 'Financial Reports')
@section('report-description', 'Detailed financial transactions and revenue analysis')

@section('filters')
<form method="GET" action="{{ route('reports.financial') }}">
    <div class="row g-3">
        <div class="col-md-3">
            <label class="form-label">Branch</label>
            <select name="branch_id" class="form-select">
                <option value="">All Branches</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->branch_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Date From</label>
            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Date To</label>
            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">&nbsp;</label>
            <div>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-2"></i>Apply Filters
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@section('report-content')
<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-2">
        <div class="card bg-primary text-white shadow-sm">
            <div class="card-body text-center py-3">
                <h5 class="mb-1">{{ number_format($summary['total_collected'], 2) }}</h5>
                <small>Total Collected</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-success text-white shadow-sm">
            <div class="card-body text-center py-3">
                <h5 class="mb-1">{{ number_format($summary['total_principal'], 2) }}</h5>
                <small>Principal</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-info text-white shadow-sm">
            <div class="card-body text-center py-3">
                <h5 class="mb-1">{{ number_format($summary['total_interest'], 2) }}</h5>
                <small>Interest</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-warning text-white shadow-sm">
            <div class="card-body text-center py-3">
                <h5 class="mb-1">{{ number_format($summary['total_fees'], 2) }}</h5>
                <small>Fees</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-danger text-white shadow-sm">
            <div class="card-body text-center py-3">
                <h5 class="mb-1">{{ number_format($summary['total_penalty'], 2) }}</h5>
                <small>Penalty</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-secondary text-white shadow-sm">
            <div class="card-body text-center py-3">
                <h5 class="mb-1">{{ $repayments->count() }}</h5>
                <small>Transactions</small>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-transparent py-3">
        <h6 class="card-title mb-0">
            <i class="fas fa-money-bill-wave me-2"></i>Financial Transactions
        </h6>
    </div>
    <div class="card-body">
        @if($repayments->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Receipt #</th>
                        <th>Loan ID</th>
                        <th>Borrower</th>
                        <th>Payment Date</th>
                        <th>Principal</th>
                        <th>Interest</th>
                        <th>Fees</th>
                        <th>Penalty</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($repayments as $repayment)
                    <tr>
                        <td><strong>{{ $repayment->receipt_number ?? 'N/A' }}</strong></td>
                        <td>#{{ $repayment->loan_id }}</td>
                        <td>{{ $repayment->borrower->full_name ?? 'N/A' }}</td>
                        <td>{{ $repayment->payment_date->format('M d, Y') }}</td>
                        <td>{{ number_format($repayment->principal_paid, 2) }}</td>
                        <td>{{ number_format($repayment->interest_paid, 2) }}</td>
                        <td>{{ number_format($repayment->fees_paid, 2) }}</td>
                        <td>{{ number_format($repayment->penalty_paid, 2) }}</td>
                        <td><strong>{{ number_format($repayment->amount, 2) }}</strong></td>
                        <td>
                            <span class="badge bg-success">Posted</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-money-bill-wave fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No financial transactions found</h5>
            <p class="text-muted">Try adjusting your filters to see more results.</p>
        </div>
        @endif
    </div>
</div>
@endsection