@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Borrowers Management</h1>
                    <p class="text-muted mb-0">Manage and track all borrowers in the system</p>
                </div>
                <a href="{{ route('borrowers.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Borrower
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Filter Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-center">
                <div class="col-md-6">
                    <form method="GET" action="{{ route('borrowers.index') }}">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0" 
                                   placeholder="Search borrowers by name, business, or mobile..." 
                                   value="{{ $search }}">
                            <button class="btn btn-outline-primary" type="submit">
                                Search
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-md-end">
                    <span class="text-muted small">
                        Showing {{ $borrowers->count() }} of {{ $borrowers->total() }} borrowers
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Unique #</th>
                            <th>Name</th>
                            <th>Business</th>
                            <th>Mobile</th>
                            <th>County</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($borrowers as $borrower)
                        <tr class="align-middle">
                            <td class="ps-4 fw-semibold text-primary">
                                {{ $borrower->unique_number ?? 'N/A' }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 36px; height: 36px;">
                                            <i class="fas fa-user text-primary small"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <span class="fw-medium">{{ $borrower->full_name }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted">{{ $borrower->business_name ?? 'N/A' }}</span>
                            </td>
                            <td>
                                @if($borrower->mobile)
                                <a href="tel:{{ $borrower->mobile }}" class="text-decoration-none">
                                    <i class="fas fa-phone me-1 text-muted small"></i>
                                    {{ $borrower->mobile }}
                                </a>
                                @else
                                <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $borrower->county }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                                    <i class="fas fa-circle small me-1"></i>Active
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-end gap-2 pe-4">
                                    <a href="{{ route('borrowers.show', $borrower) }}" 
                                       class="btn btn-sm btn-outline-info rounded-pill px-3"
                                       data-bs-toggle="tooltip" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('borrowers.edit', $borrower) }}" 
                                       class="btn btn-sm btn-outline-warning rounded-pill px-3"
                                       data-bs-toggle="tooltip" title="Edit Borrower">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('borrowers.destroy', $borrower) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                data-bs-toggle="tooltip" 
                                                title="Delete Borrower"
                                                onclick="return confirm('Are you sure you want to delete this borrower?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="py-4">
                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No borrowers found</h5>
                                    <p class="text-muted mb-0">Get started by adding your first borrower</p>
                                    <a href="{{ route('borrowers.create') }}" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus me-2"></i>Add Borrower
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination -->
        @if($borrowers->hasPages())
        <div class="card-footer bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Showing {{ $borrowers->firstItem() ?? 0 }} to {{ $borrowers->lastItem() ?? 0 }} 
                    of {{ $borrowers->total() }} results
                </div>
                <div>
                    {{ $borrowers->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
.table > :not(caption) > * > * {
    padding: 0.75rem 0.5rem;
}
.btn {
    transition: all 0.2s ease-in-out;
}
.badge {
    font-size: 0.75em;
}
</style>

<script>
// Initialize Bootstrap tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});
</script>
@endsection