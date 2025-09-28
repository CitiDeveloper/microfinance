@extends('layouts.app')

@section('title', 'Add New Staff')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .section-header {
        border-bottom: 1px solid #eaeaea;
        padding-bottom: 0.5rem;
    }
    .card {
        border-radius: 0.5rem;
    }
    .form-label {
        margin-bottom: 0.5rem;
    }
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        min-height: 38px;
    }
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
</style>
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-user-plus me-2"></i>Add New Staff Member</h4>
                        <a href="{{ route('staff.index') }}" class="btn btn-light btn-sm">View All Staff</a>
                    </div>
                </div>
                
                <form action="{{ route('staff.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body p-4">
                        <!-- Required Fields Section -->
                        <div class="section-header mb-4">
                            <h5 class="text-primary mb-0"><i class="fas fa-asterisk text-danger me-2 small"></i>Required Information</h5>
                            <p class="text-muted">Please fill in all required fields</p>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Staff Role -->
                            <div class="col-md-6">
                                <label for="staff_role_id" class="form-label fw-semibold">Staff Role <span class="text-danger">*</span></label>
                                <select class="form-select @error('staff_role_id') is-invalid @enderror" name="staff_role_id" id="staff_role_id" required>
                                    <option value="">Select Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('staff_role_id') == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('staff_role_id')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                                <div class="mt-1">
                                    <a href="#" class="text-decoration-none small"><i class="fas fa-plus me-1"></i>Add/Edit Staff Roles</a>
                                </div>
                            </div>
                            
                            <!-- Payroll Branch -->
                            <div class="col-md-6">
                                <label for="staff_payroll_branch_id" class="form-label fw-semibold">Payroll Branch <span class="text-danger">*</span></label>
                                <select class="form-select @error('staff_payroll_branch_id') is-invalid @enderror" name="staff_payroll_branch_id" id="staff_payroll_branch_id" required>
                                    <option value="">Select Payroll Branch</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ old('staff_payroll_branch_id') == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->branch_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('staff_payroll_branch_id')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                                <small class="form-text text-muted">
                                    You can enter payroll for this staff member in this branch only
                                </small>
                            </div>
                        </div>

                        <!-- Access Branches -->
                        <div class="mb-4">
                            <label for="access_branches" class="form-label fw-semibold">Access to Branches <span class="text-danger">*</span></label>
                            <select data-placeholder="Select Branches" class="form-control branches_select @error('access_branches') is-invalid @enderror" 
                                    id="access_branches" name="access_branches[]" multiple required>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ in_array($branch->id, old('access_branches', [])) ? 'selected' : '' }}>
                                        {{ $branch->branch_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('access_branches')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                            <small class="form-text text-muted">
                                Click in the box above to select multiple branches. To remove all branches with a
                                single click, click on the <b>x</b> button on top right of the above box.
                            </small>
                        </div>

                        <!-- Personal Information -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label for="staff_firstname" class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="staff_firstname" class="form-control @error('staff_firstname') is-invalid @enderror" 
                                       id="staff_firstname" placeholder="First Name" value="{{ old('staff_firstname') }}" required>
                                @error('staff_firstname')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4">
                                <label for="staff_lastname" class="form-label fw-semibold">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="staff_lastname" class="form-control @error('staff_lastname') is-invalid @enderror" 
                                       id="staff_lastname" placeholder="Last Name" value="{{ old('staff_lastname') }}" required>
                                @error('staff_lastname')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4">
                                <label for="staff_gender" class="form-label fw-semibold">Gender <span class="text-danger">*</span></label>
                                <select class="form-select @error('staff_gender') is-invalid @enderror" name="staff_gender" required>
                                    <option value="Male" {{ old('staff_gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('staff_gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('staff_gender')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="staff_email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="staff_email" class="form-control @error('staff_email') is-invalid @enderror" 
                                       id="staff_email" placeholder="Email" value="{{ old('staff_email') }}" required>
                                @error('staff_email')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Optional Fields Section -->
                        <div class="section-header mb-4 mt-5">
                            <h5 class="text-primary mb-0"><i class="fas fa-cog me-2 small"></i>Additional Settings</h5>
                            <p class="text-muted">Optional preferences and settings</p>
                        </div>

                        <div class="mb-4">
                            <label for="staff_show_results" class="form-label fw-semibold">Show Results Per Page</label>
                            <select class="form-select @error('staff_show_results') is-invalid @enderror" name="staff_show_results" id="staff_show_results">
                                <option value="20" {{ old('staff_show_results', 20) == 20 ? 'selected' : '' }}>20</option>
                                <option value="50" {{ old('staff_show_results') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ old('staff_show_results') == 100 ? 'selected' : '' }}>100</option>
                                <option value="250" {{ old('staff_show_results') == 250 ? 'selected' : '' }}>250</option>
                                <option value="500" {{ old('staff_show_results') == 500 ? 'selected' : '' }}>500</option>
                            </select>
                            @error('staff_show_results')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                            <small class="form-text text-muted">
                                You can choose the number of records to show on pages like View Borrowers, View All Loans, and View Repayments.
                            </small>
                        </div>

                        <!-- Add more optional fields here following the same pattern -->

                    </div>
                    <div class="card-footer bg-light py-3">
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                                <i class="fas fa-arrow-left me-2"></i>Back
                            </button>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i>Create Staff Member
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.branches_select').select2({
            placeholder: "Select Branches",
            allowClear: true,
            width: '100%'
        });
        
        // Add focus styling to form controls
        $('.form-control, .form-select').focus(function() {
            $(this).parent().addClass('focused');
        }).blur(function() {
            $(this).parent().removeClass('focused');
        });
    });
</script>
@endsection

