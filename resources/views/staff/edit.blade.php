@extends('layouts.app')

@section('title', 'Edit Staff')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Staff Member</h3>
                </div>
                <form action="{{ route('staff.update', $staff) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <!-- Similar to create form but with existing values -->
                        <div class="alert alert-info">
                            <h5><i class="icon fas fa-info"></i> Required Fields</h5>
                        </div>

                        <div class="form-group row">
                            <label for="staff_role_id" class="col-sm-3 col-form-label">Staff Role</label>
                            <div class="col-sm-5">
                                <select class="form-control @error('staff_role_id') is-invalid @enderror" name="staff_role_id" id="staff_role_id" required>
                                    <option value="">Select Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('staff_role_id', $staff->staff_role_id) == $role->id ? 'selected' : '' }}>
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
                        </div>

                        <!-- Include all other fields similar to create form but with existing values -->
                        
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-default" onclick="window.history.back()">Back</button>
                        <button type="submit" class="btn btn-info float-right">Update</button>
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