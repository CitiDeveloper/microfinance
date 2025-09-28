@extends('layouts.app')

@section('content')
<!-- BEGIN page-header -->
<h1 class="page-header">Repayment Cycles Management</h1>
<!-- END page-header -->

<div class="row">
    <div class="col-12">
        <!-- BEGIN card -->
        <div class="card border-0">
            <div class="card-header bg-none fw-bold d-flex align-items-center">
                <h5 class="card-title mb-0 flex-fill">Repayment Cycles List</h5>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addRepaymentCycleModal">
                    <i class="fa fa-plus fa-fw"></i> Add Repayment Cycle
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($repaymentCycles as $cycle)
                            <tr>
                                <td>{{ $cycle->code }}</td>
                                <td>{{ $cycle->name }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editRepaymentCycleModal"
                                            data-id="{{ $cycle->id }}"
                                            data-code="{{ $cycle->code }}"
                                            data-name="{{ $cycle->name }}">
                                        <i class="fa fa-edit fa-fw"></i>
                                    </button>
                                    <form action="{{ route('system-settings.repayment-cycles.destroy', $cycle->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fa fa-trash fa-fw"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @if($repaymentCycles->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center">No repayment cycles found.</td>
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

<!-- Add Repayment Cycle Modal -->
<div class="modal fade" id="addRepaymentCycleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('system-settings.repayment-cycles.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Repayment Cycle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="code" class="form-label">Code *</label>
                        <input type="text" class="form-control" id="code" name="code" required>
                        <div class="form-text">Unique code for the repayment cycle</div>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <div class="form-text">Display name for the repayment cycle</div>
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

<!-- Edit Repayment Cycle Modal -->
<div class="modal fade" id="editRepaymentCycleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editRepaymentCycleForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Repayment Cycle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_code" class="form-label">Code *</label>
                        <input type="text" class="form-control" id="edit_code" name="code" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Name *</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
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
    const editModal = document.getElementById('editRepaymentCycleModal');
    editModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const code = button.getAttribute('data-code');
        const name = button.getAttribute('data-name');
        
        document.getElementById('edit_code').value = code;
        document.getElementById('edit_name').value = name;
        
        document.getElementById('editRepaymentCycleForm').action = '/system-settings/repayment-cycles/' + id;
    });
});
</script>
@endsection