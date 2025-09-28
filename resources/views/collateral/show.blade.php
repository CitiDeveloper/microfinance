@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-1 fw-bold">Collateral Details</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('collateral.index') }}" class="text-decoration-none">Collateral</a></li>
                            <li class="breadcrumb-item active">Details</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <span class="badge bg-{{ $collateral->status === 'active' ? 'success' : ($collateral->status === 'released' ? 'info' : ($collateral->status === 'seized' ? 'warning' : 'danger')) }} fs-6 px-3 py-2">
                        {{ ucfirst($collateral->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content Column -->
        <div class="col-xl-8">
            <!-- Collateral Information Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="card-title mb-0 fw-semibold">Collateral Information</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="border-bottom pb-3">
                                <label class="form-label text-muted small mb-1">Collateral Type</label>
                                <p class="mb-0 fw-semibold fs-6">{{ $collateral->collateral_type }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border-bottom pb-3">
                                <label class="form-label text-muted small mb-1">Estimated Value</label>
                                <p class="mb-0 fw-semibold fs-6 text-success">{{ number_format($collateral->estimated_value, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom py-3">
                        <label class="form-label text-muted small mb-1">Description</label>
                        <p class="mb-0">{{ $collateral->description }}</p>
                    </div>

                    @if($collateral->location || $collateral->condition)
                    <div class="row g-4">
                        @if($collateral->location)
                        <div class="col-md-6">
                            <div class="border-bottom pb-3">
                                <label class="form-label text-muted small mb-1">Location</label>
                                <p class="mb-0">{{ $collateral->location }}</p>
                            </div>
                        </div>
                        @endif
                        @if($collateral->condition)
                        <div class="col-md-6">
                            <div class="border-bottom pb-3">
                                <label class="form-label text-muted small mb-1">Condition</label>
                                <p class="mb-0">{{ $collateral->condition }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    @if($collateral->serial_number || $collateral->registration_number)
                    <div class="row g-4">
                        @if($collateral->serial_number)
                        <div class="col-md-6">
                            <div class="border-bottom pb-3">
                                <label class="form-label text-muted small mb-1">Serial Number</label>
                                <p class="mb-0">{{ $collateral->serial_number }}</p>
                            </div>
                        </div>
                        @endif
                        @if($collateral->registration_number)
                        <div class="col-md-6">
                            <div class="border-bottom pb-3">
                                <label class="form-label text-muted small mb-1">Registration Number</label>
                                <p class="mb-0">{{ $collateral->registration_number }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    @if($collateral->acquisition_date || $collateral->last_valuation_date)
                    <div class="row g-4">
                        @if($collateral->acquisition_date)
                        <div class="col-md-6">
                            <div class="border-bottom pb-3">
                                <label class="form-label text-muted small mb-1">Acquisition Date</label>
                                <p class="mb-0">{{ \Carbon\Carbon::parse($collateral->acquisition_date)->format('M d, Y') }}</p>
                            </div>
                        </div>
                        @endif
                        @if($collateral->last_valuation_date)
                        <div class="col-md-6">
                            <div class="border-bottom pb-3">
                                <label class="form-label text-muted small mb-1">Last Valuation Date</label>
                                <p class="mb-0">{{ \Carbon\Carbon::parse($collateral->last_valuation_date)->format('M d, Y') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    @if($collateral->notes)
                    <div class="pt-3">
                        <label class="form-label text-muted small mb-1">Additional Notes</label>
                        <p class="mb-0">{{ $collateral->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Documents Card -->
            @if($collateral->document_path)
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="card-title mb-0 fw-semibold">Documents</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center p-3 bg-light rounded">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="ri-file-text-line text-primary fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 fw-semibold">Collateral Document</h6>
                            <p class="text-muted mb-0 small">Uploaded collateral documentation</p>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ asset('storage/' . $collateral->document_path) }}" target="_blank" class="btn btn-primary btn-sm px-3">
                                <i class="ri-download-line align-middle me-1"></i> Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar Column -->
        <div class="col-xl-4">
            <!-- Loan Information Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="card-title mb-0 fw-semibold">Loan Information</h5>
                </div>
                <div class="card-body p-4">
                    @if($collateral->loan && $collateral->loan->borrower)
                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="ri-user-line text-primary fs-5"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 fw-semibold">{{ $collateral->loan->borrower->full_name ?? 'N/A' }}</h6>
                            <p class="text-muted mb-0 small">Borrower</p>
                        </div>
                    </div>
                    @endif

                    <div class="mb-3 pb-3 border-bottom">
                        <label class="form-label text-muted small mb-1">Loan ID</label>
                        <p class="mb-0 fw-semibold">#{{ $collateral->loan_id }}</p>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <label class="form-label text-muted small mb-1">Created By</label>
                        <p class="mb-0">{{ $collateral->creator->full_name ?? 'N/A' }}</p>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <label class="form-label text-muted small mb-1">Created Date</label>
                        <p class="mb-0">{{ $collateral->created_at->format('M d, Y \a\t h:i A') }}</p>
                    </div>

                    <div class="mb-0">
                        <label class="form-label text-muted small mb-1">Last Updated</label>
                        <p class="mb-0">{{ $collateral->updated_at->format('M d, Y \a\t h:i A') }}</p>
                    </div>
                       <a href="{{ route('collateral.edit', $collateral) }}" class="btn btn-outline-primary py-2">
                            <i class="ri-edit-line align-middle me-2"></i> Edit Collateral
                        </a>
                        <a href="{{ route('loans.show', $collateral->loan_id) }}" class="btn btn-outline-info py-2">
                            <i class="ri-bank-card-line align-middle me-2"></i> View Loan Details
                        </a> <br> <br>
                        <button type="button" class="btn btn-outline-danger py-2" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="ri-delete-bin-line align-middle me-2"></i> Delete Collateral
                        </button>
                </div>
            </div>

          
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-semibold" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0">
                        <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                            <i class="ri-alert-line text-danger fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="mb-0">Are you sure you want to delete this collateral record? This action cannot be undone.</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('collateral.destroy', $collateral) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4">Delete Collateral</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
