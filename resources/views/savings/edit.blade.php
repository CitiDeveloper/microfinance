@extends('layouts.app')

@section('title', 'Edit Savings Account')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Savings Account - {{ $saving->account_number }}</h3>
                </div>
                <form action="{{ route('savings.update', $saving) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Account Number</label>
                                    <input type="text" class="form-control" value="{{ $saving->account_number }}" readonly>
                                    <small class="form-text text-muted">Account number cannot be changed</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Borrower</label>
                                    <input type="text" class="form-control" value="{{ $saving->borrower->full_name }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="branch_id">Branch *</label>
                                    <select name="branch_id" id="branch_id" class="form-control @error('branch_id') is-invalid @enderror" required>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}" {{ $saving->branch_id == $branch->id ? 'selected' : '' }}>
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
                                    <label for="savings_product_id">Savings Product *</label>
                                    <select name="savings_product_id" id="savings_product_id" class="form-control @error('savings_product_id') is-invalid @enderror" required>
                                        @foreach($savingsProducts as $product)
                                            <option value="{{ $product->id }}" {{ $saving->savings_product_id == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }}
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
                                    <label for="status">Status *</label>
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                        <option value="active" {{ $saving->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="dormant" {{ $saving->status == 'dormant' ? 'selected' : '' }}>Dormant</option>
                                        <option value="frozen" {{ $saving->status == 'frozen' ? 'selected' : '' }}>Frozen</option>
                                        <option value="closed" {{ $saving->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="maturity_date">Maturity Date</label>
                                    <input type="date" name="maturity_date" id="maturity_date" class="form-control @error('maturity_date') is-invalid @enderror" value="{{ $saving->maturity_date ? $saving->maturity_date->format('Y-m-d') : '' }}">
                                    @error('maturity_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $saving->notes) }}</textarea>
                            @error('notes')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update Account</button>
                        <a href="{{ route('savings.show', $saving) }}" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection