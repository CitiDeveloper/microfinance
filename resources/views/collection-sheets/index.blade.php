@extends('layouts.app')

@section('title', 'Collection Sheets')
<style>
.avatar-sm {
    width: 40px;
    height: 40px;
}

.card.border-start {
    border-left-width: 4px !important;
}

.table tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.02);
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

.empty-state {
    padding: 2rem 0;
}

.btn-group-sm > .btn, .btn-sm {
    padding: 0.35rem 0.65rem;
    border-radius: 0.375rem;
}

.badge {
    padding: 0.5em 0.75em;
    font-weight: 500;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}
</style>


@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Collection Sheets</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Collection Sheets</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-download me-2"></i>Export
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf me-2 text-danger"></i>PDF Report</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-file-excel me-2 text-success"></i>Excel</a></li>
                </ul>
            </div>
            <a href="{{ route('collection-sheets.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Create New Sheet
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-primary shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total Sheets</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $collectionSheets->total() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-receipt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-success shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">Completed</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">
                                {{ $collectionSheets->where('status', 'completed')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-warning shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">In Progress</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">
                                {{ $collectionSheets->where('status', 'in_progress')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-sync-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-info shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-info text-uppercase mb-1">Draft</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">
                                {{ $collectionSheets->where('status', 'draft')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-edit fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Collection Sheets Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="card-title mb-0 text-primary">
                <i class="fas fa-list me-2"></i>All Collection Sheets
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 ps-4">
                                <div class="d-flex align-items-center">
                                    <span>ID</span>
                                    <a href="#" class="text-muted ms-1"><i class="fas fa-sort"></i></a>
                                </div>
                            </th>
                            <th class="border-0">Collection Date</th>
                            <th class="border-0">Branch</th>
                            <th class="border-0">Staff</th>
                            <th class="border-0">Type</th>
                            <th class="border-0">Status</th>
                            <th class="border-0 text-end">Expected</th>
                            <th class="border-0 text-end">Collected</th>
                            <th class="border-0 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($collectionSheets as $sheet)
                            <tr class="align-middle">
                                <td class="ps-4">
                                    <div class="fw-semibold text-primary">#{{ $sheet->id }}</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                                            <i class="fas fa-calendar text-primary fs-6"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">{{ $sheet->collection_date->format('M d, Y') }}</h6>
                                            <small class="text-muted">{{ $sheet->collection_date->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-medium">{{ $sheet->branch->name }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2">
                                            <i class="fas fa-user text-info fs-6"></i>
                                        </div>
                                        <span>{{ $sheet->staff->full_name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info bg-opacity-10 text-info text-capitalize border border-info border-opacity-25">
                                        <i class="fas fa-tag me-1"></i>{{ $sheet->sheet_type }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'draft' => 'primary',
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
                                    <span class="badge bg-{{ $statusColors[$sheet->status] }} bg-opacity-10 text-{{ $statusColors[$sheet->status] }} border border-{{ $statusColors[$sheet->status] }} border-opacity-25">
                                        <i class="fas fa-{{ $statusIcons[$sheet->status] }} me-1"></i>
                                        {{ str_replace('_', ' ', $sheet->status) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="fw-bold text-dark">{{ number_format($sheet->total_expected, 2) }}</div>
                                </td>
                                <td class="text-end">
                                    <div class="fw-bold text-primary">{{ number_format($sheet->total_collected, 2) }}</div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('collection-sheets.show', $sheet) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           data-bs-toggle="tooltip" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($sheet->status === 'draft')
                                            <a href="{{ route('collection-sheets.edit', $sheet) }}" 
                                               class="btn btn-sm btn-outline-warning"
                                               data-bs-toggle="tooltip" title="Edit Sheet">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('collection-sheets.export-pdf', $sheet) }}" 
                                           class="btn btn-sm btn-outline-danger"
                                           data-bs-toggle="tooltip" title="Export PDF">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                                        <h4 class="text-muted">No Collection Sheets Found</h4>
                                        <p class="text-muted mb-4">Get started by creating your first collection sheet.</p>
                                        <a href="{{ route('collection-sheets.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Create New Sheet
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($collectionSheets->hasPages())
            <div class="card-footer bg-white border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing {{ $collectionSheets->firstItem() ?? 0 }} to {{ $collectionSheets->lastItem() ?? 0 }} of {{ $collectionSheets->total() }} entries
                    </div>
                    <div>
                        {{ $collectionSheets->links() }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Add loading state to buttons
    $('.btn').on('click', function() {
        const btn = $(this);
        if (!btn.hasClass('dropdown-toggle')) {
            btn.prop('disabled', true);
            setTimeout(() => {
                btn.prop('disabled', false);
            }, 1000);
        }
    });
});
</script>
@endsection
