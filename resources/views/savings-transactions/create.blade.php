@extends('layouts.app')

@section('title', 'Create Savings Transaction')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create Savings Transaction</h1>
        <a href="{{ route('savings-transactions.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Transactions
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Transaction Details</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('savings-transactions.store') }}" method="POST" id="transactionForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="saving_id">Savings Account *</label>
                                    <select class="form-control select2 @error('saving_id') is-invalid @enderror" 
                                            id="saving_id" name="saving_id" required>
                                        <option value="">Select Account</option>
                                        @foreach($savingsAccounts as $account)
                                            <option value="{{ $account->id }}" 
                                                    {{ old('saving_id') == $account->id ? 'selected' : '' }}
                                                    data-balance="{{ $account->balance }}"
                                                    data-product="{{ $account->savingsProduct->name }}"
                                                    data-allow-withdrawals="{{ $account->savingsProduct->allow_withdrawals }}">
                                                {{ $account->account_number }} - {{ $account->borrower->full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('saving_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Transaction Type *</label>
                                    <select class="form-control @error('type') is-invalid @enderror" 
                                            id="type" name="type" required>
                                        <option value="">Select Type</option>
                                        <option value="deposit" {{ old('type') == 'deposit' ? 'selected' : '' }}>Deposit</option>
                                        <option value="withdrawal" {{ old('type') == 'withdrawal' ? 'selected' : '' }}>Withdrawal</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amount">Amount *</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                               id="amount" name="amount" step="0.01" min="0.01" 
                                               value="{{ old('amount') }}" placeholder="0.00" required>
                                    </div>
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted" id="balanceInfo">
                                        Current balance: $0.00
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="transaction_date">Transaction Date *</label>
                                    <input type="date" class="form-control @error('transaction_date') is-invalid @enderror" 
                                           id="transaction_date" name="transaction_date" 
                                           value="{{ old('transaction_date', date('Y-m-d')) }}" required>
                                    @error('transaction_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="branch_id">Branch *</label>
                                    <select class="form-control @error('branch_id') is-invalid @enderror" 
                                            id="branch_id" name="branch_id" required>
                                        <option value="">Select Branch</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}" 
                                                    {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
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
                            <label for="notes">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3" 
                                      placeholder="Optional notes about this transaction">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Account Information Display -->
                        <div class="alert alert-info" id="accountInfo" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Product:</strong> <span id="productName">-</span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Current Balance:</strong> $<span id="currentBalance">0.00</span>
                                </div>
                            </div>
                            <div class="mt-2" id="withdrawalWarning" style="display: none;">
                                <i class="fas fa-exclamation-triangle text-warning"></i>
                                <small>Withdrawals are not allowed for this savings product.</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fas fa-check-circle me-1"></i> Process Transaction
                            </button>
                            <a href="{{ route('savings-transactions.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Help Card -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Transaction Guide</h6>
                </div>
                <div class="card-body">
                    <h6>Deposit Transactions</h6>
                    <p class="small">Add funds to a savings account. Increases the account balance.</p>
                    
                    <h6>Withdrawal Transactions</h6>
                    <p class="small">Remove funds from a savings account. Decreases the account balance.</p>
                    <div class="alert alert-warning small">
                        <i class="fas fa-exclamation-triangle"></i>
                        Withdrawals are only allowed if the savings product permits them and sufficient balance exists.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({
            placeholder: 'Select Savings Account',
            allowClear: true
        });

        // Update account information when account is selected
        $('#saving_id').change(function() {
            const selectedOption = $(this).find('option:selected');
            const balance = selectedOption.data('balance') || 0;
            const product = selectedOption.data('product') || '-';
            const allowWithdrawals = selectedOption.data('allow-withdrawals');
            
            $('#currentBalance').text(parseFloat(balance).toFixed(2));
            $('#productName').text(product);
            $('#balanceInfo').text('Current balance: $' + parseFloat(balance).toFixed(2));
            
            // Show/hide account info
            if (selectedOption.val()) {
                $('#accountInfo').show();
                $('#withdrawalWarning').toggle(!allowWithdrawals && $('#type').val() === 'withdrawal');
            } else {
                $('#accountInfo').hide();
            }
            
            validateForm();
        });

        // Update withdrawal warning when type changes
        $('#type').change(function() {
            const selectedAccount = $('#saving_id').find('option:selected');
            const allowWithdrawals = selectedAccount.data('allow-withdrawals');
            
            $('#withdrawalWarning').toggle(!allowWithdrawals && $(this).val() === 'withdrawal');
            validateForm();
        });

        // Form validation
        function validateForm() {
            const account = $('#saving_id').val();
            const type = $('#type').val();
            const amount = parseFloat($('#amount').val()) || 0;
            const balance = parseFloat($('#currentBalance').text()) || 0;
            const allowWithdrawals = $('#saving_id').find('option:selected').data('allow-withdrawals');
            
            let isValid = account && type && amount > 0;
            
            if (type === 'withdrawal') {
                if (!allowWithdrawals) {
                    isValid = false;
                }
                if (amount > balance) {
                    isValid = false;
                    $('#balanceInfo').addClass('text-danger');
                } else {
                    $('#balanceInfo').removeClass('text-danger');
                }
            }
            
            $('#submitBtn').prop('disabled', !isValid);
        }

        $('#amount, #saving_id, #type').on('input change', validateForm);
    });
</script>
@endsection