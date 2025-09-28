@extends('layouts.app')

@section('content')
<!-- BEGIN page-header -->
<h1 class="page-header">System Settings</h1>
<!-- END page-header -->

<!-- BEGIN row -->
<div class="row">
    <!-- BEGIN col-6 -->
    <div class="col-xl-6">
        <!-- BEGIN card -->
        <div class="card border-0">
            <div class="card-body">
                <h5 class="card-title">Configuration Modules</h5>
                <div class="list-group">
                    <a href="{{ route('system-settings.bank-accounts') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Bank Accounts
                        <i class="fa fa-chevron-right fa-fw text-body text-opacity-50"></i>
                    </a>
                    <a href="{{ route('system-settings.repayment-cycles') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Repayment Cycles
                        <i class="fa fa-chevron-right fa-fw text-body text-opacity-50"></i>
                    </a>
                    <a href="{{ route('system-settings.repayment-durations') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Repayment Durations
                        <i class="fa fa-chevron-right fa-fw text-body text-opacity-50"></i>
                    </a>
                    <a href="{{ route('system-settings.payment-methods') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Payment Methods
                        <i class="fa fa-chevron-right fa-fw text-body text-opacity-50"></i>
                    </a>
                    <a href="{{ route('system-settings.loan-statuses') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Loan Statuses
                        <i class="fa fa-chevron-right fa-fw text-body text-opacity-50"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- END card -->
    </div>
    <!-- END col-6 -->

    <!-- BEGIN col-6 -->
    <div class="col-xl-6">
        <!-- BEGIN card -->
        <div class="card border-0">
            <div class="card-body">
                <h5 class="card-title">System Operations</h5>
                <form action="{{ route('system-settings.backup') }}" method="POST" class="mb-3">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fa fa-database fa-fw"></i> Create System Backup
                    </button>
                </form>
                
                <form action="{{ route('system-settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="system_name" class="form-label">System Name</label>
                        <input type="text" class="form-control" id="system_name" name="system_name" value="Microfinance System">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Settings</button>
                </form>
            </div>
        </div>
        <!-- END card -->
    </div>
    <!-- END col-6 -->
</div>
<!-- END row -->
@endsection