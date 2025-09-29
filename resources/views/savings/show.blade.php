@extends('layouts.app')

@section('title', 'Savings Account Details')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Account Information Card -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-piggy-bank me-2"></i>Account Information
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="p-4 border-bottom">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-grow-1">
                                <h4 class="mb-1">{{ $saving->account_number }}</h4>
                                <p class="text-muted mb-0">{{ $saving->borrower->full_name }}</p>
                            </div>
                            <div class="status-badge">
                                <span class="badge bg-{{ $saving->status == 'active' ? 'success' : ($saving->status == 'closed' ? 'danger' : 'warning') }} rounded-pill px-3 py-2">
                                    {{ ucfirst($saving->status) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="balance-display text-center my-4 py-3 bg-light rounded">
                            <p class="text-muted mb-1">Current Balance</p>
                            <h2 class="text-primary fw-bold">{{ number_format($saving->balance, 2) }}</h2>
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="ps-0 text-muted">Product</td>
                                <td class="text-end pe-0 fw-medium">{{ $saving->savingsProduct->name }}</td>
                            </tr>
                            <tr>
                                <td class="ps-0 text-muted">Branch</td>
                                <td class="text-end pe-0 fw-medium">{{ $saving->branch->branch_name }}</td>
                            </tr>
                            <tr>
                                <td class="ps-0 text-muted">Opening Date</td>
                                <td class="text-end pe-0 fw-medium">{{ $saving->opening_date->format('M d, Y') }}</td>
                            </tr>
                            <tr>
                                <td class="ps-0 text-muted">Maturity Date</td>
                                <td class="text-end pe-0 fw-medium">{{ $saving->maturity_date ? $saving->maturity_date->format('M d, Y') : 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions Card -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-light py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills mb-3" id="transactionTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="deposit-tab" data-bs-toggle="pill" data-bs-target="#deposit" type="button" role="tab" aria-controls="deposit" aria-selected="true">
                                <i class="fas fa-arrow-down me-1"></i> Deposit
                            </button>
                        </li>
                        @if($saving->savingsProduct->allow_withdrawals)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="withdraw-tab" data-bs-toggle="pill" data-bs-target="#withdraw" type="button" role="tab" aria-controls="withdraw" aria-selected="false">
                                <i class="fas fa-arrow-up me-1"></i> Withdraw
                            </button>
                        </li>
                        @endif
                    </ul>
                    
                    <div class="tab-content" id="transactionTabContent">
                        <div class="tab-pane fade show active" id="deposit" role="tabpanel" aria-labelledby="deposit-tab">
                            <form action="{{ route('savings.deposit', $saving) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Deposit Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{$systemSettings->currency}}</span>
                                        <input type="number" name="amount" class="form-control" step="0.01" min="0.01" placeholder="0.00" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Transaction Date</label>
                                    <input type="date" name="transaction_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Notes</label>
                                    <textarea name="notes" class="form-control" rows="2" placeholder="Add a note..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-check-circle me-1"></i> Process Deposit
                                </button>
                            </form>
                        </div>
                        
                        @if($saving->savingsProduct->allow_withdrawals)
                        <div class="tab-pane fade" id="withdraw" role="tabpanel" aria-labelledby="withdraw-tab">
                            <form action="{{ route('savings.withdraw', $saving) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Withdrawal Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" name="amount" class="form-control" step="0.01" min="0.01" placeholder="0.00" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Transaction Date</label>
                                    <input type="date" name="transaction_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Notes</label>
                                    <textarea name="notes" class="form-control" rows="2" placeholder="Add a note..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="fas fa-paper-plane me-1"></i> Process Withdrawal
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Transaction History -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-history me-2"></i>Transaction History
                        </h5>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                                <li><a class="dropdown-item" href="#">All Transactions</a></li>
                                <li><a class="dropdown-item" href="#">Deposits Only</a></li>
                                <li><a class="dropdown-item" href="#">Withdrawals Only</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Date</th>
                                    <th>Reference</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Balance</th>
                                    <th>Receipt No.</th>
                                    <th class="pe-4">Created By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $transaction)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="transaction-icon me-3 rounded-circle d-flex align-items-center justify-content-center bg-{{ $transaction->type == 'deposit' ? 'success' : 'warning' }}-subtle">
                                                    <i class="fas fa-{{ $transaction->type == 'deposit' ? 'arrow-down text-success' : 'arrow-up text-warning' }} fa-sm"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-medium">{{ $transaction->transaction_date->format('M d, Y') }}</div>
                                                    <small class="text-muted">{{ $transaction->transaction_date->format('h:i A') }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="font-monospace">{{ $transaction->transaction_reference }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $transaction->type == 'deposit' ? 'success' : 'warning' }}-subtle text-{{ $transaction->type == 'deposit' ? 'success' : 'warning' }} rounded-pill">
                                                {{ ucfirst($transaction->type) }}
                                            </span>
                                        </td>
                                        <td class="fw-bold {{ $transaction->type == 'deposit' ? 'text-success' : 'text-warning' }}">
                                            {{ $transaction->type == 'deposit' ? '+' : '-' }}{{ number_format($transaction->amount, 2) }}
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <small class="text-muted">Before: {{ number_format($transaction->balance_before, 2) }}</small>
                                                <span class="fw-medium">After: {{ number_format($transaction->balance_after, 2) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($transaction->receipt_number)
                                            <span class="badge bg-light text-dark">{{ $transaction->receipt_number }}</span>
                                            @else
                                            <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="pe-4">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-2">
                                                    <span class="text-primary fw-bold">{{ substr($transaction->creator->name, 0, 1) }}</span>
                                                </div>
                                                <span>{{ $transaction->creator->name }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="py-4">
                                                <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">No transactions found</h5>
                                                <p class="text-muted">Transactions will appear here once they are processed.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Showing {{ $transactions->firstItem() ?? 0 }}-{{ $transactions->lastItem() ?? 0 }} of {{ $transactions->total() }} transactions
                        </div>
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .transaction-icon {
        width: 36px;
        height: 36px;
    }
    
    .balance-display {
        border-left: 4px solid #0d6efd;
    }
    
    .avatar-sm {
        width: 32px;
        height: 32px;
    }
    
    .table > :not(caption) > * > * {
        padding: 0.75rem 0.5rem;
    }
    
    .card {
        border-radius: 0.75rem;
    }
    
    .nav-pills .nav-link {
        border-radius: 0.5rem;
        margin-right: 0.5rem;
    }
</style>
@endsection