@extends('layouts.app')
<style>
    .card {
        border-radius: 0.5rem;
    }

    .card-header {
        border-radius: 0.5rem 0.5rem 0 0 !important;
    }

    .section-header {
        margin-top: 1.5rem;
    }

    .form-label {
        font-weight: 500;
    }

    .input-group-text {
        border-right: none;
    }

    .form-control:focus+.input-group-text,
    .form-select:focus+.input-group-text {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
</style>
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 text-white">
                                <i class="fas {{ isset($borrower) ? 'fa-edit' : 'fa-user-plus' }} me-2"></i>
                                {{ isset($borrower) ? 'Edit Borrower' : 'Create New Borrower' }}
                            </h4>
                            <a href="{{ route('borrowers.index') }}" class="btn btn-light btn-sm">
                                <i class="fas fa-arrow-left me-1"></i> Back to List
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form method="POST"
                            action="{{ isset($borrower) ? route('borrowers.update', $borrower) : route('borrowers.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @if (isset($borrower))
                                @method('PUT')
                            @endif

                            <!-- Required Fields Section -->
                            <div class="card mb-4 border-primary1">
                                <div class="card-header bg-primary bg-opacity-10 py-2">
                                    <h5 class="mb-0 text-primary">
                                        <i class="fas fa-asterisk text-danger me-1"></i>
                                        Required Information
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <label for="county" class="col-sm-3 col-form-label fw-bold">County <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <select class="form-select @error('county') is-invalid @enderror" name="county"
                                                id="county" required>
                                                <option value="">-- Select County --</option>
                                                @foreach (['Baringo', 'Bomet', 'Bungoma', 'Busia', 'Elgeyo-Marakwet', 'Embu', 'Garissa', 'Homa Bay', 'Isiolo', 'Kajiado', 'Kakamega', 'Kericho', 'Kiambu', 'Kilifi', 'Kirinyaga', 'Kisii', 'Kisumu', 'Kitui', 'Kwale', 'Laikipia', 'Lamu', 'Machakos', 'Makueni', 'Mandera', 'Marsabit', 'Meru', 'Migori', 'Mombasa', 'Murang\'a', 'Nairobi', 'Nakuru', 'Nandi', 'Narok', 'Nyamira', 'Nyandarua', 'Nyeri', 'Samburu', 'Siaya', 'Taita-Taveta', 'Tana River', 'Tharaka-Nithi', 'Trans Nzoia', 'Turkana', 'Uasin Gishu', 'Vihiga', 'Wajir', 'West Pokot'] as $county)
                                                    <option value="{{ $county }}"
                                                        {{ old('county', $borrower->county ?? '') == $county ? 'selected' : '' }}>
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
                                <div class="card-header bg-light py-2">
                                    <h5 class="mb-0">
                                        <i class="fas fa-info-circle text-info me-1"></i>
                                        Optional Information
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-info d-flex align-items-center">
                                        <i class="fas fa-exclamation-circle me-2 fs-5"></i>
                                        <div>
                                            <strong>All fields are optional</strong> but you must provide at least
                                            <strong>First Name</strong> <u>or</u> <strong>Business Name</strong>.
                                        </div>
                                    </div>

                                    <!-- Personal Information Section -->
                                    <div class="section-header mb-3">
                                        <h6 class="text-primary border-bottom pb-2">
                                            <i class="fas fa-user me-1"></i> Personal Information
                                        </h6>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="first_name" class="col-sm-3 col-form-label">First Name</label>
                                        <div class="col-sm-9">
                                            <input type="text"
                                                class="form-control @error('first_name') is-invalid @enderror"
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
                                            <input type="text"
                                                class="form-control @error('last_name') is-invalid @enderror"
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
                                            <div class="text-center text-muted fst-italic py-1">- OR -</div>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <label for="business_name" class="col-sm-3 col-form-label">Business Name</label>
                                        <div class="col-sm-9">
                                            <input type="text"
                                                class="form-control @error('business_name') is-invalid @enderror"
                                                name="business_name" id="business_name"
                                                value="{{ old('business_name', $borrower->business_name ?? '') }}"
                                                placeholder="Business Name">
                                            @error('business_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Additional Information Section -->
                                    <div class="section-header mb-3">
                                        <h6 class="text-primary border-bottom pb-2">
                                            <i class="fas fa-id-card me-1"></i> Additional Information
                                        </h6>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="unique_number" class="col-sm-3 col-form-label">Unique Number</label>
                                        <div class="col-sm-6">
                                            <input type="text"
                                                class="form-control @error('unique_number') is-invalid @enderror"
                                                name="unique_number" id="unique_number"
                                                value="{{ old('unique_number', $borrower->unique_number ?? '') }}"
                                                placeholder="Unique Number">
                                            <div class="form-text">
                                                You can enter unique number to identify the borrower such as Social Security
                                                Number, License #, Registration Id...
                                            </div>
                                            @error('unique_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="gender" class="col-sm-3 col-form-label">Gender</label>
                                        <div class="col-sm-9">
                                            <select class="form-select @error('gender') is-invalid @enderror" name="gender"
                                                id="gender">
                                                <option value="">-- Select Gender --</option>
                                                <option value="Male"
                                                    {{ old('gender', $borrower->gender ?? '') == 'Male' ? 'selected' : '' }}>
                                                    Male</option>
                                                <option value="Female"
                                                    {{ old('gender', $borrower->gender ?? '') == 'Female' ? 'selected' : '' }}>
                                                    Female</option>
                                                <option value="Nonbinary"
                                                    {{ old('gender', $borrower->gender ?? '') == 'Nonbinary' ? 'selected' : '' }}>
                                                    Nonbinary</option>
                                                <option value="Other"
                                                    {{ old('gender', $borrower->gender ?? '') == 'Other' ? 'selected' : '' }}>
                                                    Other</option>
                                                <option value="Decline to state"
                                                    {{ old('gender', $borrower->gender ?? '') == 'Decline to state' ? 'selected' : '' }}>
                                                    Decline to state</option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="title" class="col-sm-3 col-form-label">Title</label>
                                        <div class="col-sm-9">
                                            <select class="form-select @error('title') is-invalid @enderror"
                                                name="title" id="title">
                                                <option value="">-- Select Title --</option>
                                                <option value="Mr."
                                                    {{ old('title', $borrower->title ?? '') == 'Mr.' ? 'selected' : '' }}>
                                                    Mr.</option>
                                                <option value="Mrs."
                                                    {{ old('title', $borrower->title ?? '') == 'Mrs.' ? 'selected' : '' }}>
                                                    Mrs.</option>
                                                <option value="Miss"
                                                    {{ old('title', $borrower->title ?? '') == 'Miss' ? 'selected' : '' }}>
                                                    Miss</option>
                                                <option value="Ms."
                                                    {{ old('title', $borrower->title ?? '') == 'Ms.' ? 'selected' : '' }}>
                                                    Ms.</option>
                                                <option value="Dr."
                                                    {{ old('title', $borrower->title ?? '') == 'Dr.' ? 'selected' : '' }}>
                                                    Dr.</option>
                                                <option value="Prof."
                                                    {{ old('title', $borrower->title ?? '') == 'Prof.' ? 'selected' : '' }}>
                                                    Prof.</option>
                                                <option value="Rev."
                                                    {{ old('title', $borrower->title ?? '') == 'Rev.' ? 'selected' : '' }}>
                                                    Rev.</option>
                                            </select>
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Contact Information Section -->
                                    <div class="section-header mb-3">
                                        <h6 class="text-primary border-bottom pb-2">
                                            <i class="fas fa-address-book me-1"></i> Contact Information
                                        </h6>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-9 offset-sm-3">
                                            <div class="alert alert-warning d-flex align-items-center py-2">
                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                <div>
                                                    <strong>Important:</strong> Do not include country code, spaces, or
                                                    special characters in the mobile number field, otherwise SMS
                                                    functionality will not work.
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="mobile" class="col-sm-3 col-form-label">Mobile</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <span class="input-group-text bg-light">+254</span>
                                                <input type="text"
                                                    class="form-control @error('mobile') is-invalid @enderror"
                                                    name="mobile" id="mobile"
                                                    value="{{ old('mobile', $borrower->mobile ?? '') }}"
                                                    placeholder="Numbers Only">
                                            </div>
                                            @error('mobile')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                id="email" value="{{ old('email', $borrower->email ?? '') }}"
                                                placeholder="Email Address">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="date_of_birth" class="col-sm-3 col-form-label">Date of Birth</label>
                                        <div class="col-sm-9">
                                            <input type="date"
                                                class="form-control @error('date_of_birth') is-invalid @enderror"
                                                name="date_of_birth" id="date_of_birth"
                                                value="{{ old('date_of_birth', $borrower->date_of_birth ?? '') }}">
                                            @error('date_of_birth')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Address Information Section -->
                                    <div class="section-header mb-3">
                                        <h6 class="text-primary border-bottom pb-2">
                                            <i class="fas fa-home me-1"></i> Address Information
                                        </h6>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="address" class="col-sm-3 col-form-label">Address</label>
                                        <div class="col-sm-9">
                                            <input type="text"
                                                class="form-control @error('address') is-invalid @enderror"
                                                name="address" id="address"
                                                value="{{ old('address', $borrower->address ?? '') }}"
                                                placeholder="Street Address">
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="city" class="col-sm-3 col-form-label">City</label>
                                        <div class="col-sm-9">
                                            <input type="text"
                                                class="form-control @error('city') is-invalid @enderror" name="city"
                                                id="city" value="{{ old('city', $borrower->city ?? '') }}"
                                                placeholder="City">
                                            @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="province" class="col-sm-3 col-form-label">Province / State</label>
                                        <div class="col-sm-9">
                                            <input type="text"
                                                class="form-control @error('province') is-invalid @enderror"
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
                                            <input type="text"
                                                class="form-control @error('zipcode') is-invalid @enderror"
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
                                            <input type="text"
                                                class="form-control @error('landline') is-invalid @enderror"
                                                name="landline" id="landline"
                                                value="{{ old('landline', $borrower->landline ?? '') }}"
                                                placeholder="Landline Phone">
                                            @error('landline')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Employment and Financial Information Section -->
                                    <div class="section-header mb-3">
                                        <h6 class="text-primary border-bottom pb-2">
                                            <i class="fas fa-briefcase me-1"></i> Employment & Financial Information
                                        </h6>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="working_status" class="col-sm-3 col-form-label">Working Status</label>
                                        <div class="col-sm-9">
                                            <select class="form-select @error('working_status') is-invalid @enderror"
                                                name="working_status" id="working_status">
                                                <option value="">-- Select Working Status --</option>
                                                <option value="Employee"
                                                    {{ old('working_status', $borrower->working_status ?? '') == 'Employee' ? 'selected' : '' }}>
                                                    Employee</option>
                                                <option value="Government Employee"
                                                    {{ old('working_status', $borrower->working_status ?? '') == 'Government Employee' ? 'selected' : '' }}>
                                                    Government Employee</option>
                                                <option value="Private Sector Employee"
                                                    {{ old('working_status', $borrower->working_status ?? '') == 'Private Sector Employee' ? 'selected' : '' }}>
                                                    Private Sector Employee</option>
                                                <option value="Owner"
                                                    {{ old('working_status', $borrower->working_status ?? '') == 'Owner' ? 'selected' : '' }}>
                                                    Owner</option>
                                                <option value="Student"
                                                    {{ old('working_status', $borrower->working_status ?? '') == 'Student' ? 'selected' : '' }}>
                                                    Student</option>
                                                <option value="Overseas Worker"
                                                    {{ old('working_status', $borrower->working_status ?? '') == 'Overseas Worker' ? 'selected' : '' }}>
                                                    Overseas Worker</option>
                                                <option value="Pensioner"
                                                    {{ old('working_status', $borrower->working_status ?? '') == 'Pensioner' ? 'selected' : '' }}>
                                                    Pensioner</option>
                                                <option value="Unemployed"
                                                    {{ old('working_status', $borrower->working_status ?? '') == 'Unemployed' ? 'selected' : '' }}>
                                                    Unemployed</option>
                                            </select>
                                            @error('working_status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <label for="credit_score" class="col-sm-3 col-form-label">Credit Score</label>
                                        <div class="col-sm-9">
                                            <input type="number"
                                                class="form-control @error('credit_score') is-invalid @enderror"
                                                name="credit_score" id="credit_score"
                                                value="{{ old('credit_score', $borrower->credit_score ?? '') }}"
                                                placeholder="Credit Score" min="0" max="1000">
                                            <div class="form-text">Enter a value between 0 and 1000</div>
                                            @error('credit_score')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Description Section -->
                                    <div class="section-header mb-3">
                                        <h6 class="text-primary border-bottom pb-2">
                                            <i class="fas fa-file-alt me-1"></i> Additional Details
                                        </h6>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="description" class="col-sm-3 col-form-label">Description</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                                                rows="5" placeholder="Additional information about the borrower">{{ old('description', $borrower->description ?? '') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('borrowers.index') }}" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-arrow-left me-1"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-1"></i>
                                    {{ isset($borrower) ? 'Update Borrower' : 'Create Borrower' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
