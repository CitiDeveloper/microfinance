@extends('layouts.app')

@section('content')
<style>
    .card {
        border-radius: 0.5rem;
    }
    
    .card-header {
        border-radius: 0.5rem 0.5rem 0 0 !important;
    }
    
    .settings-section {
        padding: 1.5rem;
        border: 1px solid #e3e6f0;
        border-radius: 0.35rem;
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        font-weight: 600;
        color: #5a5c69;
    }
    
    .alert {
        border-radius: 0.35rem;
    }
    
    .input-group-text {
        background-color: #f8f9fc;
        color: #6e707e;
    }
    
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #d1d3e2;
        border-radius: 0.35rem;
    }
</style>
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h2 class="h4">{{ isset($loanProduct) ? 'Edit' : 'Create' }} Loan Product</h2>
            <p class="mb-0">Configure loan product settings and parameters</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('loan-products.index') }}" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
        </div>
    </div>

    <form action="{{ isset($loanProduct) ? route('loan-products.update', $loanProduct) : route('loan-products.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf
        @if(isset($loanProduct))
            @method('PUT')
        @endif

        <!-- Required Fields Section -->
        <div class="card border-0 shadow mb-4">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0">Required Fields</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="loan_product_name" class="form-label">Loan Product Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('loan_product_name') is-invalid @enderror" 
                                   id="loan_product_name" name="loan_product_name" 
                                   value="{{ old('loan_product_name', $loanProduct->loan_product_name ?? '') }}" required>
                            @error('loan_product_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="branches" class="form-label">Access to Branch</label>
                            <select class="form-select branches_select @error('branches') is-invalid @enderror" 
                                    id="branches" name="branches[]" multiple>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" 
                                        {{ isset($loanProduct) && $loanProduct->branches->contains($branch->id) ? 'selected' : '' }}>
                                        {{ $branch->branch_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('branches')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="alert alert-warning mt-2">
                                <small><i class="fas fa-exclamation-triangle me-1"></i> <b>Warning:</b> Select multiple branches. If no branch is selected, this loan product will not be available to any branch.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Advanced Settings Section -->
        <div class="card border-0 shadow mb-4">
            <div class="card-header bg-light py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Advanced Settings (Optional)</h5>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" id="loan_enable_parameters" 
                               name="loan_enable_parameters" value="1"
                               {{ old('loan_enable_parameters', $loanProduct->loan_enable_parameters ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="loan_enable_parameters">
                            Enable Parameters
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="alert alert-info">
                    <small><i class="fas fa-info-circle me-1"></i> All fields below are optional. Leave empty if you don't want to place restrictions.</small>
                </div>

                <div class="slidingDiv">
                    <!-- Loan Release Date Section -->
                    <div class="settings-section mb-4">
                        <h6 class="text-primary mb-3 border-bottom pb-2">
                            <i class="fas fa-calendar-alt me-2"></i>Loan Release Date
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Set Loan Released Date to Today's Date</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="default_loan_released_date" 
                                                   id="inputDefaultLoanReleasedDateNo" value="0" 
                                                   {{ old('default_loan_released_date', $loanProduct->default_loan_released_date ?? 0) == 0 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inputDefaultLoanReleasedDateNo">No</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="default_loan_released_date" 
                                                   id="inputDefaultLoanReleasedDateYes" value="1"
                                                   {{ old('default_loan_released_date', $loanProduct->default_loan_released_date ?? 0) == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inputDefaultLoanReleasedDateYes">Yes</label>
                                        </div>
                                    </div>
                                    <div class="form-text">If Yes, the Loan Released Date on the Add Loan page will be auto-filled with today's date.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Principal Amount Section -->
                    <div class="settings-section mb-4">
                        <h6 class="text-primary mb-3 border-bottom pb-2">
                            <i class="fas fa-money-bill-wave me-2"></i>Principal Amount
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Disbursed By</label>
                                    @php
                                        $disbursedMethods = ['Cash', 'M-pesa', 'Wire Transfer', 'Online Transfer'];
                                        $selectedDisbursed = isset($loanProduct) ? json_decode($loanProduct->loan_disbursed_by_id, true) : [];
                                    @endphp
                                    <div class="row">
                                        @foreach($disbursedMethods as $index => $method)
                                            <div class="col-md-6 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input inputDisbursedById" type="checkbox" 
                                                           name="loan_disbursed_by_id[]" value="{{ $index + 1 }}"
                                                           {{ in_array($index + 1, $selectedDisbursed ?? []) ? 'checked' : '' }}>
                                                    <label class="form-check-label">{{ $method }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="inputMinLoanPrincipalAmount" class="form-label">Minimum Principal Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="text" name="min_loan_principal_amount" class="form-control numeral" 
                                               id="inputMinLoanPrincipalAmount" placeholder="Minimum Amount" 
                                               value="{{ old('min_loan_principal_amount', $loanProduct->min_loan_principal_amount ?? '') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="inputDefaultLoanPrincipalAmount" class="form-label">Default Principal Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="text" name="default_loan_principal_amount" class="form-control numeral" 
                                               id="inputDefaultLoanPrincipalAmount" placeholder="Default Amount" 
                                               value="{{ old('default_loan_principal_amount', $loanProduct->default_loan_principal_amount ?? '') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="inputMaxLoanPrincipalAmount" class="form-label">Maximum Principal Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="text" name="max_loan_principal_amount" class="form-control numeral" 
                                               id="inputMaxLoanPrincipalAmount" placeholder="Maximum Amount" 
                                               value="{{ old('max_loan_principal_amount', $loanProduct->max_loan_principal_amount ?? '') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Interest Section -->
                    <div class="settings-section mb-4">
                        <h6 class="text-primary mb-3 border-bottom pb-2">
                            <i class="fas fa-percent me-2"></i>Interest
                        </h6>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="inputLoanInterestMethod" class="form-label">Interest Method</label>
                                    <select class="form-select" name="loan_interest_method" id="inputLoanInterestMethod">
                                        <option value="">Select Method</option>
                                        <option value="flat_rate" {{ old('loan_interest_method', $loanProduct->loan_interest_method ?? '') == 'flat_rate' ? 'selected' : '' }}>Flat Rate</option>
                                        <option value="reducing_rate_equal_installments" {{ old('loan_interest_method', $loanProduct->loan_interest_method ?? '') == 'reducing_rate_equal_installments' ? 'selected' : '' }}>Reducing Balance - Equal Installments</option>
                                        <option value="reducing_rate_equal_principal" {{ old('loan_interest_method', $loanProduct->loan_interest_method ?? '') == 'reducing_rate_equal_principal' ? 'selected' : '' }}>Reducing Balance - Equal Principal</option>
                                        <option value="interest_only" {{ old('loan_interest_method', $loanProduct->loan_interest_method ?? '') == 'interest_only' ? 'selected' : '' }}>Interest-Only</option>
                                        <option value="compound_interest_new" {{ old('loan_interest_method', $loanProduct->loan_interest_method ?? '') == 'compound_interest_new' ? 'selected' : '' }}>Compound Interest - Accrued</option>
                                        <option value="compound_interest" {{ old('loan_interest_method', $loanProduct->loan_interest_method ?? '') == 'compound_interest' ? 'selected' : '' }}>Compound Interest - Equal Installments</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="inputLoanInterestPeriod" class="form-label">Loan Interest Period</label>
                                    <select class="form-select" name="loan_interest_period" id="inputLoanInterestPeriod">
                                        <option value="">Select Period</option>
                                        <option value="Day" {{ old('loan_interest_period', $loanProduct->loan_interest_period ?? '') == 'Day' ? 'selected' : '' }}>Per Day</option>
                                        <option value="Week" {{ old('loan_interest_period', $loanProduct->loan_interest_period ?? '') == 'Week' ? 'selected' : '' }}>Per Week</option>
                                        <option value="Month" {{ old('loan_interest_period', $loanProduct->loan_interest_period ?? '') == 'Month' ? 'selected' : '' }}>Per Month</option>
                                        <option value="Year" {{ old('loan_interest_period', $loanProduct->loan_interest_period ?? '') == 'Year' ? 'selected' : '' }}>Per Year</option>
                                        <option value="Loan" {{ old('loan_interest_period', $loanProduct->loan_interest_period ?? '') == 'Loan' ? 'selected' : '' }}>Per Loan</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Interest Type</label>
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="loan_interest_type" 
                                           id="inputInterestTypePercentage" value="percentage" 
                                           {{ old('loan_interest_type', $loanProduct->loan_interest_type ?? 'percentage') == 'percentage' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="inputInterestTypePercentage">
                                        Percentage % based
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="loan_interest_type" 
                                           id="inputInterestTypeFixed" value="fixed"
                                           {{ old('loan_interest_type', $loanProduct->loan_interest_type ?? '') == 'fixed' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="inputInterestTypeFixed">
                                        Fixed amount per cycle
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="inputMinLoanInterest" class="form-label">Minimum Loan Interest</label>
                                    <div class="input-group">
                                        <input type="text" name="min_loan_interest" class="form-control decimal-4-places" 
                                               id="inputMinLoanInterest" placeholder="Min" 
                                               value="{{ old('min_loan_interest', $loanProduct->min_loan_interest ?? '') }}">
                                        <span class="input-group-text" id="inputMinInterestPeriod"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="inputDefaultLoanInterest" class="form-label">Default Loan Interest</label>
                                    <div class="input-group">
                                        <input type="text" name="default_loan_interest" class="form-control decimal-4-places" 
                                               id="inputDefaultLoanInterest" placeholder="Default" 
                                               value="{{ old('default_loan_interest', $loanProduct->default_loan_interest ?? '') }}">
                                        <span class="input-group-text" id="inputDefaultInterestPeriod"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="inputMaxLoanInterest" class="form-label">Maximum Loan Interest</label>
                                    <div class="input-group">
                                        <input type="text" name="max_loan_interest" class="form-control decimal-4-places" 
                                               id="inputMaxLoanInterest" placeholder="Max" 
                                               value="{{ old('max_loan_interest', $loanProduct->max_loan_interest ?? '') }}">
                                        <span class="input-group-text" id="inputMaxInterestPeriod"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Duration Section -->
                    <div class="settings-section mb-4">
                        <h6 class="text-primary mb-3 border-bottom pb-2">
                            <i class="fas fa-clock me-2"></i>Duration
                        </h6>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="inputLoanDurationPeriod" class="form-label">Loan Duration Period</label>
                                    <select class="form-select" name="loan_duration_period" id="inputLoanDurationPeriod">
                                        <option value="">Select Period</option>
                                        <option value="Days" {{ old('loan_duration_period', $loanProduct->loan_duration_period ?? '') == 'Days' ? 'selected' : '' }}>Days</option>
                                        <option value="Weeks" {{ old('loan_duration_period', $loanProduct->loan_duration_period ?? '') == 'Weeks' ? 'selected' : '' }}>Weeks</option>
                                        <option value="Months" {{ old('loan_duration_period', $loanProduct->loan_duration_period ?? '') == 'Months' ? 'selected' : '' }}>Months</option>
                                        <option value="Years" {{ old('loan_duration_period', $loanProduct->loan_duration_period ?? '') == 'Years' ? 'selected' : '' }}>Years</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="inputMinLoanDuration" class="form-label">Minimum Loan Duration</label>
                                    <div class="input-group">
                                        <select class="form-select" name="min_loan_duration" id="inputMinLoanDuration">
                                            <option value="">Any</option>
                                            @for($i = 1; $i <= 120; $i++)
                                                <option value="{{ $i }}" {{ old('min_loan_duration', $loanProduct->min_loan_duration ?? '') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                        <span class="input-group-text" id="inputMinLoanDurationPeriod"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="inputDefaultLoanDuration" class="form-label">Default Loan Duration</label>
                                    <div class="input-group">
                                        <select class="form-select" name="default_loan_duration" id="inputDefaultLoanDuration">
                                            <option value="">Any</option>
                                            @for($i = 1; $i <= 120; $i++)
                                                <option value="{{ $i }}" {{ old('default_loan_duration', $loanProduct->default_loan_duration ?? '') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                        <span class="input-group-text" id="inputDefaultLoanDurationPeriod"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="inputMaxLoanDuration" class="form-label">Maximum Loan Duration</label>
                                    <div class="input-group">
                                        <select class="form-select" name="max_loan_duration" id="inputMaxLoanDuration">
                                            <option value="">Any</option>
                                            @for($i = 1; $i <= 120; $i++)
                                                <option value="{{ $i }}" {{ old('max_loan_duration', $loanProduct->max_loan_duration ?? '') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                        <span class="input-group-text" id="inputMaxLoanDurationPeriod"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Repayments Section -->
                    <div class="settings-section mb-4">
                        <h6 class="text-primary mb-3 border-bottom pb-2">
                            <i class="fas fa-redo me-2"></i>Repayments
                        </h6>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Repayment Cycle</label>
                                    @php
                                        $repaymentCycles = [
                                            '6' => 'Daily',
                                            '4' => 'Weekly',
                                            '9' => 'Biweekly',
                                            '3' => 'Monthly',
                                            '12' => 'Bimonthly',
                                            '13' => 'Quarterly',
                                            '781' => 'Every 4 Months',
                                            '14' => 'Semi-Annual',
                                            '1943' => 'Every 9 Months',
                                            '11' => 'Yearly',
                                            '10' => 'Lump-Sum'
                                        ];
                                        $selectedCycles = isset($loanProduct) ? json_decode($loanProduct->loan_payment_scheme_id, true) : [];
                                    @endphp
                                    <div class="row">
                                        @foreach($repaymentCycles as $value => $label)
                                            <div class="col-md-6 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input classLoanPaymentSchemeId" type="checkbox" 
                                                           name="loan_payment_scheme_id[]" value="{{ $value }}"
                                                           {{ in_array($value, $selectedCycles ?? []) ? 'checked' : '' }}>
                                                    <label class="form-check-label">{{ $label }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="inputMinLoanNumOfRepayments" class="form-label">Minimum Number of Repayments</label>
                                    <input type="text" class="form-control" name="min_loan_num_of_repayments" 
                                           id="inputMinLoanNumOfRepayments" 
                                           value="{{ old('min_loan_num_of_repayments', $loanProduct->min_loan_num_of_repayments ?? '') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="inputDefaultLoanNumOfRepayments" class="form-label">Default Number of Repayments</label>
                                    <input type="text" class="form-control" name="default_loan_num_of_repayments" 
                                           id="inputDefaultLoanNumOfRepayments" 
                                           value="{{ old('default_loan_num_of_repayments', $loanProduct->default_loan_num_of_repayments ?? '') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="inputMaxLoanNumOfRepayments" class="form-label">Maximum Number of Repayments</label>
                                    <input type="text" class="form-control" name="max_loan_num_of_repayments" 
                                           id="inputMaxLoanNumOfRepayments" 
                                           value="{{ old('max_loan_num_of_repayments', $loanProduct->max_loan_num_of_repayments ?? '') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Loan Due and Loan Schedule Amounts -->
                    <div class="settings-section mb-4">
                        <h6 class="text-primary mb-3 border-bottom pb-2">
                            <i class="fas fa-calculator me-2"></i>Loan Due and Loan Schedule Amounts
                        </h6>
                        
                        <div class="alert alert-info mb-3">
                            <small><i class="fas fa-info-circle me-1"></i> If Loan Due amount and/or Schedule amounts are in decimals (e.g., $100.33333), the system will convert them based on the selected option.</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="inputLoanDecimalPlaces" class="form-label">Decimal Places</label>
                                    <select class="form-select" name="loan_decimal_places" id="inputLoanDecimalPlaces">
                                        <option value="">Select Option</option>
                                        <option value="round_off_to_two_decimal" {{ old('loan_decimal_places', $loanProduct->loan_decimal_places ?? '') == 'round_off_to_two_decimal' ? 'selected' : '' }}>Round Off to 2 Decimal Places</option>
                                        <option value="round_off_to_integer" {{ old('loan_decimal_places', $loanProduct->loan_decimal_places ?? '') == 'round_off_to_integer' ? 'selected' : '' }}>Round Off to Integer</option>
                                        <option value="round_down_to_integer" {{ old('loan_decimal_places', $loanProduct->loan_decimal_places ?? '') == 'round_down_to_integer' ? 'selected' : '' }}>Round Down to Integer</option>
                                        <option value="round_up_to_integer" {{ old('loan_decimal_places', $loanProduct->loan_decimal_places ?? '') == 'round_up_to_integer' ? 'selected' : '' }}>Round Up to Integer</option>
                                        <option value="round_off_to_one_decimal" {{ old('loan_decimal_places', $loanProduct->loan_decimal_places ?? '') == 'round_off_to_one_decimal' ? 'selected' : '' }}>Round Off to 1 Decimal Place</option>
                                        <option value="round_up_to_one_decimal" {{ old('loan_decimal_places', $loanProduct->loan_decimal_places ?? '') == 'round_up_to_one_decimal' ? 'selected' : '' }}>Round Up to 1 Decimal Place</option>
                                        <option value="round_up_to_five" {{ old('loan_decimal_places', $loanProduct->loan_decimal_places ?? '') == 'round_up_to_five' ? 'selected' : '' }}>Round Off to Nearest 5</option>
                                        <option value="round_up_to_ten" {{ old('loan_decimal_places', $loanProduct->loan_decimal_places ?? '') == 'round_up_to_ten' ? 'selected' : '' }}>Round Up to Nearest 10</option>
                                        <option value="round_off_to_hundred" {{ old('loan_decimal_places', $loanProduct->loan_decimal_places ?? '') == 'round_off_to_hundred' ? 'selected' : '' }}>Round Off to Nearest 100</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="inputLoanDecimalPlacesAdjustEachReaypment" 
                                       name="loan_decimal_places_adjust_each_interest" value="1"
                                       {{ old('loan_decimal_places_adjust_each_interest', $loanProduct->loan_decimal_places_adjust_each_interest ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="inputLoanDecimalPlacesAdjustEachReaypment">
                                    Round Up/Off Interest for all repayments in the loan schedule even if it exceeds total interest of loan.
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Repayment Order -->
                    <div class="settings-section mb-4">
                        <h6 class="text-primary mb-3 border-bottom pb-2">
                            <i class="fas fa-sort me-2"></i>Repayment Order
                        </h6>
                        
                        <div class="alert alert-info mb-3">
                            <small><i class="fas fa-info-circle me-1"></i> The order in which repayments are allocated. For example, if you receive payment of $100 and order is <b>Fees</b>, <b>Principal</b>, <b>Interest</b>, <b>Penalty</b>, the system will allocate the amount to <b>Fees</b> first, then remaining amount to <b>Principal</b>, then <b>Interest</b>, and finally <b>Penalty</b>.</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Repayment Order</label>
                                    <select multiple id="repaymentOrder" class="form-select" size="7" name="repayment_order[]">
                                        @php
                                            $repaymentOrderOptions = ['Penalty', 'Fees', 'Interest', 'Principal'];
                                            $selectedOrder = isset($loanProduct) ? json_decode($loanProduct->repayment_order, true) : $repaymentOrderOptions;
                                        @endphp
                                        @foreach($repaymentOrderOptions as $option)
                                            <option value="{{ $option }}" {{ in_array($option, $selectedOrder ?? []) ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <button type="button" class="btn btn-sm btn-outline-primary me-2" onclick="moveUp()">
                                        <i class="fas fa-arrow-up me-1"></i>Move Up
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="moveDown()">
                                        <i class="fas fa-arrow-down me-1"></i>Move Down
                                    </button>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted"><i class="fas fa-exclamation-circle me-1"></i> <b>Note:</b> If you change the above order, all Open loans will be updated with the new Repayment Order and Fee Order.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('loan-products.index') }}" class="btn btn-outline-gray-600">
                <i class="fas fa-times me-2"></i>Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>
                {{ isset($loanProduct) ? 'Update' : 'Create' }} Loan Product
            </button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.branches_select').select2({
            placeholder: "Select branches",
            allowClear: true,
            width: '100%'
        });

        // Toggle advanced settings
        $('#loan_enable_parameters').change(function() {
            $('.slidingDiv').toggle(this.checked);
        }).trigger('change');

        // Numeric input formatting
        $('.numeral').on('input', function() {
            this.value = this.value.replace(/[^0-9.]/g, '');
        });

        // Update interest period labels
        function updateInterestPeriodLabels() {
            const period = $('#inputLoanInterestPeriod').val();
            const periodText = period ? `/ ${period}` : '';
            $('#inputMinInterestPeriod').text(periodText);
            $('#inputDefaultInterestPeriod').text(periodText);
            $('#inputMaxInterestPeriod').text(periodText);
        }

        function updateDurationPeriodLabels() {
            const period = $('#inputLoanDurationPeriod').val();
            const periodText = period ? ` ${period}` : '';
            $('#inputMinLoanDurationPeriod').text(periodText);
            $('#inputDefaultLoanDurationPeriod').text(periodText);
            $('#inputMaxLoanDurationPeriod').text(periodText);
        }

        $('#inputLoanInterestPeriod').change(updateInterestPeriodLabels);
        $('#inputLoanDurationPeriod').change(updateDurationPeriodLabels);

        // Initialize labels
        updateInterestPeriodLabels();
        updateDurationPeriodLabels();
        
        // Form validation
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    });

    function moveUp() {
        const select = document.getElementById('repaymentOrder');
        const selected = Array.from(select.selectedOptions);
        selected.forEach(option => {
            if (option.previousElementSibling) {
                select.insertBefore(option, option.previousElementSibling);
            }
        });
    }

    function moveDown() {
        const select = document.getElementById('repaymentOrder');
        const selected = Array.from(select.selectedOptions).reverse();
        selected.forEach(option => {
            if (option.nextElementSibling) {
                select.insertBefore(option.nextElementSibling, option);
            }
        });
    }
</script>
@endsection



