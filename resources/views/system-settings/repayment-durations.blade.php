@extends('layouts.app')

@section('content')
<!-- BEGIN page-header -->
<h1 class="page-header">Repayment Durations Management</h1>
<!-- END page-header -->

<div class="row">
    <div class="col-12">
        <!-- BEGIN card -->
        <div class="card border-0">
            <div class="card-header bg-none fw-bold d-flex align-items-center">
                <h5 class="card-title mb-0 flex-fill">Repayment Durations List</h5>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addRepaymentDurationModal">
                    <i class="fa fa-plus fa-fw"></i> Add Repayment Duration
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Months</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($repaymentDurations as $duration)
                            <tr>
                                <td>{{ $duration->months }} month(s)</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editRepaymentDurationModal"
                                            data-id="{{ $duration->id }}"
                                            data-months="{{ $duration->months }}">
                                        <i class="fa fa-edit fa-fw"></i>
                                    </button>
                                    <form action="{{ route('system-settings.repayment-durations.destroy', $duration->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fa fa-trash fa-fw"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @if($repaymentDurations->isEmpty())
                            <tr>
                                <td colspan="2" class="text-center">No repayment durations found.</td>
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

<!-- Add Repayment Duration Modal -->
<div class="modal fade" id="addRepaymentDurationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('system-settings.repayment-durations.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Repayment Duration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="months" class="form-label">Months *</label>
                        <input type="number" class="form-control" id="months" name="months" min="1" required>
                        <div class="form-text">Duration in months</div>
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

<!-- Edit Repayment Duration Modal -->
<div class="modal fade" id="editRepaymentDurationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editRepaymentDurationForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Repayment Duration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_months" class="form-label">Months *</label>
                        <input type="number" class="form-control" id="edit_months" name="months" min="1" required>
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
    const editModal = document.getElementById('editRepaymentDurationModal');
    editModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const months = button.getAttribute('data-months');
        
        document.getElementById('edit_months').value = months;
        document.getElementById('editRepaymentDurationForm').action = '/system-settings/repayment-durations/' + id;
    });
});
</script>
@endsection