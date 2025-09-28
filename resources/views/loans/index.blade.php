@extends('layouts.app')

@section('title', 'Loans')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">All Loans</h3>
                    <a href="{{ route('loans.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> New Loan
                    </a>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-bordered text-nowrap">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Loan Product</th>
                                <th>Borrower</th>
                                <th>Principal</th>
                                <th>Interest Rate</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Release Date</th>
                                <th>Created At</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($loans as $loan)
                                <tr>
                                    <td>{{ $loan->id }}</td>
                                    <td>{{ $loan->loanProduct->name ?? 'N/A' }}</td>
                                    <td>{{ $loan->borrower->name ?? 'N/A' }}</td>
                                    <td>{{ number_format($loan->loan_principal_amount, 2) }}</td>
                                    <td>{{ $loan->loan_interest_rate }}% / {{ ucfirst($loan->loan_interest_period) }}</td>
                                    <td>{{ $loan->loan_duration }} {{ ucfirst($loan->loan_duration_period) }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($loan->loanStatus && $loan->loanStatus->name == 'Open') badge-success
                                            @elseif($loan->loanStatus && $loan->loanStatus->name == 'Processing') badge-warning
                                            @else badge-secondary @endif">
                                            {{ $loan->loanStatus->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>{{ $loan->loan_release_date ?? 'Not Set' }}</td>
                                    <td>{{ $loan->created_at->format('Y-m-d') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('loans.show', $loan->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('loans.edit', $loan->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('loans.destroy', $loan->id) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this loan?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted">
                                        No loans found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($loans->hasPages())
                    <div class="card-footer">
                        <div class="d-flex justify-content-center">
                            {{ $loans->links() }}
                        </div>
                    </div>
                @endif

            </div>

        </div>
    </div>
</div>
@endsection
