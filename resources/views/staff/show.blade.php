@extends('layouts.app')

@section('title', 'Staff Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Staff Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('staff.edit', $staff) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('staff.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Personal Information</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Full Name:</th>
                                    <td>{{ $staff->full_name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $staff->staff_email }}</td>
                                </tr>
                                <tr>
                                    <th>Gender:</th>
                                    <td>{{ $staff->staff_gender }}</td>
                                </tr>
                                <tr>
                                    <th>Role:</th>
                                    <td>{{ $staff->role->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Mobile:</th>
                                    <td>{{ $staff->staff_mobile ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Date of Birth:</th>
                                    <td>{{ $staff->staff_dob ? $staff->staff_dob->format('d/m/Y') : 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h4>Work Information</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Payroll Branch:</th>
                                    <td>{{ $staff->payrollBranch->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Results Per Page:</th>
                                    <td>{{ $staff->staff_show_results }}</td>
                                </tr>
                                <tr>
                                    <th>Access Branches:</th>
                                    <td>
                                        @foreach($staff->branches as $branch)
                                            <span class="badge badge-primary">{{ $branch->name }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>Office Phone:</th>
                                    <td>{{ $staff->staff_office_phone ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Teams:</th>
                                    <td>{{ $staff->staff_teams ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h4>Address Information</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Address:</th>
                                    <td>{{ $staff->staff_address ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>City:</th>
                                    <td>{{ $staff->staff_city ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Province/State:</th>
                                    <td>{{ $staff->staff_province ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Zipcode:</th>
                                    <td>{{ $staff->staff_zipcode ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection