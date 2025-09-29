@extends('layouts.app')

@section('title', 'Past Maturity Loans')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Past Maturity Date Loans</h3>
                    <div class="card-tools">
                        <a href="{{ route('collection-sheets.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Create Collection Sheet
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($pastMaturityLoans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Borrower</th>
                                        <th>Loan ID</th>
                                        <th>Product</th>
                                        <th>Outstanding Balance</th>
                                        <th>Maturity Date</th>
                                        <th>Days Past Due</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pastMaturityLoans as $loan)
                                        @php
                                            $daysPastDue = $loan->maturity_date->diffInDays(Carbon\Carbon::today());
                                        @endphp
                                        <tr>
                                            <td>{{ $loan->borrower->full_name }}</td>
                                            <td>LOAN-{{ $loan->id }}</td>
                                            <td>{{ $loan->loanProduct->name ?? 'N/A' }}</td>
                                            <td>{{ number_format($loan->outstanding_balance, 2) }}</td>
                                            <td>{{ $loan->maturity_date->format('M d, Y') }}</td>
                                            <td>
                                                <span class="badge badge-danger">{{ $daysPastDue }} days</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-warning">Past Maturity</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('loans.show', $loan) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <button class="btn btn-sm btn-warning" 
                                                        onclick="alert('Collection action would go here')">
                                                    <i class="fas fa-hand-holding-usd"></i> Collect
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-success text-center">
                            <h5><i class="fas fa-check-circle"></i> No Past Maturity Loans</h5>
                            <p>All loans are within their maturity period.</p>
                        </div>
                    @endif
                </div>
                @if($pastMaturityLoans->count() > 0)
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="info-box bg-danger">
                                    <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Outstanding</span>
                                        <span class="info-box-number">{{ number_format($summary['total_outstanding'], 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box bg-warning">
                                    <span class="info-box-icon"><i class="fas fa-file-invoice"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Loans</span>
                                        <span class="info-box-number">{{ $summary['total_loans'] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box bg-info">
                                    <span class="info-box-icon"><i class="fas fa-calendar-times"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Oldest Maturity</span>
                                        <span class="info-box-number">
                                            {{ $summary['oldest_maturity'] ? $summary['oldest_maturity']->format('M d, Y') : 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection