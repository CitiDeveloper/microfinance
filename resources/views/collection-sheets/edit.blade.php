@extends('layouts.app')

@section('title', 'Edit Collection Sheet')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Collection Sheet #{{ $collectionSheet->id }}</h3>
                    <a href="{{ route('collection-sheets.show', $collectionSheet) }}" class="btn btn-default btn-sm float-right">
                        <i class="fas fa-arrow-left"></i> Back to Details
                    </a>
                </div>
                <form action="{{ route('collection-sheets.update', $collectionSheet) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="branch_id">Branch *</label>
                                    <select name="branch_id" id="branch_id" class="form-control @error('branch_id') is-invalid @enderror" required>
                                        <option value="">Select Branch</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}" 
                                                {{ old('branch_id', $collectionSheet->branch_id) == $branch->id ? 'selected' : '' }}>
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
                                    <label for="staff_id">Staff *</label>
                                    <select name="staff_id" id="staff_id" class="form-control @error('staff_id') is-invalid @enderror" required>
                                        <option value="">Select Staff</option>
                                        @foreach($staff as $staffMember)
                                            <option value="{{ $staffMember->id }}" 
                                                {{ old('staff_id', $collectionSheet->staff_id) == $staffMember->id ? 'selected' : '' }}>
                                                {{ $staffMember->full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('staff_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="collection_date">Collection Date *</label>
                                    <input type="date" name="collection_date" id="collection_date" 
                                           class="form-control @error('collection_date') is-invalid @enderror" 
                                           value="{{ old('collection_date', $collectionSheet->collection_date->format('Y-m-d')) }}" required>
                                    @error('collection_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sheet_type">Sheet Type *</label>
                                    <select name="sheet_type" id="sheet_type" class="form-control @error('sheet_type') is-invalid @enderror" required>
                                        <option value="daily" {{ old('sheet_type', $collectionSheet->sheet_type) == 'daily' ? 'selected' : '' }}>Daily</option>
                                        <option value="weekly" {{ old('sheet_type', $collectionSheet->sheet_type) == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                        <option value="custom" {{ old('sheet_type', $collectionSheet->sheet_type) == 'custom' ? 'selected' : '' }}>Custom</option>
                                    </select>
                                    @error('sheet_type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" 
                                      rows="3" placeholder="Additional notes...">{{ old('notes', $collectionSheet->notes) }}</textarea>
                            @error('notes')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Collection Sheet
                        </button>
                        <a href="{{ route('collection-sheets.show', $collectionSheet) }}" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Current Items</h3>
                </div>
                <div class="card-body">
                    <p>This collection sheet contains <strong>{{ $collectionSheet->items->count() }}</strong> items.</p>
                    
                    <div class="mt-3">
                        <h6>Summary:</h6>
                        <ul class="list-unstyled">
                            <li>Total Expected: <strong>{{ number_format($collectionSheet->items->sum('expected_amount'), 2) }}</strong></li>
                            <li>Total Collected: <strong>{{ number_format($collectionSheet->items->sum('collected_amount'), 2) }}</strong></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Warning</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <small>
                            <i class="fas fa-exclamation-triangle"></i>
                            Only collection sheets with "draft" status can be edited. 
                            Once processed, changes cannot be made.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection