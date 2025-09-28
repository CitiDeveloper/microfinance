@extends('layouts.app')

@section('content')
<!-- BEGIN page-header -->
<h1 class="page-header">Loan Statuses Management</h1>
<!-- END page-header -->

<div class="row">
    <div class="col-12">
        <!-- BEGIN card -->
        <div class="card border-0">
            <div class="card-header bg-none fw-bold d-flex align-items-center">
                <h5 class="card-title mb-0 flex-fill">Loan Statuses List</h5>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addLoanStatusModal">
                    <i class="fa fa-plus fa-fw"></i> Add Loan Status
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Default</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($loanStatuses as $status)
                            <tr>
                                <td>{{ $status->name }}</td>
                                <td>
                                    @if($status->is_default)
                                        <span class="badge bg-success">Yes</span>
                                    @else
                                        <span class="badge bg-secondary">No</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editLoanStatusModal"
                                            data-id="{{ $status->id }}"
                                            data-name="{{ $status->name }}"
                                            data-is-default="{{ $status->is_default }}">
                                        <i class="fa fa-edit fa-fw"></i>
                                    </button>
                                    <form action="{{ route('system-settings.loan-statuses.destroy', $status->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fa fa-trash fa-fw"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @if($loanStatuses->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center">No loan statuses found.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END card -->
    </div>
</div>

<!-- Add Loan Status Modal -->
<div class="modal fade" id="addLoanStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('system-settings.loan-statuses.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Loan Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_default" name="is_default" value="1">
                            <label class="form-check-label" for="is_default">
                                Set as default status
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Loan Status Modal -->
<div class="modal fade" id="editLoanStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editLoanStatusForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Loan Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Name *</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="edit_is_default" name="is_default" value="1">
                            <label class="form-check-label" for="edit_is_default">
                                Set as default status
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editModal = document.getElementById('editLoanStatusModal');
    editModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const isDefault = button.getAttribute('data-is-default');
        
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_is_default').checked = isDefault === '1';
        
        document.getElementById('editLoanStatusForm').action = '/system-settings/loan-statuses/' + id;
    });
});
</script>
@endsection