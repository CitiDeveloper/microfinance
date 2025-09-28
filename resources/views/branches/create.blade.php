@extends('layouts.app')
<style>
    /* Custom CSS for Modern Branch Form */
:root {
    --primary-color: #3498db;
    --secondary-color: #2c3e50;
    --accent-color: #1abc9c;
    --light-gray: #f8f9fa;
    --border-color: #e9ecef;
    --success-color: #28a745;
    --warning-color: #ffc107;
}

.form-container {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
    padding: 2rem;
    margin-top: 2rem;
    margin-bottom: 2rem;
}

.form-header {
    border-bottom: 1px solid var(--border-color);
    padding-bottom: 1rem;
    margin-bottom: 1.5rem;
}

.section-header {
    background-color: var(--light-gray);
    padding: 0.75rem 1rem;
    border-radius: 5px;
    margin-bottom: 1.5rem;
    border-left: 4px solid var(--primary-color);
    font-weight: 600;
    color: var(--secondary-color);
}

.form-section {
    margin-bottom: 2.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--border-color);
}

.form-section:last-of-type {
    border-bottom: none;
}

.form-label {
    font-weight: 500;
    color: var(--secondary-color);
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border-radius: 0.375rem;
    padding: 0.75rem 1rem;
    border: 1px solid #ced4da;
    transition: all 0.15s ease-in-out;
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
}

.form-text {
    font-size: 0.875rem;
    margin-top: 0.375rem;
}

.info-card {
    background-color: #e8f4fc;
    border-left: 4px solid var(--primary-color);
    padding: 1rem;
    border-radius: 0.375rem;
    margin-bottom: 1.5rem;
}

.info-card p {
    margin-bottom: 0;
    color: var(--secondary-color);
}

.btn-primary {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    border-radius: 0.375rem;
}

.btn-primary:hover {
    background-color: #2980b9;
    border-color: #2980b9;
}

.btn-outline-secondary {
    border-color: #6c757d;
    color: #6c757d;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    border-radius: 0.375rem;
}

.btn-outline-secondary:hover {
    background-color: #6c757d;
    border-color: #6c757d;
    color: white;
}

.form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875rem;
    color: #dc3545;
}

.is-invalid {
    border-color: #dc3545;
}

.is-invalid:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

/* Custom select2 styling */
.select2-container--default .select2-selection--multiple {
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    min-height: 42px;
}

.select2-container--default.select2-container--focus .select2-selection--multiple {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
}

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: var(--primary-color);
    border: 1px solid var(--primary-color);
    border-radius: 0.25rem;
    color: white;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .form-container {
        padding: 1rem;
    }
    
    .section-header {
        font-size: 1rem;
    }
}
</style>

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Create Branch</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('branches.index') }}">Branches</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title">Branch Information</h6>
                        </div>
                        <form action="{{ route('branches.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                @include('branches._form')
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Create Branch</button>
                                <a href="{{ route('branches.index') }}" class="btn btn-default">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function() {
        // Initialize select2 for multiple select boxes
        $('.loan_products_select, .loan_officers_select, .repayment_collector_select').select2({
            placeholder: "Select options",
            allowClear: true,
            width: '100%'
        });

        // Show/hide account settings override fields
        $('#inputAccountSettingsOverride').change(function() {
            if ($(this).is(':checked')) {
                $('#inputCountry, #inputCurrency, #inputDateformat, #inputCurrencyInWords').prop('disabled', false);
            } else {
                $('#inputCountry, #inputCurrency, #inputDateformat, #inputCurrencyInWords').prop('disabled', true);
            }
        }).trigger('change');
    });
</script>
@endsection