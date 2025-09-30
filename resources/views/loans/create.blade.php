@extends('layouts.app')

@section('title', 'Create New Loan')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Create New Loan</h3>
                        <a href="{{ route('loans.index') }}" class="btn btn-light btn-sm">Back to Loans</a>
                    </div>
                    <form action="{{ route('loans.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <!-- Loan & Borrower Information -->
                            <h5 class="text-primary">Basic Information</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="loan_product_id" class="form-label">Loan Product *</label>
                                    <select name="loan_product_id" id="loan_product_id"
                                        class="form-control @error('loan_product_id') is-invalid @enderror" required
                                        onchange="updateLoanProductDefaults()">
                                        <option value="">-- Select Loan Product --</option>
                                        @foreach ($loanProducts as $product)
                                            <option value="{{ $product->id }}"
                                                {{ old('loan_product_id') == $product->id ? 'selected' : '' }}
                                                data-defaults="{{ json_encode([
                                                    'default_loan_principal_amount' => $product->default_loan_principal_amount,
                                                    'loan_interest_method' => $product->loan_interest_method,
                                                    'loan_interest_type' => $product->loan_interest_type,
                                                    'default_loan_interest' => $product->default_loan_interest,
                                                    'loan_interest_period' => $product->loan_interest_period,
                                                    'loan_duration_period' => $product->loan_duration_period,
                                                    'default_loan_duration' => $product->default_loan_duration,
                                                    'loan_payment_scheme_id' => $product->loan_payment_scheme_id,
                                                    'default_loan_num_of_repayments' => $product->default_loan_num_of_repayments,
                                                    'dea_cash_bank_account' => $product->dea_cash_bank_account,
                                                    'loan_disbursed_by_id' => $product->loan_disbursed_by_id,
                                                ]) }}">
                                                {{ $product->loan_product_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('loan_product_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="borrower_id" class="form-label">Borrower *</label>
                                    <select name="borrower_id" id="borrower_id"
                                        class="form-control select2 @error('borrower_id') is-invalid @enderror" required>
                                        <option value="">-- Select Borrower --</option>
                                        @foreach ($borrowers as $borrower)
                                            <option value="{{ $borrower->id }}"
                                                {{ old('borrower_id') == $borrower->id ? 'selected' : '' }}>
                                                {{ $borrower->full_name }} - {{ $borrower->member_id }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('borrower_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
    <label for="loan_application_id" class="form-label">Application ID</label>
    <input type="text" name="loan_application_id" id="loan_application_id"
        class="form-control @error('loan_application_id') is-invalid @enderror"
        value="{{ old('loan_application_id', \App\Models\SystemSetting::getSettings()->generateLoanId()) }}">
    <small class="text-muted">Leave as is to auto-generate, or override if needed.</small>
    @error('loan_application_id')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

                                <div class="col-md-6 mb-3">
                                    <label for="branch_id" class="form-label">Branch *</label>
                                    <select name="branch_id" id="branch_id"
                                        class="form-control @error('branch_id') is-invalid @enderror" required>
                                        <option value="">-- Select Branch --</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}"
                                                {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->branch_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('branch_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Principal Information -->
                            <h5 class="text-primary mt-4">Principal Information</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="loan_disbursed_by_id" class="form-label">Disbursed By *</label>
                                    <select name="loan_disbursed_by_id" id="loan_disbursed_by_id"
                                        class="form-control @error('loan_disbursed_by_id') is-invalid @enderror" required>
                                        <option value="">-- Select Method --</option>
                                        @foreach ($disbursementMethods as $method)
                                            <option value="{{ $method->id }}"
                                                {{ old('loan_disbursed_by_id') == $method->id ? 'selected' : '' }}>
                                                {{ $method->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('loan_disbursed_by_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="loan_principal_amount" class="form-label">Principal Amount *</label>
                                    <input type="number" step="0.01" name="loan_principal_amount"
                                        id="loan_principal_amount"
                                        class="form-control @error('loan_principal_amount') is-invalid @enderror"
                                        value="{{ old('loan_principal_amount') }}" required>
                                    @error('loan_principal_amount')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="loan_released_date" class="form-label">Release Date *</label>
                                    <input type="date" name="loan_released_date" id="loan_released_date"
                                        class="form-control @error('loan_released_date') is-invalid @enderror"
                                        value="{{ old('loan_released_date', date('Y-m-d')) }}" required>
                                    @error('loan_released_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="staff_id" class="form-label">Loan Officer *</label>
                                    <select name="staff_id" id="staff_id"
                                        class="form-control @error('staff_id') is-invalid @enderror" required>
                                        <option value="">-- Select Officer --</option>
                                        @foreach ($staff as $officer)
                                            <option value="{{ $officer->id }}"
                                                {{ old('staff_id') == $officer->id ? 'selected' : '' }}>
                                                {{ $officer->full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('staff_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Interest Information -->
                            <h5 class="text-primary mt-4">Interest Information</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="loan_interest_method" class="form-label">Interest Method *</label>
                                    <select name="loan_interest_method" id="loan_interest_method"
                                        class="form-control @error('loan_interest_method') is-invalid @enderror" required>
                                        <option value="">-- Select Method --</option>
                                        <option value="flat_rate"
                                            {{ old('loan_interest_method') == 'flat_rate' ? 'selected' : '' }}>Flat Rate</option>
                                        <option value="reducing_rate_equal_installments"
                                            {{ old('loan_interest_method') == 'reducing_rate_equal_installments' ? 'selected' : '' }}>
                                            Reducing Balance - Equal Installments</option>
                                        <option value="reducing_rate_equal_principal"
                                            {{ old('loan_interest_method') == 'reducing_rate_equal_principal' ? 'selected' : '' }}>
                                            Reducing Balance - Equal Principal</option>
                                        <option value="interest_only"
                                            {{ old('loan_interest_method') == 'interest_only' ? 'selected' : '' }}>Interest-Only
                                        </option>
                                        <option value="compound_interest_new"
                                            {{ old('loan_interest_method') == 'compound_interest_new' ? 'selected' : '' }}>
                                            Compound Interest - Accrued</option>
                                        <option value="compound_interest"
                                            {{ old('loan_interest_method') == 'compound_interest' ? 'selected' : '' }}>Compound
                                            Interest - Equal Installments</option>
                                    </select>
                                    @error('loan_interest_method')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Interest Type *</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="loan_interest_type"
                                            id="interest_type_percentage" value="percentage"
                                            {{ old('loan_interest_type', 'percentage') == 'percentage' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="interest_type_percentage">Percentage
                                            %</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="loan_interest_type"
                                            id="interest_type_fixed" value="fixed"
                                            {{ old('loan_interest_type') == 'fixed' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="interest_type_fixed">Fixed Per Cycle</label>
                                    </div>
                                    @error('loan_interest_type')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="loan_interest" class="form-label">Loan Interest *</label>
                                    <input type="number" step="0.0001" name="loan_interest" id="loan_interest"
                                        class="form-control @error('loan_interest') is-invalid @enderror"
                                        value="{{ old('loan_interest') }}" required>
                                    @error('loan_interest')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="loan_interest_period" class="form-label">Interest Period *</label>
                                    <select name="loan_interest_period" id="loan_interest_period"
                                        class="form-control @error('loan_interest_period') is-invalid @enderror" required>
                                        <option value="">-- Select Period --</option>
                                        <option value="Day" {{ old('loan_interest_period') == 'Day' ? 'selected' : '' }}>Per
                                            Day</option>
                                        <option value="Week" {{ old('loan_interest_period') == 'Week' ? 'selected' : '' }}>Per
                                            Week</option>
                                        <option value="Month" {{ old('loan_interest_period') == 'Month' ? 'selected' : '' }}>
                                            Per Month</option>
                                        <option value="Year" {{ old('loan_interest_period') == 'Year' ? 'selected' : '' }}>Per
                                            Year</option>
                                        <option value="Loan" {{ old('loan_interest_period') == 'Loan' ? 'selected' : '' }}>Per
                                            Loan</option>
                                    </select>
                                    @error('loan_interest_period')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Duration -->
                            <h5 class="text-primary mt-4">Duration Information</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="loan_duration" class="form-label">Loan Duration *</label>
                                    <input type="number" name="loan_duration" id="loan_duration"
                                        class="form-control @error('loan_duration') is-invalid @enderror"
                                        value="{{ old('loan_duration', 1) }}" min="1" required>
                                    @error('loan_duration')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="loan_duration_period" class="form-label">Duration Period *</label>
                                    <select name="loan_duration_period" id="loan_duration_period"
                                        class="form-control @error('loan_duration_period') is-invalid @enderror" required>
                                        <option value="">-- Select Period --</option>
                                        <option value="Days" {{ old('loan_duration_period') == 'Days' ? 'selected' : '' }}>
                                            Days</option>
                                        <option value="Weeks" {{ old('loan_duration_period') == 'Weeks' ? 'selected' : '' }}>
                                            Weeks</option>
                                        <option value="Months" {{ old('loan_duration_period') == 'Months' ? 'selected' : '' }}>
                                            Months</option>
                                        <option value="Years" {{ old('loan_duration_period') == 'Years' ? 'selected' : '' }}>
                                            Years</option>
                                    </select>
                                    @error('loan_duration_period')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="grace_period_repayments">Grace Period (Installments)</label>
                                        <input type="number" name="grace_period_repayments" id="grace_period_repayments"
                                            class="form-control"
                                            value="{{ old('grace_period_repayments', 0) }}"
                                            min="0">
                                        <small class="text-muted">Number of installments where only interest is
                                            paid</small>
                                    </div>
                                </div>

                            </div>

                            <!-- Repayment -->
                            <h5 class="text-primary mt-4">Repayment Information</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="loan_payment_scheme_id" class="form-label">Repayment Cycle *</label>
                                    <select name="loan_payment_scheme_id" id="loan_payment_scheme_id"
                                        class="form-control @error('loan_payment_scheme_id') is-invalid @enderror"
                                        required>
                                        <option value="">-- Select Cycle --</option>
                                        @foreach ($repaymentCycles as $cycle)
                                            <option value="{{ $cycle->id }}"
                                                {{ old('loan_payment_scheme_id') == $cycle->id ? 'selected' : '' }}>
                                                {{ $cycle->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('loan_payment_scheme_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="loan_num_of_repayments" class="form-label">Number of Repayments *</label>
                                    <input type="number" name="loan_num_of_repayments" id="loan_num_of_repayments"
                                        class="form-control @error('loan_num_of_repayments') is-invalid @enderror"
                                        value="{{ old('loan_num_of_repayments') }}" min="1" required>
                                    @error('loan_num_of_repayments')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="loan_first_repayment_date" class="form-label">First Repayment Date
                                        *</label>
                                    <input type="date" name="loan_first_repayment_date" id="loan_first_repayment_date"
                                        class="form-control @error('loan_first_repayment_date') is-invalid @enderror"
                                        value="{{ old('loan_first_repayment_date') }}" required>
                                    @error('loan_first_repayment_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="loan_status_id" class="form-label">Loan Status *</label>
                                    <select name="loan_status_id" id="loan_status_id"
                                        class="form-control @error('loan_status_id') is-invalid @enderror" required>
                                        <option value="">-- Select Status --</option>
                                        @foreach ($loanStatuses as $status)
                                            <option value="{{ $status->id }}"
                                                {{ old('loan_status_id') == $status->id ? 'selected' : '' }}>
                                                {{ $status->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('loan_status_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Bank Information -->
                            <h5 class="text-primary mt-4">Bank & Account Information</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="dea_cash_bank_account" class="form-label">Cash Bank Account *</label>
                                    <select name="dea_cash_bank_account" id="dea_cash_bank_account"
                                        class="form-control @error('dea_cash_bank_account') is-invalid @enderror"
                                        required>
                                        <option value="">-- Select Account --</option>
                                        @foreach ($bankAccounts as $account)
                                            <option value="{{ $account->id }}"
                                                {{ old('dea_cash_bank_account') == $account->id ? 'selected' : '' }}>
                                                {{ $account->coa_name }} - {{ $account->coa_code }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('dea_cash_bank_account')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-success">Create Loan</button>
                            <a href="{{ route('loans.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
function updateLoanProductDefaults() {
    const loanProductSelect = document.getElementById('loan_product_id');
    const selectedOption = loanProductSelect.options[loanProductSelect.selectedIndex];
    
    if (selectedOption.value && selectedOption.dataset.defaults) {
        const defaults = JSON.parse(selectedOption.dataset.defaults);
        
        // Update Principal Amount
        if (defaults.default_loan_principal_amount) {
            document.getElementById('loan_principal_amount').value = defaults.default_loan_principal_amount;
        }
        
        // Update Interest Method
        if (defaults.loan_interest_method) {
            document.getElementById('loan_interest_method').value = defaults.loan_interest_method;
        }
        
        // Update Interest Type (radio buttons)
        if (defaults.loan_interest_type) {
            if (defaults.loan_interest_type === 'percentage') {
                document.getElementById('interest_type_percentage').checked = true;
            } else if (defaults.loan_interest_type === 'fixed') {
                document.getElementById('interest_type_fixed').checked = true;
            }
        }
        
        // Update Loan Interest
        if (defaults.default_loan_interest) {
            document.getElementById('loan_interest').value = defaults.default_loan_interest;
        }
        
        // Update Interest Period
        if (defaults.loan_interest_period) {
            document.getElementById('loan_interest_period').value = defaults.loan_interest_period;
        }
        
        // Update Duration Period
        if (defaults.loan_duration_period) {
            document.getElementById('loan_duration_period').value = defaults.loan_duration_period;
        }
        
        // Update Loan Duration
        if (defaults.default_loan_duration) {
            document.getElementById('loan_duration').value = defaults.default_loan_duration;
        }
        
        // Update Repayment Cycle
        if (defaults.loan_payment_scheme_id) {
            // Handle array case (multiple payment schemes)
            const paymentSchemeId = Array.isArray(defaults.loan_payment_scheme_id) 
                ? defaults.loan_payment_scheme_id[0] 
                : defaults.loan_payment_scheme_id;
            document.getElementById('loan_payment_scheme_id').value = paymentSchemeId;
        }
        
        // Update Number of Repayments
        if (defaults.default_loan_num_of_repayments) {
            document.getElementById('loan_num_of_repayments').value = defaults.default_loan_num_of_repayments;
        }
        
        // Update Bank Account
        if (defaults.dea_cash_bank_account) {
            // Handle array case
            const bankAccountId = Array.isArray(defaults.dea_cash_bank_account) 
                ? defaults.dea_cash_bank_account[0] 
                : defaults.dea_cash_bank_account;
            document.getElementById('dea_cash_bank_account').value = bankAccountId;
        }
        
        // Update Disbursement Method
        if (defaults.loan_disbursed_by_id) {
            // Handle array case
            const disbursedById = Array.isArray(defaults.loan_disbursed_by_id) 
                ? defaults.loan_disbursed_by_id[0] 
                : defaults.loan_disbursed_by_id;
            document.getElementById('loan_disbursed_by_id').value = disbursedById;
        }
    }
}

// Initialize defaults when page loads if a loan product is already selected
document.addEventListener('DOMContentLoaded', function() {
    const loanProductSelect = document.getElementById('loan_product_id');
    if (loanProductSelect.value) {
        updateLoanProductDefaults();
    }
});
</script>
@endsection

