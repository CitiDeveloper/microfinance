@extends('reports.layout')

@section('report-title', 'Performance Reports')
@section('report-description', 'Branch and portfolio performance metrics')

@section('filters')
<form method="GET" action="{{ route('reports.performance') }}">
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Branch</label>
            <select name="branch_id" class="form-select">
                <option value="">All Branches</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->branch_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Date From</label>
            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Date To</label>
            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search me-2"></i>Apply Filters
            </button>
            <a href="{{ route('reports.performance') }}" class="btn btn-outline-secondary">
                <i class="fas fa-refresh me-2"></i>Reset
            </a>
        </div>
    </div>
</form>
@endsection

@section('report-content')
<!-- Loan Performance -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-transparent py-3">
                <h6 class="card-title mb-0">
                    <i class="fas fa-chart-pie me-2"></i>Loan Performance by Branch
                </h6>
            </div>
            <div class="card-body">
                @if($loanPerformance->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Branch</th>
                                <th>Status</th>
                                <th>Loan Count</th>
                                <th>Total Principal</th>
                                <th>Average Loan Size</th>
                                <th>Portfolio Share</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalPortfolio = $loanPerformance->sum('total_principal');
                            @endphp
                            @foreach($loanPerformance as $performance)
                            @php
                                $portfolioShare = $totalPortfolio > 0 ? ($performance->total_principal / $totalPortfolio) * 100 : 0;
                            @endphp
                            <tr>
                                <td><strong>{{ $performance->branch_name }}</strong></td>
                                <td>
                                    <span class="badge 
                                        @if($performance->name == 'Open') bg-success
                                        @elseif($performance->name == 'Defaulted') bg-danger
                                        @elseif($performance->name == 'Processing') bg-warning
                                        @else bg-secondary @endif">
                                        {{ $performance->name }}
                                    </span>
                                </td>
                                <td>{{ $performance->loan_count }}</td>
                                <td>{{ number_format($performance->total_principal, 2) }}</td>
                                <td>{{ number_format($performance->avg_loan_size, 2) }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                            <div class="progress-bar bg-info" style="width: {{ $portfolioShare }}%"></div>
                                        </div>
                                        <small>{{ number_format($portfolioShare, 1) }}%</small>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-chart-pie fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No performance data found</h5>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Risk Metrics -->
<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-transparent py-3">
                <h6 class="card-title mb-0 text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>Portfolio at Risk
                </h6>
            </div>
            <div class="card-body">
                @if($portfolioAtRisk->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Branch</th>
                                <th>Risky Loans</th>
                                <th>Risky Amount</th>
                                <th>Risk Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($portfolioAtRisk as $risk)
                            @php
                                $totalBranchPortfolio = $loanPerformance->where('branch_name', $risk->branch_name)->sum('total_principal');
                                $riskPercentage = $totalBranchPortfolio > 0 ? ($risk->risky_amount / $totalBranchPortfolio) * 100 : 0;
                            @endphp
                            <tr>
                                <td>{{ $risk->branch_name }}</td>
                                <td>{{ $risk->risky_loans }}</td>
                                <td>{{ number_format($risk->risky_amount, 2) }}</td>
                                <td>
                                    <span class="badge 
                                        @if($riskPercentage < 5) bg-success
                                        @elseif($riskPercentage < 10) bg-warning
                                        @else bg-danger @endif">
                                        {{ number_format($riskPercentage, 1) }}%
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <p class="text-muted mb-0">No significant portfolio risk detected</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-transparent py-3">
                <h6 class="card-title mb-0 text-success">
                    <i class="fas fa-tachometer-alt me-2"></i>Collection Efficiency
                </h6>
            </div>
            <div class="card-body">
                @if($collectionEfficiency->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Branch</th>
                                <th>Actual Collection</th>
                                <th>Transactions</th>
                                <th>Avg per Transaction</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($collectionEfficiency as $efficiency)
                            <tr>
                                <td>{{ $efficiency->branch_name }}</td>
                                <td>{{ number_format($efficiency->actual_collection, 2) }}</td>
                                <td>{{ $efficiency->transactions_count }}</td>
                                <td>{{ number_format($efficiency->actual_collection / max($efficiency->transactions_count, 1), 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-chart-line fa-2x text-muted mb-2"></i>
                    <p class="text-muted mb-0">No collection efficiency data available</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection