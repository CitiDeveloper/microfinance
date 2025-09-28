@extends('layouts.app')

@section('title', 'Edit Loan')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Edit Loan #{{ $loan->id }}</h3>
                    <a href="{{ route('loans.index') }}" class="btn btn-light btn-sm">Back to Loans</a>
                </div>

                <form action="{{ route('loans.update', $loan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        <!-- Basic Information -->
                        <h5 class="text-primary">Basic Information</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="loan_product_id" class="form-label">Loan Product *</label>
                                <select name="loan_product_id" id="loan_product_id" 
                                        class="form-control @error('loan_product_id') is-invalid @enderror" required>
                                    <option value="">-- Select Loan Product --</option>
                                    @foreach($loanProducts as $product)
                                        <option value="{{ $product->id }}" 
                                            {{ old('loan_product_id', $loan->loan_product_id) == $product->id ? 'selected' : '' }}>
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
                                        class="form-control @error('borrower_id') is-invalid @enderror readonly" required readonly>
                                    <option value="">-- Select Borrower --</option>
                                    @foreach($borrowers as $borrower)
                                        <option value="{{ $borrower->id }}" 
                                            {{ old('borrower_id', $loan->borrower_id) == $borrower->id ? 'selected' : '' }}>
                                            {{ $borrower->full_name }}
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
                                <label for="loan_application_id" class="form-label">Application ID *</label>
                                <input type="text" name="loan_application_id" id="loan_application_id"
                                       class="form-control @error('loan_application_id') is-invalid @enderror"
                                       value="{{ old('loan_application_id', $loan->loan_application_id) }}" readonly required>
                                @error('loan_application_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="branch_id" class="form-label">Branch *</label>
                                <select name="branch_id" id="branch_id" 
                                        class="form-control @error('branch_id') is-invalid @enderror" required>
                                    <option value="">-- Select Branch --</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" 
                                            {{ old('branch_id', $loan->branch_id) == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('branch_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Principal & Disbursement Information -->
                        <h5 class="text-primary mt-4">Principal & Disbursement</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="loan_principal_amount" class="form-label">Principal Amount *</label>
                                <input type="number" step="0.01" name="loan_principal_amount" id="loan_principal_amount"
                                       class="form-control @error('loan_principal_amount') is-invalid @enderror"
                                       value="{{ old('loan_principal_amount', $loan->loan_principal_amount) }}" required>
                                @error('loan_principal_amount')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="loan_disbursed_by_id" class="form-label">Disbursement Method *</label>
                                <select name="loan_disbursed_by_id" id="loan_disbursed_by_id" 
                                        class="form-control @error('loan_disbursed_by_id') is-invalid @enderror" required>
                                    <option value="">-- Select Method --</option>
                                    @foreach($disbursementMethods as $method)
                                        <option value="{{ $method->id }}" 
                                            {{ old('loan_disbursed_by_id', $loan->loan_disbursed_by_id) == $method->id ? 'selected' : '' }}>
                                            {{ $method->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('loan_disbursed_by_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="loan_released_date" class="form-label">Release Date *</label>
                                <input type="date" name="loan_released_date" id="loan_released_date"
                                       class="form-control @error('loan_released_date') is-invalid @enderror"
                                       value="{{ old('loan_released_date', $loan->loan_released_date ? $loan->loan_released_date->format('Y-m-d') : '') }}" required>
                                @error('loan_released_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="staff_id" class="form-label">Staff *</label>
                                <select name="staff_id" id="staff_id" 
                                        class="form-control @error('staff_id') is-invalid @enderror" required>
                                    <option value="">-- Select Staff --</option>
                                    @foreach($staff as $member)
                                        <option value="{{ $member->id }}" 
                                            {{ old('staff_id', $loan->staff_id) == $member->id ? 'selected' : '' }}>
                                            {{ $member->name }}
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
                            <div class="col-md-4 mb-3">
                                <label for="loan_interest_method" class="form-label">Interest Method *</label>
                                <select name="loan_interest_method" id="loan_interest_method" 
                                        class="form-control @error('loan_interest_method') is-invalid @enderror" required>
                                    <option value="">-- Select Method --</option>
                                    @foreach(['flat_rate','reducing_rate_equal_installments','reducing_rate_equal_principal','interest_only','compound_interest_new','compound_interest'] as $method)
                                        <option value="{{ $method }}" 
                                            {{ old('loan_interest_method', $loan->loan_interest_method) == $method ? 'selected' : '' }}>
                                            {{ ucwords(str_replace('_',' ', $method)) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('loan_interest_method')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Interest Type *</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="loan_interest_type" 
                                           id="interest_type_percentage" value="percentage" 
                                           {{ old('loan_interest_type', $loan->loan_interest_type) == 'percentage' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="interest_type_percentage">Percentage %</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="loan_interest_type" 
                                           id="interest_type_fixed" value="fixed" 
                                           {{ old('loan_interest_type', $loan->loan_interest_type) == 'fixed' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="interest_type_fixed">Fixed Amount</label>
                                </div>
                                @error('loan_interest_type')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="loan_interest" class="form-label">Interest Rate/Amount *</label>
                                <input type="number" step="0.01" name="loan_interest" id="loan_interest"
                                       class="form-control @error('loan_interest') is-invalid @enderror"
                                       value="{{ old('loan_interest', $loan->loan_interest) }}" required>
                                @error('loan_interest')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="loan_interest_period" class="form-label">Interest Period *</label>
                                <select name="loan_interest_period" id="loan_interest_period" 
                                        class="form-control @error('loan_interest_period') is-invalid @enderror" required>
                                    <option value="">-- Select Period --</option>
                                    @foreach(['Day','Week','Month','Year','Loan'] as $period)
                                        <option value="{{ $period }}" 
                                            {{ old('loan_interest_period', $loan->loan_interest_period) == $period ? 'selected' : '' }}>
                                            {{ $period }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('loan_interest_period')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Duration Information -->
                        <h5 class="text-primary mt-4">Duration Information</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="loan_duration" class="form-label">Loan Duration *</label>
                                <input type="number" name="loan_duration" id="loan_duration"
                                       class="form-control @error('loan_duration') is-invalid @enderror"
                                       value="{{ old('loan_duration', $loan->loan_duration) }}" required>
                                @error('loan_duration')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="loan_duration_period" class="form-label">Duration Period *</label>
                                <select name="loan_duration_period" id="loan_duration_period" 
                                        class="form-control @error('loan_duration_period') is-invalid @enderror" required>
                                    <option value="">-- Select Period --</option>
                                    @foreach(['Days','Weeks','Months','Years'] as $period)
                                        <option value="{{ $period }}" 
                                            {{ old('loan_duration_period', $loan->loan_duration_period) == $period ? 'selected' : '' }}>
                                            {{ $period }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('loan_duration_period')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Repayment Information -->
                        <h5 class="text-primary mt-4">Repayment Information</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="loan_payment_scheme_id" class="form-label">Repayment Cycle *</label>
                                <select name="loan_payment_scheme_id" id="loan_payment_scheme_id" 
                                        class="form-control @error('loan_payment_scheme_id') is-invalid @enderror" required>
                                    <option value="">-- Select Cycle --</option>
                                    @foreach($repaymentCycles as $cycle)
                                        <option value="{{ $cycle->id }}" 
                                            {{ old('loan_payment_scheme_id', $loan->loan_payment_scheme_id) == $cycle->id ? 'selected' : '' }}>
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
                                       value="{{ old('loan_num_of_repayments', $loan->loan_num_of_repayments) }}" required>
                                @error('loan_num_of_repayments')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Status & Bank Information -->
                        <h5 class="text-primary mt-4">Status & Banking</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="loan_status_id" class="form-label">Loan Status *</label>
                                <select name="loan_status_id" id="loan_status_id" 
                                        class="form-control @error('loan_status_id') is-invalid @enderror" required>
                                    <option value="">-- Select Status --</option>
                                    @foreach($loanStatuses as $status)
                                        <option value="{{ $status->id }}" 
                                            {{ old('loan_status_id', $loan->loan_status_id) == $status->id ? 'selected' : '' }}>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('loan_status_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="dea_cash_bank_account" class="form-label">Cash Bank Account *</label>
                                <select name="dea_cash_bank_account" id="dea_cash_bank_account" 
                                        class="form-control @error('dea_cash_bank_account') is-invalid @enderror" required>
                                    <option value="">-- Select Account --</option>
                                    @foreach($bankAccounts as $account)
                                        <option value="{{ $account->id }}" 
                                            {{ old('dea_cash_bank_account', $loan->dea_cash_bank_account) == $account->id ? 'selected' : '' }}>
                                            {{ $account->coa_name }} - {{ $account->coa_code }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('dea_cash_bank_account')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Guarantors -->
                        <div class="mb-3">
                            <label for="guarantors" class="form-label">Guarantors</label>
                            <select name="guarantors[]" id="guarantors" 
                                    class="form-control @error('guarantors') is-invalid @enderror" multiple>
                                @foreach($guarantors as $guarantor)
                                    <option value="{{ $guarantor->id }}"
                                        {{ in_array($guarantor->id, old('guarantors', $loan->guarantors->pluck('id')->toArray())) ? 'selected' : '' }}>
                                        {{ $guarantor->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('guarantors')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-success">Update Loan</button>
                        <a href="{{ route('loans.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection