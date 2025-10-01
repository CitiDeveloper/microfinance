{{-- resources/views/accounting/income-statement.blade.php --}}
@extends('layouts.app')

@section('title', 'Income Statement')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Income Statement</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('accounting.journal-entries') }}">Accounting</a></li>
                        <li class="breadcrumb-item active">Income Statement</li>
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
                            <form action="{{ route('accounting.income-statement') }}" method="GET">
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
                                                <a href="{{ route('accounting.income-statement') }}" class="btn btn-secondary">
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

            <!-- Income Statement Report -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title text-center">
                                INCOME STATEMENT<br>
                                <small>
                                    For the Period {{ \Carbon\Carbon::parse(request('start_date', now()->startOfMonth()->format('Y-m-d')))->format('M d, Y') }} 
                                    to {{ \Carbon\Carbon::parse(request('end_date', now()->format('Y-m-d')))->format('M d, Y') }}
                                </small>
                            </h3>
                        </div>
                        <div class="card-body">
                            <!-- Revenue Section -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card card-success">
                                        <div class="card-header bg-success">
                                            <h3 class="card-title text-white">REVENUE</h3>
                                        </div>
                                        <div class="card-body p-0">
                                            <table class="table table-sm table-striped">
                                                <tbody>
                                                    @foreach($incomes as $income)
                                                    <tr>
                                                        <td width="70%">{{ $income['account']->name }}</td>
                                                        <td class="text-right font-weight-bold text-success">
                                                            {{ number_format($income['balance'], 2) }}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr class="table-success">
                                                        <td><strong>TOTAL REVENUE</strong></td>
                                                        <td class="text-right font-weight-bold">
                                                            {{ number_format($totalIncome, 2) }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Expenses Section -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card card-danger">
                                        <div class="card-header bg-danger">
                                            <h3 class="card-title text-white">EXPENSES</h3>
                                        </div>
                                        <div class="card-body p-0">
                                            <table class="table table-sm table-striped">
                                                <tbody>
                                                    @foreach($expenses as $expense)
                                                    <tr>
                                                        <td width="70%">{{ $expense['account']->name }}</td>
                                                        <td class="text-right font-weight-bold text-danger">
                                                            {{ number_format($expense['balance'], 2) }}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr class="table-danger">
                                                        <td><strong>TOTAL EXPENSES</strong></td>
                                                        <td class="text-right font-weight-bold">
                                                            {{ number_format($totalExpenses, 2) }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Net Income/Loss -->
                            <div class="row">
                                <div class="col-12 text-center">
                                    @if($netIncome >= 0)
                                    <div class="alert alert-success">
                                        <h3>
                                            <i class="fas fa-arrow-up mr-2"></i>
                                            NET INCOME: {{ number_format($netIncome, 2) }}
                                        </h3>
                                        <p class="mb-0">Total Revenue - Total Expenses</p>
                                    </div>
                                    @else
                                    <div class="alert alert-danger">
                                        <h3>
                                            <i class="fas fa-arrow-down mr-2"></i>
                                            NET LOSS: {{ number_format(abs($netIncome), 2) }}
                                        </h3>
                                        <p class="mb-0">Total Revenue - Total Expenses</p>
                                    </div>
                                    @endif
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

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4'
        });

        // Set default dates if not provided
        if (!$('#start_date').val()) {
            $('#start_date').val('{{ now()->startOfMonth()->format("Y-m-d") }}');
        }
        if (!$('#end_date').val()) {
            $('#end_date').val('{{ now()->format("Y-m-d") }}');
        }
    });
</script>
@endpush