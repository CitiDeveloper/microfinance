@extends('layouts.app')

@section('title', 'Branch Details - ' . $branch->branch_name)
<style>
.card {
    border: none;
    border-radius: 0.5rem;
}

.card-header {
    border-bottom: 1px solid rgba(0,0,0,.05);
}

.info-item {
    border-bottom: 1px solid rgba(0,0,0,.05);
    padding-bottom: 0.75rem;
}

.info-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.stat-card {
    transition: transform 0.2s;
}

.stat-card:hover {
    transform: translateY(-2px);
}

.template-box {
    font-family: 'SFMono-Regular', 'Menlo', 'Monaco', 'Consolas', monospace;
    font-size: 0.875rem;
}

.badge-lg {
    font-size: 0.8rem;
    padding: 0.35rem 0.75rem;
}

.table th {
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn {
    border-radius: 0.375rem;
    font-weight: 500;
}
</style>
@section('content')
<div class="content-wrapper">
    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-dark">
                        <i class="fas fa-code-branch mr-2 text-primary"></i>Branch Details
                    </h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('branches.index') }}">Branches</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row">
                <!-- Left Column: Branch Information -->
                <div class="col-lg-8">
                    <!-- Branch Information Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3 d-flex align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle mr-2 text-primary"></i>Branch Information
                            </h5>
                            <div class="card-tools ml-auto">
                                <span class="badge badge-{{ $branch->is_active ? 'success' : 'danger' }} badge-lg px-3 py-2">
                                    {{ $branch->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <label class="text-muted small mb-1">Branch Name</label>
                                        <p class="mb-0 font-weight-bold">{{ $branch->branch_name }}</p>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small mb-1">Open Date</label>
                                        <p class="mb-0">{{ $branch->formatted_open_date }}</p>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small mb-1">Country</label>
                                        <p class="mb-0">
                                            @if($branch->branch_country)
                                                <i class="fas fa-flag mr-1 text-muted"></i>
                                                {{ \App\Models\Branch::getCountryName($branch->branch_country) }}
                                            @else
                                                <span class="text-muted">Not set</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small mb-1">Currency</label>
                                        <p class="mb-0">
                                            @if($branch->branch_currency)
                                                {{ $branch->branch_currency }}
                                            @else
                                                <span class="text-muted">Not set</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <label class="text-muted small mb-1">Settings Override</label>
                                        <p class="mb-0">
                                            <span class="badge badge-{{ $branch->account_settings_override ? 'info' : 'secondary' }}">
                                                {{ $branch->account_settings_override ? 'Yes' : 'No' }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small mb-1">Created</label>
                                        <p class="mb-0">{{ $branch->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small mb-1">Last Updated</label>
                                        <p class="mb-0">{{ $branch->updated_at->format('M d, Y') }}</p>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small mb-1">Currency in Words</label>
                                        <p class="mb-0">
                                            {{ $branch->branch_currency_in_words ?? 'Not set' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information Card -->
                    @if($branch->branch_address || $branch->branch_city || $branch->branch_province)
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-map-marker-alt mr-2 text-info"></i>Address Information
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="info-item mb-3">
                                <label class="text-muted small mb-1">Full Address</label>
                                <p class="mb-0">{{ $branch->full_address ?? 'Not provided' }}</p>
                            </div>
                            
                            @if($branch->branch_landline || $branch->branch_mobile)
                            <div class="row">
                                @if($branch->branch_landline)
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <label class="text-muted small mb-1">
                                            <i class="fas fa-phone mr-1"></i>Landline
                                        </label>
                                        <p class="mb-0">{{ $branch->branch_landline }}</p>
                                    </div>
                                </div>
                                @endif
                                @if($branch->branch_mobile)
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <label class="text-muted small mb-1">
                                            <i class="fas fa-mobile-alt mr-1"></i>Mobile
                                        </label>
                                        <p class="mb-0">{{ $branch->branch_mobile }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Loan Restrictions Card -->
                    @if($branch->branch_min_loan_amount || $branch->branch_max_loan_amount || $branch->branch_min_interest_rate || $branch->branch_max_interest_rate)
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-hand-holding-usd mr-2 text-warning"></i>Loan Restrictions
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @if($branch->branch_min_loan_amount)
                                <div class="col-md-6 mb-3">
                                    <div class="stat-card bg-light rounded p-3 text-center">
                                        <div class="stat-icon mb-2">
                                            <i class="fas fa-arrow-down text-info fa-lg"></i>
                                        </div>
                                        <div class="stat-label text-muted small">Min Loan Amount</div>
                                        <div class="stat-value font-weight-bold">{{ number_format($branch->branch_min_loan_amount, 2) }}</div>
                                    </div>
                                </div>
                                @endif
                                @if($branch->branch_max_loan_amount)
                                <div class="col-md-6 mb-3">
                                    <div class="stat-card bg-light rounded p-3 text-center">
                                        <div class="stat-icon mb-2">
                                            <i class="fas fa-arrow-up text-success fa-lg"></i>
                                        </div>
                                        <div class="stat-label text-muted small">Max Loan Amount</div>
                                        <div class="stat-value font-weight-bold">{{ number_format($branch->branch_max_loan_amount, 2) }}</div>
                                    </div>
                                </div>
                                @endif
                                @if($branch->branch_min_interest_rate)
                                <div class="col-md-6 mb-3">
                                    <div class="stat-card bg-light rounded p-3 text-center">
                                        <div class="stat-icon mb-2">
                                            <i class="fas fa-percentage text-info fa-lg"></i>
                                        </div>
                                        <div class="stat-label text-muted small">Min Interest Rate</div>
                                        <div class="stat-value font-weight-bold">{{ $branch->branch_min_interest_rate }}%</div>
                                    </div>
                                </div>
                                @endif
                                @if($branch->branch_max_interest_rate)
                                <div class="col-md-6 mb-3">
                                    <div class="stat-card bg-light rounded p-3 text-center">
                                        <div class="stat-icon mb-2">
                                            <i class="fas fa-percentage text-success fa-lg"></i>
                                        </div>
                                        <div class="stat-label text-muted small">Max Interest Rate</div>
                                        <div class="stat-value font-weight-bold">{{ $branch->branch_max_interest_rate }}%</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Right Column: Actions and Statistics -->
                <div class="col-lg-4">
                    <!-- Actions Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-cogs mr-2 text-success"></i>Actions
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('branches.edit', $branch) }}" class="btn btn-primary btn-block py-2">
                                    <i class="fas fa-edit mr-2"></i>Edit Branch
                                </a>
                                <a href="{{ route('branches.index') }}" class="btn btn-outline-secondary btn-block py-2">
                                    <i class="fas fa-arrow-left mr-2"></i>Back to List
                                </a>
                                
                                @if($branch->staff_count == 0 && $branch->borrowers_count == 0 && $branch->loans_count == 0)
                                <form action="{{ route('branches.destroy', $branch) }}" method="POST" class="d-grid">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-block py-2" 
                                            onclick="return confirm('Are you sure you want to delete this branch?')">
                                        <i class="fas fa-trash mr-2"></i>Delete Branch
                                    </button>
                                </form>
                                @else
                                <button class="btn btn-danger btn-block py-2" disabled title="Cannot delete branch with related records">
                                    <i class="fas fa-trash mr-2"></i>Delete Branch
                                </button>
                                <small class="text-muted text-center d-block mt-1">
                                    <i class="fas fa-info-circle mr-1"></i>Cannot delete: Branch has related records
                                </small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-chart-bar mr-2 text-info"></i>Statistics
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <div class="stat-card bg-primary text-white rounded p-3 text-center">
                                        <div class="stat-icon mb-2">
                                            <i class="fas fa-users fa-lg"></i>
                                        </div>
                                        <div class="stat-label small">Staff</div>
                                        <div class="stat-value font-weight-bold">{{ $branch->staff_count }}</div>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="stat-card bg-success text-white rounded p-3 text-center">
                                        <div class="stat-icon mb-2">
                                            <i class="fas fa-user-friends fa-lg"></i>
                                        </div>
                                        <div class="stat-label small">Borrowers</div>
                                        <div class="stat-value font-weight-bold">{{ $branch->borrowers_count }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-card bg-warning text-white rounded p-3 text-center">
                                        <div class="stat-icon mb-2">
                                            <i class="fas fa-file-invoice-dollar fa-lg"></i>
                                        </div>
                                        <div class="stat-label small">Loans</div>
                                        <div class="stat-value font-weight-bold">{{ $branch->loans_count }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-card bg-info text-white rounded p-3 text-center">
                                        <div class="stat-icon mb-2">
                                            <i class="fas fa-piggy-bank fa-lg"></i>
                                        </div>
                                        <div class="stat-label small">Savings</div>
                                        <div class="stat-value font-weight-bold">{{ $branch->savings_count ?? 0 }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Unique Number Templates Card -->
                    @if($branch->borrower_num_placeholder || $branch->loan_num_placeholder)
                    <div class="card shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-hashtag mr-2 text-secondary"></i>Unique Number Templates
                            </h3>
                        </div>
                        <div class="card-body">
                            @if($branch->borrower_num_placeholder)
                            <div class="mb-3">
                                <label class="text-muted small mb-1">Borrower Template</label>
                                <div class="template-box bg-light border rounded p-2 font-monospace">
                                    {{ $branch->borrower_num_placeholder }}
                                </div>
                            </div>
                            @endif
                            @if($branch->loan_num_placeholder)
                            <div>
                                <label class="text-muted small mb-1">Loan Template</label>
                                <div class="template-box bg-light border rounded p-2 font-monospace">
                                    {{ $branch->loan_num_placeholder }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Related Data Section -->
            <div class="row mt-4">
                <!-- Loan Products Card -->
                @if($branch->loanProducts->count() > 0)
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white py-3 d-flex align-items-center">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-list-alt mr-2 text-primary"></i>Assigned Loan Products
                            </h3>
                            <span class="badge badge-primary ml-auto">{{ $branch->loanProducts->count() }}</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="border-0">Product Name</th>
                                            <th class="border-0">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($branch->loanProducts as $product)
                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td>
                                                <span class="badge badge-{{ $product->is_active ? 'success' : 'secondary' }}">
                                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Loan Officers Card -->
                @if($branch->loanOfficers->count() > 0)
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white py-3 d-flex align-items-center">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-user-tie mr-2 text-success"></i>Assigned Loan Officers
                            </h3>
                            <span class="badge badge-success ml-auto">{{ $branch->loanOfficers->count() }}</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="border-0">Officer Name</th>
                                            <th class="border-0">Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($branch->loanOfficers as $officer)
                                        <tr>
                                            <td>{{ $officer->name }}</td>
                                            <td>{{ $officer->email ?? 'N/A' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
</div>


@endsection