@extends('layouts.app')

@section('content')
<!-- BEGIN page-header -->
<h1 class="page-header">Bank Accounts Management</h1>
<!-- END page-header -->

<div class="row">
    <div class="col-12">
        <!-- BEGIN card -->
        <div class="card border-0">
            <div class="card-header bg-none fw-bold d-flex align-items-center">
                <h5 class="card-title mb-0 flex-fill">Bank Accounts List</h5>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addBankAccountModal">
                    <i class="fa fa-plus fa-fw"></i> Add Bank Account
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>COA Code</th>
                                <th>COA Name</th>
                                <th>Default Categories</th>
                                <th>Access Branches</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bankAccounts as $account)
                            <tr>
                                <td>{{ $account->coa_code }}</td>
                                <td>{{ $account->coa_name }}</td>
                                <td>
                                    @if($account->coa_default_categories)
                                        {{ implode(', ', $account->coa_default_categories) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($account->access_branches)
                                        {{ implode(', ', $account->access_branches) }}
                                    @else
                                        All Branches
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editBankAccountModal"
                                            data-id="{{ $account->id }}"
                                            data-coa-code="{{ $account->coa_code }}"
                                            data-coa-name="{{ $account->coa_name }}"
                                            data-categories="{{ json_encode($account->coa_default_categories) }}"
                                            data-branches="{{ json_encode($account->access_branches) }}">
                                        <i class="fa fa-edit fa-fw"></i>
                                    </button>
                                    <form action="{{ route('system-settings.bank-accounts.destroy', $account->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fa fa-trash fa-fw"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END card -->
    </div>
</div>

<!-- Add Bank Account Modal -->
<div class="modal fade" id="addBankAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('system-settings.bank-accounts.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Bank Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="coa_code" class="form-label">COA Code *</label>
                        <input type="text" class="form-control" id="coa_code" name="coa_code" required>
                    </div>
                    <div class="mb-3">
                        <label for="coa_name" class="form-label">COA Name *</label>
                        <input type="text" class="form-control" id="coa_name" name="coa_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="coa_default_categories" class="form-label">Default Categories (comma separated)</label>
                        <input type="text" class="form-control" id="coa_default_categories" name="coa_default_categories">
                    </div>
                    <div class="mb-3">
                        <label for="access_branches" class="form-label">Access Branches (comma separated)</label>
                        <input type="text" class="form-control" id="access_branches" name="access_branches">
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

<!-- Edit Bank Account Modal -->
<div class="modal fade" id="editBankAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editBankAccountForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Bank Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_coa_code" class="form-label">COA Code *</label>
                        <input type="text" class="form-control" id="edit_coa_code" name="coa_code" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_coa_name" class="form-label">COA Name *</label>
                        <input type="text" class="form-control" id="edit_coa_name" name="coa_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_coa_default_categories" class="form-label">Default Categories (comma separated)</label>
                        <input type="text" class="form-control" id="edit_coa_default_categories" name="coa_default_categories">
                    </div>
                    <div class="mb-3">
                        <label for="edit_access_branches" class="form-label">Access Branches (comma separated)</label>
                        <input type="text" class="form-control" id="edit_access_branches" name="access_branches">
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
    const editModal = document.getElementById('editBankAccountModal');
    editModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const coaCode = button.getAttribute('data-coa-code');
        const coaName = button.getAttribute('data-coa-name');
        const categories = button.getAttribute('data-categories');
        const branches = button.getAttribute('data-branches');
        
        document.getElementById('edit_coa_code').value = coaCode;
        document.getElementById('edit_coa_name').value = coaName;
        document.getElementById('edit_coa_default_categories').value = categories ? JSON.parse(categories).join(', ') : '';
        document.getElementById('edit_access_branches').value = branches ? JSON.parse(branches).join(', ') : '';
        
        document.getElementById('editBankAccountForm').action = '/system-settings/bank-accounts/' + id;
    });
});
</script>
@endsection