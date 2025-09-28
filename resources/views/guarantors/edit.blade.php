@extends('layouts.app')

@section('title', 'Edit Guarantor - ' . $guarantor->display_name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Guarantor</h3>
                    <div class="card-tools">
                        <a href="{{ route('guarantors.show', $guarantor->id) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> View Details
                        </a>
                        <a href="{{ route('guarantors.index') }}" class="btn btn-secondary ml-1">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('guarantors.update', $guarantor->id) }}" method="POST" enctype="multipart/form-data" id="editGuarantorForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="alert alert-info">
                            <strong>Note:</strong> All fields are optional but you must type at least <b>First Name</b> and <b>Middle / Last Name</b> <u>or</u> <b>Business Name</b>.
                        </div>

                        {{-- First/Last/Business Name --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name">First Name *</label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                           id="first_name" name="first_name" 
                                           value="{{ old('first_name', $guarantor->first_name) }}" 
                                           placeholder="Enter First Name Only">
                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name">Middle / Last Name *</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                           id="last_name" name="last_name" 
                                           value="{{ old('last_name', $guarantor->last_name) }}" 
                                           placeholder="Middle and Last Name">
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="text-center my-3"><p class="font-weight-bold"><i>AND/OR</i></p></div>

                        <div class="form-group">
                            <label for="business_name">Business Name</label>
                            <input type="text" class="form-control @error('business_name') is-invalid @enderror" 
                                   id="business_name" name="business_name" 
                                   value="{{ old('business_name', $guarantor->business_name) }}" 
                                   placeholder="Business Name">
                            @error('business_name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <hr>
                        <h5 class="text-primary mb-4"><b>All of the below fields are optional:</b></h5>

                        {{-- Unique Number --}}
                        <div class="form-group">
                            <label for="unique_number">Unique Number</label>
                            <input type="text" class="form-control @error('unique_number') is-invalid @enderror" 
                                   id="unique_number" name="unique_number" 
                                   value="{{ old('unique_number', $guarantor->unique_number) }}" 
                                   placeholder="Unique Number">
                            <small class="form-text text-muted">You can enter unique number to identify the guarantor such as Social Security Number, License #, Registration Id....</small>
                            @error('unique_number')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        {{-- Gender / Title --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                                        <option value="">Select Gender</option>
                                        @foreach(['Male','Female','Nonbinary','Other','Decline to state'] as $gender)
                                            <option value="{{ $gender }}" {{ old('gender', $guarantor->gender) == $gender ? 'selected' : '' }}>{{ $gender }}</option>
                                        @endforeach
                                    </select>
                                    @error('gender')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <select class="form-control @error('title') is-invalid @enderror" id="title" name="title">
                                        <option value="">Select Title</option>
                                        @foreach(['Mr.','Mrs.','Miss','Ms.','Dr.','Prof.','Rev.'] as $title)
                                            <option value="{{ $title }}" {{ old('title', $guarantor->title) == $title ? 'selected' : '' }}>{{ $title }}</option>
                                        @endforeach
                                    </select>
                                    @error('title')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Mobile / Email --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mobile">Mobile</label>
                                    <input type="text" class="form-control @error('mobile') is-invalid @enderror" 
                                           id="mobile" name="mobile" 
                                           value="{{ old('mobile', $guarantor->mobile) }}" 
                                           placeholder="Numbers Only">
                                    <small class="form-text text-muted"><b><u>Do not</u> put country code, spaces, or characters</b> in mobile otherwise SMS won’t work.</small>
                                    @error('mobile')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" 
                                           value="{{ old('email', $guarantor->email) }}" 
                                           placeholder="Email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- DOB --}}
                        <div class="form-group">
                            <label for="date_of_birth">Date of Birth</label>
                            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                   id="date_of_birth" name="date_of_birth" 
                                   value="{{ old('date_of_birth', $guarantor->date_of_birth ? $guarantor->date_of_birth->format('Y-m-d') : '') }}">
                            @error('date_of_birth')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        {{-- Address --}}
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                   id="address" name="address" 
                                   value="{{ old('address', $guarantor->address) }}" 
                                   placeholder="Address">
                            @error('address')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        {{-- City / Province / Zip --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                           id="city" name="city" 
                                           value="{{ old('city', $guarantor->city) }}" 
                                           placeholder="City">
                                    @error('city')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="province">Province / State</label>
                                    <input type="text" class="form-control @error('province') is-invalid @enderror" 
                                           id="province" name="province" 
                                           value="{{ old('province', $guarantor->province) }}" 
                                           placeholder="Province or State">
                                    @error('province')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="zipcode">Zipcode</label>
                                    <input type="text" class="form-control @error('zipcode') is-invalid @enderror" 
                                           id="zipcode" name="zipcode" 
                                           value="{{ old('zipcode', $guarantor->zipcode) }}" 
                                           placeholder="Zipcode">
                                    @error('zipcode')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Landline --}}
                        <div class="form-group">
                            <label for="landline">Landline Phone</label>
                            <input type="text" class="form-control @error('landline') is-invalid @enderror" 
                                   id="landline" name="landline" 
                                   value="{{ old('landline', $guarantor->landline) }}" 
                                   placeholder="Landline Phone">
                            @error('landline')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        {{-- Working Status --}}
                        <div class="form-group">
                            <label for="working_status">Working Status</label>
                            <select class="form-control @error('working_status') is-invalid @enderror" id="working_status" name="working_status">
                                <option value="">Select Working Status</option>
                                @foreach(['Employee','Government Employee','Private Sector Employee','Owner','Student','Overseas Worker','Pensioner','Unemployed'] as $status)
                                    <option value="{{ $status }}" {{ old('working_status', $guarantor->working_status) == $status ? 'selected' : '' }}>{{ $status }}</option>
                                @endforeach
                            </select>
                            @error('working_status')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        {{-- Photo --}}
                        @if($guarantor->photo)
                        <div class="form-group">
                            <label>Current Photo</label>
                            <div>
                                <img src="{{ asset('storage/' . $guarantor->photo) }}" alt="{{ $guarantor->full_name }}" class="img-thumbnail" style="max-width: 150px; max-height: 150px; object-fit: cover;">
                                <div class="form-check mt-2">
                                    <input type="checkbox" class="form-check-input" id="remove_photo" name="remove_photo" value="1">
                                    <label class="form-check-label text-danger" for="remove_photo">Remove current photo</label>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="form-group">
                            <label for="photo">Update Photo</label>
                            <input type="file" class="form-control-file @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
                            <small class="form-text text-muted">Leave empty to keep current photo</small>
                            @error('photo')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        {{-- Files --}}
                        <div class="form-group">
                            <label for="files">Additional Files</label>
                            <input type="file" class="form-control-file @error('files') is-invalid @enderror" id="files" name="files[]" multiple>
                            <small class="form-text text-muted">Select multiple files to add to existing files</small>
                            @error('files')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        @if($guarantor->files && count($guarantor->files) > 0)
                        <div class="form-group">
                            <label>Current Files</label>
                            <div class="row">
                                @foreach($guarantor->files as $index => $file)
                                    <div class="col-md-3 mb-2">
                                        <div class="card file-card">
                                            <div class="card-body text-center p-2">
                                                <i class="fas fa-file text-secondary fa-2x"></i>
                                                <p class="small mb-1 text-truncate" title="{{ basename($file) }}">{{ basename($file) }}</p>
                                                <a href="{{ asset('storage/' . $file) }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                                <div class="form-check mt-2">
                                                    <input type="checkbox" class="form-check-input" id="remove_file_{{ $index }}" name="remove_files[]" value="{{ $file }}">
                                                    <label class="form-check-label text-danger" for="remove_file_{{ $index }}">Remove</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- Branch --}}
                        <div class="form-group">
                            <label for="branch_id">Branch</label>
                            <select class="form-control @error('branch_id') is-invalid @enderror" id="branch_id" name="branch_id">
                                <option value="">Select Branch</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ old('branch_id', $guarantor->branch_id) == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                @endforeach
                            </select>
                            @error('branch_id')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="form-group">
                            <label for="description">Description / Notes</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Additional notes">{{ old('description', $guarantor->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update Guarantor</button>
                            <a href="{{ route('guarantors.index') }}" class="btn btn-secondary ml-2"><i class="fas fa-times"></i> Cancel</a>
                        </div>
                    </form>
                </div> 
            </div>
        </div>
    </div>
</div>
@endsection
