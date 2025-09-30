{{-- resources/views/accounting/account-types/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Account Types')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Account Types</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('accounting.chart-of-accounts') }}">Accounting</a></li>
                        <li class="breadcrumb-item active">Account Types</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalTypes }}</h3>
                            <p>Total Types</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-layer-group"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $activeTypes }}</h3>
                            <p>Active Types</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $categoriesCount }}</h3>
                            <p>Categories</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-tags"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalAccounts }}</h3>
                            <p>Linked Accounts</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Card -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Account Types Management</h3>
                            <div class="card-tools">
                                <a href="{{ route('accounting.account-types.create') }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-plus-circle"></i> Create New Type
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="accountTypesTable" class="table table-hover table-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Code</th>
                                            <th>Type Name</th>
                                            <th>Category</th>
                                            <th>Description</th>
                                            <th>Accounts Count</th>
                                            <th>Status</th>
                                            <th width="120" class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($accountTypes as $type)
                                        <tr>
                                            <td>
                                                <span class="font-weight-bold text-primary">{{ $type->code }}</span>
                                            </td>
                                            <td>
                                                <strong>{{ $type->name }}</strong>
                                            </td>
                                            <td>
                                                @php
                                                    $categoryColors = [
                                                        'asset' => 'primary',
                                                        'liability' => 'success',
                                                        'equity' => 'info',
                                                        'income' => 'warning',
                                                        'expense' => 'danger'
                                                    ];
                                                    $color = $categoryColors[$type->category] ?? 'secondary';
                                                @endphp
                                                <span class="badge badge-{{ $color }}">
                                                    <i class="fas fa-{{ $type->category === 'asset' ? 'building' : ($type->category === 'liability' ? 'hand-holding-usd' : ($type->category === 'equity' ? 'users' : ($type->category === 'income' ? 'arrow-up' : 'arrow-down'))) }} mr-1"></i>
                                                    {{ ucfirst($type->category) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($type->description)
                                                    {{ Str::limit($type->description, 60) }}
                                                @else
                                                    <span class="text-muted">No description</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-pill badge-light border">
                                                    {{ $type->chart_of_accounts_count }} accounts
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $type->is_active ? 'success' : 'danger' }}">
                                                    <i class="fas fa-{{ $type->is_active ? 'check' : 'times' }} mr-1"></i>
                                                    {{ $type->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('accounting.account-types.show', $type) }}" 
                                                       class="btn btn-info" 
                                                       data-toggle="tooltip" 
                                                       title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('accounting.account-types.edit', $type) }}" 
                                                       class="btn btn-warning" 
                                                       data-toggle="tooltip" 
                                                       title="Edit Type">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @if($type->chart_of_accounts_count == 0)
                                                    <form action="{{ route('accounting.account-types.destroy', $type) }}" 
                                                          method="POST" 
                                                          class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-danger" 
                                                                data-toggle="tooltip" 
                                                                title="Delete Type"
                                                                onclick="return confirm('Are you sure you want to delete this account type?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    @else
                                                    <button class="btn btn-secondary" 
                                                            data-toggle="tooltip" 
                                                            title="Cannot delete - has linked accounts"
                                                            disabled>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    @endif
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
@endsection

@push('styles')
<style>
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.1);
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#accountTypesTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "order": [[0, 'asc']],
            "language": {
                "search": "_INPUT_",
                "searchPlaceholder": "Search types...",
                "emptyTable": "No account types found",
                "infoEmpty": "No types available",
                "zeroRecords": "No matching types found"
            }
        });

        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush