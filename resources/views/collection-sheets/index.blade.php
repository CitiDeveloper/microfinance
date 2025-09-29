@extends('layouts.app')

@section('title', 'Collection Sheets')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Collection Sheets</h3>
                    <div class="card-tools">
                        <a href="{{ route('collection-sheets.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Create New Sheet
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Collection Date</th>
                                    <th>Branch</th>
                                    <th>Staff</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Expected</th>
                                    <th>Collected</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($collectionSheets as $sheet)
                                    <tr>
                                        <td>{{ $sheet->id }}</td>
                                        <td>{{ $sheet->collection_date->format('M d, Y') }}</td>
                                        <td>{{ $sheet->branch->name }}</td>
                                        <td>{{ $sheet->staff->full_name }}</td>
                                        <td>
                                            <span class="badge badge-info text-capitalize">{{ $sheet->sheet_type }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'draft' => 'secondary',
                                                    'in_progress' => 'warning',
                                                    'completed' => 'success',
                                                    'cancelled' => 'danger'
                                                ];
                                            @endphp
                                            <span class="badge badge-{{ $statusColors[$sheet->status] }} text-capitalize">
                                                {{ str_replace('_', ' ', $sheet->status) }}
                                            </span>
                                        </td>
                                        <td>{{ number_format($sheet->total_expected, 2) }}</td>
                                        <td>{{ number_format($sheet->total_collected, 2) }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('collection-sheets.show', $sheet) }}" 
                                                   class="btn btn-info" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($sheet->status === 'draft')
                                                    <a href="{{ route('collection-sheets.edit', $sheet) }}" 
                                                       class="btn btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('collection-sheets.destroy', $sheet) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" 
                                                                title="Delete" 
                                                                onclick="return confirm('Are you sure you want to delete this collection sheet?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                <a href="{{ route('collection-sheets.export-pdf', $sheet) }}" 
                                                   class="btn btn-secondary" title="Export PDF">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No collection sheets found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-3">
                        {{ $collectionSheets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection