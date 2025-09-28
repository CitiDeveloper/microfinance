@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Bank Account</h2>
    <form action="{{ route('bank_accounts.update', $bankAccount) }}" method="POST">
        @csrf @method('PUT')

        <div class="form-group">
            <label>Code</label>
            <input type="text" name="coa_code" class="form-control"
                value="{{ old('coa_code', $bankAccount->coa_code) }}" required minlength="4" maxlength="4">
        </div>

        <div class="form-group">
            <label>Bank Account Name</label>
            <input type="text" name="coa_name" class="form-control"
                value="{{ old('coa_name', $bankAccount->coa_name) }}" required>
        </div>

        <div class="form-group">
            <label>Default Categories</label>
            <select name="coa_default_categories[]" class="form-control" multiple>
                @php $selected = $bankAccount->coa_default_categories ?? []; @endphp
                <option value="add_loan" {{ in_array('add_loan', $selected) ? 'selected' : '' }}>Add Loan</option>
                <option value="add_repayment" {{ in_array('add_repayment', $selected) ? 'selected' : '' }}>Add Repayment</option>
                <option value="add_expense" {{ in_array('add_expense', $selected) ? 'selected' : '' }}>Add Expense</option>
                <option value="add_other_income" {{ in_array('add_other_income', $selected) ? 'selected' : '' }}>Add Other Income</option>
                <option value="add_branch_capital" {{ in_array('add_branch_capital', $selected) ? 'selected' : '' }}>Add Branch Capital</option>
                <option value="add_payroll" {{ in_array('add_payroll', $selected) ? 'selected' : '' }}>Add Payroll</option>
            </select>
        </div>

        <div class="form-group">
            <label>Access Branches</label>
            <select name="access_branches[]" class="form-control" multiple required>
                <option value="78560" {{ in_array("78560", $bankAccount->access_branches) ? 'selected' : '' }}>Branch #1</option>
                <option value="78561" {{ in_array("78561", $bankAccount->access_branches) ? 'selected' : '' }}>Branch #2</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('bank_accounts.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
