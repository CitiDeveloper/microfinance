   <input type="hidden" name="back_url" value="">
                            
                            <div class="card-body">
                                <!-- Required Fields Section -->
                                <div class="form-section">
                                    <div class="section-header">Required Information</div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="inputBranchName" class="form-label">Branch Name <span class="text-danger">*</span></label>
                                            <input type="text" name="branch_name" class="form-control @error('branch_name') is-invalid @enderror" 
                                                   id="inputBranchName" placeholder="Enter branch name" 
                                                   value="{{ old('branch_name', $branch->branch_name ?? '') }}" required>
                                            @error('branch_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="inputBranchOpenDate" class="form-label">Branch Open Date <span class="text-danger">*</span></label>
                                            <input type="date" name="branch_open_date" class="form-control @error('branch_open_date') is-invalid @enderror" 
                                                   id="inputBranchOpenDate" 
                                                   value="{{ old('branch_open_date', isset($branch) ? $branch->branch_open_date->format('Y-m-d') : '') }}" required>
                                            @error('branch_open_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Account Settings Override Section -->
                                <div class="form-section">
                                    <div class="section-header">Account Settings Override</div>
                                    
                                    <div class="info-card">
                                        <p>If you are operating in different countries, you can create a branch for each country and then override the account settings below. This is particularly useful for setting different currencies for each branch.</p>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" name="account_settings_override" id="inputAccountSettingsOverride" value="1" 
                                                       {{ old('account_settings_override', $branch->account_settings_override ?? '') ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold" for="inputAccountSettingsOverride">
                                                    Override Account Settings?
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="inputCountry" class="form-label">Country</label>
                                            <select class="form-select @error('branch_country') is-invalid @enderror" name="branch_country" id="inputCountry">
                                                <option value="">Select Country</option>
                                                @foreach([
                                                    'AF' => 'Afghanistan', 'AX' => 'Aland Islands', 'AL' => 'Albania', 'DZ' => 'Algeria',
                                                    'AS' => 'American Samoa', 'AD' => 'Andorra', 'AO' => 'Angola', 'AI' => 'Anguilla',
                                                    // ... rest of countries (truncated for brevity)
                                                ] as $code => $name)
                                                    <option value="{{ $code }}" {{ old('branch_country', $branch->branch_country ?? '') == $code ? 'selected' : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('branch_country')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="inputCurrency" class="form-label">Currency</label>
                                            <select class="form-select @error('branch_currency') is-invalid @enderror" name="branch_currency" id="inputCurrency">
                                                <option value="">Select Currency</option>
                                                @foreach([
                                                    'AED' => 'AED - د.إ', 'AFN' => 'AFN - Af', 'ALL' => 'ALL - Lek', 'AMD' => 'AMD - ֏',
                                                    // ... rest of currencies (truncated for brevity)
                                                ] as $code => $name)
                                                    <option value="{{ $code }}" {{ old('branch_currency', $branch->branch_currency ?? '') == $code ? 'selected' : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('branch_currency')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="inputDateformat" class="form-label">Date Format</label>
                                            <select class="form-select @error('branch_dateformat') is-invalid @enderror" name="branch_dateformat" id="inputDateformat">
                                                <option value="">Select Date Format</option>
                                                <option value="dd/mm/yyyy" {{ old('branch_dateformat', $branch->branch_dateformat ?? '') == 'dd/mm/yyyy' ? 'selected' : '' }}>dd/mm/yyyy</option>
                                                <option value="mm/dd/yyyy" {{ old('branch_dateformat', $branch->branch_dateformat ?? '') == 'mm/dd/yyyy' ? 'selected' : '' }}>mm/dd/yyyy</option>
                                                <option value="yyyy/mm/dd" {{ old('branch_dateformat', $branch->branch_dateformat ?? '') == 'yyyy/mm/dd' ? 'selected' : '' }}>yyyy/mm/dd</option>
                                            </select>
                                            @error('branch_dateformat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="inputCurrencyInWords" class="form-label">Currency in Words</label>
                                            <input type="text" name="branch_currency_in_words" class="form-control @error('branch_currency_in_words') is-invalid @enderror" 
                                                   id="inputCurrencyInWords" placeholder="Enter currency in words" 
                                                   value="{{ old('branch_currency_in_words', $branch->branch_currency_in_words ?? '') }}">
                                            <div class="form-text">Please visit Account Settings for an explanation on <b>Currency in Words</b> field.</div>
                                            @error('branch_currency_in_words')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Address Section -->
                                <div class="form-section">
                                    <div class="section-header">Address Information</div>
                                    
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label for="inputBranchAddress" class="form-label">Branch Address</label>
                                            <input type="text" name="branch_address" class="form-control @error('branch_address') is-invalid @enderror" 
                                                   id="inputBranchAddress" placeholder="Enter branch address" 
                                                   value="{{ old('branch_address', $branch->branch_address ?? '') }}">
                                            @error('branch_address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label for="inputBranchCity" class="form-label">Branch City</label>
                                            <input type="text" name="branch_city" class="form-control @error('branch_city') is-invalid @enderror" 
                                                   id="inputBranchCity" placeholder="Enter branch city" 
                                                   value="{{ old('branch_city', $branch->branch_city ?? '') }}">
                                            @error('branch_city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label for="inputBranchProvince" class="form-label">Branch Province</label>
                                            <input type="text" name="branch_province" class="form-control @error('branch_province') is-invalid @enderror" 
                                                   id="inputBranchProvince" placeholder="Enter branch province" 
                                                   value="{{ old('branch_province', $branch->branch_province ?? '') }}">
                                            @error('branch_province')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label for="inputBranchZipcode" class="form-label">Branch Zipcode</label>
                                            <input type="text" name="branch_zipcode" class="form-control @error('branch_zipcode') is-invalid @enderror" 
                                                   id="inputBranchZipcode" placeholder="Enter branch zipcode" 
                                                   value="{{ old('branch_zipcode', $branch->branch_zipcode ?? '') }}">
                                            @error('branch_zipcode')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="inputBranchPhoneLandline" class="form-label">Branch Landline</label>
                                            <input type="text" name="branch_landline" class="form-control @error('branch_landline') is-invalid @enderror" 
                                                   id="inputBranchPhoneLandline" placeholder="Enter branch landline" 
                                                   value="{{ old('branch_landline', $branch->branch_landline ?? '') }}">
                                            @error('branch_landline')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="inputBranchMobile" class="form-label">Branch Mobile</label>
                                            <input type="text" name="branch_mobile" class="form-control @error('branch_mobile') is-invalid @enderror" 
                                                   id="inputBranchMobile" placeholder="Enter branch mobile (numbers only)" 
                                                   value="{{ old('branch_mobile', $branch->branch_mobile ?? '') }}">
                                            @error('branch_mobile')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Loan Restrictions Section -->
                                <div class="form-section">
                                    <div class="section-header">Loan Restrictions</div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="inputBranchMinLoanAmount" class="form-label">Minimum Loan Amount</label>
                                            <input type="number" step="0.01" name="branch_min_loan_amount" class="form-control @error('branch_min_loan_amount') is-invalid @enderror" 
                                                   id="inputBranchMinLoanAmount" placeholder="Enter minimum loan amount" 
                                                   value="{{ old('branch_min_loan_amount', $branch->branch_min_loan_amount ?? '') }}">
                                            @error('branch_min_loan_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="inputBranchMaxLoanAmount" class="form-label">Maximum Loan Amount</label>
                                            <input type="number" step="0.01" name="branch_max_loan_amount" class="form-control @error('branch_max_loan_amount') is-invalid @enderror" 
                                                   id="inputBranchMaxLoanAmount" placeholder="Enter maximum loan amount" 
                                                   value="{{ old('branch_max_loan_amount', $branch->branch_max_loan_amount ?? '') }}">
                                            @error('branch_max_loan_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="inputBranchMinLoanInterest" class="form-label">Minimum Loan Interest Rate</label>
                                            <input type="number" step="0.01" name="branch_min_interest_rate" class="form-control @error('branch_min_interest_rate') is-invalid @enderror" 
                                                   id="inputBranchMinLoanInterest" placeholder="Enter minimum interest rate" 
                                                   value="{{ old('branch_min_interest_rate', $branch->branch_min_interest_rate ?? '') }}">
                                            @error('branch_min_interest_rate')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="inputBranchMaxLoanInterest" class="form-label">Maximum Loan Interest Rate</label>
                                            <input type="number" step="0.01" name="branch_max_interest_rate" class="form-control @error('branch_max_interest_rate') is-invalid @enderror" 
                                                   id="inputBranchMaxLoanInterest" placeholder="Enter maximum interest rate" 
                                                   value="{{ old('branch_max_interest_rate', $branch->branch_max_interest_rate ?? '') }}">
                                            @error('branch_max_interest_rate')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Custom Number Generation Section -->
                                <div class="form-section">
                                    <div class="section-header">Custom Number Generation</div>
                                    
                                    <div class="info-card">
                                        <p>Below, you can generate a <b>Borrower Unique Number</b> on the Add Borrower page and a unique <b>Loan #</b> on the Add Loan page. If you do not set the below, for borrowers, the system leaves the <b>Borrower Unique Number</b> field empty. For loans, the system generates a unique 7 digit <b>Loan #</b>. But you might want a different format or a branch code in that number. You can use the below placeholders to force the system into generating borrower unique numbers and loan numbers based on the below patterns.</p>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="inputGenerateBorrowerUniqueNumbers" class="form-label">Borrower Unique Number (optional)</label>
                                            <input type="text" class="form-control @error('borrower_num_placeholder') is-invalid @enderror" 
                                                   placeholder="Enter borrower number format" name="borrower_num_placeholder" id="inputGenerateBorrowerUniqueNumbers" 
                                                   value="{{ old('borrower_num_placeholder', $branch->borrower_num_placeholder ?? '') }}">
                                            <div class="form-text">Leave it empty if you do not need a Borrower Unique Number</div>
                                            @error('borrower_num_placeholder')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="inputGenerateLoanUniqueNumbers" class="form-label">Loan Unique Number (optional)</label>
                                            <input type="text" class="form-control @error('loan_num_placeholder') is-invalid @enderror" 
                                                   placeholder="Enter loan number format" name="loan_num_placeholder" id="inputGenerateLoanUniqueNumbers" 
                                                   value="{{ old('loan_num_placeholder', $branch->loan_num_placeholder ?? '') }}">
                                            <div class="form-text">Leave it empty if you would like the system to auto generate this</div>
                                            @error('loan_num_placeholder')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Branch Relationships Section -->
                                @if(isset($loanProducts) && isset($staff))
                                    <div class="form-section">
                                        <div class="section-header">Branch Relationships</div>
                                        
                                        <div class="mb-4">
                                            <label for="inputLoanProducts" class="form-label">Loan Products</label>
                                            <select class="form-control loan_products_select @error('loan_products_ids') is-invalid @enderror" 
                                                    name="loan_products_ids[]" id="inputLoanProducts" multiple>
                                                @foreach($loanProducts as $product)
                                                    <option value="{{ $product->id }}" 
                                                            {{ in_array($product->id, old('loan_products_ids', isset($branch) ? $branch->loanProducts->pluck('id')->toArray() : [])) ? 'selected' : '' }}>
                                                        {{ $product->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="form-text">Click in the box above to select multiple loan products.</div>
                                            @error('loan_products_ids')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="inputLoanOfficers" class="form-label">Loan Officers</label>
                                            <select class="form-control loan_officers_select @error('loan_officers_ids') is-invalid @enderror" 
                                                    name="loan_officers_ids[]" id="inputLoanOfficers" multiple>
                                                @foreach($staff as $officer)
                                                    <option value="{{ $officer->id }}" 
                                                            {{ in_array($officer->id, old('loan_officers_ids', isset($branch) ? $branch->loanOfficers->pluck('id')->toArray() : [])) ? 'selected' : '' }}>
                                                        {{ $officer->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="form-text">Click in the box above to select multiple loan officers.</div>
                                            @error('loan_officers_ids')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="inputRepaymentCollectors" class="form-label">Repayment Collectors</label>
                                            <select class="form-control repayment_collector_select @error('repayment_collector_ids') is-invalid @enderror" 
                                                    name="repayment_collector_ids[]" id="inputRepaymentCollectors" multiple>
                                                @foreach($staff as $collector)
                                                    <option value="{{ $collector->id }}" 
                                                            {{ in_array($collector->id, old('repayment_collector_ids', isset($branch) ? $branch->collectors->pluck('id')->toArray() : [])) ? 'selected' : '' }}>
                                                        {{ $collector->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="form-text">Click in the box above to select multiple repayment collectors.</div>
                                            @error('repayment_collector_ids')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            {{-- <div class="card-footer d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">Back</button>
                                <button type="submit" class="btn btn-primary submit-button">
                                    {{ isset($branch) ? 'Update Branch' : 'Create Branch' }}
                                </button>
                            </div> --}}