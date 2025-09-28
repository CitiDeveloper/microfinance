@extends('layouts.app')

@section('content')
<style>
    .card {
        border-radius: 0.5rem;
        border: 1px solid #e3e6f0;
    }
    
    .card-header {
        border-radius: 0.5rem 0.5rem 0 0 !important;
        border-bottom: 1px solid #e3e6f0;
    }
    
    .table > :not(caption) > * > * {
        padding: 1rem 0.75rem;
        border-bottom-color: #e3e6f0;
    }
    
    .table th {
        font-weight: 600;
        color: #5a5c69;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .icon-shape {
        width: 2rem;
        height: 2rem;
    }
    
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }
    
    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }
    
    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }
    
    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }
    
    .btn-group .btn {
        border-radius: 0;
    }
    
    .btn-group .btn:first-child {
        border-top-left-radius: 0.375rem;
        border-bottom-left-radius: 0.375rem;
    }
    
    .btn-group .btn:last-child {
        border-top-right-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
    }
    
    .product-row:hover {
        background-color: #f8f9fc;
    }
</style>
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h1 class="h3 mb-0">Loan Products</h1>
            <p class="mb-0 text-gray-600">Manage and monitor all available loan products</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('loan-products.create') }}" class="btn btn-primary d-inline-flex align-items-center">
                <i class="fas fa-plus me-2"></i> New Loan Product
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Products
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $loanProducts->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Active Products
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $loanProducts->where('is_active', true)->count() }}
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
            <div class="card border-left-info shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                With Interest Method
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $loanProducts->whereNotNull('loan_interest_method')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percent fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Multi-Branch Products
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $loanProducts->filter(fn($product) => $product->branches->count() > 1)->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-code-branch fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loan Products Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <div>
                <h5 class="mb-0 text-primary"><i class="fas fa-list me-2"></i>Loan Products</h5>
            </div>
            <div class="d-flex align-items-center">
                <span class="badge bg-primary rounded-pill me-3">{{ $loanProducts->count() }} Total</span>
                <div class="input-group input-group-sm" style="width: 250px;">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-search text-gray-400"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Search products..." id="searchInput">
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="productsTable">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4">Product Name</th>
                            <th scope="col">Branches</th>
                            <th scope="col">Interest Method</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($loanProducts as $product)
                        <tr class="product-row">
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="icon-shape icon-sm bg-primary rounded-circle text-white me-3 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-file-invoice fa-sm"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold">{{ $product->loan_product_name }}</h6>
                                        <small class="text-muted">Created: {{ $product->created_at->format('M d, Y') }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($product->branches->count())
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach($product->branches->take(2) as $branch)
                                            <span class="badge bg-light text-dark border">{{ $branch->name }}</span>
                                        @endforeach
                                        @if($product->branches->count() > 2)
                                            <span class="badge bg-secondary">+{{ $product->branches->count() - 2 }} more</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted small">No branches assigned</span>
                                @endif
                            </td>
                            <td>
                                @if($product->loan_interest_method)
                                    <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">
                                        {{ Str::title(str_replace('_', ' ', $product->loan_interest_method)) }}
                                    </span>
                                @else
                                    <span class="badge bg-light text-muted border">Not configured</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="badge rounded-pill {{ $product->is_active ? 'bg-success' : 'bg-secondary' }} me-2">
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    @if($product->is_active)
                                        <i class="fas fa-circle text-success fa-xs" data-bs-toggle="tooltip" title="Active"></i>
                                    @else
                                        <i class="fas fa-circle text-secondary fa-xs" data-bs-toggle="tooltip" title="Inactive"></i>
                                    @endif
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('loan-products.show', $product) }}" 
                                       class="btn btn-sm btn-outline-primary rounded-start" 
                                       data-bs-toggle="tooltip" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('loan-products.edit', $product) }}" 
                                       class="btn btn-sm btn-outline-secondary" 
                                       data-bs-toggle="tooltip" title="Edit Product">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('loan-products.destroy', $product) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger rounded-end"
                                                data-bs-toggle="tooltip" title="Delete Product"
                                                onclick="return confirm('Are you sure you want to delete this loan product? This action cannot be undone.')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-4">
                                    <i class="fas fa-box-open fa-3x text-gray-300 mb-3"></i>
                                    <h5 class="text-muted">No loan products found</h5>
                                    <p class="text-muted mb-3">Get started by creating your first loan product</p>
                                    <a href="{{ route('loan-products.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus-circle me-2"></i> Create Loan Product
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($loanProducts->hasPages())
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Showing {{ $loanProducts->firstItem() ?? 0 }} to {{ $loanProducts->lastItem() ?? 0 }} of {{ $loanProducts->total() }} entries
                </div>
                <div>
                    {{ $loanProducts->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const productRows = document.querySelectorAll('.product-row');
        
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                
                productRows.forEach(row => {
                    const productName = row.querySelector('h6').textContent.toLowerCase();
                    const branches = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    const interestMethod = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                    
                    if (productName.includes(searchTerm) || 
                        branches.includes(searchTerm) || 
                        interestMethod.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
        
        // Enhanced delete confirmation
        const deleteForms = document.querySelectorAll('form[action*="destroy"]');
        deleteForms.forEach(form => {
            const deleteButton = form.querySelector('button[type="submit"]');
            if (deleteButton) {
                deleteButton.addEventListener('click', function(e) {
                    if (!confirm('Are you sure you want to delete this loan product? This action cannot be undone and will affect all associated data.')) {
                        e.preventDefault();
                    }
                });
            }
        });
    });
</script>
@endsection


