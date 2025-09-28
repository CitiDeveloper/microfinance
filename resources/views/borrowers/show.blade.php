@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2>Borrower Details</h2>
        <div class="btn-group">
            <a href="{{ route('borrowers.edit', $borrower) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('borrowers.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h4>Personal Information</h4>
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Full Name:</th>
                        <td>{{ $borrower->full_name }}</td>
                    </tr>
                    <tr>
                        <th>Unique Number:</th>
                        <td>{{ $borrower->unique_number ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Gender:</th>
                        <td>{{ $borrower->gender ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Title:</th>
                        <td>{{ $borrower->title ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Date of Birth:</th>
                        <td>{{ $borrower->date_of_birth ? $borrower->date_of_birth->format('M d, Y') : 'N/A' }}</td>
                    </tr>
                </table>
            </div>
            
            <div class="col-md-6">
                <h4>Contact Information</h4>
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Mobile:</th>
                        <td>{{ $borrower->mobile ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $borrower->email ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Landline:</th>
                        <td>{{ $borrower->landline ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>County:</th>
                        <td>{{ $borrower->county }}</td>
                    </tr>
                    <tr>
                        <th>City:</th>
                        <td>{{ $borrower->city ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <h4>Address Information</h4>
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Address:</th>
                        <td>{{ $borrower->address ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Province/State:</th>
                        <td>{{ $borrower->province ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Zipcode:</th>
                        <td>{{ $borrower->zipcode ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
            
            <div class="col-md-6">
                <h4>Employment & Financial</h4>
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Working Status:</th>
                        <td>{{ $borrower->working_status ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Credit Score:</th>
                        <td>{{ $borrower->credit_score ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Business Name:</th>
                        <td>{{ $borrower->business_name ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        @if($borrower->description)
        <div class="row mt-4">
            <div class="col-12">
                <h4>Description</h4>
                <div class="card">
                    <div class="card-body">
                        {{ $borrower->description }}
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>System Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Created:</strong> {{ $borrower->created_at->format('M d, Y H:i') }}
                            </div>
                            <div class="col-md-3">
                                <strong>Updated:</strong> {{ $borrower->updated_at->format('M d, Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection