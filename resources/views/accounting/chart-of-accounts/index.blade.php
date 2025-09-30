{{-- resources/views/accounting/chart-of-accounts/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Chart of Accounts')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <div class="page-pretitle">Accounting</div>
                <h1 class="page-title">Chart of Accounts</h1>
            </div>
            <div class="col-auto">
                <div class="btn-list">
                    <a href="{{ route('accounting.account-types.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-cog me-2"></i>
                        Manage Account Types
                    </a>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAccountModal">
                        <i class="fas fa-plus-circle me-2"></i>
                        Create Account
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row row-deck row-cards mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-primary text-white avatar">
                                <i class="fas fa-chart-pie"></i>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">{{ $totalAccounts }} Total Accounts</div>
                            <div class="text-muted">All account records</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-success text-white avatar">
                                <i class="fas fa-check-circle"></i>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">{{ $activeAccounts }} Active</div>
                            <div class="text-muted">Currently active accounts</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-warning text-white avatar">
                                <i class="fas fa-pause-circle"></i>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">{{ $inactiveAccounts }} Inactive</div>
                            <div class="text-muted">Currently inactive accounts</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-info text-white avatar">
                                <i class="fas fa-layer-group"></i>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">{{ $categoriesCount }} Categories</div>
                            <div class="text-muted">Account categories</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Accounts Management</h3>
            <div class="card-actions">
                <div class="input-icon me-2" style="width: 300px;">
                    <input type="text" class="form-control" placeholder="Search accounts..." id="searchInput">
                    <span class="input-icon-addon">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
                <div class="dropdown">
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-download me-2"></i>Export
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-file-excel me-2"></i>Excel
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-file-pdf me-2"></i>PDF
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-file-csv me-2"></i>CSV
                        </a>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-primary ms-2" id="refreshBtn">
                    <i class="fas fa-sync-alt me-2"></i>Refresh
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Accounts Table -->
            <div class="table-responsive">
                <table id="accountsTable" class="table table-hover table-vcenter">
                    <thead>
                        <tr>
                            <th width="100">Code</th>
                            <th>Account Name</th>
                            <th>Type</th>
                            <th>Category</th>
                            <th>Normal Balance</th>
                            <th>Current Balance</th>
                            <th>Status</th>
                            <th width="120" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accounts as $account)
                        <tr class="{{ $account->parent_id ? 'child-row' : 'parent-row' }}" data-level="{{ $account->parent_id ? 1 : 0 }}">
                            <td>
                                <span class="font-weight-bold text-primary">{{ $account->code }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($account->parent_id)
                                    <span class="text-muted me-2">
                                        <i class="fas fa-level-down-alt fa-rotate-90"></i>
                                    </span>
                                    @endif
                                    <div>
                                        <div class="font-weight-medium">{{ $account->name }}</div>
                                        @if($account->description)
                                        <div class="text-muted text-sm">{{ Str::limit($account->description, 50) }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $account->accountType->name }}</span>
                            </td>
                            <td>
                                @php
                                    $categoryColors = [
                                        'asset' => 'blue',
                                        'liability' => 'green',
                                        'equity' => 'cyan',
                                        'income' => 'yellow',
                                        'expense' => 'red'
                                    ];
                                    $color = $categoryColors[$account->accountType->category] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }}-lt">
                                    <i class="fas fa-{{ $account->accountType->category === 'asset' ? 'building' : ($account->accountType->category === 'liability' ? 'hand-holding-usd' : ($account->accountType->category === 'equity' ? 'users' : ($account->accountType->category === 'income' ? 'arrow-up' : 'arrow-down'))) }} me-1"></i>
                                    {{ ucfirst($account->accountType->category) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $account->normal_balance === 'debit' ? 'dark' : 'secondary' }}">
                                    <i class="fas fa-{{ $account->normal_balance === 'debit' ? 'arrow-left' : 'arrow-right' }} me-1"></i>
                                    {{ ucfirst($account->normal_balance) }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $balance = $account->balance;
                                    $isPositive = $balance >= 0;
                                    $balanceClass = $isPositive ? 'text-success' : 'text-danger';
                                    $balanceIcon = $isPositive ? 'arrow-up' : 'arrow-down';
                                @endphp
                                <span class="font-weight-bold {{ $balanceClass }}">
                                    <i class="fas fa-{{ $balanceIcon }} me-1"></i>
                                    {{ number_format(abs($balance), 2) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $account->is_active ? 'success' : 'danger' }}-lt">
                                    <i class="fas fa-{{ $account->is_active ? 'check' : 'times' }} me-1"></i>
                                    {{ $account->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('accounting.chart-of-accounts.show', $account) }}" 
                                       class="btn btn-sm btn-icon btn-info" 
                                       data-bs-toggle="tooltip" 
                                       title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('accounting.chart-of-accounts.edit', $account) }}" 
                                       class="btn btn-sm btn-icon btn-warning" 
                                       data-bs-toggle="tooltip" 
                                       title="Edit Account">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('accounting.chart-of-accounts.toggle-status', $account) }}" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="btn btn-sm btn-icon btn-{{ $account->is_active ? 'secondary' : 'success' }}" 
                                                data-bs-toggle="tooltip" 
                                                title="{{ $account->is_active ? 'Deactivate' : 'Activate' }}">
                                            <i class="fas fa-{{ $account->is_active ? 'pause' : 'play' }}"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex align-items-center mt-4">
                <div class="me-auto">
                    <div class="text-muted">
                        Showing {{ $accounts->firstItem() ?? 0 }} to {{ $accounts->lastItem() ?? 0 }} of {{ $accounts->total() }} entries
                    </div>
                </div>
                <div>
                    {{ $accounts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Account Modal -->
<div class="modal fade" id="createAccountModal" tabindex="-1" role="dialog" aria-labelledby="createAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createAccountModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Create New Account
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('accounting.chart-of-accounts.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="account_type_id" class="form-label">Account Type <span class="text-danger">*</span></label>
                                <select name="account_type_id" id="account_type_id" class="form-select" required>
                                    <option value="">Select Account Type</option>
                                    @foreach($accountTypes as $type)
                                    <option value="{{ $type->id }}" data-category="{{ $type->category }}">
                                        {{ $type->name }} ({{ $type->code }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="parent_id" class="form-label">Parent Account</label>
                                <select name="parent_id" id="parent_id" class="form-select">
                                    <option value="">No Parent (Main Account)</option>
                                    @foreach($parentAccounts as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->code }} - {{ $parent->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="code" class="form-label">Account Code <span class="text-danger">*</span></label>
                                <input type="text" name="code" id="code" class="form-control" required 
                                       placeholder="e.g., 1010">
                                <small class="form-text text-muted">Unique code for the account</small>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="name" class="form-label">Account Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" required 
                                       placeholder="e.g., Cash on Hand">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="normal_balance" class="form-label">Normal Balance <span class="text-danger">*</span></label>
                                <select name="normal_balance" id="normal_balance" class="form-select" required>
                                    <option value="debit">Debit</option>
                                    <option value="credit">Credit</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="is_active" class="form-label">Status</label>
                                <select name="is_active" id="is_active" class="form-select">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="3" 
                                  placeholder="Optional account description..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Create Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .parent-row {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    .child-row {
        background-color: #ffffff;
    }
    .child-row td:first-child {
        padding-left: 40px !important;
    }
    .table-vcenter td {
        vertical-align: middle;
    }
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .page-header {
        margin-bottom: 2rem;
    }
    .avatar {
        width: 3rem;
        height: 3rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    .badge.bg-blue-lt {
        background-color: rgba(0, 123, 255, 0.1) !important;
        color: #0d6efd;
        border: 1px solid rgba(0, 123, 255, 0.2);
    }
    .badge.bg-green-lt {
        background-color: rgba(40, 167, 69, 0.1) !important;
        color: #28a745;
        border: 1px solid rgba(40, 167, 69, 0.2);
    }
    .badge.bg-cyan-lt {
        background-color: rgba(23, 162, 184, 0.1) !important;
        color: #17a2b8;
        border: 1px solid rgba(23, 162, 184, 0.2);
    }
    .badge.bg-yellow-lt {
        background-color: rgba(255, 193, 7, 0.1) !important;
        color: #ffc107;
        border: 1px solid rgba(255, 193, 7, 0.2);
    }
    .badge.bg-red-lt {
        background-color: rgba(220, 53, 69, 0.1) !important;
        color: #dc3545;
        border: 1px solid rgba(220, 53, 69, 0.2);
    }
    .badge.bg-success-lt {
        background-color: rgba(40, 167, 69, 0.1) !important;
        color: #28a745;
        border: 1px solid rgba(40, 167, 69, 0.2);
    }
    .badge.bg-danger-lt {
        background-color: rgba(220, 53, 69, 0.1) !important;
        color: #dc3545;
        border: 1px solid rgba(220, 53, 69, 0.2);
    }
    .input-icon {
        position: relative;
    }
    .input-icon .form-control {
        padding-left: 2.5rem;
    }
    .input-icon-addon {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 2.5rem;
        color: #6c757d;
        pointer-events: none;
    }
    .btn-icon {
        width: 2rem;
        height: 2rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DataTable
        const accountsTable = new simpleDatatables.DataTable("#accountsTable", {
            searchable: true,
            fixedHeight: false,
            perPage: 10,
            perPageSelect: [10, 25, 50, 100],
            labels: {
                placeholder: "Search accounts...",
                searchTitle: "Search within table",
                pageTitle: "Page {page}",
                perPage: "entries per page",
                noRows: "No entries to found",
                info: "Showing {start} to {end} of {rows} entries",
                noResults: "No results match your search query",
            }
        });

        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Refresh button functionality
        document.getElementById('refreshBtn').addEventListener('click', function() {
            window.location.reload();
        });

        // Auto-suggest normal balance based on account type category
        document.getElementById('account_type_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const category = selectedOption.getAttribute('data-category');
            
            if (category) {
                let normalBalance = 'debit';
                if (['liability', 'equity', 'income'].includes(category)) {
                    normalBalance = 'credit';
                }
                document.getElementById('normal_balance').value = normalBalance;
            }
        });

        // Search functionality
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                accountsTable.search(this.value);
            });
        }
    });
</script>
@endpush