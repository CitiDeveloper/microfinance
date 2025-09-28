<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-{{ isset($repayment) ? 'warning' : 'primary' }} text-white">
                    <h5 class="mb-0">
                        <i class="fas {{ isset($repayment) ? 'fa-edit' : 'fa-plus' }} me-2"></i>
                        {{ isset($repayment) ? 'Edit Repayment' : 'Create New Repayment' }}
                    </h5>
                </div>

                <div class="card-body">
                    <form method="POST" 
                          action="{{ isset($repayment) ? route('repayments.update', $repayment) : route('repayments.store') }}">
                        @csrf
                        @if(isset($repayment))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <!-- Basic Information -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Basic Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="loan_id" class="form-label">Loan *</label>
                                                <select class="form-select @error('loan_id') is-invalid @enderror" 
                                                        id="loan_id" name="loan_id" required>
                                                    <option value="">Select Loan</option>
                                                    @foreach($loans as $loan)
                                                        <option value="{{ $loan->id }}" 
                                                            {{ old('loan_id', $repayment->loan_id ?? '') == $loan->id ? 'selected' : '' }}>
                                                            {{ $loan->loan_application_id }} - {{ $loan->borrower->full_name ?? 'N/A' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('loan_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="borrower_id" class="form-label">Borrower *</label>
                                                <select class="form-select @error('borrower_id') is-invalid @enderror" 
                                                        id="borrower_id" name="borrower_id" required>
                                                    <option value="">Select Borrower</option>
                                                    @foreach($loans as $loan)
                                                        <option value="{{ $loan->borrower->id }}" 
                                                            {{ old('borrower_id', $repayment->borrower_id ?? '') == $loan->borrower->id ? 'selected' : '' }}>
                                                            {{ $loan->borrower->full_name ?? 'N/A' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('borrower_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="branch_id" class="form-label">Branch *</label>
                                                <select class="form-select @error('branch_id') is-invalid @enderror" 
                                                        id="branch_id" name="branch_id" required>
                                                    <option value="">Select Branch</option>
                                                    @foreach($branches as $branch)
                                                        <option value="{{ $branch->id }}" 
                                                            {{ old('branch_id', $repayment->branch_id ?? '') == $branch->id ? 'selected' : '' }}>
                                                            {{ $branch->branch_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('branch_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="collected_by" class="form-label">Collected By</label>
                                                <select class="form-select @error('collected_by') is-invalid @enderror" 
                                                        id="collected_by" name="collected_by">
                                                    <option value="">Select Staff</option>
                                                    @foreach($staff as $staffMember)
                                                        <option value="{{ $staffMember->id }}" 
                                                            {{ old('collected_by', $repayment->collected_by ?? '') == $staffMember->id ? 'selected' : '' }}>
                                                            {{ $staffMember->full_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('collected_by')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="payment_date" class="form-label">Payment Date *</label>
                                                <input type="date" class="form-control @error('payment_date') is-invalid @enderror" 
                                                       id="payment_date" name="payment_date" 
                                                       value="{{ old('payment_date', $repayment->payment_date->format('Y-m-d') ?? date('Y-m-d')) }}" required>
                                                @error('payment_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="status" class="form-label">Status *</label>
                                                <select class="form-select @error('status') is-invalid @enderror" 
                                                        id="status" name="status" required>
                                                    <option value="pending" {{ old('status', $repayment->status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="posted" {{ old('status', $repayment->status ?? '') == 'posted' ? 'selected' : '' }}>Posted</option>
                                                </select>
                                                @error('status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Details -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-credit-card me-2"></i>Payment Details</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="receipt_number" class="form-label">Receipt Number</label>
                                                <input type="text" class="form-control @error('receipt_number') is-invalid @enderror" 
                                                       id="receipt_number" name="receipt_number" 
                                                       value="{{ old('receipt_number', $repayment->receipt_number ?? '') }}">
                                                @error('receipt_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="transaction_reference" class="form-label">Transaction Reference</label>
                                                <input type="text" class="form-control @error('transaction_reference') is-invalid @enderror" 
                                                       id="transaction_reference" name="transaction_reference" 
                                                       value="{{ old('transaction_reference', $repayment->transaction_reference ?? '') }}">
                                                @error('transaction_reference')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="payment_method_id" class="form-label">Payment Method</label>
                                                <select class="form-select @error('payment_method_id') is-invalid @enderror" 
                                                        id="payment_method_id" name="payment_method_id">
                                                    <option value="">Select Payment Method</option>
                                                    @foreach($paymentMethods as $method)
                                                        <option value="{{ $method->id }}" 
                                                            {{ old('payment_method_id', $repayment->payment_method_id ?? '') == $method->id ? 'selected' : '' }}>
                                                            {{ $method->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('payment_method_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="dea_cash_bank_account" class="form-label">Bank Account</label>
                                                <select class="form-select @error('dea_cash_bank_account') is-invalid @enderror" 
                                                        id="dea_cash_bank_account" name="dea_cash_bank_account">
                                                    <option value="">Select Bank Account</option>
                                                    @foreach($bankAccounts as $account)
                                                        <option value="{{ $account->id }}" 
                                                            {{ old('dea_cash_bank_account', $repayment->dea_cash_bank_account ?? '') == $account->id ? 'selected' : '' }}>
                                                            {{ $account->coa_name }} - {{ $account->coa_code }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('dea_cash_bank_account')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <!-- Amount Breakdown -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Amount Breakdown</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="amount" class="form-label">Total Amount *</label>
                                            <input type="number" step="0.01" min="0.01" 
                                                   class="form-control @error('amount') is-invalid @enderror" 
                                                   id="amount" name="amount" 
                                                   value="{{ old('amount', $repayment->amount ?? '') }}" required>
                                            @error('amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="principal_paid" class="form-label">Principal Paid *</label>
                                                <input type="number" step="0.01" min="0" 
                                                       class="form-control @error('principal_paid') is-invalid @enderror" 
                                                       id="principal_paid" name="principal_paid" 
                                                       value="{{ old('principal_paid', $repayment->principal_paid ?? 0) }}" required>
                                                @error('principal_paid')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="interest_paid" class="form-label">Interest Paid *</label>
                                                <input type="number" step="0.01" min="0" 
                                                       class="form-control @error('interest_paid') is-invalid @enderror" 
                                                       id="interest_paid" name="interest_paid" 
                                                       value="{{ old('interest_paid', $repayment->interest_paid ?? 0) }}" required>
                                                @error('interest_paid')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="fees_paid" class="form-label">Fees Paid</label>
                                                <input type="number" step="0.01" min="0" 
                                                       class="form-control @error('fees_paid') is-invalid @enderror" 
                                                       id="fees_paid" name="fees_paid" 
                                                       value="{{ old('fees_paid', $repayment->fees_paid ?? 0) }}">
                                                @error('fees_paid')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="penalty_paid" class="form-label">Penalty Paid</label>
                                                <input type="number" step="0.01" min="0" 
                                                       class="form-control @error('penalty_paid') is-invalid @enderror" 
                                                       id="penalty_paid" name="penalty_paid" 
                                                       value="{{ old('penalty_paid', $repayment->penalty_paid ?? 0) }}">
                                                @error('penalty_paid')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="waiver_amount" class="form-label">Waiver Amount</label>
                                            <input type="number" step="0.01" min="0" 
                                                   class="form-control @error('waiver_amount') is-invalid @enderror" 
                                                   id="waiver_amount" name="waiver_amount" 
                                                   value="{{ old('waiver_amount', $repayment->waiver_amount ?? 0) }}">
                                            @error('waiver_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="alert alert-info">
                                            <i class="fas fa-calculator me-2"></i>
                                            <strong>Total Allocated:</strong> 
                                            <span id="total-allocated">$0.00</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Information -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Additional Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="notes" class="form-label">Notes</label>
                                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                                      id="notes" name="notes" rows="4">{{ old('notes', $repayment->notes ?? '') }}</textarea>
                                            @error('notes')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-{{ isset($repayment) ? 'warning' : 'primary' }}">
                                        <i class="fas {{ isset($repayment) ? 'fa-save' : 'fa-plus' }} me-1"></i>
                                        {{ isset($repayment) ? 'Update Repayment' : 'Create Repayment' }}
                                    </button>
                                    <a href="{{ route('repayments.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-1"></i>Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const amountFields = ['principal_paid', 'interest_paid', 'fees_paid', 'penalty_paid', 'waiver_amount'];
    
    function calculateTotal() {
        let total = 0;
        
        amountFields.forEach(field => {
            const value = parseFloat(document.getElementById(field).value) || 0;
            if (field === 'waiver_amount') {
                total -= value;
            } else {
                total += value;
            }
        });
        
        document.getElementById('total-allocated').textContent = '$' + total.toFixed(2);
        
        // Auto-fill total amount if empty
        const amountField = document.getElementById('amount');
        if (!amountField.value || amountField.value == '0') {
            amountField.value = total.toFixed(2);
        }
    }
    
    amountFields.forEach(field => {
        document.getElementById(field).addEventListener('input', calculateTotal);
    });
    
    // Initial calculation
    calculateTotal();
    
    // Sync loan and borrower selection
    const loanSelect = document.getElementById('loan_id');
    const borrowerSelect = document.getElementById('borrower_id');
    
    if (loanSelect && borrowerSelect) {
        loanSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                // Extract borrower ID from loan option data attribute or text
                const loanText = selectedOption.text;
                // This would need adjustment based on your data structure
                // For now, it's a simple sync - you might want to use AJAX for proper sync
            }
        });
    }
});
</script>
@endpush