@extends('layouts.app')

@section('title', 'Edit Loan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Edit Loan #{{ $loan->id }}</h3>
                    <a href="{{ route('loans.index') }}" class="btn btn-secondary">Back to Loans</a>
                </div>

                <form action="{{ route('loans.update', $loan->id) }}" method="POST" class="form-horizontal">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        {{-- Loan Product --}}
                        <div class="form-group">
                            <label for="loan_product_id">Loan Product *</label>
                            <select class="form-control @error('loan_product_id') is-invalid @enderror" 
                                    name="loan_product_id" id="loan_product_id" required>
                                <option value="">Select Product</option>
                                @foreach($loanProducts as $product)
                                    <option value="{{ $product->id }}" 
                                        {{ old('loan_product_id', $loan->loan_product_id) == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('loan_product_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Borrower --}}
                        <div class="form-group">
                            <label for="borrower_id">Borrower *</label>
                            <select class="form-control @error('borrower_id') is-invalid @enderror" 
                                    name="borrower_id" id="borrower_id" required>
                                <option value="">Select Borrower</option>
                                @foreach($borrowers as $borrower)
                                    <option value="{{ $borrower->id }}" 
                                        {{ old('borrower_id', $loan->borrower_id) == $borrower->id ? 'selected' : '' }}>
                                        {{ $borrower->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('borrower_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Application ID --}}
                        <div class="form-group">
                            <label for="loan_application_id">Application ID *</label>
                            <input type="text" class="form-control @error('loan_application_id') is-invalid @enderror"
                                   name="loan_application_id" id="loan_application_id" 
                                   value="{{ old('loan_application_id', $loan->loan_application_id) }}" required>
                            @error('loan_application_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Branch & Staff --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="branch_id">Branch *</label>
                                    <select class="form-control @error('branch_id') is-invalid @enderror" 
                                            name="branch_id" id="branch_id" required>
                                        <option value="">Select Branch</option>
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="staff_id">Staff *</label>
                                    <select class="form-control @error('staff_id') is-invalid @enderror" 
                                            name="staff_id" id="staff_id" required>
                                        <option value="">Select Staff</option>
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
                        </div>

                        {{-- Principal, Disbursement & Release Date --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="loan_principal_amount">Principal Amount *</label>
                                    <input type="number" step="0.01"
                                           class="form-control @error('loan_principal_amount') is-invalid @enderror"
                                           name="loan_principal_amount" id="loan_principal_amount"
                                           value="{{ old('loan_principal_amount', $loan->loan_principal_amount) }}" required>
                                    @error('loan_principal_amount')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="loan_disbursed_by_id">Disbursement Method *</label>
                                    <select class="form-control @error('loan_disbursed_by_id') is-invalid @enderror" 
                                            name="loan_disbursed_by_id" id="loan_disbursed_by_id" required>
                                        <option value="">Select Method</option>
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
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="loan_released_date">Release Date *</label>
                                    <input type="date" class="form-control @error('loan_released_date') is-invalid @enderror"
                                           name="loan_released_date" id="loan_released_date"
                                           value="{{ old('loan_released_date', $loan->loan_released_date ? $loan->loan_released_date->format('Y-m-d') : '') }}" required>
                                    @error('loan_released_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Interest --}}
                        <h5 class="text-danger mt-4">Interest Information</h5>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="loan_interest_method">Method *</label>
                                <select name="loan_interest_method" id="loan_interest_method" 
                                        class="form-control @error('loan_interest_method') is-invalid @enderror" required>
                                    @foreach(['flat_rate','reducing_rate_equal_installments','reducing_rate_equal_principal','interest_only','compound_interest_new','compound_interest'] as $method)
                                        <option value="{{ $method }}" 
                                            {{ old('loan_interest_method', $loan->loan_interest_method) == $method ? 'selected' : '' }}>
                                            {{ ucwords(str_replace('_',' ', $method)) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('loan_interest_method')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-3">
                                <label for="loan_interest_type">Type *</label>
                                <select name="loan_interest_type" id="loan_interest_type" 
                                        class="form-control @error('loan_interest_type') is-invalid @enderror" required>
                                    @foreach(['percentage','fixed'] as $type)
                                        <option value="{{ $type }}" 
                                            {{ old('loan_interest_type', $loan->loan_interest_type) == $type ? 'selected' : '' }}>
                                            {{ ucfirst($type) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('loan_interest_type')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-3">
                                <label for="loan_interest">Rate *</label>
                                <input type="number" step="0.01" 
                                       class="form-control @error('loan_interest') is-invalid @enderror"
                                       name="loan_interest" id="loan_interest"
                                       value="{{ old('loan_interest', $loan->loan_interest) }}" required>
                                @error('loan_interest')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-3">
                                <label for="loan_interest_period">Period *</label>
                                <select name="loan_interest_period" id="loan_interest_period" 
                                        class="form-control @error('loan_interest_period') is-invalid @enderror" required>
                                    @foreach(['Day','Week','Month','Year','Loan'] as $period)
                                        <option value="{{ $period }}" 
                                            {{ old('loan_interest_period', $loan->loan_interest_period) == $period ? 'selected' : '' }}>
                                            {{ $period }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('loan_interest_period')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- Duration --}}
                        <h5 class="text-danger mt-4">Duration</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="loan_duration">Loan Duration *</label>
                                <input type="number" name="loan_duration" id="loan_duration"
                                       class="form-control @error('loan_duration') is-invalid @enderror"
                                       value="{{ old('loan_duration', $loan->loan_duration) }}" required>
                                @error('loan_duration')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="loan_duration_period">Period *</label>
                                <select name="loan_duration_period" id="loan_duration_period" 
                                        class="form-control @error('loan_duration_period') is-invalid @enderror" required>
                                    @foreach(['Days','Weeks','Months','Years'] as $period)
                                        <option value="{{ $period }}" 
                                            {{ old('loan_duration_period', $loan->loan_duration_period) == $period ? 'selected' : '' }}>
                                            {{ $period }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('loan_duration_period')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- Repayment --}}
                        <h5 class="text-danger mt-4">Repayment Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="loan_payment_scheme_id">Repayment Cycle *</label>
                                <select class="form-control @error('loan_payment_scheme_id') is-invalid @enderror"
                                        name="loan_payment_scheme_id" id="loan_payment_scheme_id" required>
                                    <option value="">Select Cycle</option>
                                    @foreach($repaymentCycles as $cycle)
                                        <option value="{{ $cycle->id }}" 
                                            {{ old('loan_payment_scheme_id', $loan->loan_payment_scheme_id) == $cycle->id ? 'selected' : '' }}>
                                            {{ $cycle->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('loan_payment_scheme_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="loan_num_of_repayments">Number of Repayments *</label>
                                <input type="number" class="form-control @error('loan_num_of_repayments') is-invalid @enderror"
                                       name="loan_num_of_repayments" id="loan_num_of_repayments"
                                       value="{{ old('loan_num_of_repayments', $loan->loan_num_of_repayments) }}" required>
                                @error('loan_num_of_repayments')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- Status & Bank Account --}}
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label for="loan_status_id">Loan Status *</label>
                                <select class="form-control @error('loan_status_id') is-invalid @enderror"
                                        name="loan_status_id" id="loan_status_id" required>
                                    <option value="">Select Status</option>
                                    @foreach($loanStatuses as $status)
                                        <option value="{{ $status->id }}" 
                                            {{ old('loan_status_id', $loan->loan_status_id) == $status->id ? 'selected' : '' }}>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('loan_status_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="dea_cash_bank_account">Cash Bank Account *</label>
                                <select class="form-control @error('dea_cash_bank_account') is-invalid @enderror"
                                        name="dea_cash_bank_account" id="dea_cash_bank_account" required>
                                    <option value="">Select Account</option>
                                    @foreach($bankAccounts as $account)
                                        <option value="{{ $account->id }}" 
                                            {{ old('dea_cash_bank_account', $loan->dea_cash_bank_account) == $account->id ? 'selected' : '' }}>
                                            {{ $account->name }} - {{ $account->account_number }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('dea_cash_bank_account')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- Guarantors --}}
                        <div class="form-group mt-3">
                            <label for="guarantors">Guarantors</label>
                            <select name="guarantors[]" id="guarantors" class="form-control @error('guarantors') is-invalid @enderror" multiple>
                                @foreach($guarantors as $guarantor)
                                    <option value="{{ $guarantor->id }}"
                                        {{ in_array($guarantor->id, old('guarantors', $loan->guarantors->pluck('id')->toArray())) ? 'selected' : '' }}>
                                        {{ $guarantor->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('guarantors')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Update Loan</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
@endsection
