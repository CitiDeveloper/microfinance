@extends('layouts.app')

@section('title', 'Guarantor Details - ' . $guarantor->display_name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Guarantor Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('guarantors.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <a href="{{ route('guarantors.edit', $guarantor->id) }}" class="btn btn-warning ml-1">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Personal Information -->
                        <div class="col-md-4">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4 class="card-title">Personal Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        @if($guarantor->photo)
                                            <img src="{{ asset('storage/' . $guarantor->photo) }}" 
                                                 alt="{{ $guarantor->full_name }}" 
                                                 class="img-circle img-fluid"
                                                 style="max-width: 150px; max-height: 150px; object-fit: cover;">
                                        @else
                                            <div class="img-circle bg-secondary d-flex align-items-center justify-content-center mx-auto"
                                                 style="width: 150px; height: 150px;">
                                                <i class="fas fa-user fa-3x text-white"></i>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <th width="40%">Name:</th>
                                            <td><strong>{{ $guarantor->display_name }}</strong></td>
                                        </tr>
                                        @if($guarantor->title)
                                        <tr>
                                            <th>Title:</th>
                                            <td>{{ $guarantor->title }}</td>
                                        </tr>
                                        @endif
                                        @if($guarantor->gender)
                                        <tr>
                                            <th>Gender:</th>
                                            <td>{{ $guarantor->gender }}</td>
                                        </tr>
                                        @endif
                                        @if($guarantor->date_of_birth)
                                        <tr>
                                            <th>Date of Birth:</th>
                                            <td>{{ $guarantor->date_of_birth->format('M j, Y') }}</td>
                                        </tr>
                                        @endif
                                        @if($guarantor->unique_number)
                                        <tr>
                                            <th>Unique Number:</th>
                                            <td><span class="badge badge-info">{{ $guarantor->unique_number }}</span></td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="col-md-4">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h4 class="card-title">Contact Information</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm table-borderless">
                                        @if($guarantor->mobile)
                                        <tr>
                                            <th width="40%">Mobile:</th>
                                            <td>
                                                <i class="fas fa-phone text-success mr-1"></i>
                                                {{ $guarantor->mobile }}
                                            </td>
                                        </tr>
                                        @endif
                                        @if($guarantor->landline)
                                        <tr>
                                            <th>Landline:</th>
                                            <td>
                                                <i class="fas fa-phone-alt text-secondary mr-1"></i>
                                                {{ $guarantor->landline }}
                                            </td>
                                        </tr>
                                        @endif
                                        @if($guarantor->email)
                                        <tr>
                                            <th>Email:</th>
                                            <td>
                                                <i class="fas fa-envelope text-primary mr-1"></i>
                                                <a href="mailto:{{ $guarantor->email }}">{{ $guarantor->email }}</a>
                                            </td>
                                        </tr>
                                        @endif
                                        @if($guarantor->address)
                                        <tr>
                                            <th>Address:</th>
                                            <td>
                                                <i class="fas fa-map-marker-alt text-danger mr-1"></i>
                                                {{ $guarantor->address }}
                                            </td>
                                        </tr>
                                        @endif
                                        @if($guarantor->city)
                                        <tr>
                                            <th>City:</th>
                                            <td>{{ $guarantor->city }}</td>
                                        </tr>
                                        @endif
                                        @if($guarantor->province)
                                        <tr>
                                            <th>Province/State:</th>
                                            <td>{{ $guarantor->province }}</td>
                                        </tr>
                                        @endif
                                        @if($guarantor->zipcode)
                                        <tr>
                                            <th>Zipcode:</th>
                                            <td>{{ $guarantor->zipcode }}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Employment & Additional Info -->
                        <div class="col-md-4">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h4 class="card-title">Employment & Additional Info</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm table-borderless">
                                        @if($guarantor->working_status)
                                        <tr>
                                            <th width="40%">Working Status:</th>
                                            <td><span class="badge badge-light">{{ $guarantor->working_status }}</span></td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <th>Branch:</th>
                                            <td><span class="badge badge-primary">{{ $guarantor->branch->name ?? 'N/A' }}</span></td>
                                        </tr>
                                        <tr>
                                            <th>Created By:</th>
                                            <td>{{ $guarantor->creator->name ?? 'System' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Created At:</th>
                                            <td>{{ $guarantor->created_at->format('M j, Y g:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Last Updated:</th>
                                            <td>{{ $guarantor->updated_at->format('M j, Y g:i A') }}</td>
                                        </tr>
                                    </table>

                                    @if($guarantor->description)
                                    <div class="mt-3">
                                        <h6>Description:</h6>
                                        <p class="text-muted">{{ $guarantor->description }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Files Section -->
                    @if($guarantor->files && count($guarantor->files) > 0)
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h4 class="card-title">Attached Files</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach($guarantor->files as $file)
                                            <div class="col-md-3 mb-3">
                                                <div class="card file-card">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-file fa-3x text-secondary mb-2"></i>
                                                        <p class="file-name small text-truncate" title="{{ basename($file) }}">
                                                            {{ basename($file) }}
                                                        </p>
                                                        <a href="{{ asset('storage/' . $file) }}" 
                                                           target="_blank" 
                                                           class="btn btn-sm btn-info">
                                                            <i class="fas fa-download"></i> Download
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Associated Loans (if any) -->
                    @if($guarantor->loans && $guarantor->loans->count() > 0)
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card card-danger">
                                <div class="card-header">
                                    <h4 class="card-title">Associated Loans</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Loan ID</th>
                                                    <th>Borrower</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Issue Date</th>
                                                    <th>Due Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($guarantor->loans as $loan)
                                                    <tr>
                                                        <td>#{{ $loan->id }}</td>
                                                        <td>{{ $loan->borrower->full_name ?? 'N/A' }}</td>
                                                        <td>{{ number_format($loan->amount, 2) }}</td>
                                                        <td>
                                                            <span class="badge badge-{{ $loan->status == 'active' ? 'success' : 'warning' }}">
                                                                {{ ucfirst($loan->status) }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $loan->issue_date->format('M j, Y') }}</td>
                                                        <td>{{ $loan->due_date->format('M j, Y') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .file-card {
        transition: transform 0.2s;
    }
    .file-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .file-name {
        max-width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .table-borderless th {
        font-weight: 600;
        color: #6c757d;
    }
</style>
@endsection