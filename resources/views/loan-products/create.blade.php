@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">{{ isset($loanProduct) ? 'Edit' : 'Create' }} Loan Product</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('loan-products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<form action="{{ isset($loanProduct) ? route('loan-products.update', $loanProduct) : route('loan-products.store') }}" method="POST">
    @csrf
    @if(isset($loanProduct))
        @method('PUT')
    @endif

    <div class="form-section">
        <div class="section-header">Required Fields</div>
        
        <div class="row mb-3">
            <label for="loan_product_name" class="col-sm-3 col-form-label">Loan Product Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control @error('loan_product_name') is-invalid @enderror" 
                       id="loan_product_name" name="loan_product_name" 
                       value="{{ old('loan_product_name', $loanProduct->loan_product_name ?? '') }}" required>
                @error('loan_product_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="branches" class="col-sm-3 col-form-label">Access to Branch</label>
            <div class="col-sm-9">
                <select class="form-control branches_select @error('branches') is-invalid @enderror" 
                        id="branches" name="branches[]" multiple>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" 
                            {{ isset($loanProduct) && $loanProduct->branches->contains($branch->id) ? 'selected' : '' }}>
                            {{ $branch->name }}
                        </option>
                    @endforeach
                </select>
                @error('branches')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="alert alert-warning mt-2">
                    <small><b>Warning:</b> Click in the box above to select multiple branches. If you do not select any branch, then this loan product will not be available to any branch.</small>
                </div>
            </div>
        </div>
    </div>

    <div class="form-section">
        <div class="section-header">Advance Settings (optional)</div>
        
        <div class="row mb-3">
            <div class="col-sm-8 offset-sm-3">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="loan_enable_parameters" 
                           name="loan_enable_parameters" value="1"
                           {{ old('loan_enable_parameters', $loanProduct->loan_enable_parameters ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label text-primary fw-bold" for="loan_enable_parameters">
                        Enable Below Parameters
                    </label>
                </div>
            </div>
        </div>

        <div class="alert alert-info">
            <small>Please note that all of the below fields are optional. You can leave the fields empty if you do not want to place any restriction.</small>
        </div>

        <div class="slidingDiv">
            <!-- Loan Release Date Section -->
            <hr>
            <h5 class="text-danger mb-3">Loan Release Date:</h5>
            
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Set Loan Released Date to Today's date</label>
                <div class="col-sm-5">
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
                    <small class="form-text text-muted">If you select Yes, the Loan Released Date on the Add Loan page will be auto-filled with today's date.</small>
                </div>
            </div>

            <!-- Principal Amount Section -->
            <hr>
            <h5 class="text-danger mb-3">Principal Amount:</h5>
            
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Disbursed By</label>
                <div class="col-sm-5">
                    @php
                        $disbursedMethods = ['Cash', 'M-pesa', 'Wire Transfer', 'Online Transfer'];
                        $selectedDisbursed = isset($loanProduct) ? json_decode($loanProduct->loan_disbursed_by_id, true) : [];
                    @endphp
                    @foreach($disbursedMethods as $index => $method)
                        <div class="form-check">
                            <input class="form-check-input inputDisbursedById" type="checkbox" 
                                   name="loan_disbursed_by_id[]" value="{{ $index + 1 }}"
                                   {{ in_array($index + 1, $selectedDisbursed ?? []) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $method }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputMinLoanPrincipalAmount" class="col-sm-3 col-form-label">Minimum Principal Amount</label>
                <div class="col-sm-5">
                    <input type="text" name="min_loan_principal_amount" class="form-control numeral" 
                           id="inputMinLoanPrincipalAmount" placeholder="Minimum Amount" 
                           value="{{ old('min_loan_principal_amount', $loanProduct->min_loan_principal_amount ?? '') }}">
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputDefaultLoanPrincipalAmount" class="col-sm-3 col-form-label">Default Principal Amount</label>
                <div class="col-sm-5">
                    <input type="text" name="default_loan_principal_amount" class="form-control numeral" 
                           id="inputDefaultLoanPrincipalAmount" placeholder="Default Amount" 
                           value="{{ old('default_loan_principal_amount', $loanProduct->default_loan_principal_amount ?? '') }}">
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputMaxLoanPrincipalAmount" class="col-sm-3 col-form-label">Maximum Principal Amount</label>
                <div class="col-sm-5">
                    <input type="text" name="max_loan_principal_amount" class="form-control numeral" 
                           id="inputMaxLoanPrincipalAmount" placeholder="Maximum Amount" 
                           value="{{ old('max_loan_principal_amount', $loanProduct->max_loan_principal_amount ?? '') }}">
                </div>
            </div>

            <!-- Interest Section -->
            <hr>
            <h5 class="text-danger mb-3">Interest:</h5>

            <div class="row mb-3">
                <label for="inputLoanInterestMethod" class="col-sm-3 col-form-label">Interest Method</label>
                <div class="col-sm-5">
                    <select class="form-control" name="loan_interest_method" id="inputLoanInterestMethod">
                        <option value=""></option>
                        <option value="flat_rate" {{ old('loan_interest_method', $loanProduct->loan_interest_method ?? '') == 'flat_rate' ? 'selected' : '' }}>Flat Rate</option>
                        <option value="reducing_rate_equal_installments" {{ old('loan_interest_method', $loanProduct->loan_interest_method ?? '') == 'reducing_rate_equal_installments' ? 'selected' : '' }}>Reducing Balance - Equal Installments</option>
                        <option value="reducing_rate_equal_principal" {{ old('loan_interest_method', $loanProduct->loan_interest_method ?? '') == 'reducing_rate_equal_principal' ? 'selected' : '' }}>Reducing Balance - Equal Principal</option>
                        <option value="interest_only" {{ old('loan_interest_method', $loanProduct->loan_interest_method ?? '') == 'interest_only' ? 'selected' : '' }}>Interest-Only</option>
                        <option value="compound_interest_new" {{ old('loan_interest_method', $loanProduct->loan_interest_method ?? '') == 'compound_interest_new' ? 'selected' : '' }}>Compound Interest - Accrued</option>
                        <option value="compound_interest" {{ old('loan_interest_method', $loanProduct->loan_interest_method ?? '') == 'compound_interest' ? 'selected' : '' }}>Compound Interest - Equal Installments</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Interest Type</label>
                <div class="col-sm-5">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="loan_interest_type" 
                               id="inputInterestTypePercentage" value="percentage" 
                               {{ old('loan_interest_type', $loanProduct->loan_interest_type ?? 'percentage') == 'percentage' ? 'checked' : '' }}>
                        <label class="form-check-label" for="inputInterestTypePercentage">
                            I want Interest to be percentage % based
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="loan_interest_type" 
                               id="inputInterestTypeFixed" value="fixed"
                               {{ old('loan_interest_type', $loanProduct->loan_interest_type ?? '') == 'fixed' ? 'checked' : '' }}>
                        <label class="form-check-label" for="inputInterestTypeFixed">
                            I want Interest to be a fixed amount Per Cycle
                        </label>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputLoanInterestPeriod" class="col-sm-3 col-form-label">Loan Interest Period</label>
                <div class="col-sm-5">
                    <select class="form-control" name="loan_interest_period" id="inputLoanInterestPeriod">
                        <option value=""></option>
                        <option value="Day" {{ old('loan_interest_period', $loanProduct->loan_interest_period ?? '') == 'Day' ? 'selected' : '' }}>Per Day</option>
                        <option value="Week" {{ old('loan_interest_period', $loanProduct->loan_interest_period ?? '') == 'Week' ? 'selected' : '' }}>Per Week</option>
                        <option value="Month" {{ old('loan_interest_period', $loanProduct->loan_interest_period ?? '') == 'Month' ? 'selected' : '' }}>Per Month</option>
                        <option value="Year" {{ old('loan_interest_period', $loanProduct->loan_interest_period ?? '') == 'Year' ? 'selected' : '' }}>Per Year</option>
                        <option value="Loan" {{ old('loan_interest_period', $loanProduct->loan_interest_period ?? '') == 'Loan' ? 'selected' : '' }}>Per Loan</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputMinLoanInterest" class="col-sm-3 col-form-label">Minimum Loan Interest</label>
                <div class="col-sm-2">
                    <input type="text" name="min_loan_interest" class="form-control decimal-4-places" 
                           id="inputMinLoanInterest" placeholder="" 
                           value="{{ old('min_loan_interest', $loanProduct->min_loan_interest ?? '') }}">
                </div>
                <div class="col-sm-3">
                    <div id="inputMinInterestPeriod" class="form-text"></div>
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputDefaultLoanInterest" class="col-sm-3 col-form-label">Default Loan Interest</label>
                <div class="col-sm-2">
                    <input type="text" name="default_loan_interest" class="form-control decimal-4-places" 
                           id="inputDefaultLoanInterest" placeholder="" 
                           value="{{ old('default_loan_interest', $loanProduct->default_loan_interest ?? '') }}">
                </div>
                <div class="col-sm-3">
                    <div id="inputDefaultInterestPeriod" class="form-text"></div>
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputMaxLoanInterest" class="col-sm-3 col-form-label">Maximum Loan Interest</label>
                <div class="col-sm-2">
                    <input type="text" name="max_loan_interest" class="form-control decimal-4-places" 
                           id="inputMaxLoanInterest" placeholder="" 
                           value="{{ old('max_loan_interest', $loanProduct->max_loan_interest ?? '') }}">
                </div>
                <div class="col-sm-3">
                    <div id="inputMaxInterestPeriod" class="form-text"></div>
                </div>
            </div>

            <!-- Duration Section -->
            <hr>
            <h5 class="text-danger mb-3">Duration:</h5>

            <div class="row mb-3">
                <label for="inputLoanDurationPeriod" class="col-sm-3 col-form-label">Loan Duration Period</label>
                <div class="col-sm-5">
                    <select class="form-control" name="loan_duration_period" id="inputLoanDurationPeriod">
                        <option value=""></option>
                        <option value="Days" {{ old('loan_duration_period', $loanProduct->loan_duration_period ?? '') == 'Days' ? 'selected' : '' }}>Days</option>
                        <option value="Weeks" {{ old('loan_duration_period', $loanProduct->loan_duration_period ?? '') == 'Weeks' ? 'selected' : '' }}>Weeks</option>
                        <option value="Months" {{ old('loan_duration_period', $loanProduct->loan_duration_period ?? '') == 'Months' ? 'selected' : '' }}>Months</option>
                        <option value="Years" {{ old('loan_duration_period', $loanProduct->loan_duration_period ?? '') == 'Years' ? 'selected' : '' }}>Years</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputMinLoanDuration" class="col-sm-3 col-form-label">Minimum Loan Duration</label>
                <div class="col-sm-2">
                    <select class="form-control" name="min_loan_duration" id="inputMinLoanDuration">
                        <option value="">Any</option>
                        @for($i = 1; $i <= 120; $i++)
                            <option value="{{ $i }}" {{ old('min_loan_duration', $loanProduct->min_loan_duration ?? '') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-sm-3">
                    <div id="inputMinLoanDurationPeriod" class="form-text"></div>
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputDefaultLoanDuration" class="col-sm-3 col-form-label">Default Loan Duration</label>
                <div class="col-sm-2">
                    <select class="form-control" name="default_loan_duration" id="inputDefaultLoanDuration">
                        <option value="">Any</option>
                        @for($i = 1; $i <= 120; $i++)
                            <option value="{{ $i }}" {{ old('default_loan_duration', $loanProduct->default_loan_duration ?? '') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-sm-3">
                    <div id="inputDefaultLoanDurationPeriod" class="form-text"></div>
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputMaxLoanDuration" class="col-sm-3 col-form-label">Maximum Loan Duration</label>
                <div class="col-sm-2">
                    <select class="form-control" name="max_loan_duration" id="inputMaxLoanDuration">
                        <option value="">Any</option>
                        @for($i = 1; $i <= 120; $i++)
                            <option value="{{ $i }}" {{ old('max_loan_duration', $loanProduct->max_loan_duration ?? '') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-sm-3">
                    <div id="inputMaxLoanDurationPeriod" class="form-text"></div>
                </div>
            </div>

            <!-- Repayments Section -->
            <hr>
            <h5 class="text-danger mb-3">Repayments:</h5>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Repayment Cycle</label>
                <div class="col-sm-3">
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
                    @foreach($repaymentCycles as $value => $label)
                        <div class="form-check">
                            <input class="form-check-input classLoanPaymentSchemeId" type="checkbox" 
                                   name="loan_payment_scheme_id[]" value="{{ $value }}"
                                   {{ in_array($value, $selectedCycles ?? []) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $label }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputMinLoanNumOfRepayments" class="col-sm-3 col-form-label">Minimum Number of Repayments</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" name="min_loan_num_of_repayments" 
                           id="inputMinLoanNumOfRepayments" 
                           value="{{ old('min_loan_num_of_repayments', $loanProduct->min_loan_num_of_repayments ?? '') }}">
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputDefaultLoanNumOfRepayments" class="col-sm-3 col-form-label">Default Number of Repayments</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" name="default_loan_num_of_repayments" 
                           id="inputDefaultLoanNumOfRepayments" 
                           value="{{ old('default_loan_num_of_repayments', $loanProduct->default_loan_num_of_repayments ?? '') }}">
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputMaxLoanNumOfRepayments" class="col-sm-3 col-form-label">Maximum Number of Repayments</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" name="max_loan_num_of_repayments" 
                           id="inputMaxLoanNumOfRepayments" 
                           value="{{ old('max_loan_num_of_repayments', $loanProduct->max_loan_num_of_repayments ?? '') }}">
                </div>
            </div>

            <!-- Loan Due and Loan Schedule Amounts -->
            <hr>
            <h5 class="text-danger mb-3">Loan Due and Loan Schedule Amounts:</h5>
            
            <div class="alert alert-info mb-3">
                If Loan Due amount and/or Schedule amounts are in decimals for example $100.33333, the system will convert them based on below option.
            </div>

            <div class="row mb-3">
                <label for="inputLoanDecimalPlaces" class="col-sm-3 col-form-label">Decimal Places</label>
                <div class="col-sm-5">
                    <select class="form-control" name="loan_decimal_places" id="inputLoanDecimalPlaces">
                        <option value=""></option>
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

            <div class="row mb-3">
                <div class="col-sm-8 offset-sm-3">
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
            <hr>
            <h5 class="text-danger mb-3">Repayment Order:</h5>
            
            <div class="alert alert-info mb-3">
                The order in which repayments are allocated. For example let's say you receive payment of $100 and order is <b>Fees</b>, <b>Principal</b>, <b>Interest</b>, <b>Penalty</b>. Based on the loan schedule, the system will allocate the amount to <b>Fees</b> first and remaining amount to <b>Principal</b> and then <b>Interest</b> and then <b>Penalty</b>.
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Repayment Order</label>
                <div class="col-sm-6">
                    <select multiple id="repaymentOrder" class="form-control" size="7" name="repayment_order[]">
                        @php
                            $repaymentOrderOptions = ['Penalty', 'Fees', 'Interest', 'Principal'];
                            $selectedOrder = isset($loanProduct) ? json_decode($loanProduct->repayment_order, true) : $repaymentOrderOptions;
                        @endphp
                        @foreach($repaymentOrderOptions as $option)
                            <option value="{{ $option }}" {{ in_array($option, $selectedOrder ?? []) ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-6 offset-sm-3">
                    <button type="button" class="btn btn-sm btn-secondary me-2" onclick="moveUp()">Up</button>
                    <button type="button" class="btn btn-sm btn-secondary" onclick="moveDown()">Down</button>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-8 offset-sm-3">
                    <small class="text-muted"><b>Please note:</b> If you change the above order, all Open loans will be updated with the new Repayment Order and Fee Order</small>
                </div>
            </div>

            <!-- Continue with other sections following the same pattern -->
            <!-- Automated Payments, Fees, Extend Loan After Maturity, Advance settings, etc. -->
            
        </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('loan-products.index') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i>
            {{ isset($loanProduct) ? 'Update' : 'Create' }} Loan Product
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.branches_select').select2({
            placeholder: "Select branches",
            allowClear: true
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
            const periodText = period ? ` ${period}` : '';
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
@endpush