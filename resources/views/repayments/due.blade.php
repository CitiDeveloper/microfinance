@extends('layouts.app')

@section('title', 'Due Repayments')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-clock me-2"></i>Due Repayments
                    </h5>
                </div>

                <div class="card-body">
                    @if($repayments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>Borrower</th>
                                        <th>Loan</th>
                                        <th>Due Amount</th>
                                        <th>Due Date</th>
                                        <th>Branch</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($repayments as $repayment)
                                        <tr>
                                            <td>{{ $repayment->borrower->name ?? 'N/A' }}</td>
                                            <td>{{ $repayment->loan->loan_number ?? 'N/A' }}</td>
                                            <td class="text-success fw-bold">${{ number_format($repayment->amount, 2) }}</td>
                                            <td>
                                                <span class="badge bg-danger">{{ $repayment->payment_date->format('M d, Y') }}</span>
                                            </td>
                                            <td>{{ $repayment->branch->name ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('repayments.show', $repayment) }}" 
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-eye me-1"></i>View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Showing {{ $repayments->firstItem() }} to {{ $repayments->lastItem() }} of {{ $repayments->total() }} entries
                            </div>
                            {{ $repayments->links('pagination::bootstrap-4') }}
                        </div>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h4>No Due Repayments</h4>
                            <p class="mb-4">All repayments are up to date.</p>
                            <a href="{{ route('repayments.index') }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left me-1"></i>Back to All Repayments
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection