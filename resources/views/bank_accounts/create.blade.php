@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Bank Account</h2>
    <form action="{{ route('bank_accounts.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Code</label>
            <input type="text" name="coa_code" class="form-control" required minlength="4" maxlength="4">
        </div>

        <div class="form-group">
            <label>Bank Account Name</label>
            <input type="text" name="coa_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Default Categories</label>
            <select name="coa_default_categories[]" class="form-control" multiple>
                <option value="add_loan">Add Loan</option>
                <option value="add_repayment">Add Repayment</option>
                <option value="add_expense">Add Expense</option>
                <option value="add_other_income">Add Other Income</option>
                <option value="add_branch_capital">Add Branch Capital</option>
                <option value="add_payroll">Add Payroll</option>
            </select>
        </div>

        <div class="form-group">
            <label>Access Branches</label>
            <select name="access_branches[]" class="form-control" multiple required>
                <option value="78560">Branch #1</option>
                <option value="78561">Branch #2</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Submit</button>
        <a href="{{ route('bank_accounts.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
