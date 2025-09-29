<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --border: #e9ecef;
        }
        
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 24px;
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid var(--border);
            padding: 20px 25px;
            border-radius: 12px 12px 0 0 !important;
        }
        
        .card-title {
            font-weight: 600;
            color: var(--dark);
            margin: 0;
            font-size: 1.4rem;
        }
        
        .section-title {
            color: var(--primary);
            font-weight: 600;
            margin: 25px 0 15px 0;
            padding-bottom: 8px;
            border-bottom: 1px solid rgba(67, 97, 238, 0.2);
            font-size: 1.1rem;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--dark);
            margin-bottom: 8px;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid var(--border);
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.15);
        }
        
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            border-radius: 8px;
            padding: 10px 25px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary);
            border-color: var(--secondary);
            transform: translateY(-1px);
        }
        
        .btn-outline-secondary {
            border-radius: 8px;
            padding: 10px 25px;
            font-weight: 500;
        }
        
        .logo-preview {
            max-height: 100px;
            border-radius: 8px;
            border: 1px solid var(--border);
            padding: 5px;
            background-color: white;
        }
        
        .settings-icon {
            color: var(--primary);
            margin-right: 10px;
            font-size: 1.1rem;
        }
        
        .alert-success {
            border-radius: 8px;
            border-left: 4px solid #28a745;
        }
        
        .card-footer {
            background-color: white;
            border-top: 1px solid var(--border);
            padding: 20px 25px;
            border-radius: 0 0 12px 12px;
        }
        
        .form-section {
            padding: 0 10px;
        }
        
        @media (max-width: 768px) {
            .form-section {
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-xxl-10 col-xl-11 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            <i class="fas fa-cog settings-icon"></i>System Settings
                        </h3>
                        <span class="badge bg-primary">Microfinance System</span>
                    </div>
                    
                    <div class="card-body p-4">
                        @if(session('success'))
                            <div class="alert alert-success d-flex align-items-center" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <div>{{ session('success') }}</div>
                            </div>
                        @endif

                        <form action="{{ route('system-settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row form-section">
                                <!-- Company Settings -->
                                <div class="col-12">
                                    <h5 class="section-title">
                                        <i class="fas fa-building me-2"></i>Company Settings
                                    </h5>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="company_name" class="form-label">Company Name</label>
                                    <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" 
                                           id="company_name" placeholder="Enter company name" value="{{ old('company_name', $settings->company_name) }}" required>
                                    @error('company_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="country" class="form-label">Country</label>
                                    <select class="form-select @error('country') is-invalid @enderror" name="country" id="country" required>
                                        <option value="">Select Country</option>
                                        @foreach($countries as $code => $name)
                                            <option value="{{ $code }}" {{ old('country', $settings->country) == $code ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="timezone" class="form-label">Timezone</label>
                                    <select class="form-select @error('timezone') is-invalid @enderror" name="timezone" id="timezone" required>
                                        <option value="">Select Timezone</option>
                                        @foreach($timezones as $tz)
                                            <option value="{{ $tz }}" {{ old('timezone', $settings->timezone) == $tz ? 'selected' : '' }}>
                                                {{ $tz }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('timezone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="currency" class="form-label">Currency</label>
                                    <select class="form-select @error('currency') is-invalid @enderror" name="currency" id="currency" required>
                                        <option value="">Select Currency</option>
                                        @foreach($currencies as $code => $display)
                                            <option value="{{ $code }}" {{ old('currency', $settings->currency) == $code ? 'selected' : '' }}>
                                                {{ $display }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('currency')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="currency_in_words" class="form-label">Currency In Words</label>
                                    <input type="text" name="currency_in_words" class="form-control @error('currency_in_words') is-invalid @enderror" 
                                           id="currency_in_words" value="{{ old('currency_in_words', $settings->currency_in_words) }}" placeholder="e.g., Dollars">
                                    @error('currency_in_words')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="date_format" class="form-label">Date Format</label>
                                    <input type="text" name="date_format" class="form-control @error('date_format') is-invalid @enderror" 
                                           id="date_format" value="{{ old('date_format', $settings->date_format) }}" placeholder="e.g., Y-m-d">
                                    @error('date_format')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="decimal_separator" class="form-label">Decimal Separator</label>
                                    <select name="decimal_separator" id="decimal_separator" class="form-select @error('decimal_separator') is-invalid @enderror">
                                        <option value="dot" {{ old('decimal_separator', $settings->decimal_separator) == 'dot' ? 'selected' : '' }}>Dot (.)</option>
                                        <option value="comma" {{ old('decimal_separator', $settings->decimal_separator) == 'comma' ? 'selected' : '' }}>Comma (,)</option>
                                    </select>
                                    @error('decimal_separator')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="thousand_separator" class="form-label">Thousand Separator</label>
                                    <select name="thousand_separator" id="thousand_separator" class="form-select @error('thousand_separator') is-invalid @enderror">
                                        <option value="comma" {{ old('thousand_separator', $settings->thousand_separator) == 'comma' ? 'selected' : '' }}>Comma (,)</option>
                                        <option value="dot" {{ old('thousand_separator', $settings->thousand_separator) == 'dot' ? 'selected' : '' }}>Dot (.)</option>
                                        <option value="space" {{ old('thousand_separator', $settings->thousand_separator) == 'space' ? 'selected' : '' }}>Space ( )</option>
                                    </select>
                                    @error('thousand_separator')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Loan Settings -->
                            <div class="row form-section mt-4">
                                <div class="col-12">
                                    <h5 class="section-title">
                                        <i class="fas fa-hand-holding-usd me-2"></i>Loan Settings
                                    </h5>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="monthly_repayment_cycle" class="form-label">Monthly Repayment Cycle</label>
                                    <select name="monthly_repayment_cycle" class="form-select @error('monthly_repayment_cycle') is-invalid @enderror">
                                        @foreach(['Actual Days in a Month','Same Day Every Month','31','30','28'] as $option)
                                            <option value="{{ $option }}" {{ old('monthly_repayment_cycle', $settings->monthly_repayment_cycle) == $option ? 'selected' : '' }}>
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('monthly_repayment_cycle')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="yearly_repayment_cycle" class="form-label">Yearly Repayment Cycle</label>
                                    <select name="yearly_repayment_cycle" class="form-select @error('yearly_repayment_cycle') is-invalid @enderror">
                                        @foreach(['Actual Days in a Year','Same Day Every Year','365','360'] as $option)
                                            <option value="{{ $option }}" {{ old('yearly_repayment_cycle', $settings->yearly_repayment_cycle) == $option ? 'selected' : '' }}>
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('yearly_repayment_cycle')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="days_in_month_interest" class="form-label">Days in Month for Interest</label>
                                    <select name="days_in_month_interest" class="form-select @error('days_in_month_interest') is-invalid @enderror">
                                        @foreach(['31','30','28'] as $option)
                                            <option value="{{ $option }}" {{ old('days_in_month_interest', $settings->days_in_month_interest) == $option ? 'selected' : '' }}>
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('days_in_month_interest')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="days_in_year_interest" class="form-label">Days in Year for Interest</label>
                                    <select name="days_in_year_interest" class="form-select @error('days_in_year_interest') is-invalid @enderror">
                                        @foreach(['360','365'] as $option)
                                            <option value="{{ $option }}" {{ old('days_in_year_interest', $settings->days_in_year_interest) == $option ? 'selected' : '' }}>
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('days_in_year_interest')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Business Details -->
                            <div class="row form-section mt-4">
                                <div class="col-12">
                                    <h5 class="section-title">
                                        <i class="fas fa-file-invoice me-2"></i>Business Details
                                    </h5>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="business_registration_number" class="form-label">Business Registration Number</label>
                                    <input type="text" name="business_registration_number" class="form-control @error('business_registration_number') is-invalid @enderror" 
                                           id="business_registration_number" value="{{ old('business_registration_number', $settings->business_registration_number) }}" placeholder="Registration number">
                                    @error('business_registration_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-12 mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3" placeholder="Business address">{{ old('address', $settings->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" 
                                           value="{{ old('city', $settings->city) }}" placeholder="City">
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="province" class="form-label">Province/State</label>
                                    <input type="text" name="province" class="form-control @error('province') is-invalid @enderror" 
                                           value="{{ old('province', $settings->province) }}" placeholder="Province or state">
                                    @error('province')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="zipcode" class="form-label">Zip Code</label>
                                    <input type="text" name="zipcode" class="form-control @error('zipcode') is-invalid @enderror" 
                                           value="{{ old('zipcode', $settings->zipcode) }}" placeholder="Postal code">
                                    @error('zipcode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-12 mb-3">
                                    <label for="company_logo" class="form-label">Company Logo</label>
                                    <div class="d-flex align-items-center">
                                        @if($settings->company_logo)
                                            <div class="me-3">
                                                <img src="{{ Storage::url($settings->company_logo) }}" alt="Company Logo" class="logo-preview">
                                            </div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <input type="file" name="company_logo" class="form-control @error('company_logo') is-invalid @enderror" id="company_logo">
                                            <div class="form-text">The logo will be displayed on receipts, statements, and reports. Recommended size: 200x60px.</div>
                                            @error('company_logo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-footer px-0 pb-0 bg-transparent border-0 mt-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="reset" class="btn btn-outline-secondary">
                                        <i class="fas fa-undo me-2"></i>Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add some interactivity
        document.addEventListener('DOMContentLoaded', function() {
            // Add focus effect to form controls
            const formControls = document.querySelectorAll('.form-control, .form-select');
            formControls.forEach(control => {
                control.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                
                control.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });
            });
            
            // Preview logo before upload
            const logoInput = document.getElementById('company_logo');
            if (logoInput) {
                logoInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const preview = document.querySelector('.logo-preview');
                            if (preview) {
                                preview.src = e.target.result;
                            } else {
                                const logoContainer = document.querySelector('.d-flex.align-items-center');
                                const newPreview = document.createElement('img');
                                newPreview.src = e.target.result;
                                newPreview.className = 'logo-preview me-3';
                                logoContainer.insertBefore(newPreview, logoContainer.firstChild);
                            }
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
</body>
</html>