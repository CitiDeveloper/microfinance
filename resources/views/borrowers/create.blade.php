@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>{{ isset($borrower) ? 'Edit Borrower' : 'Create New Borrower' }}</h2>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ isset($borrower) ? route('borrowers.update', $borrower) : route('borrowers.store') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($borrower))
                @method('PUT')
            @endif

            <!-- Required Fields Section -->
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <strong>Required Fields</strong>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label for="county" class="col-sm-3 col-form-label">County</label>
                        <div class="col-sm-9">
                            <select class="form-control @error('county') is-invalid @enderror" name="county" id="county" required>
                                <option value="">-- Select County --</option>
                                @foreach([
                                    'Baringo', 'Bomet', 'Bungoma', 'Busia', 'Elgeyo-Marakwet',
                                    'Embu', 'Garissa', 'Homa Bay', 'Isiolo', 'Kajiado',
                                    'Kakamega', 'Kericho', 'Kiambu', 'Kilifi', 'Kirinyaga',
                                    'Kisii', 'Kisumu', 'Kitui', 'Kwale', 'Laikipia',
                                    'Lamu', 'Machakos', 'Makueni', 'Mandera', 'Marsabit',
                                    'Meru', 'Migori', 'Mombasa', 'Murang\'a', 'Nairobi',
                                    'Nakuru', 'Nandi', 'Narok', 'Nyamira', 'Nyandarua',
                                    'Nyeri', 'Samburu', 'Siaya', 'Taita-Taveta', 'Tana River',
                                    'Tharaka-Nithi', 'Trans Nzoia', 'Turkana', 'Uasin Gishu',
                                    'Vihiga', 'Wajir', 'West Pokot'
                                ] as $county)
                                    <option value="{{ $county }}" {{ old('county', $borrower->county ?? '') == $county ? 'selected' : '' }}>
                                        {{ $county }}
                                    </option>
                                @endforeach
                            </select>
                            @error('county')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Optional Fields Section -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <strong>Optional Fields</strong>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <p><strong>All fields are optional</strong> but you must type at least <strong>First Name</strong> <u>or</u> <strong>Business Name</strong>.</p>
                    </div>

                    <!-- Personal Information -->
                    <div class="row mb-3">
                        <label for="first_name" class="col-sm-3 col-form-label">First Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                   name="first_name" id="first_name" 
                                   value="{{ old('first_name', $borrower->first_name ?? '') }}" 
                                   placeholder="Enter First Name Only">
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="last_name" class="col-sm-3 col-form-label">Middle / Last Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                   name="last_name" id="last_name" 
                                   value="{{ old('last_name', $borrower->last_name ?? '') }}" 
                                   placeholder="Middle and Last Name">
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-9 offset-sm-3">
                            <em>AND/OR</em>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="business_name" class="col-sm-3 col-form-label">Business Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('business_name') is-invalid @enderror" 
                                   name="business_name" id="business_name" 
                                   value="{{ old('business_name', $borrower->business_name ?? '') }}" 
                                   placeholder="Business Name">
                            @error('business_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>
                    <p class="text-primary"><strong>All of the below fields are optional:</strong></p>

                    <!-- Additional Information -->
                    <div class="row mb-3">
                        <label for="unique_number" class="col-sm-3 col-form-label">Unique Number</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control @error('unique_number') is-invalid @enderror" 
                                   name="unique_number" id="unique_number" 
                                   value="{{ old('unique_number', $borrower->unique_number ?? '') }}" 
                                   placeholder="Unique Number">
                            <small class="form-text text-muted">
                                You can enter unique number to identify the borrower such as Social Security Number, License #, Registration Id....
                            </small>
                            @error('unique_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="gender" class="col-sm-3 col-form-label">Gender</label>
                        <div class="col-sm-9">
                            <select class="form-control @error('gender') is-invalid @enderror" name="gender" id="gender">
                                <option value="">-- Select Gender --</option>
                                <option value="Male" {{ old('gender', $borrower->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender', $borrower->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Nonbinary" {{ old('gender', $borrower->gender ?? '') == 'Nonbinary' ? 'selected' : '' }}>Nonbinary</option>
                                <option value="Other" {{ old('gender', $borrower->gender ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                                <option value="Decline to state" {{ old('gender', $borrower->gender ?? '') == 'Decline to state' ? 'selected' : '' }}>Decline to state</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="title" class="col-sm-3 col-form-label">Title</label>
                        <div class="col-sm-9">
                            <select class="form-control @error('title') is-invalid @enderror" name="title" id="title">
                                <option value="">-- Select Title --</option>
                                <option value="Mr." {{ old('title', $borrower->title ?? '') == 'Mr.' ? 'selected' : '' }}>Mr.</option>
                                <option value="Mrs." {{ old('title', $borrower->title ?? '') == 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
                                <option value="Miss" {{ old('title', $borrower->title ?? '') == 'Miss' ? 'selected' : '' }}>Miss</option>
                                <option value="Ms." {{ old('title', $borrower->title ?? '') == 'Ms.' ? 'selected' : '' }}>Ms.</option>
                                <option value="Dr." {{ old('title', $borrower->title ?? '') == 'Dr.' ? 'selected' : '' }}>Dr.</option>
                                <option value="Prof." {{ old('title', $borrower->title ?? '') == 'Prof.' ? 'selected' : '' }}>Prof.</option>
                                <option value="Rev." {{ old('title', $borrower->title ?? '') == 'Rev.' ? 'selected' : '' }}>Rev.</option>
                            </select>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="row mb-3">
                        <div class="col-sm-9 offset-sm-3">
                            <div class="alert alert-warning">
                                <strong>Do not put country code, spaces, or characters</strong> in the below mobile otherwise you won't be able to send SMS to the mobile.
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="mobile" class="col-sm-3 col-form-label">Mobile</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('mobile') is-invalid @enderror" 
                                   name="mobile" id="mobile" 
                                   value="{{ old('mobile', $borrower->mobile ?? '') }}" 
                                   placeholder="Numbers Only">
                            @error('mobile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" id="email" 
                                   value="{{ old('email', $borrower->email ?? '') }}" 
                                   placeholder="Email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="date_of_birth" class="col-sm-3 col-form-label">Date of Birth</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                   name="date_of_birth" id="date_of_birth" 
                                   value="{{ old('date_of_birth', $borrower->date_of_birth ?? '') }}">
                            @error('date_of_birth')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="row mb-3">
                        <label for="address" class="col-sm-3 col-form-label">Address</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                   name="address" id="address" 
                                   value="{{ old('address', $borrower->address ?? '') }}" 
                                   placeholder="Address">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="city" class="col-sm-3 col-form-label">City</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                   name="city" id="city" 
                                   value="{{ old('city', $borrower->city ?? '') }}" 
                                   placeholder="City">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="province" class="col-sm-3 col-form-label">Province / State</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('province') is-invalid @enderror" 
                                   name="province" id="province" 
                                   value="{{ old('province', $borrower->province ?? '') }}" 
                                   placeholder="Province or State">
                            @error('province')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="zipcode" class="col-sm-3 col-form-label">Zipcode</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('zipcode') is-invalid @enderror" 
                                   name="zipcode" id="zipcode" 
                                   value="{{ old('zipcode', $borrower->zipcode ?? '') }}" 
                                   placeholder="Zipcode">
                            @error('zipcode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="landline" class="col-sm-3 col-form-label">Landline Phone</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('landline') is-invalid @enderror" 
                                   name="landline" id="landline" 
                                   value="{{ old('landline', $borrower->landline ?? '') }}" 
                                   placeholder="Landline Phone">
                            @error('landline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Employment and Financial Information -->
                    <div class="row mb-3">
                        <label for="working_status" class="col-sm-3 col-form-label">Working Status</label>
                        <div class="col-sm-9">
                            <select class="form-control @error('working_status') is-invalid @enderror" name="working_status" id="working_status">
                                <option value="">-- Select Working Status --</option>
                                <option value="Employee" {{ old('working_status', $borrower->working_status ?? '') == 'Employee' ? 'selected' : '' }}>Employee</option>
                                <option value="Government Employee" {{ old('working_status', $borrower->working_status ?? '') == 'Government Employee' ? 'selected' : '' }}>Government Employee</option>
                                <option value="Private Sector Employee" {{ old('working_status', $borrower->working_status ?? '') == 'Private Sector Employee' ? 'selected' : '' }}>Private Sector Employee</option>
                                <option value="Owner" {{ old('working_status', $borrower->working_status ?? '') == 'Owner' ? 'selected' : '' }}>Owner</option>
                                <option value="Student" {{ old('working_status', $borrower->working_status ?? '') == 'Student' ? 'selected' : '' }}>Student</option>
                                <option value="Overseas Worker" {{ old('working_status', $borrower->working_status ?? '') == 'Overseas Worker' ? 'selected' : '' }}>Overseas Worker</option>
                                <option value="Pensioner" {{ old('working_status', $borrower->working_status ?? '') == 'Pensioner' ? 'selected' : '' }}>Pensioner</option>
                                <option value="Unemployed" {{ old('working_status', $borrower->working_status ?? '') == 'Unemployed' ? 'selected' : '' }}>Unemployed</option>
                            </select>
                            @error('working_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="credit_score" class="col-sm-3 col-form-label">Credit Score</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control @error('credit_score') is-invalid @enderror" 
                                   name="credit_score" id="credit_score" 
                                   value="{{ old('credit_score', $borrower->credit_score ?? '') }}" 
                                   placeholder="Credit Score" min="0" max="1000">
                            @error('credit_score')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="row mb-3">
                        <label for="description" class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9">
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      name="description" id="description" 
                                      rows="5" placeholder="Description">{{ old('description', $borrower->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="row">
                <div class="col-sm-9 offset-sm-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ isset($borrower) ? 'Update Borrower' : 'Create Borrower' }}
                    </button>
                    <a href="{{ route('borrowers.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection