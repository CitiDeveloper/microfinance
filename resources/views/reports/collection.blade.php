@extends('reports.layout')

@section('report-title', 'Collection Reports')
@section('report-description', 'Collection performance and staff efficiency')

@section('filters')
<form method="GET" action="{{ route('reports.collection') }}">
    <div class="row g-3">
        <div class="col-md-3">
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
        <div class="col-md-3">
            <label class="form-label">Date From</label>
            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Date To</label>
            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">&nbsp;</label>
            <div>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-2"></i>Apply Filters
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@section('report-content')
<!-- Staff Performance -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-transparent py-3">
                <h6 class="card-title mb-0">
                    <i class="fas fa-chart-line me-2"></i>Staff Collection Performance
                </h6>
            </div>
            <div class="card-body">
                @if($staffPerformance->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Staff Member</th>
                                <th>Total Collected</th>
                                <th>Transactions</th>
                                <th>Average Collection</th>
                                <th>Efficiency</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($staffPerformance as $staff)
                            <tr>
                                <td>
                                    <strong>{{ $staff->staff_firstname }} {{ $staff->staff_lastname }}</strong>
                                </td>
                                <td>{{ number_format($staff->total_collected, 2) }}</td>
                                <td>{{ $staff->total_transactions }}</td>
                                <td>{{ number_format($staff->total_collected / max($staff->total_transactions, 1), 2) }}</td>
                                <td>
                                    @php
                                        $efficiency = min(100, ($staff->total_transactions / max($collectionSheets->count(), 1)) * 100);
                                    @endphp
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                            <div class="progress-bar 
                                                @if($efficiency >= 80) bg-success
                                                @elseif($efficiency >= 60) bg-warning
                                                @else bg-danger @endif" 
                                                style="width: {{ $efficiency }}%">
                                            </div>
                                        </div>
                                        <small>{{ number_format($efficiency, 1) }}%</small>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No collection data found</h5>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Collection Sheets -->
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-transparent py-3">
                <h6 class="card-title mb-0">
                    <i class="fas fa-clipboard-list me-2"></i>Collection Sheets
                </h6>
            </div>
            <div class="card-body">
                @if($collectionSheets->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Sheet ID</th>
                                <th>Branch</th>
                                <th>Staff</th>
                                <th>Collection Date</th>
                                <th>Expected</th>
                                <th>Collected</th>
                                <th>Efficiency</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($collectionSheets as $sheet)
                            @php
                                $efficiency = $sheet->total_expected > 0 ? ($sheet->total_collected / $sheet->total_expected) * 100 : 0;
                            @endphp
                            <tr>
                                <td><strong>#{{ $sheet->id }}</strong></td>
                                <td>{{ $sheet->branch->branch_name ?? 'N/A' }}</td>
                                <td>{{ $sheet->staff->staff_firstname ?? 'N/A' }} {{ $sheet->staff->staff_lastname ?? '' }}</td>
                                <td>{{ $sheet->collection_date->format('M d, Y') }}</td>
                                <td>{{ number_format($sheet->total_expected, 2) }}</td>
                                <td>{{ number_format($sheet->total_collected, 2) }}</td>
                                <td>
                                    <span class="badge 
                                        @if($efficiency >= 90) bg-success
                                        @elseif($efficiency >= 70) bg-warning
                                        @else bg-danger @endif">
                                        {{ number_format($efficiency, 1) }}%
                                    </span>
                                </td>
                                <td>
                                    <span class="badge 
                                        @if($sheet->status == 'completed') bg-success
                                        @elseif($sheet->status == 'in_progress') bg-warning
                                        @else bg-secondary @endif">
                                        {{ ucfirst($sheet->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No collection sheets found</h5>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection