@extends('reports.layout')

@section('report-title', 'Savings Reports')
@section('report-description', 'Savings accounts and transaction analysis')

@section('filters')
<form method="GET" action="{{ route('reports.savings') }}">
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
            <label class="form-label">Account Status</label>
            <select name="status" class="form-select">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
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
            <a href="{{ route('reports.savings') }}" class="btn btn-outline-secondary">
                <i class="fas fa-refresh me-2"></i>Reset
            </a>
        </div>
    </div>
</form>
@endsection

@section('report-content')
<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="mb-0">{{ number_format($summary['total_balance'], 2) }}</h4>
                        <p class="mb-0">Total Balance</p>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-piggy-bank fa-2x opacity-50"></i>
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
                        <h4 class="mb-0">{{ number_format($summary['total_deposits'], 2) }}</h4>
                        <p class="mb-0">Total Deposits</p>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-arrow-down fa-2x opacity-50"></i>
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
                        <h4 class="mb-0">{{ number_format($summary['total_withdrawals'], 2) }}</h4>
                        <p class="mb-0">Total Withdrawals</p>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-arrow-up fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="mb-0">{{ $summary['active_accounts'] }}</h4>
                        <p class="mb-0">Active Accounts</p>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-users fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-transparent py-3">
                <h6 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>Savings Accounts
                </h6>
            </div>
            <div class="card-body">
                @if($savings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Account #</th>
                                <th>Borrower</th>
                                <th>Product</th>
                                <th>Balance</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($savings as $account)
                            <tr>
                                <td><strong>{{ $account->account_number }}</strong></td>
                                <td>{{ $account->borrower->full_name ?? 'N/A' }}</td>
                                <td>{{ $account->savingsProduct->name ?? 'N/A' }}</td>
                                <td>{{ number_format($account->balance, 2) }}</td>
                                <td>
                                    <span class="badge 
                                        @if($account->status == 'active') bg-success
                                        @elseif($account->status == 'inactive') bg-warning
                                        @else bg-secondary @endif">
                                        {{ ucfirst($account->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                    <p class="text-muted mb-0">No savings accounts found</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-transparent py-3">
                <h6 class="card-title mb-0">
                    <i class="fas fa-exchange-alt me-2"></i>Recent Transactions
                </h6>
            </div>
            <div class="card-body">
                @if($transactions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Account</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions->take(10) as $transaction)
                            <tr>
                                <td>{{ $transaction->transaction_date->format('M d') }}</td>
                                <td>{{ $transaction->account->account_number ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge 
                                        @if($transaction->type == 'deposit') bg-success
                                        @else bg-warning @endif">
                                        {{ ucfirst($transaction->type) }}
                                    </span>
                                </td>
                                <td>{{ number_format($transaction->amount, 2) }}</td>
                                <td>{{ number_format($transaction->balance_after, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-exchange-alt fa-2x text-muted mb-2"></i>
                    <p class="text-muted mb-0">No transactions found</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection