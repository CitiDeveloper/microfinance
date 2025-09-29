@extends('layouts.app')

@section('title', 'Collection Sheet Details')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Collection Sheet Details</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('collection-sheets.index') }}">Collection Sheets</a></li>
                    <li class="breadcrumb-item active" aria-current="page">#{{ $collectionSheet->id }}</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('collection-sheets.export-pdf', $collectionSheet) }}" class="btn btn-outline-primary">
                <i class="fas fa-file-pdf me-2"></i>Export PDF
            </a>
            <a href="{{ route('collection-sheets.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-xl-8 col-lg-7">
            <!-- Sheet Information Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 text-primary">
                        <i class="fas fa-receipt me-2"></i>Collection Sheet #{{ $collectionSheet->id }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="text-muted small mb-1">Collection Date</label>
                                <p class="mb-0 fw-semibold">
                                    <i class="fas fa-calendar text-primary me-2"></i>
                                    {{ $collectionSheet->collection_date->format('M d, Y') }}
                                </p>
                            </div>
                            <div class="info-item mt-3">
                                <label class="text-muted small mb-1">Branch</label>
                                <p class="mb-0 fw-semibold">
                                    <i class="fas fa-building text-primary me-2"></i>
                                    {{ $collectionSheet->branch->branch_name }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="text-muted small mb-1">Staff Member</label>
                                <p class="mb-0 fw-semibold">
                                    <i class="fas fa-user text-primary me-2"></i>
                                    {{ $collectionSheet->staff->full_name }}
                                </p>
                            </div>
                            <div class="info-item mt-3">
                                <label class="text-muted small mb-1">Sheet Type</label>
                                <span class="badge bg-info bg-opacity-10 text-info text-capitalize border border-info border-opacity-25">
                                    <i class="fas fa-tag me-1"></i>{{ $collectionSheet->sheet_type }}
                                </span>
                            </div>
                        </div>
                    </div>

                    @if($collectionSheet->notes)
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="alert alert-light border">
                                <h6 class="alert-heading text-muted mb-2">
                                    <i class="fas fa-sticky-note me-2"></i>Notes
                                </h6>
                                <p class="mb-0 text-dark">{{ $collectionSheet->notes }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Collection Items Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 text-primary">
                        <i class="fas fa-list me-2"></i>Collection Items
                    </h5>
                    <span class="badge bg-primary bg-opacity-10 text-primary">
                        {{ $collectionSheet->items->count() }} items
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 ps-4">Borrower</th>
                                    <th class="border-0">Loan ID</th>
                                    <th class="border-0 text-end">Expected</th>
                                    <th class="border-0 text-end">Collected</th>
                                    <th class="border-0">Status</th>
                                    @if($collectionSheet->status === 'draft')
                                    <th class="border-0 text-center">Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($collectionSheet->items as $item)
                                <tr class="align-middle">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                                                <i class="fas fa-user text-primary fs-6"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">{{ $item->borrower->full_name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted">LOAN-{{ $item->loan_id }}</span>
                                    </td>
                                    <td class="text-end fw-semibold">
                                        {{ number_format($item->expected_amount, 2) }}
                                    </td>
                                    <td class="text-end fw-bold text-primary">
                                        {{ number_format($item->collected_amount, 2) }}
                                    </td>
                                    <td>
                                        @php
                                            $itemStatusColors = [
                                                'pending' => 'secondary',
                                                'collected' => 'success',
                                                'partial' => 'warning',
                                                'missed' => 'danger'
                                            ];
                                            $itemStatusIcons = [
                                                'pending' => 'clock',
                                                'collected' => 'check-circle',
                                                'partial' => 'exclamation-circle',
                                                'missed' => 'times-circle'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $itemStatusColors[$item->collection_status] }} bg-opacity-10 text-{{ $itemStatusColors[$item->collection_status] }} border border-{{ $itemStatusColors[$item->collection_status] }} border-opacity-25">
                                            <i class="fas fa-{{ $itemStatusIcons[$item->collection_status] }} me-1"></i>
                                            {{ ucfirst($item->collection_status) }}
                                        </span>
                                    </td>
                                    @if($collectionSheet->status === 'draft')
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary update-collection-btn" 
                                                data-item-id="{{ $item->id }}"
                                                data-expected="{{ $item->expected_amount }}"
                                                data-current="{{ $item->collected_amount }}"
                                                data-status="{{ $item->collection_status }}"
                                                data-bs-toggle="tooltip" title="Update Collection">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-xl-4 col-lg-5">
            <!-- Status Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 text-primary">
                        <i class="fas fa-info-circle me-2"></i>Sheet Status
                    </h5>
                </div>
                <div class="card-body text-center">
                    @php
                        $statusColors = [
                            'draft' => 'secondary',
                            'in_progress' => 'warning',
                            'completed' => 'success',
                            'cancelled' => 'danger'
                        ];
                        $statusIcons = [
                            'draft' => 'edit',
                            'in_progress' => 'sync-alt',
                            'completed' => 'check-circle',
                            'cancelled' => 'ban'
                        ];
                    @endphp
                    <div class="status-indicator bg-{{ $statusColors[$collectionSheet->status] }} bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-{{ $statusIcons[$collectionSheet->status] }} text-{{ $statusColors[$collectionSheet->status] }} fs-2"></i>
                    </div>
                    <h4 class="text-{{ $statusColors[$collectionSheet->status] }} text-capitalize">
                        {{ str_replace('_', ' ', $collectionSheet->status) }}
                    </h4>
                    <p class="text-muted mb-0">Created by {{ $collectionSheet->createdBy->name ?? 'System' }}</p>
                </div>
            </div>

            <!-- Summary Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 text-primary">
                        <i class="fas fa-chart-pie me-2"></i>Collection Summary
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Amount Summary -->
                    <div class="summary-card bg-primary bg-opacity-5 border border-primary border-opacity-10 rounded p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-primary mb-1">Total Expected</h6>
                                <h4 class="text-primary mb-0">{{ number_format($summary['total_expected'], 2) }}</h4>
                            </div>
                            <div class="icon-circle bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                        </div>
                    </div>

                    <div class="summary-card bg-success bg-opacity-5 border border-success border-opacity-10 rounded p-3 mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-success mb-1">Total Collected</h6>
                                <h4 class="text-success mb-0">{{ number_format($summary['total_collected'], 2) }}</h4>
                            </div>
                            <div class="icon-circle bg-success bg-opacity-10 text-success">
                                <i class="fas fa-cash-register"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Status Counts -->
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="stat-card bg-secondary bg-opacity-5 border border-secondary border-opacity-10 rounded p-3 text-center">
                                <div class="stat-number text-secondary mb-1">{{ $summary['pending_count'] }}</div>
                                <div class="stat-label text-muted small">Pending</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card bg-success bg-opacity-5 border border-success border-opacity-10 rounded p-3 text-center">
                                <div class="stat-number text-success mb-1">{{ $summary['collected_count'] }}</div>
                                <div class="stat-label text-muted small">Collected</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card bg-warning bg-opacity-5 border border-warning border-opacity-10 rounded p-3 text-center">
                                <div class="stat-number text-warning mb-1">{{ $summary['partial_count'] }}</div>
                                <div class="stat-label text-muted small">Partial</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card bg-danger bg-opacity-5 border border-danger border-opacity-10 rounded p-3 text-center">
                                <div class="stat-number text-danger mb-1">{{ $summary['missed_count'] }}</div>
                                <div class="stat-label text-muted small">Missed</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            @if($collectionSheet->status === 'draft')
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 text-primary">
                        <i class="fas fa-cog me-2"></i>Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('collection-sheets.edit', $collectionSheet) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit Sheet
                        </a>
                        <form action="{{ route('collection-sheets.process-collection', $collectionSheet) }}" method="POST" class="d-grid">
                            @csrf
                            <button type="submit" class="btn btn-success" 
                                    onclick="return confirm('Are you sure you want to process this collection? This action cannot be undone.')">
                                <i class="fas fa-check me-2"></i>Process Collection
                            </button>
                        </form>
                        <form action="{{ route('collection-sheets.destroy', $collectionSheet) }}" method="POST" class="d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger" 
                                    onclick="return confirm('Are you sure you want to delete this collection sheet?')">
                                <i class="fas fa-trash me-2"></i>Delete Sheet
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Update Collection Modal -->
<div class="modal fade" id="updateCollectionModal" tabindex="-1" aria-labelledby="updateCollectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title text-primary" id="updateCollectionModalLabel">
                    <i class="fas fa-edit me-2"></i>Update Collection
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateCollectionForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="item_id" id="item_id">
                    <div class="mb-3">
                        <label for="expected_amount" class="form-label text-muted small">Expected Amount</label>
                        <input type="text" id="expected_amount" class="form-control bg-light" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="collected_amount" class="form-label">Collected Amount <span class="text-danger">*</span></label>
                        <input type="number" name="collected_amount" id="collected_amount" 
                               class="form-control" step="0.01" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="collection_status" class="form-label">Collection Status <span class="text-danger">*</span></label>
                        <select name="collection_status" id="collection_status" class="form-select" required>
                            <option value="pending">Pending</option>
                            <option value="collected">Collected</option>
                            <option value="partial">Partial</option>
                            <option value="missed">Missed</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Add any notes about this collection..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Collection
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.avatar-sm {
    width: 40px;
    height: 40px;
}

.icon-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.status-indicator {
    border: 3px solid;
    border-color: inherit;
    border-opacity: 0.2;
}

.summary-card:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

.table tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.02);
}

.info-item {
    padding: 12px 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.info-item:last-child {
    border-bottom: none;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Update collection modal
    $('.update-collection-btn').click(function() {
        const itemId = $(this).data('item-id');
        const expected = $(this).data('expected');
        const current = $(this).data('current');
        const status = $(this).data('status');
        
        $('#item_id').val(itemId);
        $('#expected_amount').val('$' + parseFloat(expected).toFixed(2));
        $('#collected_amount').val(current);
        $('#collection_status').val(status);
        
        const modal = new bootstrap.Modal(document.getElementById('updateCollectionModal'));
        modal.show();
    });
    
    $('#updateCollectionForm').submit(function(e) {
        e.preventDefault();
        
        const itemId = $('#item_id').val();
        const formData = $(this).serialize();
        
        $.ajax({
            url: `/collection-sheet-items/${itemId}/update-collection`,
            method: 'POST',
            data: formData,
            beforeSend: function() {
                $('#updateCollectionForm button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Updating...');
            },
            success: function(response) {
                if (response.success) {
                    $('#updateCollectionModal').modal('hide');
                    location.reload();
                }
            },
            error: function(xhr) {
                alert('Error updating collection: ' + xhr.responseJSON.message);
                $('#updateCollectionForm button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save me-2"></i>Update Collection');
            },
            complete: function() {
                $('#updateCollectionForm button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save me-2"></i>Update Collection');
            }
        });
    });
});
</script>
@endpush