@extends('layouts.app')

@section('title', 'Repayments Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-money-bill-wave me-2"></i>Repayments Management
                    </h5>
                    <div>
                        <a href="{{ route('repayments.due') }}" class="btn btn-warning btn-sm me-2">
                            <i class="fas fa-clock me-1"></i>Due Repayments
                        </a>
                        <a href="{{ route('repayments.create') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-plus me-1"></i>New Repayment
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filters -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form method="GET" class="row g-3">
                                <div class="col-md-3">
                                    <input type="text" name="search" class="form-control" placeholder="Search..." 
                                           value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <select name="status" class="form-select">
                                        <option value="">All Status</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="posted" {{ request('status') == 'posted' ? 'selected' : '' }}>Posted</option>
                                        <option value="reversed" {{ request('status') == 'reversed' ? 'selected' : '' }}>Reversed</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="branch_id" class="form-select">
                                        <option value="">All Branches</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="fas fa-filter me-1"></i>Filter
                                    </button>
                                    <a href="{{ route('repayments.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-redo me-1"></i>Reset
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Repayments Table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Receipt #</th>
                                    <th>Borrower</th>
                                    <th>Loan</th>
                                    <th>Amount</th>
                                    <th>Payment Date</th>
                                    <th>Status</th>
                                    <th>Branch</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($repayments as $repayment)
                                    <tr>
                                        <td>
                                            <strong>{{ $repayment->receipt_number ?? 'N/A' }}</strong>
                                            @if($repayment->transaction_reference)
                                                <br><small class="text-muted">{{ $repayment->transaction_reference }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $repayment->borrower->full_name ?? 'N/A' }}</td>
                                        <td>{{ $repayment->loan->loan_application_id ?? 'N/A' }}</td>
                                        <td>
                                            <strong class="text-success">${{ number_format($repayment->amount, 2) }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                P: ${{ number_format($repayment->principal_paid, 2) }} | 
                                                I: ${{ number_format($repayment->interest_paid, 2) }}
                                            </small>
                                        </td>
                                        <td>{{ $repayment->payment_date->format('M d, Y') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $repayment->status === 'posted' ? 'success' : ($repayment->status === 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($repayment->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $repayment->branch->name ?? 'N/A' }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('repayments.show', $repayment) }}" 
                                                   class="btn btn-outline-primary" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if(!$repayment->isPosted())
                                                    <a href="{{ route('repayments.edit', $repayment) }}" 
                                                       class="btn btn-outline-secondary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            <i class="fas fa-money-bill-wave fa-2x mb-3"></i>
                                            <p>No repayments found.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Showing {{ $repayments->firstItem() }} to {{ $repayments->lastItem() }} of {{ $repayments->total() }} entries
                        </div>
                        {{ $repayments->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection