@extends('layouts.app')

@section('title', 'Loan Product Details')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>{{ $loanProduct->loan_product_name }}</h2>
        <a href="{{ route('loan-products.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
    </div>

    {{-- Basic Info --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Basic Information
        </div>
        <div class="card-body">
            <p><strong>Status:</strong> {{ $loanProduct->loanStatus?->name ?? 'N/A' }}</p>
            <p><strong>Active:</strong> {{ $loanProduct->is_active ? 'Yes' : 'No' }}</p>
            <p><strong>Branches:</strong> 
                @forelse($loanProduct->branches as $branch)
                    <span class="badge bg-info text-dark">{{ $branch->name }}</span>
                @empty
                    <span class="text-muted">No branches assigned</span>
                @endforelse
            </p>
        </div>
    </div>

    {{-- Principal --}}
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            Loan Principal
        </div>
        <div class="card-body row">
            <div class="col-md-4"><strong>Min:</strong> {{ number_format($loanProduct->min_loan_principal_amount, 2) }}</div>
            <div class="col-md-4"><strong>Default:</strong> {{ number_format($loanProduct->default_loan_principal_amount, 2) }}</div>
            <div class="col-md-4"><strong>Max:</strong> {{ number_format($loanProduct->max_loan_principal_amount, 2) }}</div>
        </div>
    </div>

    {{-- Interest --}}
    <div class="card mb-4">
        <div class="card-header bg-warning text-dark">
            Loan Interest
        </div>
        <div class="card-body row">
            <div class="col-md-4"><strong>Min:</strong> {{ number_format($loanProduct->min_loan_interest, 4) }}%</div>
            <div class="col-md-4"><strong>Default:</strong> {{ number_format($loanProduct->default_loan_interest, 4) }}%</div>
            <div class="col-md-4"><strong>Max:</strong> {{ number_format($loanProduct->max_loan_interest, 4) }}%</div>
            <div class="col-md-12 mt-2"><strong>Method:</strong> {{ ucfirst($loanProduct->loan_interest_method) }}</div>
            <div class="col-md-12"><strong>Type:</strong> {{ ucfirst($loanProduct->loan_interest_type) }}</div>
            <div class="col-md-12"><strong>Period:</strong> {{ ucfirst($loanProduct->loan_interest_period) }}</div>
        </div>
    </div>

    {{-- Duration --}}
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            Loan Duration
        </div>
        <div class="card-body row">
            <div class="col-md-4"><strong>Min:</strong> {{ $loanProduct->min_loan_duration }} {{ $loanProduct->loan_duration_period }}</div>
            <div class="col-md-4"><strong>Default:</strong> {{ $loanProduct->default_loan_duration }} {{ $loanProduct->loan_duration_period }}</div>
            <div class="col-md-4"><strong>Max:</strong> {{ $loanProduct->max_loan_duration }} {{ $loanProduct->loan_duration_period }}</div>
        </div>
    </div>

    {{-- Repayment --}}
    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            Repayment Information
        </div>
        <div class="card-body">
            <p><strong>Number of Repayments:</strong></p>
            <ul>
                <li>Min: {{ $loanProduct->min_loan_num_of_repayments }}</li>
                <li>Default: {{ $loanProduct->default_loan_num_of_repayments }}</li>
                <li>Max: {{ $loanProduct->max_loan_num_of_repayments }}</li>
            </ul>
            <p><strong>Repayment Order:</strong> 
                {{ is_array($loanProduct->repayment_order) ? implode(', ', $loanProduct->repayment_order) : 'N/A' }}
            </p>
        </div>
    </div>

    {{-- Parameters --}}
    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">
            Additional Parameters
        </div>
        <div class="card-body">
            <p><strong>Decimal Places:</strong> {{ $loanProduct->loan_decimal_places }}</p>
            <p><strong>Enable Parameters:</strong> {{ $loanProduct->loan_enable_parameters ? 'Yes' : 'No' }}</p>
            <p><strong>Stop Duplicate Repayments:</strong> {{ $loanProduct->stop_loan_duplicate_repayments ? 'Yes' : 'No' }}</p>
            <p><strong>Automatic Payments:</strong> {{ $loanProduct->automatic_payments ? 'Enabled' : 'Disabled' }}</p>
        </div>
    </div>
</div>
@endsection
