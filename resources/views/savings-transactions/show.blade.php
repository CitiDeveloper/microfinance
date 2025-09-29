@extends('layouts.app')

@section('title', 'Transaction Details')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Transaction Details</h1>
        <div>
          

            <a href="{{ route('savings-transactions.edit', $savingsTransaction) }}" 
               class="btn btn-primary shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit
            </a>
            <a href="{{ route('savings-transactions.index') }}" class="btn btn-light shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-gray-50"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Transaction Details -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Transaction Information</h6>
                    <span class="badge badge-{{ $savingsTransaction->type == 'deposit' ? 'success' : 'warning' }} badge-lg">
                        {{ strtoupper($savingsTransaction->type) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th class="text-muted">Reference No.</th>
                                    <td class="font-weight-bold">{{ $savingsTransaction->transaction_reference }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Receipt No.</th>
                                    <td>
                                        @if($savingsTransaction->receipt_number)
                                            <span class="badge badge-light">{{ $savingsTransaction->receipt_number }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Transaction Date</th>
                                    <td>{{ $savingsTransaction->transaction_date->format('F d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Branch</th>
                                    <td>{{ $savingsTransaction->branch->name }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th class="text-muted">Amount</th>
                                    <td class="h5 font-weight-bold {{ $savingsTransaction->type == 'deposit' ? 'text-success' : 'text-warning' }}">
                                        {{ $savingsTransaction->type == 'deposit' ? '+' : '-' }}{{ number_format($savingsTransaction->amount, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Balance Before</th>
                                    <td>{{ number_format($savingsTransaction->balance_before, 2) }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Balance After</th>
                                    <td class="font-weight-bold text-primary">{{ number_format($savingsTransaction->balance_after, 2) }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Processed By</th>
                                    <td>{{ $savingsTransaction->creator->name }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Account Information -->
                    <div class="border-top pt-3">
                        <h6 class="text-muted mb-3">Account Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Account Number:</strong>
                                <a href="{{ route('savings.show', $savingsTransaction->saving_id) }}" class="ml-2">
                                    {{ $savingsTransaction->account->account_number }}
                                </a>
                            </div>
                            <div class="col-md-6">
                                <strong>Borrower:</strong>
                                <span class="ml-2">{{ $savingsTransaction->account->borrower->full_name }}</span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <strong>Product:</strong>
                                <span class="ml-2">{{ $savingsTransaction->account->savingsProduct->name }}</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Current Balance:</strong>
                                <span class="ml-2 font-weight-bold">{{ number_format($savingsTransaction->account->balance, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($savingsTransaction->notes)
                    <div class="border-top pt-3 mt-3">
                        <h6 class="text-muted mb-2">Notes</h6>
                        <p class="mb-0">{{ $savingsTransaction->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions & Timeline -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('savings-transactions.print-receipt', $savingsTransaction) }}" 
                           class="btn btn-outline-secondary btn-block" target="_blank">
                            <i class="fas fa-print me-1"></i> Print Receipt
                        </a>
                        <a href="{{ route('savings-transactions.edit', $savingsTransaction) }}" 
                           class="btn btn-outline-primary btn-block">
                            <i class="fas fa-edit me-1"></i> Edit Transaction
                        </a>
                        @can('delete', $savingsTransaction)
                        <form action="{{ route('savings-transactions.destroy', $savingsTransaction) }}" 
                              method="POST" class="d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-block"
                                    onclick="return confirm('Are you sure you want to delete this transaction? This action cannot be undone.')">
                                <i class="fas fa-trash me-1"></i> Delete Transaction
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>

            <!-- Transaction Timeline -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Transaction Timeline</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Transaction Created</h6>
                                <p class="text-muted mb-0">{{ $savingsTransaction->created_at->format('M d, Y g:i A') }}</p>
                                <small>By: {{ $savingsTransaction->creator->name }}</small>
                            </div>
                        </div>
                        @if($savingsTransaction->updated_at != $savingsTransaction->created_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Last Updated</h6>
                                <p class="text-muted mb-0">{{ $savingsTransaction->updated_at->format('M d, Y g:i A') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 20px;
}
.timeline-item {
    position: relative;
    margin-bottom: 20px;
}
.timeline-marker {
    position: absolute;
    left: -20px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
}
.timeline-content {
    padding-bottom: 10px;
}
.badge-lg {
    font-size: 0.9em;
    padding: 0.5em 0.8em;
}
</style>
@endsection