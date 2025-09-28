@extends('layouts.app')

@section('title', 'Guarantors Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Guarantors Management</h3>
                    <div class="card-tools">
                        <a href="{{ route('guarantors.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add New Guarantor
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Search and Filter Form -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form action="{{ route('guarantors.index') }}" method="GET" class="form-inline">
                                <div class="input-group input-group-sm w-100">
                                    <input type="text" name="search" class="form-control" placeholder="Search by name, business, unique number, mobile or email..." value="{{ request('search') }}">
                                    <select name="branch_id" class="form-control ml-2" style="max-width: 200px;">
                                        <option value="">All Branches</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <select name="working_status" class="form-control ml-2" style="max-width: 200px;">
                                        <option value="">All Working Status</option>
                                        @foreach(['Employee', 'Government Employee', 'Private Sector Employee', 'Owner', 'Student', 'Overseas Worker', 'Pensioner', 'Unemployed'] as $status)
                                            <option value="{{ $status }}" {{ request('working_status') == $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append ml-2">
                                        <button type="submit" class="btn btn-info">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                        <a href="{{ route('guarantors.index') }}" class="btn btn-secondary ml-1">
                                            <i class="fas fa-refresh"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Guarantors Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Name / Business</th>
                                    <th>Unique Number</th>
                                    <th>Contact Info</th>
                                    <th>Working Status</th>
                                    <th>Branch</th>
                                    <th>Created By</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($guarantors as $guarantor)
                                    <tr>
                                        <td>{{ $loop->iteration + ($guarantors->perPage() * ($guarantors->currentPage() - 1)) }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($guarantor->photo)
                                                    <img src="{{ asset('storage/' . $guarantor->photo) }}" 
                                                         alt="{{ $guarantor->full_name }}" 
                                                         class="img-circle img-size-32 mr-2"
                                                         style="width: 32px; height: 32px; object-fit: cover;">
                                                @else
                                                    <div class="img-circle bg-secondary d-flex align-items-center justify-content-center mr-2"
                                                         style="width: 32px; height: 32px;">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <strong>{{ $guarantor->display_name }}</strong>
                                                    @if($guarantor->email)
                                                        <br><small class="text-muted">{{ $guarantor->email }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($guarantor->unique_number)
                                                <span class="badge badge-info">{{ $guarantor->unique_number }}</span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($guarantor->mobile)
                                                <div><i class="fas fa-phone text-success"></i> {{ $guarantor->mobile }}</div>
                                            @endif
                                            @if($guarantor->landline)
                                                <div><i class="fas fa-phone-alt text-secondary"></i> {{ $guarantor->landline }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($guarantor->working_status)
                                                <span class="badge badge-light">{{ $guarantor->working_status }}</span>
                                            @else
                                                <span class="text-muted">Not specified</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">{{ $guarantor->branch->name ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            <small>{{ $guarantor->creator->name ?? 'System' }}</small>
                                        </td>
                                        <td>
                                            <small>{{ $guarantor->created_at->format('M j, Y') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('guarantors.show', $guarantor->id) }}" 
                                                   class="btn btn-info" 
                                                   title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('guarantors.edit', $guarantor->id) }}" 
                                                   class="btn btn-warning" 
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-danger" 
                                                        title="Delete"
                                                        onclick="confirmDelete({{ $guarantor->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                            <form id="delete-form-{{ $guarantor->id }}" 
                                                  action="{{ route('guarantors.destroy', $guarantor->id) }}" 
                                                  method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">
                                            <i class="fas fa-users fa-3x mb-3"></i>
                                            <p>No guarantors found. <a href="{{ route('guarantors.create') }}">Create the first guarantor</a></p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Showing {{ $guarantors->firstItem() }} to {{ $guarantors->lastItem() }} of {{ $guarantors->total() }} entries
                        </div>
                        <div>
                            {{ $guarantors->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function confirmDelete(guarantorId) {
        if (confirm('Are you sure you want to delete this guarantor? This action cannot be undone.')) {
            event.preventDefault();
            document.getElementById('delete-form-' + guarantorId).submit();
        }
    }

    // Auto-submit form when filter changes
    document.addEventListener('DOMContentLoaded', function() {
        const branchFilter = document.querySelector('select[name="branch_id"]');
        const statusFilter = document.querySelector('select[name="working_status"]');
        
        if (branchFilter) {
            branchFilter.addEventListener('change', function() {
                this.form.submit();
            });
        }
        
        if (statusFilter) {
            statusFilter.addEventListener('change', function() {
                this.form.submit();
            });
        }
    });
</script>
@endsection