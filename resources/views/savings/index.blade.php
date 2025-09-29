@extends('layouts.app')

@section('title', 'Savings Accounts')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Savings Accounts</h3>
                    <div class="card-tools">
                        <a href="{{ route('savings.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create New Account
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Account Number</th>
                                    <th>Borrower</th>
                                    <th>Product</th>
                                    <th>Branch</th>
                                    <th>Balance</th>
                                    <th>Status</th>
                                    <th>Opening Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($savings as $saving)
                                    <tr>
                                        <td>{{ $saving->account_number }}</td>
                                        <td>{{ $saving->borrower->full_name }}</td>
                                        <td>{{ $saving->savingsProduct->name }}</td>
                                        <td>{{ $saving->branch->name }}</td>
                                        <td>{{ number_format($saving->balance, 2) }}</td>
                                        <td>
                                            <span class="badge badge-{{ $saving->status == 'active' ? 'success' : ($saving->status == 'closed' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($saving->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $saving->opening_date->format('M d, Y') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('savings.show', $saving) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('savings.edit', $saving) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('savings.destroy', $saving) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No savings accounts found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $savings->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection