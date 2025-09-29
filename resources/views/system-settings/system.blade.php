@extends('layouts.app')

@section('title', 'System Settings')
<style>
    .settings-section {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 1.5rem 1.75rem;
        transition: all 0.3s ease;
    }
    
    .settings-section:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    
    .section-header h5 {
        font-weight: 600;
    }
    
    .icon-wrapper {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label {
        color: #6c757d;
        font-weight: 500;
    }
    
    .card-header.bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
    }
    
    .logo-preview {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 8px;
        background: white;
    }
    
    @media (max-width: 768px) {
        .settings-section {
            padding: 1.25rem 1.5rem;
        }
        
        .page-header {
            text-align: center;
        }
        
        .page-header .d-flex {
            flex-direction: column;
            gap: 1rem;
        }
    }
</style>
@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-xxl-10 col-lg-12">

            <!-- Page Header -->
            {{-- <div class="page-header mb-4">
                <div class="d-flex justify-content-between align-items-center">
                   
                    <span class="badge bg-primary-subtle text-primary fs-6 py-2 px-3">
                        <i class="fas fa-shield-alt me-1"></i>Microfinance System
                    </span>
                </div>
            </div> --}}

            <!-- System Settings Card -->
            <div class="card shadow-sm border-0 rounded-lg overflow-hidden">
                <!-- Card Header -->
                <div class="card-header bg-gradient-primary text-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-sliders-h me-2 text-white"></i> <span class="text-white">Configuration Panel</span>
                    </h5>
                </div>

                <div class="card-body p-4 p-md-1">
                   
                    <form action="{{ route('system-settings.update') }}" method="POST" enctype="multipart/form-data" id="settingsForm">
                        @csrf
                        @method('PUT')

                        <!-- Company Settings Section -->
                        <div class="settings-section mb-5">
                            <div class="section-header mb-4">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper bg-primary bg-opacity-10 p-2 rounded me-3">
                                        <i class="fas fa-building text-primary fs-5"></i>
                                    </div>
                                    <h5 class="mb-0 text-dark">Company Settings</h5>
                                </div>
                                <hr class="mt-2">
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" 
                                               id="companyName" placeholder="Company Name" 
                                               value="{{ old('company_name', $settings->company_name) }}" required>
                                        <label for="companyName" class="form-label">Company Name</label>
                                        @error('company_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="country" class="form-select @error('country') is-invalid @enderror" 
                                                id="country" required>
                                            <option value="">Select Country</option>
                                            @foreach($countries as $code => $name)
                                                <option value="{{ $code }}" {{ old('country', $settings->country) == $code ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="country" class="form-label">Country</label>
                                        @error('country')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="timezone" class="form-select @error('timezone') is-invalid @enderror" 
                                                id="timezone" required>
                                            <option value="">Select Timezone</option>
                                            @foreach($timezones as $tz)
                                                <option value="{{ $tz }}" {{ old('timezone', $settings->timezone) == $tz ? 'selected' : '' }}>
                                                    {{ $tz }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="timezone" class="form-label">Timezone</label>
                                        @error('timezone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="currency" class="form-select @error('currency') is-invalid @enderror" 
                                                id="currency" required>
                                            <option value="">Select Currency</option>
                                            @foreach($currencies as $code => $display)
                                                <option value="{{ $code }}" {{ old('currency', $settings->currency) == $code ? 'selected' : '' }}>
                                                    {{ $display }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="currency" class="form-label">Currency</label>
                                        @error('currency')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="currency_in_words" class="form-control @error('currency_in_words') is-invalid @enderror" 
                                               id="currencyInWords" placeholder="Currency in Words" 
                                               value="{{ old('currency_in_words', $settings->currency_in_words) }}">
                                        <label for="currencyInWords" class="form-label">Currency In Words</label>
                                        <div class="form-text">e.g., Dollars, Pounds, Euros</div>
                                        @error('currency_in_words')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="date_format" class="form-control @error('date_format') is-invalid @enderror" 
                                               id="dateFormat" placeholder="Date Format" 
                                               value="{{ old('date_format', $settings->date_format) }}">
                                        <label for="dateFormat" class="form-label">Date Format</label>
                                        <div class="form-text">e.g., Y-m-d, d/m/Y, m/d/Y</div>
                                        @error('date_format')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="decimal_separator" class="form-select @error('decimal_separator') is-invalid @enderror" 
                                                id="decimalSeparator">
                                            <option value="dot" {{ old('decimal_separator', $settings->decimal_separator) == 'dot' ? 'selected' : '' }}>Dot (.)</option>
                                            <option value="comma" {{ old('decimal_separator', $settings->decimal_separator) == 'comma' ? 'selected' : '' }}>Comma (,)</option>
                                        </select>
                                        <label for="decimalSeparator" class="form-label">Decimal Separator</label>
                                        @error('decimal_separator')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="thousand_separator" class="form-select @error('thousand_separator') is-invalid @enderror" 
                                                id="thousandSeparator">
                                            <option value="comma" {{ old('thousand_separator', $settings->thousand_separator) == 'comma' ? 'selected' : '' }}>Comma (,)</option>
                                            <option value="dot" {{ old('thousand_separator', $settings->thousand_separator) == 'dot' ? 'selected' : '' }}>Dot (.)</option>
                                            <option value="space" {{ old('thousand_separator', $settings->thousand_separator) == 'space' ? 'selected' : '' }}>Space ( )</option>
                                        </select>
                                        <label for="thousandSeparator" class="form-label">Thousand Separator</label>
                                        @error('thousand_separator')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Loan Settings Section -->
                        <div class="settings-section mb-5">
                            <div class="section-header mb-4">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper bg-success bg-opacity-10 p-2 rounded me-3">
                                        <i class="fas fa-hand-holding-usd text-success fs-5"></i>
                                    </div>
                                    <h5 class="mb-0 text-dark">Loan Settings</h5>
                                </div>
                                <hr class="mt-2">
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="monthly_repayment_cycle" class="form-select @error('monthly_repayment_cycle') is-invalid @enderror" 
                                                id="monthlyRepaymentCycle">
                                            @foreach(['Actual Days in a Month','Same Day Every Month','31','30','28'] as $option)
                                                <option value="{{ $option }}" {{ old('monthly_repayment_cycle', $settings->monthly_repayment_cycle) == $option ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="monthlyRepaymentCycle" class="form-label">Monthly Repayment Cycle</label>
                                        @error('monthly_repayment_cycle')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="yearly_repayment_cycle" class="form-select @error('yearly_repayment_cycle') is-invalid @enderror" 
                                                id="yearlyRepaymentCycle">
                                            @foreach(['Actual Days in a Year','Same Day Every Year','365','360'] as $option)
                                                <option value="{{ $option }}" {{ old('yearly_repayment_cycle', $settings->yearly_repayment_cycle) == $option ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="yearlyRepaymentCycle" class="form-label">Yearly Repayment Cycle</label>
                                        @error('yearly_repayment_cycle')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="days_in_month_interest" class="form-select @error('days_in_month_interest') is-invalid @enderror" 
                                                id="daysInMonthInterest">
                                            @foreach(['31','30','28'] as $option)
                                                <option value="{{ $option }}" {{ old('days_in_month_interest', $settings->days_in_month_interest) == $option ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="daysInMonthInterest" class="form-label">Days in Month for Interest</label>
                                        @error('days_in_month_interest')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="days_in_year_interest" class="form-select @error('days_in_year_interest') is-invalid @enderror" 
                                                id="daysInYearInterest">
                                            @foreach(['360','365'] as $option)
                                                <option value="{{ $option }}" {{ old('days_in_year_interest', $settings->days_in_year_interest) == $option ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="daysInYearInterest" class="form-label">Days in Year for Interest</label>
                                        @error('days_in_year_interest')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Business Details Section -->
                        <div class="settings-section mb-5">
                            <div class="section-header mb-4">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper bg-info bg-opacity-10 p-2 rounded me-3">
                                        <i class="fas fa-file-invoice text-info fs-5"></i>
                                    </div>
                                    <h5 class="mb-0 text-dark">Business Details</h5>
                                </div>
                                <hr class="mt-2">
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="business_registration_number" class="form-control @error('business_registration_number') is-invalid @enderror" 
                                               id="businessRegistrationNumber" placeholder="Business Registration Number" 
                                               value="{{ old('business_registration_number', $settings->business_registration_number) }}">
                                        <label for="businessRegistrationNumber" class="form-label">Business Registration Number</label>
                                        @error('business_registration_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" 
                                                  id="address" placeholder="Address" style="height: 120px">{{ old('address', $settings->address) }}</textarea>
                                        <label for="address" class="form-label">Address</label>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" 
                                               id="city" placeholder="City" 
                                               value="{{ old('city', $settings->city) }}">
                                        <label for="city" class="form-label">City</label>
                                        @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" name="province" class="form-control @error('province') is-invalid @enderror" 
                                               id="province" placeholder="Province/State" 
                                               value="{{ old('province', $settings->province) }}">
                                        <label for="province" class="form-label">Province/State</label>
                                        @error('province')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" name="zipcode" class="form-control @error('zipcode') is-invalid @enderror" 
                                               id="zipcode" placeholder="Zip Code" 
                                               value="{{ old('zipcode', $settings->zipcode) }}">
                                        <label for="zipcode" class="form-label">Zip Code</label>
                                        @error('zipcode')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="companyLogo" class="form-label fw-semibold">Company Logo</label>
                                        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-4">
                                            @if($settings->company_logo)
                                                <div class="logo-preview">
                                                    <img src="{{ Storage::url($settings->company_logo) }}" alt="Company Logo" class="img-thumbnail" style="max-height: 100px;">
                                                </div>
                                            @endif
                                            <div class="flex-grow-1">
                                                <input type="file" name="company_logo" class="form-control @error('company_logo') is-invalid @enderror" 
                                                       id="companyLogo" accept="image/*">
                                                @error('company_logo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="form-text">
                                                    <i class="fas fa-info-circle me-1"></i>Recommended size: 200x60px. Displayed on receipts and reports.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions mt-5 pt-4 border-top">
                            <div class="d-flex justify-content-end gap-3">
                                <button type="reset" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-undo me-2"></i>Reset
                                </button>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>Update Settings
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection