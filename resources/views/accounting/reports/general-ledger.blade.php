{{-- resources/views/accounting/reports/general-ledger.blade.php --}}
@extends('layouts.app')

@section('title', 'General Ledger')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">General Ledger</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('accounting.journal-entries') }}">Accounting</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('accounting.reports.general-ledger') }}">Reports</a></li>
                        <li class="breadcrumb-item active">General Ledger</li>
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
                            <form action="{{ route('accounting.reports.general-ledger') }}" method="GET">
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
                                            <label for="account_id">Account</label>
                                            <select class="form-control select2" id="account_id" name="account_id">
                                                <option value="">All Accounts</option>
                                                @foreach($accounts as $account)
                                                <option value="{{ $account->id }}" {{ request('account_id') == $account->id ? 'selected' : '' }}>
                                                    {{ $account->code }} - {{ $account->name }}
                                                </option>
                                                @endforeach
                                            </select>
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
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn btn-primary mr-2">
                                            <i class="fas fa-filter"></i> Generate Report
                                        </button>
                                        <a href="{{ route('accounting.reports.general-ledger') }}" class="btn btn-secondary">
                                            <i class="fas fa-redo"></i> Reset
                                        </a>
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
                            <h3>{{ $totalTransactions }}</h3>
                            <p>Total Transactions</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-exchange-alt"></i>
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
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $uniqueAccounts }}</h3>
                            <p>Accounts</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- General Ledger Report -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                General Ledger Report
                                <small class="ml-2">
                                    @if(request('account_id'))
                                    for {{ $selectedAccount->code }} - {{ $selectedAccount->name }}
                                    @endif
                                    ({{ \Carbon\Carbon::parse(request('start_date', now()->startOfMonth()->format('Y-m-d')))->format('M d, Y') }} 
                                    to {{ \Carbon\Carbon::parse(request('end_date', now()->format('Y-m-d')))->format('M d, Y') }})
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
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(request('account_id'))
                                <!-- Single Account Ledger -->
                                <div class="table-responsive">
                                    <table id="generalLedgerTable" class="table table-bordered table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th width="120">Date</th>
                                                <th width="120">Entry #</th>
                                                <th>Description</th>
                                                <th class="text-right">Debit ({{ config('app.currency', 'USD') }})</th>
                                                <th class="text-right">Credit ({{ config('app.currency', 'USD') }})</th>
                                                <th class="text-right">Balance ({{ config('app.currency', 'USD') }})</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $runningBalance = 0;
                                            @endphp
                                            @foreach($transactions as $transaction)
                                            @php
                                                $debit = $transaction->debit;
                                                $credit = $transaction->credit;
                                                
                                                if ($selectedAccount->normal_balance === 'debit') {
                                                    $runningBalance += $debit - $credit;
                                                } else {
                                                    $runningBalance += $credit - $debit;
                                                }
                                            @endphp
                                            <tr>
                                                <td>{{ $transaction->journalEntry->entry_date->format('M d, Y') }}</td>
                                                <td>
                                                    <a href="{{ route('accounting.journal-entries.show', $transaction->journalEntry) }}" 
                                                       class="text-primary">
                                                        {{ $transaction->journalEntry->entry_number }}
                                                    </a>
                                                </td>
                                                <td>
                                                    {{ $transaction->journalEntry->description }}
                                                    @if($transaction->description)
                                                    <br><small class="text-muted">{{ $transaction->description }}</small>
                                                    @endif
                                                </td>
                                                <td class="text-right">
                                                    @if($debit > 0)
                                                    <span class="text-danger font-weight-bold">{{ number_format($debit, 2) }}</span>
                                                    @else
                                                    <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-right">
                                                    @if($credit > 0)
                                                    <span class="text-success font-weight-bold">{{ number_format($credit, 2) }}</span>
                                                    @else
                                                    <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-right font-weight-bold">
                                                    <span class="{{ $runningBalance >= 0 ? 'text-success' : 'text-danger' }}">
                                                        {{ number_format($runningBalance, 2) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="bg-light font-weight-bold">
                                            <tr>
                                                <td colspan="3" class="text-right">TOTALS:</td>
                                                <td class="text-right text-danger">{{ number_format($transactions->sum('debit'), 2) }}</td>
                                                <td class="text-right text-success">{{ number_format($transactions->sum('credit'), 2) }}</td>
                                                <td class="text-right">
                                                    <span class="{{ $runningBalance >= 0 ? 'text-success' : 'text-danger' }}">
                                                        {{ number_format($runningBalance, 2) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @else
                                <!-- All Accounts Summary -->
                                <div class="table-responsive">
                                    <table id="generalLedgerTable" class="table table-bordered table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Account Code</th>
                                                <th>Account Name</th>
                                                <th class="text-right">Debit Total</th>
                                                <th class="text-right">Credit Total</th>
                                                <th class="text-right">Balance</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($accountSummaries as $summary)
                                            <tr>
                                                <td><strong>{{ $summary['account']->code }}</strong></td>
                                                <td>{{ $summary['account']->name }}</td>
                                                <td class="text-right text-danger font-weight-bold">
                                                    {{ number_format($summary['debit'], 2) }}
                                                </td>
                                                <td class="text-right text-success font-weight-bold">
                                                    {{ number_format($summary['credit'], 2) }}
                                                </td>
                                                <td class="text-right font-weight-bold">
                                                    @php
                                                        $balance = $summary['account']->normal_balance === 'debit' 
                                                            ? $summary['debit'] - $summary['credit']
                                                            : $summary['credit'] - $summary['debit'];
                                                    @endphp
                                                    <span class="{{ $balance >= 0 ? 'text-success' : 'text-danger' }}">
                                                        {{ number_format($balance, 2) }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('accounting.reports.general-ledger', array_merge(request()->all(), ['account_id' => $summary['account']->id])) }}" 
                                                       class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i> View Ledger
                                                    </a>
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
                                                    @php
                                                        $netBalance = $totalDebit - $totalCredit;
                                                    @endphp
                                                    <span class="{{ $netBalance == 0 ? 'text-success' : 'text-danger' }}">
                                                        {{ number_format($netBalance, 2) }}
                                                    </span>
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Information -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Report Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6><i class="fas fa-info-circle mr-2"></i>About General Ledger</h6>
                                    <p class="text-muted mb-0">
                                        The General Ledger shows all financial transactions organized by account. 
                                        It provides a complete record of all accounting transactions.
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h6><i class="fas fa-clock mr-2"></i>Report Generated</h6>
                                    <p class="text-muted mb-0">
                                        {{ now()->format('F d, Y \a\t h:i A') }}<br>
                                        @if(request('account_id'))
                                        Account: {{ $selectedAccount->code }} - {{ $selectedAccount->name }}
                                        @else
                                        All Accounts
                                        @endif
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
        $('#generalLedgerTable').DataTable({
            "paging": true,
            "pageLength": 25,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "order": [[0, 'desc']],
            "language": {
                "search": "_INPUT_",
                "searchPlaceholder": "Search transactions...",
                "emptyTable": "No transactions found for the selected criteria",
                "zeroRecords": "No matching transactions found"
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
        alert('PDF export functionality would be implemented here');
    }

    function exportToExcel() {
        alert('Excel export functionality would be implemented here');
    }
</script>
@endpush