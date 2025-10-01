{{-- resources/views/accounting/balance-sheet.blade.php --}}
@extends('layouts.app')

@section('title', 'Balance Sheet')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Balance Sheet</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('accounting.journal-entries') }}">Accounting</a></li>
                        <li class="breadcrumb-item active">Balance Sheet</li>
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
                            <form action="{{ route('accounting.balance-sheet') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="as_of_date">As Of Date</label>
                                            <input type="date" class="form-control" id="as_of_date" name="as_of_date" 
                                                   value="{{ request('as_of_date', now()->format('Y-m-d')) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
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
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="d-flex">
                                                <button type="submit" class="btn btn-primary mr-2">
                                                    <i class="fas fa-filter"></i> Generate Report
                                                </button>
                                                <a href="{{ route('accounting.balance-sheet') }}" class="btn btn-secondary">
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

            <!-- Balance Sheet Report -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title text-center">
                                BALANCE SHEET<br>
                                <small>As of {{ \Carbon\Carbon::parse(request('as_of_date', now()->format('Y-m-d')))->format('F d, Y') }}</small>
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
                                        <a class="dropdown-item" href="#"><i class="fas fa-file-pdf mr-1"></i> PDF</a>
                                        <a class="dropdown-item" href="#"><i class="fas fa-file-excel mr-1"></i> Excel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Assets -->
                                <div class="col-md-6">
                                    <div class="card card-success">
                                        <div class="card-header bg-success">
                                            <h3 class="card-title text-white">ASSETS</h3>
                                        </div>
                                        <div class="card-body p-0">
                                            <table class="table table-sm table-striped">
                                                <tbody>
                                                    @foreach($assets as $asset)
                                                    <tr>
                                                        <td>{{ $asset['account']->name }}</td>
                                                        <td class="text-right font-weight-bold">
                                                            {{ number_format($asset['balance'], 2) }}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr class="table-primary">
                                                        <td><strong>TOTAL ASSETS</strong></td>
                                                        <td class="text-right font-weight-bold">
                                                            {{ number_format($totalAssets, 2) }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Liabilities & Equity -->
                                <div class="col-md-6">
                                    <div class="card card-danger">
                                        <div class="card-header bg-danger">
                                            <h3 class="card-title text-white">LIABILITIES & EQUITY</h3>
                                        </div>
                                        <div class="card-body p-0">
                                            <table class="table table-sm table-striped">
                                                <thead>
                                                    <tr class="bg-light">
                                                        <th colspan="2">LIABILITIES</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($liabilities as $liability)
                                                    <tr>
                                                        <td>{{ $liability['account']->name }}</td>
                                                        <td class="text-right font-weight-bold">
                                                            {{ number_format($liability['balance'], 2) }}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr class="bg-light">
                                                        <td><strong>Total Liabilities</strong></td>
                                                        <td class="text-right font-weight-bold">
                                                            {{ number_format($totalLiabilities, 2) }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <table class="table table-sm table-striped mt-3">
                                                <thead>
                                                    <tr class="bg-light">
                                                        <th colspan="2">EQUITY</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($equity as $equityItem)
                                                    <tr>
                                                        <td>{{ $equityItem['account']->name }}</td>
                                                        <td class="text-right font-weight-bold">
                                                            {{ number_format($equityItem['balance'], 2) }}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr class="bg-light">
                                                        <td><strong>Total Equity</strong></td>
                                                        <td class="text-right font-weight-bold">
                                                            {{ number_format($totalEquity, 2) }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <table class="table table-sm mt-3">
                                                <tbody>
                                                    <tr class="table-primary">
                                                        <td><strong>TOTAL LIABILITIES & EQUITY</strong></td>
                                                        <td class="text-right font-weight-bold">
                                                            {{ number_format($totalLiabilities + $totalEquity, 2) }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Balance Check -->
                            <div class="row mt-4">
                                <div class="col-12 text-center">
                                    @if($totalAssets == ($totalLiabilities + $totalEquity))
                                    <div class="alert alert-success">
                                        <h4><i class="fas fa-check-circle mr-2"></i> BALANCE SHEET BALANCED</h4>
                                        <p class="mb-0">Total Assets = Total Liabilities + Equity</p>
                                    </div>
                                    @else
                                    <div class="alert alert-danger">
                                        <h4><i class="fas fa-exclamation-triangle mr-2"></i> BALANCE SHEET UNBALANCED</h4>
                                        <p class="mb-0">
                                            Difference: {{ number_format(abs($totalAssets - ($totalLiabilities + $totalEquity)), 2) }}
                                        </p>
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

        // Set default date if not provided
        if (!$('#as_of_date').val()) {
            $('#as_of_date').val('{{ now()->format("Y-m-d") }}');
        }
    });
</script>
@endpush