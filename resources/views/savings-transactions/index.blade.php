@extends('layouts.app')

@section('title', 'Savings Transactions')
<style>
/* Modern Card Styles */
.summary-card {
    border: none;
    border-radius: 12px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
}


.icon-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Table and UI Improvements */
.avatar-sm {
    width: 32px;
    height: 32px;
}

.action-btn {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease-in-out;
}

.action-btn:hover {
    transform: translateY(-1px);
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.04) !important;
    transform: translateY(0);
    transition: all 0.2s ease;
}

.badge {
    font-weight: 500;
}

.card {
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    border-radius: 10px;
}

.card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    border-radius: 10px 10px 0 0 !important;
}

.btn-icon-split {
    padding: 0.375rem 1rem;
    border-radius: 8px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .summary-card .card-body {
        padding: 1rem;
    }
    
    .icon-circle {
        width: 50px;
        height: 50px;
    }
    
    .summary-card h2 {
        font-size: 1.5rem;
    }
}
</style>
@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Savings Transactions</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Savings Transactions</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('savings-transactions.create') }}" class="btn btn-primary btn-icon-split shadow-sm">
            <span class="icon text-black-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">New Transaction</span>
        </a>
    </div>

    <!-- Modern Summary Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card summary-card bg-primary-gradient shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-black-50 mb-1">Total Transactions</h6>
                            <h2 class="text-black mb-0">{{ $transactions->total() }}</h2>
                            <div class="mt-2">
                                <span class="badge bg-white bg-opacity-25 text-black">
                                    <i class="fas fa-calendar me-1"></i>All Time
                                </span>
                            </div>
                        </div>
                        <div class="icon-circle bg-white bg-opacity-25">
                            <i class="fas fa-exchange-alt text-black"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card summary-card bg-success-gradient shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-black-50 mb-1">Total Amount</h6>
                            <h2 class="text-black mb-0">{{$systemSettings->currency}} {{ number_format($totalAmount, 2) }}</h2>
                            <div class="mt-2">
                                <span class="badge bg-white bg-opacity-25 text-black">
                                    <i class="fas fa-chart-line me-1"></i>All Transactions
                                </span>
                            </div>
                        </div>
                        <div class="icon-circle bg-white bg-opacity-25">
                            <i class="fas fa-dollar-sign text-black"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card summary-card bg-info-gradient shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-black-50 mb-1">Deposits</h6>
                            <h2 class="text-black mb-0">{{ $depositsCount ?? 'N/A' }}</h2>
                            <div class="mt-2">
                                <span class="badge bg-white bg-opacity-25 text-black">
                                    <i class="fas fa-arrow-down me-1"></i>Incoming
                                </span>
                            </div>
                        </div>
                        <div class="icon-circle bg-white bg-opacity-25">
                            <i class="fas fa-download text-black"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card summary-card bg-warning-gradient shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-black-50 mb-1">Withdrawals</h6>
                            <h2 class="text-black mb-0">{{ $withdrawalsCount ?? 'N/A' }}</h2>
                            <div class="mt-2">
                                <span class="badge bg-white bg-opacity-25 text-black">
                                    <i class="fas fa-arrow-up me-1"></i>Outgoing
                                </span>
                            </div>
                        </div>
                        <div class="icon-circle bg-white bg-opacity-25">
                            <i class="fas fa-upload text-black"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Filters & Search</h6>
            <button class="btn btn-sm btn-outline-secondary" type="button" data-toggle="collapse" 
                    data-target="#filterCollapse" aria-expanded="true" aria-controls="filterCollapse">
                <i class="fas fa-filter"></i> Toggle Filters
            </button>
        </div>
        <div class="collapse show" id="filterCollapse">
            <div class="card-body">
                <form action="{{ route('savings-transactions.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="search" class="form-label">Search</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" id="search" name="search" 
                                       value="{{ request('search') }}" placeholder="Reference, Account, Borrower...">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="type" class="form-label">Transaction Type</label>
                            <select class="form-select" id="type" name="type">
                                <option value="">All Types</option>
                                <option value="deposit" {{ request('type') == 'deposit' ? 'selected' : '' }}>Deposit</option>
                                <option value="withdrawal" {{ request('type') == 'withdrawal' ? 'selected' : '' }}>Withdrawal</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="branch_id" class="form-label">Branch</label>
                            <select class="form-select" id="branch_id" name="branch_id">
                                <option value="">All Branches</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="date_from" class="form-label">Date From</label>
                            <input type="date" class="form-control" id="date_from" name="date_from" 
                                   value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="date_to" class="form-label">Date To</label>
                            <input type="date" class="form-control" id="date_to" name="date_to" 
                                   value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <div class="d-grid gap-2 w-100">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter me-1"></i>Filter
                                </button>
                                <a href="{{ route('savings-transactions.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-redo me-1"></i>Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Transaction Records</h6>
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" 
                        id="exportDropdown" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-download me-1"></i>Export
                </button>
                <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf me-2"></i>PDF</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-file-excel me-2"></i>Excel</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-file-csv me-2"></i>CSV</a></li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Reference</th>
                            <th>Account</th>
                            <th>Borrower</th>
                            <th>Type</th>
                            <th class="text-end">Amount</th>
                            <th>Branch</th>
                            <th>Receipt No.</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr class="align-middle">
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark">{{ $transaction->transaction_date->format('M d, Y') }}</span>
                                        <small class="text-muted">{{ $transaction->transaction_date->format('h:i A') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="font-monospace badge bg-light text-dark border">
                                        #{{ $transaction->transaction_reference }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('savings.show', $transaction->saving_id) }}" 
                                       class="text-decoration-none text-primary fw-bold">
                                        {{ $transaction->account->account_number }}
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="fas fa-user text-primary fs-6"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            {{ $transaction->account->borrower->full_name }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-pill bg-{{ $transaction->type == 'deposit' ? 'success' : 'warning' }}-subtle 
                                              text-{{ $transaction->type == 'deposit' ? 'success' : 'warning' }} 
                                              border border-{{ $transaction->type == 'deposit' ? 'success' : 'warning' }}-subtle">
                                        <i class="fas fa-{{ $transaction->type == 'deposit' ? 'arrow-down' : 'arrow-up' }} me-1"></i>
                                        {{ ucfirst($transaction->type) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <span class="fw-bold {{ $transaction->type == 'deposit' ? 'text-success' : 'text-warning' }}">
                                        {{ $transaction->type == 'deposit' ? '+' : '-' }}{{ number_format($transaction->amount, 2) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                        {{ $transaction->branch->name }}
                                    </span>
                                </td>
                                <td>
                                    @if($transaction->receipt_number)
                                        <span class="badge bg-light text-dark border">
                                            <i class="fas fa-receipt me-1"></i>{{ $transaction->receipt_number }}
                                        </span>
                                    @else
                                        <span class="text-muted fst-italic">Not set</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('savings-transactions.show', $transaction) }}" 
                                           class="btn btn-sm btn-outline-info rounded-circle action-btn" 
                                           title="View Details" data-bs-toggle="tooltip">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('savings-transactions.print-receipt', $transaction) }}" 
                                           class="btn btn-sm btn-outline-secondary rounded-circle action-btn" 
                                           title="Print Receipt" target="_blank" data-bs-toggle="tooltip">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        @can('delete', $transaction)
                                        <form action="{{ route('savings-transactions.destroy', $transaction) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle action-btn" 
                                                    onclick="return confirm('Are you sure you want to delete this transaction? This action cannot be undone.')"
                                                    title="Delete" data-bs-toggle="tooltip">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="fas fa-exchange-alt fa-4x text-muted mb-3 opacity-25"></i>
                                        <h5 class="text-muted">No transactions found</h5>
                                        <p class="text-muted mb-3">Get started by creating your first transaction.</p>
                                        <a href="{{ route('savings-transactions.create') }}" class="btn btn-primary btn-lg">
                                            <i class="fas fa-plus me-2"></i> Create Transaction
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($transactions->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Showing <span class="fw-bold">{{ $transactions->firstItem() }}</span> to 
                        <span class="fw-bold">{{ $transactions->lastItem() }}</span> of 
                        <span class="fw-bold">{{ $transactions->total() }}</span> entries
                    </div>
                    <nav aria-label="Transaction pagination">
                        {{ $transactions->links() }}
                    </nav>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Auto-submit form when filters change
        const filters = ['type', 'branch_id'];
        filters.forEach(filter => {
            const element = document.getElementById(filter);
            if (element) {
                element.addEventListener('change', function() {
                    this.form.submit();
                });
            }
        });

        // Add loading state to filter buttons
        const filterForm = document.querySelector('form');
        const filterBtn = filterForm.querySelector('button[type="submit"]');
        
        filterForm.addEventListener('submit', function() {
            filterBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Filtering...';
            filterBtn.disabled = true;
        });

        // Date range validation
        const dateFrom = document.getElementById('date_from');
        const dateTo = document.getElementById('date_to');
        
        if (dateFrom && dateTo) {
            dateFrom.addEventListener('change', function() {
                if (dateTo.value && this.value > dateTo.value) {
                    dateTo.value = this.value;
                }
            });
            
            dateTo.addEventListener('change', function() {
                if (dateFrom.value && this.value < dateFrom.value) {
                    dateFrom.value = this.value;
                }
            });
        }
    });
</script>


@endsection