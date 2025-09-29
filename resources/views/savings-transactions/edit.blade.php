@extends('layouts.app')

@section('title', 'Edit Savings Transaction')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Transaction</h1>
        <a href="{{ route('savings-transactions.show', $savingsTransaction) }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Details
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Transaction Details</h6>
                    <span class="badge badge-{{ $savingsTransaction->type == 'deposit' ? 'success' : 'warning' }}">
                        {{ strtoupper($savingsTransaction->type) }}
                    </span>
                </div>
                <div class="card-body">
                    <form action="{{ route('savings-transactions.update', $savingsTransaction) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Display-only fields -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Reference Number</label>
                                    <input type="text" class="form-control bg-light" value="{{ $savingsTransaction->transaction_reference }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Transaction Type</label>
                                    <input type="text" class="form-control bg-light" value="{{ ucfirst($savingsTransaction->type) }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Account Number</label>
                                    <input type="text" class="form-control bg-light" value="{{ $savingsTransaction->account->account_number }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Borrower</label>
                                    <input type="text" class="form-control bg-light" value="{{ $savingsTransaction->account->borrower->full_name }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Amount</label>
                                    <input type="text" class="form-control bg-light" value="{{ number_format($savingsTransaction->amount, 2) }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Balance Before</label>
                                    <input type="text" class="form-control bg-light" value="{{ number_format($savingsTransaction->balance_before, 2) }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Balance After</label>
                                    <input type="text" class="form-control bg-light" value="{{ number_format($savingsTransaction->balance_after, 2) }}" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Editable fields -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="transaction_date" class="form-label">Transaction Date *</label>
                                    <input type="date" class="form-control @error('transaction_date') is-invalid @enderror" 
                                           id="transaction_date" name="transaction_date" 
                                           value="{{ old('transaction_date', $savingsTransaction->transaction_date->format('Y-m-d')) }}" required>
                                    @error('transaction_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="branch_id" class="form-label">Branch *</label>
                                    <select class="form-control @error('branch_id') is-invalid @enderror" 
                                            id="branch_id" name="branch_id" required>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}" 
                                                    {{ old('branch_id', $savingsTransaction->branch_id) == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('branch_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="4">{{ old('notes', $savingsTransaction->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Transaction
                            </button>
                            <a href="{{ route('savings-transactions.show', $savingsTransaction) }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Information Card -->
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Update Information</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle me-2"></i>Important</h6>
                        <p class="small mb-0">
                            You can only update the transaction date, branch, and notes. 
                            The transaction amount and type cannot be modified for accounting integrity.
                        </p>
                    </div>
                    
                    <div class="mt-3">
                        <h6>Transaction Details</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td><strong>Reference:</strong></td>
                                <td>{{ $savingsTransaction->transaction_reference }}</td>
                            </tr>
                            <tr>
                                <td><strong>Receipt No:</strong></td>
                                <td>{{ $savingsTransaction->receipt_number ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Created By:</strong></td>
                                <td>{{ $savingsTransaction->creator->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Created On:</strong></td>
                                <td>{{ $savingsTransaction->created_at->format('M d, Y g:i A') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection