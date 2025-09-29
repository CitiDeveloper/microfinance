@extends('layouts.app')

@section('title', 'Create Collection Sheet')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Create Collection Sheet</h1>
            <p class="mb-0">Generate a new collection sheet for tracking repayments</p>
        </div>
        <a href="{{ route('collection-sheets.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-outline-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Back to List
        </a>
    </div>

    <div class="row">
        <!-- Main Form Section -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4 border-0">
                <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-plus-circle me-2"></i>New Collection Sheet
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('collection-sheets.store') }}" method="POST" id="collectionForm">
                        @csrf
                        <div class="row g-3">
                            <!-- Branch Selection -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select name="branch_id" id="branch_id" class="form-select @error('branch_id') is-invalid @enderror" required>
                                        <option value="" selected disabled>Select a branch</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->branch_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="branch_id" class="form-label">
                                        <i class="fas fa-building me-1 text-muted"></i> Branch
                                    </label>
                                    @error('branch_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Staff Selection -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select name="staff_id" id="staff_id" class="form-select @error('staff_id') is-invalid @enderror" required>
                                        <option value="" selected disabled>Select staff member</option>
                                        @foreach($staff as $staffMember)
                                            <option value="{{ $staffMember->id }}" {{ old('staff_id') == $staffMember->id ? 'selected' : '' }}>
                                                {{ $staffMember->full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="staff_id" class="form-label">
                                        <i class="fas fa-user me-1 text-muted"></i> Staff Member
                                    </label>
                                    @error('staff_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Collection Date -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" name="collection_date" id="collection_date" 
                                           class="form-control @error('collection_date') is-invalid @enderror" 
                                           value="{{ old('collection_date', date('Y-m-d')) }}" required>
                                    <label for="collection_date" class="form-label">
                                        <i class="fas fa-calendar-alt me-1 text-muted"></i> Collection Date
                                    </label>
                                    @error('collection_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Sheet Type -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select name="sheet_type" id="sheet_type" class="form-select @error('sheet_type') is-invalid @enderror" required>
                                        <option value="daily" {{ old('sheet_type') == 'daily' ? 'selected' : '' }}>Daily</option>
                                        <option value="weekly" {{ old('sheet_type') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                        <option value="custom" {{ old('sheet_type') == 'custom' ? 'selected' : '' }}>Custom</option>
                                    </select>
                                    <label for="sheet_type" class="form-label">
                                        <i class="fas fa-file-alt me-1 text-muted"></i> Sheet Type
                                    </label>
                                    @error('sheet_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Notes -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" 
                                              placeholder="Additional notes" style="height: 100px">{{ old('notes') }}</textarea>
                                    <label for="notes" class="form-label">
                                        <i class="fas fa-sticky-note me-1 text-muted"></i> Additional Notes
                                    </label>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Form Actions -->
                        <div class="row mt-4">
                            <div class="col-12 d-flex justify-content-end gap-2">
                                <a href="{{ route('collection-sheets.index') }}" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-times me-1"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary px-4" id="submitBtn">
                                    <i class="fas fa-save me-1"></i> Create Collection Sheet
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Sidebar Section -->
        <div class="col-xl-4 col-lg-5">
            <!-- Quick Actions Card -->
            <div class="card shadow mb-4 border-0">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush rounded">
                        <a href="{{ route('collection-sheets.daily') }}" class="list-group-item list-group-item-action d-flex align-items-center py-3">
                            <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                                <i class="fas fa-calendar-day text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Daily Collection</h6>
                                <small class="text-muted">View today's collection schedule</small>
                            </div>
                        </a>
                        <a href="{{ route('collection-sheets.missed') }}" class="list-group-item list-group-item-action d-flex align-items-center py-3">
                            <div class="bg-warning bg-opacity-10 p-2 rounded me-3">
                                <i class="fas fa-exclamation-triangle text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Missed Repayments</h6>
                                <small class="text-muted">Review overdue payments</small>
                            </div>
                        </a>
                        <a href="{{ route('collection-sheets.past-maturity') }}" class="list-group-item list-group-item-action d-flex align-items-center py-3">
                            <div class="bg-danger bg-opacity-10 p-2 rounded me-3">
                                <i class="fas fa-calendar-times text-danger"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Past Maturity Loans</h6>
                                <small class="text-muted">Loans beyond maturity date</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Information Card -->
            <div class="card shadow border-0">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle me-2"></i>Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-lightbulb text-warning"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-0 text-muted small">
                                Creating a collection sheet will automatically generate items for all due repayments 
                                on the selected date for the chosen branch.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    .card {
        border-radius: 0.5rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }
    
    .card-header {
        border-bottom: 1px solid #e3e6f0;
    }
    
    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label {
        color: #6e707e;
        font-weight: 500;
    }
    
    .list-group-item {
        border: none;
        transition: all 0.15s ease-in-out;
    }
    
    .list-group-item:hover {
        background-color: #f8f9fc;
    }
    
    .btn {
        border-radius: 0.35rem;
        font-weight: 500;
    }
    
    .form-control, .form-select {
        border-radius: 0.35rem;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
</style>

<!-- Optional JavaScript for enhanced UX -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form submission enhancement
        const form = document.getElementById('collectionForm');
        const submitBtn = document.getElementById('submitBtn');
        
        form.addEventListener('submit', function() {
            // Disable button and show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Creating...';
        });
        
        // Set minimum date to today for collection date
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('collection_date').setAttribute('min', today);
    });
</script>
@endsection