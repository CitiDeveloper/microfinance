@extends('layouts.app')

@section('title', 'Staff Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Staff Members</h3>
                    <div class="card-tools">
                        <a href="{{ route('staff.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add New Staff
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Gender</th>
                                    <th>Payroll Branch</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($staff as $member)
                                <tr>
                                    <td>{{ $member->id }}</td>
                                    <td>{{ $member->full_name }}</td>
                                    <td>{{ $member->staff_email }}</td>
                                    <td>{{ $member->role->name ?? 'N/A' }}</td>
                                    <td>{{ $member->staff_gender }}</td>
                                    <td>{{ $member->payrollBranch->name ?? 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('staff.show', $member) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('staff.edit', $member) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('staff.destroy', $member) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $staff->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection