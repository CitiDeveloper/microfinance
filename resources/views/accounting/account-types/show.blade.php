{{-- resources/views/accounting/account-types/show.blade.php --}}
@extends('layouts.app')

@section('title', $accountType->name)

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ $accountType->name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('accounting.account-types.index') }}">Account Types</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Type Information</h3>
                            <div class="card-tools">
                                <a href="{{ route('accounting.account-types.edit', $accountType) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Code:</th>
                                    <td><strong>{{ $accountType->code }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Name:</th>
                                    <td>{{ $accountType->name }}</td>
                                </tr>
                                <tr>
                                    <th>Category:</th>
                                    <td>
                                        @php
                                            $categoryColors = [
                                                'asset' => 'primary',
                                                'liability' => 'success',
                                                'equity' => 'info',
                                                'income' => 'warning',
                                                'expense' => 'danger'
                                            ];
                                            $color = $categoryColors[$accountType->category] ?? 'secondary';
                                        @endphp
                                        <span class="badge badge-{{ $color }}">
                                            {{ ucfirst($accountType->category) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge badge-{{ $accountType->is_active ? 'success' : 'danger' }}">
                                            {{ $accountType->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Accounts Count:</th>
                                    <td>
                                        <span class="badge badge-pill badge-light border">
                                            {{ $accountType->chart_of_accounts_count }} accounts
                                        </span>
                                    </td>
                                </tr>
                                @if($accountType->description)
                                <tr>
                                    <th>Description:</th>
                                    <td>{{ $accountType->description }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Created:</th>
                                    <td>{{ $accountType->created_at->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated:</th>
                                    <td>{{ $accountType->updated_at->format('M d, Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Linked Accounts ({{ $accountType->chart_of_accounts_count }})</h3>
                        </div>
                        <div class="card-body">
                            @if($accountType->chartOfAccounts->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Account Name</th>
                                            <th>Normal Balance</th>
                                            <th>Status</th>
                                            <th>Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($accountType->chartOfAccounts as $account)
                                        <tr>
                                            <td><strong>{{ $account->code }}</strong></td>
                                            <td>{{ $account->name }}</td>
                                            <td>
                                                <span class="badge badge-{{ $account->normal_balance === 'debit' ? 'dark' : 'secondary' }}">
                                                    {{ ucfirst($account->normal_balance) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $account->is_active ? 'success' : 'danger' }}">
                                                    {{ $account->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="font-weight-bold {{ $account->balance >= 0 ? 'text-success' : 'text-danger' }}">
                                                    {{ number_format($account->balance, 2) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-4">
                                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No accounts linked to this type yet.</p>
                                <a href="{{ route('accounting.chart-of-accounts.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Create New Account
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection