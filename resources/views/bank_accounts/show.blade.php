@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Bank Account Details</h2>
    <p><strong>Code:</strong> {{ $bankAccount->coa_code }}</p>
    <p><strong>Name:</strong> {{ $bankAccount->coa_name }}</p>
    <p><strong>Categories:</strong> {{ implode(', ', $bankAccount->coa_default_categories ?? []) }}</p>
    <p><strong>Branches:</strong> {{ implode(', ', $bankAccount->access_branches ?? []) }}</p>
    <a href="{{ route('bank_accounts.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
