{{-- resources/views/accounting/reports/cash-flow.blade.php --}}
@extends('layouts.app')

@section('title', 'Cash Flow Statement')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Cash Flow Statement</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('accounting.journal-entries') }}">Accounting</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('accounting.reports.cash-flow') }}">Reports</a></li>
                        <li class="breadcrumb-item active">Cash Flow</li>
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
                            <form action="{{ route('accounting.reports.cash-flow') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="start_date">From Date</label>
                                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                                   value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="end_date">To Date</label>
                                            <input type="date" class="form-control" id="end_date" name="end_date" 
                                                   value="{{ request('end_date', now()->format('Y-m-d')) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="d-flex">
                                                <button type="submit" class="btn btn-primary mr-2">
                                                    <i class="fas fa-filter"></i> Generate Report
                                                </button>
                                                <a href="{{ route('accounting.reports.cash-flow') }}" class="btn btn-secondary">
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

            <!-- Cash Flow Statement -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title text-center">
                                STATEMENT OF CASH FLOWS<br>
                                <small>
                                    For the Period {{ \Carbon\Carbon::parse(request('start_date', now()->startOfMonth()->format('Y-m-d')))->format('M d, Y') }} 
                                    to {{ \Carbon\Carbon::parse(request('end_date', now()->format('Y-m-d')))->format('M d, Y') }}
                                </small>
                            </h3>
                        </div>
                        <div class="card-body">
                            <!-- Cash from Operating Activities -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card card-info">
                                        <div class="card-header bg-info">
                                            <h4 class="card-title text-white mb-0">
                                                <i class="fas fa-cogs mr-2"></i>CASH FLOWS FROM OPERATING ACTIVITIES
                                            </h4>
                                        </div>
                                        <div class="card-body p-0">
                                            <table class="table table-sm table-striped mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td width="70%">Net Income</td>
                                                        <td class="text-right font-weight-bold text-success">
                                                            {{ number_format($netIncome, 2) }}
                                                        </td>
                                                    </tr>
                                                    @foreach($operatingActivities as $activity)
                                                    <tr>
                                                        <td>{{ $activity['description'] }}</td>
                                                        <td class="text-right font-weight-bold {{ $activity['amount'] >= 0 ? 'text-success' : 'text-danger' }}">
                                                            {{ number_format($activity['amount'], 2) }}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr class="table-info">
                                                        <td><strong>NET CASH FROM OPERATING ACTIVITIES</strong></td>
                                                        <td class="text-right font-weight-bold">
                                                            {{ number_format($cashFromOperations, 2) }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Cash from Investing Activities -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card card-warning">
                                        <div class="card-header bg-warning">
                                            <h4 class="card-title text-white mb-0">
                                                <i class="fas fa-chart-line mr-2"></i>CASH FLOWS FROM INVESTING ACTIVITIES
                                            </h4>
                                        </div>
                                        <div class="card-body p-0">
                                            <table class="table table-sm table-striped mb-0">
                                                <tbody>
                                                    @foreach($investingActivities as $activity)
                                                    <tr>
                                                        <td width="70%">{{ $activity['description'] }}</td>
                                                        <td class="text-right font-weight-bold {{ $activity['amount'] >= 0 ? 'text-success' : 'text-danger' }}">
                                                            {{ number_format($activity['amount'], 2) }}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr class="table-warning">
                                                        <td><strong>NET CASH FROM INVESTING ACTIVITIES</strong></td>
                                                        <td class="text-right font-weight-bold">
                                                            {{ number_format($cashFromInvesting, 2) }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Cash from Financing Activities -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card card-success">
                                        <div class="card-header bg-success">
                                            <h4 class="card-title text-white mb-0">
                                                <i class="fas fa-hand-holding-usd mr-2"></i>CASH FLOWS FROM FINANCING ACTIVITIES
                                            </h4>
                                        </div>
                                        <div class="card-body p-0">
                                            <table class="table table-sm table-striped mb-0">
                                                <tbody>
                                                    @foreach($financingActivities as $activity)
                                                    <tr>
                                                        <td width="70%">{{ $activity['description'] }}</td>
                                                        <td class="text-right font-weight-bold {{ $activity['amount'] >= 0 ? 'text-success' : 'text-danger' }}">
                                                            {{ number_format($activity['amount'], 2) }}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr class="table-success">
                                                        <td><strong>NET CASH FROM FINANCING ACTIVITIES</strong></td>
                                                        <td class="text-right font-weight-bold">
                                                            {{ number_format($cashFromFinancing, 2) }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Net Cash Flow -->
                            <div class="row">
                                <div class="col-12 text-center">
                                    @php
                                        $netCashFlow = $cashFromOperations + $cashFromInvesting + $cashFromFinancing;
                                    @endphp
                                    <div class="alert {{ $netCashFlow >= 0 ? 'alert-success' : 'alert-danger' }}">
                                        <h3>
                                            <i class="fas fa-{{ $netCashFlow >= 0 ? 'arrow-up' : 'arrow-down' }} mr-2"></i>
                                            NET INCREASE IN CASH: {{ number_format($netCashFlow, 2) }}
                                        </h3>
                                        <p class="mb-0">
                                            Operating: {{ number_format($cashFromOperations, 2) }} + 
                                            Investing: {{ number_format($cashFromInvesting, 2) }} + 
                                            Financing: {{ number_format($cashFromFinancing, 2) }}
                                        </p>
                                    </div>
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