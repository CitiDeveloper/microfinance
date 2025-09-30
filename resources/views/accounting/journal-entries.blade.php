{{-- resources/views/accounting/journal-entries.blade.php --}}
@extends('layouts.app')

@section('title', 'Journal Entries')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Journal Entries</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Journal Entries</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>From Date</label>
                                        <input type="date" class="form-control" id="fromDate">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>To Date</label>
                                        <input type="date" class="form-control" id="toDate">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" id="statusFilter">
                                            <option value="">All Status</option>
                                            <option value="draft">Draft</option>
                                            <option value="posted">Posted</option>
                                            <option value="cancelled">Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button class="btn btn-primary btn-block" onclick="filterEntries()">
                                            <i class="fas fa-filter"></i> Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Journal Entries</h3>
                            <div class="card-tools">
                                <a href="{{ route('accounting.journal-entries.create') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus"></i> New Entry
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="journalEntriesTable" class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Entry #</th>
                                            <th>Date</th>
                                            <th>Description</th>
                                            <th>Branch</th>
                                            <th>Debit Total</th>
                                            <th>Credit Total</th>
                                            <th>Status</th>
                                            <th>Created By</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($journalEntries as $entry)
                                        <tr>
                                            <td><strong>{{ $entry->entry_number }}</strong></td>
                                            <td>{{ $entry->entry_date->format('M d, Y') }}</td>
                                            <td>{{ Str::limit($entry->description, 50) }}</td>
                                            <td>{{ $entry->branch->name }}</td>
                                            <td class="text-danger font-weight-bold">{{ number_format($entry->total_debit, 2) }}</td>
                                            <td class="text-success font-weight-bold">{{ number_format($entry->total_credit, 2) }}</td>
                                            <td>
                                                <span class="badge badge-{{ $entry->status === 'posted' ? 'success' : ($entry->status === 'draft' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($entry->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $entry->createdBy->name }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('accounting.journal-entries.show', $entry) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($entry->status === 'draft')
                                                    <a href="{{ route('accounting.journal-entries.edit', $entry) }}" class="btn btn-sm btn-outline-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('accounting.journal-entries.destroy', $entry) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#journalEntriesTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "order": [[1, 'desc']]
        });
    });

    function filterEntries() {
        // Implement filtering logic here
        console.log('Filtering entries...');
    }
</script>
@endpush