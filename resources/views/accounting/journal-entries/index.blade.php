{{-- resources/views/accounting/journal-entries/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Journal Entries')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Journal Entries</h1>
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
            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalEntries }}</h3>
                            <p>Total Entries</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-book"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $postedEntries }}</h3>
                            <p>Posted Entries</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $draftEntries }}</h3>
                            <p>Draft Entries</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-edit"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ number_format($totalAmount, 2) }}</h3>
                            <p>Total Amount</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters Card -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('accounting.journal-entries') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>From Date</label>
                                            <input type="date" class="form-control" name="start_date" 
                                                   value="{{ request('start_date') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>To Date</label>
                                            <input type="date" class="form-control" name="end_date" 
                                                   value="{{ request('end_date') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" name="status">
                                                <option value="">All Status</option>
                                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                                <option value="posted" {{ request('status') == 'posted' ? 'selected' : '' }}>Posted</option>
                                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="d-flex">
                                                <button type="submit" class="btn btn-primary mr-2">
                                                    <i class="fas fa-filter"></i> Filter
                                                </button>
                                                <a href="{{ route('accounting.journal-entries') }}" class="btn btn-secondary">
                                                    <i class="fas fa-redo"></i> Reset
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Card -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Journal Entries</h3>
                            <div class="card-tools">
                                <a href="{{ route('accounting.journal-entries.create') }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-plus-circle"></i> New Entry
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="journalEntriesTable" class="table table-hover table-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Entry #</th>
                                            <th>Date</th>
                                            <th>Description</th>
                                            <th>Branch</th>
                                            <th>Debit Total</th>
                                            <th>Credit Total</th>
                                            <th>Status</th>
                                            <th>Created By</th>
                                            <th width="120" class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($journalEntries as $entry)
                                        <tr>
                                            <td>
                                                <strong class="text-primary">{{ $entry->entry_number }}</strong>
                                                @if($entry->reference)
                                                <br><small class="text-muted">Ref: {{ $entry->reference }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $entry->entry_date->format('M d, Y') }}</td>
                                            <td>
                                                {{ Str::limit($entry->description, 50) }}
                                                @if($entry->notes)
                                                <br><small class="text-muted">{{ Str::limit($entry->notes, 30) }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $entry->branch->name }}</td>
                                            <td class="text-danger font-weight-bold">{{ number_format($entry->total_debit, 2) }}</td>
                                            <td class="text-success font-weight-bold">{{ number_format($entry->total_credit, 2) }}</td>
                                            <td>
                                                <span class="badge badge-{{ $entry->status === 'posted' ? 'success' : ($entry->status === 'draft' ? 'warning' : 'danger') }}">
                                                    <i class="fas fa-{{ $entry->status === 'posted' ? 'check' : ($entry->status === 'draft' ? 'edit' : 'times') }} mr-1"></i>
                                                    {{ ucfirst($entry->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <small>{{ $entry->createdBy->name }}</small>
                                                @if($entry->posted_at)
                                                <br><small class="text-muted">Posted: {{ $entry->posted_at->format('M d, Y') }}</small>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('accounting.journal-entries.show', $entry) }}" 
                                                       class="btn btn-info" 
                                                       data-toggle="tooltip" 
                                                       title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($entry->status === 'draft')
                                                    <a href="{{ route('accounting.journal-entries.edit', $entry) }}" 
                                                       class="btn btn-warning" 
                                                       data-toggle="tooltip" 
                                                       title="Edit Entry">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('accounting.journal-entries.destroy', $entry) }}" 
                                                          method="POST" 
                                                          class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-danger" 
                                                                data-toggle="tooltip" 
                                                                title="Delete Entry"
                                                                onclick="return confirm('Are you sure you want to delete this journal entry?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                    @if($entry->status === 'draft')
                                                    <form action="{{ route('accounting.journal-entries.post', $entry) }}" 
                                                          method="POST" 
                                                          class="d-inline">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="btn btn-success" 
                                                                data-toggle="tooltip" 
                                                                title="Post Entry"
                                                                onclick="return confirm('Are you sure you want to post this journal entry?')">
                                                            <i class="fas fa-check"></i>
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

                            <!-- Pagination -->
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="dataTables_info">
                                        Showing {{ $journalEntries->firstItem() ?? 0 }} to {{ $journalEntries->lastItem() ?? 0 }} of {{ $journalEntries->total() }} entries
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-end">
                                        {{ $journalEntries->links() }}
                                    </div>
                                </div>
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
            "paging": false,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "responsive": true,
            "order": [[1, 'desc']],
            "language": {
                "search": "_INPUT_",
                "searchPlaceholder": "Search entries...",
                "emptyTable": "No journal entries found",
                "zeroRecords": "No matching entries found"
            }
        });

        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush