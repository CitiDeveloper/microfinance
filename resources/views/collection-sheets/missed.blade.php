@extends('layouts.app')

@section('title', 'Missed Repayments')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Missed Repayments</h3>
                    <div class="card-tools">
                        <a href="{{ route('collection-sheets.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Create Collection Sheet
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($missedRepayments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Borrower</th>
                                        <th>Loan ID</th>
                                        <th>Product</th>
                                        <th>Overdue Amount</th>
                                        <th>Due Date</th>
                                        <th>Days Overdue</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($missedRepayments as $loan)
                                        @foreach($loan->repaymentSchedule as $repayment)
                                            @php
                                                $daysOverdue = $repayment->due_date->diffInDays(Carbon\Carbon::today());
                                            @endphp
                                            <tr>
                                                <td>{{ $loan->borrower->full_name }}</td>
                                                <td>LOAN-{{ $loan->id }}</td>
                                                <td>{{ $loan->loanProduct->name ?? 'N/A' }}</td>
                                                <td>{{ number_format($repayment->due_amount, 2) }}</td>
                                                <td>{{ $repayment->due_date->format('M d, Y') }}</td>
                                                <td>
                                                    <span class="badge badge-danger">{{ $daysOverdue }} days</span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('loans.show', $loan) }}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                    <button class="btn btn-sm btn-warning" 
                                                            onclick="alert('Follow-up action would go here')">
                                                        <i class="fas fa-phone"></i> Follow Up
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-success text-center">
                            <h5><i class="fas fa-check-circle"></i> No Missed Repayments</h5>
                            <p>Great! There are no missed repayments at the moment.</p>
                        </div>
                    @endif
                </div>
                @if($missedRepayments->count() > 0)
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="info-box bg-danger">
                                    <span class="info-box-icon"><i class="fas fa-exclamation-triangle"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Overdue</span>
                                        <span class="info-box-number">{{ number_format($summary['total_overdue'], 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-warning">
                                    <span class="info-box-icon"><i class="fas fa-users"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Borrowers</span>
                                        <span class="info-box-number">{{ $summary['total_borrowers'] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-info">
                                    <span class="info-box-icon"><i class="fas fa-calendar"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Oldest Overdue</span>
                                        <span class="info-box-number">
                                            {{ $summary['oldest_overdue'] ? $summary['oldest_overdue']->format('M d, Y') : 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-secondary">
                                    <span class="info-box-icon"><i class="fas fa-file-invoice"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Items</span>
                                        <span class="info-box-number">
                                            {{ $missedRepayments->sum(function($loan) { return $loan->repaymentSchedule->count(); }) }}
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