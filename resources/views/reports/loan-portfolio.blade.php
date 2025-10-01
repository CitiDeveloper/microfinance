@extends('reports.layout')

@section('report-title', 'Loan Portfolio Report')
@section('report-description', 'Comprehensive overview of all loans in the system')

@section('filters')
<!-- Statistics Cards -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="mb-0">{{ number_format($loans->sum('loan_principal_amount'), 2) }}</h4>
                        <p class="mb-0">Total Portfolio</p>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-dollar-sign fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="mb-0">{{ $loans->where('loan_status_id', 1)->count() }}</h4>
                        <p class="mb-0">Active Loans</p>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="mb-0">{{ $loans->where('loan_status_id', 8)->count() }}</h4>
                        <p class="mb-0">Pending Approval</p>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-clock fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="mb-0">{{ $loans->where('loan_status_id', 3)->count() }}</h4>
                        <p class="mb-0">Defaulted Loans</p>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<form method="GET" action="{{ route('reports.loan-portfolio') }}">
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
            <label class="form-label">Loan Status</label>
            <select name="loan_status_id" class="form-select">
                <option value="">All Statuses</option>
                @foreach($loanStatuses as $status)
                    <option value="{{ $status->id }}" {{ request('loan_status_id') == $status->id ? 'selected' : '' }}>
                        {{ $status->status_name }}
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
        <div class="col-12">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search me-2"></i>Apply Filters
            </button>
            <a href="{{ route('reports.loan-portfolio') }}" class="btn btn-outline-secondary">
                <i class="fas fa-refresh me-2"></i>Reset
            </a>
        </div>
    </div>
</form>
@endsection

@section('report-content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-transparent py-3">
        <h6 class="card-title mb-0">
            <i class="fas fa-list me-2"></i>Loan Portfolio Summary
            <span class="badge bg-primary ms-2">{{ $loans->count() }} Loans</span>
        </h6>
    </div>
    <div class="card-body">
        @if($loans->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Loan ID</th>
                        <th>Borrower</th>
                        <th>Branch</th>
                        <th>Product</th>
                        <th>Principal</th>
                        <th>Interest Rate</th>
                        <th>Status</th>
                        <th>Release Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loans as $loan)
                    <tr>
                        <td><strong>#{{ $loan->id }}</strong></td>
                        <td>{{ $loan->borrower->full_name ?? 'N/A' }}</td>
                        <td>{{ $loan->branch->branch_name ?? 'N/A' }}</td>
                        <td>{{ $loan->loanProduct->loan_product_name ?? 'N/A' }}</td>
                        <td>{{ number_format($loan->loan_principal_amount, 2) }}</td>
                        <td>
                            <span class="badge bg-info">{{ number_format($loan->loan_interest, 2) }}%</span>
                        </td>
                        <td>
                            <span class="badge 
                                @if($loan->loan_status_id == 1) bg-success
                                @elseif($loan->loan_status_id == 3) bg-danger
                                @elseif($loan->loan_status_id == 8) bg-warning
                                @else bg-secondary @endif">
                                {{ $loan->loanStatus->status_name ?? 'N/A' }}
                            </span>
                        </td>
                        <td>{{ $loan->loan_released_date?->format('M d, Y') ?? 'N/A' }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="4" class="text-end">Total:</th>
                        <th>{{ number_format($loans->sum('loan_principal_amount'), 2) }}</th>
                        <th colspan="4"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No loans found</h5>
            <p class="text-muted">Try adjusting your filters to see more results.</p>
        </div>
        @endif
    </div>
</div>


@endsection