@extends('layouts.app')

@section('title', 'Daily Collection')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daily Collection - {{ $today->format('F d, Y') }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('collection-sheets.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Create Collection Sheet
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($dueRepayments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Borrower</th>
                                        <th>Loan ID</th>
                                        <th>Product</th>
                                        <th>Due Amount</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dueRepayments as $loan)
                                        @foreach($loan->repaymentSchedule as $repayment)
                                            <tr>
                                                <td>{{ $loan->borrower->full_name }}</td>
                                                <td>LOAN-{{ $loan->id }}</td>
                                                <td>{{ $loan->loanProduct->name ?? 'N/A' }}</td>
                                                <td>{{ number_format($repayment->due_amount, 2) }}</td>
                                                <td>{{ $repayment->due_date->format('M d, Y') }}</td>
                                                <td>
                                                    <span class="badge badge-warning">Due Today</span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('loans.show', $loan) }}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i> View Loan
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info text-center">
                            <h5><i class="fas fa-info-circle"></i> No Due Repayments Today</h5>
                            <p>There are no repayments due for collection today.</p>
                        </div>
                    @endif
                </div>
                @if($dueRepayments->count() > 0)
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>{{ number_format($summary['total_expected'], 2) }}</h3>
                                        <p>Total Expected Today</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h3>{{ $summary['total_borrowers'] }}</h3>
                                        <p>Borrowers Due Today</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>{{ $dueRepayments->sum(function($loan) { return $loan->repaymentSchedule->count(); }) }}</h3>
                                        <p>Total Installments</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-list"></i>
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