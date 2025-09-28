@extends('layouts.app')

@section('title', 'Add New Guarantor')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add New Guarantor</h3>
                    <div class="card-tools">
                        <a href="{{ route('guarantors.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Guarantors
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('guarantors.store') }}" method="POST" enctype="multipart/form-data" id="addGuarantorForm">
                        @csrf
                        
                        <div class="alert alert-info">
                            <strong>Note:</strong> All fields are optional but you must type at least <b>First Name</b> and <b>Middle / Last Name</b> <u>or</u> <b>Business Name</b>.
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name">First Name *</label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                           id="first_name" name="first_name" 
                                           value="{{ old('first_name') }}" 
                                           placeholder="Enter First Name Only">
                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name">Middle / Last Name *</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                           id="last_name" name="last_name" 
                                           value="{{ old('last_name') }}" 
                                           placeholder="Middle and Last Name">
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="text-center my-3">
                            <p class="font-weight-bold"><i>AND/OR</i></p>
                        </div>

                        <div class="form-group">
                            <label for="business_name">Business Name</label>
                            <input type="text" class="form-control @error('business_name') is-invalid @enderror" 
                                   id="business_name" name="business_name" 
                                   value="{{ old('business_name') }}" 
                                   placeholder="Business Name">
                            @error('business_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <hr>
                        <h5 class="text-primary mb-4"><b>All of the below fields are optional:</b></h5>

                        <div class="form-group">
                            <label for="unique_number">Unique Number</label>
                            <input type="text" class="form-control @error('unique_number') is-invalid @enderror" 
                                   id="unique_number" name="unique_number" 
                                   value="{{ old('unique_number') }}" 
                                   placeholder="Unique Number">
                            <small class="form-text text-muted">
                                You can enter unique number to identify the guarantor such as Social Security Number, License #, Registration Id....
                            </small>
                            @error('unique_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select class="form-control @error('gender') is-invalid @enderror" 
                                            id="gender" name="gender">
                                        <option value="">Select Gender</option>
                                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                        <option value="Nonbinary" {{ old('gender') == 'Nonbinary' ? 'selected' : '' }}>Nonbinary</option>
                                        <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                                        <option value="Decline to state" {{ old('gender') == 'Decline to state' ? 'selected' : '' }}>Decline to state</option>
                                    </select>
                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <select class="form-control @error('title') is-invalid @enderror" 
                                            id="title" name="title">
                                        <option value="">Select Title</option>
                                        <option value="Mr." {{ old('title') == 'Mr.' ? 'selected' : '' }}>Mr.</option>
                                        <option value="Mrs." {{ old('title') == 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
                                        <option value="Miss" {{ old('title') == 'Miss' ? 'selected' : '' }}>Miss</option>
                                        <option value="Ms." {{ old('title') == 'Ms.' ? 'selected' : '' }}>Ms.</option>
                                        <option value="Dr." {{ old('title') == 'Dr.' ? 'selected' : '' }}>Dr.</option>
                                        <option value="Prof." {{ old('title') == 'Prof.' ? 'selected' : '' }}>Prof.</option>
                                        <option value="Rev." {{ old('title') == 'Rev.' ? 'selected' : '' }}>Rev.</option>
                                    </select>
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mobile">Mobile</label>
                                    <input type="text" class="form-control @error('mobile') is-invalid @enderror" 
                                           id="mobile" name="mobile" 
                                           value="{{ old('mobile') }}" 
                                           placeholder="Numbers Only">
                                    <small class="form-text text-muted">
                                        <b><u>Do not</u> put country code, spaces, or characters</b> in mobile otherwise you won't be able to send SMS to this mobile.
                                    </small>
                                    @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" 
                                           value="{{ old('email') }}" 
                                           placeholder="Email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="date_of_birth">Date of Birth</label>
                            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                   id="date_of_birth" name="date_of_birth" 
                                   value="{{ old('date_of_birth') }}">
                            @error('date_of_birth')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                   id="address" name="address" 
                                   value="{{ old('address') }}" 
                                   placeholder="Address">
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                           id="city" name="city" 
                                           value="{{ old('city') }}" 
                                           placeholder="City">
                                    @error('city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="province">Province / State</label>
                                    <input type="text" class="form-control @error('province') is-invalid @enderror" 
                                           id="province" name="province" 
                                           value="{{ old('province') }}" 
                                           placeholder="Province or State">
                                    @error('province')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="zipcode">Zipcode</label>
                                    <input type="text" class="form-control @error('zipcode') is-invalid @enderror" 
                                           id="zipcode" name="zipcode" 
                                           value="{{ old('zipcode') }}" 
                                           placeholder="Zipcode">
                                    @error('zipcode')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="landline">Landline Phone</label>
                            <input type="text" class="form-control @error('landline') is-invalid @enderror" 
                                   id="landline" name="landline" 
                                   value="{{ old('landline') }}" 
                                   placeholder="Landline Phone">
                            @error('landline')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="working_status">Working Status</label>
                            <select class="form-control @error('working_status') is-invalid @enderror" 
                                    id="working_status" name="working_status">
                                <option value="">Select Working Status</option>
                                <option value="Employee" {{ old('working_status') == 'Employee' ? 'selected' : '' }}>Employee</option>
                                <option value="Government Employee" {{ old('working_status') == 'Government Employee' ? 'selected' : '' }}>Government Employee</option>
                                <option value="Private Sector Employee" {{ old('working_status') == 'Private Sector Employee' ? 'selected' : '' }}>Private Sector Employee</option>
                                <option value="Owner" {{ old('working_status') == 'Owner' ? 'selected' : '' }}>Owner</option>
                                <option value="Student" {{ old('working_status') == 'Student' ? 'selected' : '' }}>Student</option>
                                <option value="Overseas Worker" {{ old('working_status') == 'Overseas Worker' ? 'selected' : '' }}>Overseas Worker</option>
                                <option value="Pensioner" {{ old('working_status') == 'Pensioner' ? 'selected' : '' }}>Pensioner</option>
                                <option value="Unemployed" {{ old('working_status') == 'Unemployed' ? 'selected' : '' }}>Unemployed</option>
                            </select>
                            @error('working_status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="photo">Guarantor Photo</label>
                            <input type="file" class="form-control-file @error('photo') is-invalid @enderror" 
                                   id="photo" name="photo" accept="image/*">
                            @error('photo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="files">Guarantor Files</label>
                            <input type="file" class="form-control-file @error('files') is-invalid @enderror" 
                                   id="files" name="files[]" multiple>
                            @error('files')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" 
                                      rows="3" placeholder="Enter description">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="branch_id">Branch</label>
                            <select class="form-control @error('branch_id') is-invalid @enderror" 
                                    id="branch_id" name="branch_id" required>
                                <option value="">Select Branch</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('branch_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Guarantor
                            </button>
                            <a href="{{ route('guarantors.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form validation
        const form = document.getElementById('addGuarantorForm');
        
        form.addEventListener('submit', function(e) {
            const firstName = document.getElementById('first_name').value;
            const lastName = document.getElementById('last_name').value;
            const businessName = document.getElementById('business_name').value;
            
            if ((!firstName || !lastName) && !businessName) {
                e.preventDefault();
                alert('Please enter either both First Name and Last Name OR Business Name.');
                return false;
            }
        });

        // Mobile number validation (numbers only)
        const mobileInput = document.getElementById('mobile');
        mobileInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
</script>
@endsection