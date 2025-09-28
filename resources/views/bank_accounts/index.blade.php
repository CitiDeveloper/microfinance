@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Bank Accounts</h2>
    <a href="{{ route('bank_accounts.create') }}" class="btn btn-primary mb-3">Add New</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Branches</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bankAccounts as $bank)
            <tr>
                <td>{{ $bank->coa_code }}</td>
                <td>{{ $bank->coa_name }}</td>
                <td>{{ implode(', ', $bank->access_branches ?? []) }}</td>
                <td>
                    <a href="{{ route('bank_accounts.show', $bank) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('bank_accounts.edit', $bank) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('bank_accounts.destroy', $bank) }}" method="POST" style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $bankAccounts->links() }}
</div>
@endsection
