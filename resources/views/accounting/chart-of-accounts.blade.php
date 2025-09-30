{{-- resources/views/accounting/chart-of-accounts.blade.php --}}
@extends('layouts.app')

@section('title', 'Chart of Accounts')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Chart of Accounts</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Chart of Accounts</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Accounts List</h3>
                            <div class="card-tools">
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createAccountModal">
                                    <i class="fas fa-plus"></i> New Account
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="accountsTable" class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Account Name</th>
                                            <th>Type</th>
                                            <th>Category</th>
                                            <th>Normal Balance</th>
                                            <th>Balance</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($accounts as $account)
                                        <tr>
                                            <td><strong>{{ $account->code }}</strong></td>
                                            <td>{{ $account->name }}</td>
                                            <td>{{ $account->accountType->name }}</td>
                                            <td>
                                                <span class="badge badge-{{ $account->accountType->category === 'asset' ? 'primary' : ($account->accountType->category === 'liability' ? 'success' : ($account->accountType->category === 'equity' ? 'info' : ($account->accountType->category === 'income' ? 'warning' : 'danger'))) }}">
                                                    {{ ucfirst($account->accountType->category) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $account->normal_balance === 'debit' ? 'primary' : 'success' }}">
                                                    {{ ucfirst($account->normal_balance) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="font-weight-bold {{ $account->balance >= 0 ? 'text-success' : 'text-danger' }}">
                                                    {{ number_format($account->balance, 2) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $account->is_active ? 'success' : 'danger' }}">
                                                    {{ $account->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#editAccountModal{{ $account->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-info" data-toggle="modal" data-target="#viewAccountModal{{ $account->id }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Create Account Modal -->
<div class="modal fade" id="createAccountModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Account</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('accounting.accounts.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Account Type *</label>
                                <select name="account_type_id" class="form-control" required>
                                    <option value="">Select Account Type</option>
                                    @foreach($accountTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }} ({{ $type->code }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Parent Account</label>
                                <select name="parent_id" class="form-control">
                                    <option value="">No Parent</option>
                                    @foreach($accounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Account Code *</label>
                                <input type="text" name="code" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Account Name *</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Normal Balance *</label>
                                <select name="normal_balance" class="form-control" required>
                                    <option value="debit">Debit</option>
                                    <option value="credit">Credit</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="is_active" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Account</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#accountsTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "order": [[0, 'asc']]
        });
    });
</script>
@endpush