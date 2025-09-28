@extends('layouts.app')

@section('title', 'Add New Staff')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add New Staff Member</h3>
                </div>
                <form action="{{ route('staff.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="alert alert-info">
                            <h5><i class="icon fas fa-info"></i> Required Fields</h5>
                        </div>

                        <div class="form-group row">
                            <label for="staff_role_id" class="col-sm-3 col-form-label">Staff Role</label>
                            <div class="col-sm-5">
                                <select class="form-control @error('staff_role_id') is-invalid @enderror" name="staff_role_id" id="staff_role_id" required>
                                    <option value="">Select Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('staff_role_id') == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('staff_role_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-sm-3">
                                <div class="pull-left" style="margin-top:5px">
                                    <a href="#" target="_blank">Add/Edit Staff Roles</a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="access_branches" class="col-sm-3 col-form-label">Access to Branches</label>
                            <div class="col-sm-9">
                                <select data-placeholder="Select Branches" class="form-control branches_select @error('access_branches') is-invalid @enderror" 
                                        id="access_branches" name="access_branches[]" multiple required>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ in_array($branch->id, old('access_branches', [])) ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('access_branches')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="form-text text-muted">
                                    Click in the box above to select multiple branches. To remove all branches with a
                                    single click, click on the <b>x</b> button on top right of the above box.
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="staff_payroll_branch_id" class="col-sm-3 col-form-label">Payroll Branch</label>
                            <div class="col-sm-5">
                                <select class="form-control @error('staff_payroll_branch_id') is-invalid @enderror" name="staff_payroll_branch_id" id="staff_payroll_branch_id" required>
                                    <option value="">Select Payroll Branch</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ old('staff_payroll_branch_id') == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('staff_payroll_branch_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="form-text text-muted">
                                    You can enter payroll for this staff member in this branch only
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="staff_firstname" class="col-sm-3 col-form-label">First Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="staff_firstname" class="form-control @error('staff_firstname') is-invalid @enderror" 
                                       id="staff_firstname" placeholder="First Name" value="{{ old('staff_firstname') }}" required>
                                @error('staff_firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="staff_lastname" class="col-sm-3 col-form-label">Middle / Last Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="staff_lastname" class="form-control @error('staff_lastname') is-invalid @enderror" 
                                       id="staff_lastname" placeholder="Last Name" value="{{ old('staff_lastname') }}" required>
                                @error('staff_lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="staff_email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" name="staff_email" class="form-control @error('staff_email') is-invalid @enderror" 
                                       id="staff_email" placeholder="Email" value="{{ old('staff_email') }}" required>
                                @error('staff_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="staff_gender" class="col-sm-3 col-form-label">Gender</label>
                            <div class="col-sm-4">
                                <select class="form-control @error('staff_gender') is-invalid @enderror" name="staff_gender" required>
                                    <option value="Male" {{ old('staff_gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('staff_gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('staff_gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <div class="alert alert-info">
                            <h5><i class="icon fas fa-info"></i> Optional Fields</h5>
                        </div>

                        <div class="form-group row">
                            <label for="staff_show_results" class="col-sm-3 col-form-label">Show Results Per Page</label>
                            <div class="col-sm-9">
                                <select class="form-control @error('staff_show_results') is-invalid @enderror" name="staff_show_results" id="staff_show_results">
                                    <option value="20" {{ old('staff_show_results', 20) == 20 ? 'selected' : '' }}>20</option>
                                    <option value="50" {{ old('staff_show_results') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ old('staff_show_results') == 100 ? 'selected' : '' }}>100</option>
                                    <option value="250" {{ old('staff_show_results') == 250 ? 'selected' : '' }}>250</option>
                                    <option value="500" {{ old('staff_show_results') == 500 ? 'selected' : '' }}>500</option>
                                </select>
                                @error('staff_show_results')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="form-text text-muted">
                                    You can choose the number of records to show on pages like View Borrowers, View All Loans, and View Repayments.
                                </small>
                            </div>
                        </div>

                        <!-- Add more optional fields here following the same pattern -->

                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-default" onclick="window.history.back()">Back</button>
                        <button type="submit" class="btn btn-info float-right">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.branches_select').select2({
            placeholder: "Select Branches",
            allowClear: true
        });
    });
</script>
@endpush