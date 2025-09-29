@extends('layouts.app')

@section('title', 'Create Savings Account')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create New Savings Account</h3>
                </div>
                <form action="{{ route('savings.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="borrower_id">Borrower *</label>
                                    <select name="borrower_id" id="borrower_id" class="form-control @error('borrower_id') is-invalid @enderror" required>
                                        <option value="">Select Borrower</option>
                                        @foreach($borrowers as $borrower)
                                            <option value="{{ $borrower->id }}" {{ old('borrower_id') == $borrower->id ? 'selected' : '' }}>
                                                {{ $borrower->full_name }} ({{ $borrower->id_number }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('borrower_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="savings_product_id">Savings Product *</label>
                                    <select name="savings_product_id" id="savings_product_id" class="form-control @error('savings_product_id') is-invalid @enderror" required>
                                        <option value="">Select Product</option>
                                        @foreach($savingsProducts as $product)
                                            <option value="{{ $product->id }}" {{ old('savings_product_id') == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }} (Min: {{ number_format($product->minimum_deposit, 2) }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('savings_product_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="branch_id">Branch *</label>
                                    <select name="branch_id" id="branch_id" class="form-control @error('branch_id') is-invalid @enderror" required>
                                        <option value="">Select Branch</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('branch_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="opening_date">Opening Date *</label>
                                    <input type="date" name="opening_date" id="opening_date" class="form-control @error('opening_date') is-invalid @enderror" value="{{ old('opening_date', date('Y-m-d')) }}" required>
                                    @error('opening_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="initial_deposit">Initial Deposit *</label>
                                    <input type="number" name="initial_deposit" id="initial_deposit" class="form-control @error('initial_deposit') is-invalid @enderror" value="{{ old('initial_deposit', 0) }}" step="0.01" min="0" required>
                                    @error('initial_deposit')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Create Account</button>
                        <a href="{{ route('savings.index') }}" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection