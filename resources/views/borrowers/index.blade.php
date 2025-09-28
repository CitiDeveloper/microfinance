@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Borrowers Management</h1>
    <a href="{{ route('borrowers.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Borrower
    </a>
</div>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <form method="GET" action="{{ route('borrowers.index') }}">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search borrowers..." value="{{ $search }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Unique #</th>
                        <th>Name</th>
                        <th>Business</th>
                        <th>Mobile</th>
                        <th>County</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowers as $borrower)
                    <tr>
                        <td>{{ $borrower->unique_number ?? 'N/A' }}</td>
                        <td>{{ $borrower->full_name }}</td>
                        <td>{{ $borrower->business_name ?? 'N/A' }}</td>
                        <td>{{ $borrower->mobile ?? 'N/A' }}</td>
                        <td>{{ $borrower->county }}</td>
                        <td>
                            <span class="badge bg-success">Active</span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('borrowers.show', $borrower) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('borrowers.edit', $borrower) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('borrowers.destroy', $borrower) }}" method="POST" class="d-inline">
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
                        <td colspan="7" class="text-center">No borrowers found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center">
            {{ $borrowers->links() }}
        </div>
    </div>
</div>
@endsection