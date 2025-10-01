{{-- resources/views/accounting/trial-balance.blade.php --}}
@extends('layouts.app')

@section('title', 'Trial Balance')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Trial Balance</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('accounting.journal-entries') }}">Accounting</a></li>
                        <li class="breadcrumb-item active">Trial Balance</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Filters Card -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Report Filters</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('accounting.trial-balance') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="start_date">From Date</label>
                                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                                   value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="end_date">To Date</label>
                                            <input type="date" class="form-control" id="end_date" name="end_date" 
                                                   value="{{ request('end_date', now()->format('Y-m-d')) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="branch_id">Branch</label>
                                            <select class="form-control select2" id="branch_id" name="branch_id">
                                                <option value="">All Branches</option>
                                                @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                                    {{ $branch->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="d-flex">
                                                <button type="submit" class="btn btn-primary mr-2">
                                                    <i class="fas fa-filter"></i> Generate Report
                                                </button>
                                                <a href="{{ route('accounting.trial-balance') }}" class="btn btn-secondary">
                                                    <i class="fas fa-redo"></i> Reset
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Summary -->
            <div class="row mb-3">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalAccounts }}</h3>
                            <p>Total Accounts</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ number_format($totalDebit, 2) }}</h3>
                            <p>Total Debit</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-arrow-left"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ number_format($totalCredit, 2) }}</h3>
                            <p>Total Credit</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box {{ $totalDebit == $totalCredit ? 'bg-primary' : 'bg-danger' }}">
                        <div class="inner">
                            <h3>{{ number_format(abs($totalDebit - $totalCredit), 2) }}</h3>
                            <p>{{ $totalDebit == $totalCredit ? 'Balanced' : 'Difference' }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trial Balance Report -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                Trial Balance Report
                                <small class="ml-2">
                                    ({{ \Carbon\Carbon::parse(request('start_date', now()->startOfMonth()->format('Y-m-d')))->format('M d, Y') }} 
                                    to 
                                    {{ \Carbon\Carbon::parse(request('end_date', now()->format('Y-m-d')))->format('M d, Y') }})
                                </small>
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                                        <i class="fas fa-download mr-1"></i> Export
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" onclick="exportToPDF()">
                                            <i class="fas fa-file-pdf mr-1"></i> PDF
                                        </a>
                                        <a class="dropdown-item" href="#" onclick="exportToExcel()">
                                            <i class="fas fa-file-excel mr-1"></i> Excel
                                        </a>
                                        <a class="dropdown-item" href="#" onclick="exportToCSV()">
                                            <i class="fas fa-file-csv mr-1"></i> CSV
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="trialBalanceTable" class="table table-bordered table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th width="80">Account Code</th>
                                            <th>Account Name</th>
                                            <th class="text-right">Debit ({{ config('app.currency', 'USD') }})</th>
                                            <th class="text-right">Credit ({{ config('app.currency', 'USD') }})</th>
                                            <th class="text-right">Balance ({{ config('app.currency', 'USD') }})</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($accounts as $account)
                                        <tr class="{{ $account['account']->parent_id ? 'child-row' : 'parent-row' }}">
                                            <td>
                                                <strong class="{{ $account['account']->parent_id ? 'text-muted' : 'text-primary' }}">
                                                    {{ $account['account']->code }}
                                                </strong>
                                            </td>
                                            <td>
                                                @if($account['account']->parent_id)
                                                <span class="ml-3"><i class="fas fa-level-down-alt text-muted mr-1"></i></span>
                                                @endif
                                                {{ $account['account']->name }}
                                            </td>
                                            <td class="text-right">
                                                @if($account['debit'] > 0)
                                                <span class="text-danger font-weight-bold">{{ number_format($account['debit'], 2) }}</span>
                                                @else
                                                <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                @if($account['credit'] > 0)
                                                <span class="text-success font-weight-bold">{{ number_format($account['credit'], 2) }}</span>
                                                @else
                                                <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                @php
                                                    $balance = $account['balance'];
                                                    $isPositive = $balance >= 0;
                                                    $balanceClass = $isPositive ? 'text-success' : 'text-danger';
                                                    $balanceIcon = $isPositive ? 'arrow-up' : 'arrow-down';
                                                @endphp
                                                <span class="font-weight-bold {{ $balanceClass }}">
                                                    <i class="fas fa-{{ $balanceIcon }} mr-1"></i>
                                                    {{ number_format(abs($balance), 2) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-light font-weight-bold">
                                        <tr>
                                            <td colspan="2" class="text-right">TOTALS:</td>
                                            <td class="text-right text-danger">{{ number_format($totalDebit, 2) }}</td>
                                            <td class="text-right text-success">{{ number_format($totalCredit, 2) }}</td>
                                            <td class="text-right">
                                                @if($totalDebit == $totalCredit)
                                                <span class="text-success">
                                                    <i class="fas fa-check-circle mr-1"></i>BALANCED
                                                </span>
                                                @else
                                                <span class="text-danger">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>UNBALANCED
                                                </span>
                                                @endif
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Notes -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Report Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6><i class="fas fa-info-circle mr-2"></i>About Trial Balance</h6>
                                    <p class="text-muted mb-0">
                                        The Trial Balance shows all account balances for the selected period. 
                                        Total debits should equal total credits when the books are balanced.
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h6><i class="fas fa-clock mr-2"></i>Report Generated</h6>
                                    <p class="text-muted mb-0">
                                        {{ now()->format('F d, Y \a\t h:i A') }}<br>
                                        Period: {{ \Carbon\Carbon::parse(request('start_date', now()->startOfMonth()->format('Y-m-d')))->format('M d, Y') }} 
                                        to {{ \Carbon\Carbon::parse(request('end_date', now()->format('Y-m-d')))->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    .parent-row {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    .child-row {
        background-color: #ffffff;
    }
    .child-row td:first-child {
        padding-left: 40px !important;
    }
    .table-bordered {
        border: 1px solid #dee2e6;
    }
    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({
            theme: 'bootstrap4'
        });

        // Initialize DataTable
        $('#trialBalanceTable').DataTable({
            "paging": false,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "responsive": true,
            "order": [[0, 'asc']],
            "language": {
                "search": "_INPUT_",
                "searchPlaceholder": "Search accounts...",
                "emptyTable": "No data available for the selected period",
                "zeroRecords": "No matching accounts found"
            }
        });

        // Set default dates if not provided
        if (!$('#start_date').val()) {
            $('#start_date').val('{{ now()->startOfMonth()->format("Y-m-d") }}');
        }
        if (!$('#end_date').val()) {
            $('#end_date').val('{{ now()->format("Y-m-d") }}');
        }
    });

    function exportToPDF() {
        // Implement PDF export functionality
        alert('PDF export functionality would be implemented here');
    }

    function exportToExcel() {
        // Implement Excel export functionality
        alert('Excel export functionality would be implemented here');
    }

    function exportToCSV() {
        // Implement CSV export functionality
        alert('CSV export functionality would be implemented here');
    }
</script>
@endpush