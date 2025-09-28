@extends('layouts.app')

@section('title', 'Staff Details')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-xxl-10 col-xl-11 col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="h4 mb-0 text-primary fw-bold">
                            <i class="fas fa-user-tie me-2"></i>Staff Details
                        </h3>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('staff.edit', $staff) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit me-1"></i> Edit Staff
                        </a>
                        <a href="{{ route('staff.index') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <!-- Profile Header -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                        <i class="fas fa-user text-white fs-4"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="h3 mb-1">{{ $staff->full_name }}</h2>
                                    <p class="text-muted mb-1">{{ $staff->role->name ?? 'N/A' }}</p>
                                    <div class="d-flex flex-wrap gap-2">
                                        <span class="badge bg-light text-dark">
                                            <i class="fas fa-envelope me-1"></i> {{ $staff->staff_email }}
                                        </span>
                                        @if($staff->staff_mobile)
                                        <span class="badge bg-light text-dark">
                                            <i class="fas fa-phone me-1"></i> {{ $staff->staff_mobile }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <div class="d-flex flex-column h-100 justify-content-center">
                                <div class="mb-2">
                                    <span class="badge bg-primary fs-6 p-2">{{ $staff->staff_gender }}</span>
                                </div>
                                @if($staff->staff_dob)
                                <div class="text-muted">
                                    <small>Date of Birth: {{ $staff->staff_dob->format('d/m/Y') }}</small>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Information Cards -->
                    <div class="row g-4">
                        <!-- Personal Information -->
                        <div class="col-lg-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header bg-light py-3">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-user-circle me-2 text-primary"></i>Personal Information
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <td class="text-muted" style="width: 40%;">Full Name:</td>
                                                    <td class="fw-medium">{{ $staff->full_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">Email:</td>
                                                    <td>
                                                        <a href="mailto:{{ $staff->staff_email }}" class="text-decoration-none">
                                                            {{ $staff->staff_email }}
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">Gender:</td>
                                                    <td>{{ $staff->staff_gender }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">Role:</td>
                                                    <td>
                                                        <span class="badge bg-primary">{{ $staff->role->name ?? 'N/A' }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">Mobile:</td>
                                                    <td>{{ $staff->staff_mobile ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">Date of Birth:</td>
                                                    <td>{{ $staff->staff_dob ? $staff->staff_dob->format('d/m/Y') : 'N/A' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Work Information -->
                        <div class="col-lg-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header bg-light py-3">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-briefcase me-2 text-primary"></i>Work Information
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <td class="text-muted" style="width: 40%;">Payroll Branch:</td>
                                                    <td class="fw-medium">{{ $staff->payrollBranch->name ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">Results Per Page:</td>
                                                    <td>{{ $staff->staff_show_results }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">Office Phone:</td>
                                                    <td>{{ $staff->staff_office_phone ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">Teams:</td>
                                                    <td>{{ $staff->staff_teams ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted align-top">Access Branches:</td>
                                                    <td>
                                                        @if($staff->branches && $staff->branches->count() > 0)
                                                            @foreach($staff->branches as $branch)
                                                                <span class="badge bg-secondary mb-1">{{ $branch->name }}</span>
                                                            @endforeach
                                                        @else
                                                            <span class="text-muted">N/A</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Address Information -->
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light py-3">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-map-marker-alt me-2 text-primary"></i>Address Information
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="table-responsive">
                                                <table class="table table-borderless mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-muted" style="width: 30%;">Address:</td>
                                                            <td class="fw-medium">{{ $staff->staff_address ?? 'N/A' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted">City:</td>
                                                            <td>{{ $staff->staff_city ?? 'N/A' }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="table-responsive">
                                                <table class="table table-borderless mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-muted" style="width: 40%;">Province/State:</td>
                                                            <td>{{ $staff->staff_province ?? 'N/A' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted">Zipcode:</td>
                                                            <td>{{ $staff->staff_zipcode ?? 'N/A' }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    @if($staff->staff_address)
                                    <div class="mt-3">
                                        <a href="https://maps.google.com/?q={{ urlencode($staff->staff_address . ', ' . $staff->staff_city . ', ' . $staff->staff_province . ', ' . $staff->staff_zipcode) }}" 
                                           target="_blank" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-map-marked-alt me-1"></i> View on Map
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 0.75rem;
    }
    .card-header {
        border-radius: 0.75rem 0.75rem 0 0 !important;
    }
    .badge {
        font-size: 0.75rem;
    }
    .table-borderless tbody tr {
        border-bottom: 1px solid #f0f0f0;
    }
    .table-borderless tbody tr:last-child {
        border-bottom: none;
    }
</style>
@endsection