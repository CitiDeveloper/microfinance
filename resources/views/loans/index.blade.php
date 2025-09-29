@extends('layouts.app')

@section('title', 'Loans Management')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-hand-holding-usd text-primary me-2"></i>Loan Portfolio
                            </h4>
                            <a href="{{ route('loans.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle me-1"></i> New Loan
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">#</th>
                                        <th class="ps-4">ID</th>
                                        <th>Loan Product</th>
                                        <th>Borrower</th>
                                        <th class="text-end">Principal</th>
                                        <th class="text-center">Interest Rate</th>
                                        <th class="text-center">Duration</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Release Date</th>
                                        <th class="text-center">Created</th>
                                        <th class="text-center pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($loans as $key=> $loan)
                                        <tr class="align-middle">
                                            <td class="ps-4 fw-semibold text-muted">{{ $key + 1 }}</td>
                                            <td class="ps-4 fw-semibold text-muted">{{ $loan->loan_application_id }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-light rounded-circle p-2 me-2">
                                                        <i class="fas fa-file-invoice text-primary"></i>
                                                    </div>
                                                    <span>{{ $loan->loanProduct->loan_product_name ?? 'N/A' }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $loan->borrower->full_name ?? 'N/A' }}</span>
                                            </td>
                                            <td class="text-end fw-bold">

                                                {{ number_format($loan->loan_principal_amount, 2) }}
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $loanProduct = $loan->loanProduct;
                                                    $interestDetails = [];

                                                    if ($loanProduct) {
                                                        // Interest method and type
                                                        $interestMethod = $loanProduct->loan_interest_method ?? 'flat';
                                                        $interestType = $loanProduct->loan_interest_type ?? 'fixed';
                                                        $interestPeriod = $loanProduct->loan_interest_period ?? 'year';

                                                        // Build interest details
                                                        $interestDetails[] = $loan->loan_interest . '%'; // Changed from loan_interest_rate to loan_interest
                                                        $interestDetails[] = ucfirst($interestPeriod);

                                                        if ($interestMethod) {
                                                            $interestDetails[] = ucfirst($interestMethod);
                                                        }

                                                        if ($interestType) {
                                                            $interestDetails[] = ucfirst($interestType);
                                                        }
                                                    }
                                                @endphp
                                                <span class="badge bg-light text-dark"
                                                    title="{{ implode(' | ', $interestDetails) }}">
                                                    {{ number_format($loan->loan_interest, 2) }}% {{-- Changed from loan_interest_rate to loan_interest --}}
                                                    <small class="text-muted">/
                                                        {{ ucfirst($loanProduct->loan_interest_period ?? 'year') }}</small>
                                                </span>
                                                @if ($loanProduct && ($loanProduct->loan_interest_method !== 'flat' || $loanProduct->loan_interest_type !== 'fixed'))
                                                    <br>
                                                    <small class="text-muted">
                                                        {{ ucfirst($loanProduct->loan_interest_method) }} <br>
                                                        {{ ucfirst($loanProduct->loan_interest_type) }}
                                                    </small>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ $loan->loan_duration }} {{ ucfirst($loan->loan_duration_period) }}
                                                @if ($loanProduct && $loanProduct->default_loan_num_of_repayments)
                                                    <br>
                                                    <small class="text-muted">
                                                        {{ $loanProduct->default_loan_num_of_repayments }} repayments
                                                    </small>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $statusClass = 'bg-primary';
                                                    if ($loan->loanStatus) {
                                                        switch ($loan->loanStatus->name) {
                                                            case 'Open':
                                                                $statusClass = 'bg-success';
                                                                break;
                                                            case 'Processing':
                                                                $statusClass = 'bg-warning';
                                                                break;
                                                            case 'Closed':
                                                                $statusClass = 'bg-info';
                                                                break;
                                                            case 'Denied':
                                                                $statusClass = 'bg-danger';
                                                                break;
                                                            case 'Defaulted':
                                                                $statusClass = 'bg-danger';
                                                                break;
                                                        }
                                                    }
                                                @endphp
                                                <span class="badge {{ $statusClass }}">
                                                    {{ $loan->loanStatus->name ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @if ($loan->loan_released_date)
                                                    <span
                                                        class="text-muted">{{ $loan->loan_released_date->format('d-m-Y') }}</span>
                                                @else
                                                    <span class="text-warning">Not Set</span>
                                                @endif
                                            </td>
                                            <td class="text-center text-muted">
                                                {{ $loan->created_at->format('M j, Y') }}
                                            </td>
                                            <td class="text-center pe-4">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('loans.show', $loan->id) }}"
                                                        class="btn btn-sm btn-outline-info" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('loans.edit', $loan->id) }}"
                                                        class="btn btn-sm btn-outline-warning" title="Edit Loan">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center py-5">
                                                <div class="py-4">
                                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                    <h5 class="text-muted">No loans found</h5>
                                                    <p class="text-muted mb-0">Get started by creating your first loan
                                                        application</p>
                                                    <a href="{{ route('loans.create') }}" class="btn btn-primary mt-3">
                                                        <i class="fas fa-plus me-1"></i> Create New Loan
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($loans->hasPages())
                        <div class="card-footer bg-white border-top py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted small">
                                    Showing {{ $loans->firstItem() ?? 0 }} to {{ $loans->lastItem() ?? 0 }} of
                                    {{ $loans->total() }} entries
                                </div>
                                <div>

                                    {{ $loans->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
