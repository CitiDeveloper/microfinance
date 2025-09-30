{{-- resources/views/accounting/journal-entries/show.blade.php --}}
@extends('layouts.app')

@section('title', $journalEntry->entry_number)

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Journal Entry: {{ $journalEntry->entry_number }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('accounting.journal-entries') }}">Journal Entries</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <!-- Entry Information Card -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Entry Information</h3>
                            <div class="card-tools">
                                @if($journalEntry->status === 'draft')
                                <a href="{{ route('accounting.journal-entries.edit', $journalEntry) }}" 
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Entry Number:</th>
                                    <td><strong>{{ $journalEntry->entry_number }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Date:</th>
                                    <td>{{ $journalEntry->entry_date->format('F d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Branch:</th>
                                    <td>{{ $journalEntry->branch->name }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge badge-{{ $journalEntry->status === 'posted' ? 'success' : ($journalEntry->status === 'draft' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($journalEntry->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Description:</th>
                                    <td>{{ $journalEntry->description }}</td>
                                </tr>
                                @if($journalEntry->reference)
                                <tr>
                                    <th>Reference:</th>
                                    <td>{{ $journalEntry->reference }}</td>
                                </tr>
                                @endif
                                @if($journalEntry->notes)
                                <tr>
                                    <th>Notes:</th>
                                    <td>{{ $journalEntry->notes }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Created By:</th>
                                    <td>{{ $journalEntry->createdBy->name }}</td>
                                </tr>
                                <tr>
                                    <th>Created Date:</th>
                                    <td>{{ $journalEntry->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                @if($journalEntry->posted_at)
                                <tr>
                                    <th>Posted By:</th>
                                    <td>{{ $journalEntry->postedBy->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Posted Date:</th>
                                    <td>{{ $journalEntry->posted_at->format('M d, Y H:i') }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    <!-- Totals Card -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Entry Totals</h3>
                        </div>
                        <div class="card-body text-center">
                            <div class="row">
                                <div class="col-6">
                                    <h4 class="text-danger">{{ number_format($journalEntry->total_debit, 2) }}</h4>
                                    <small class="text-muted">Total Debit</small>
                                </div>
                                <div class="col-6">
                                    <h4 class="text-success">{{ number_format($journalEntry->total_credit, 2) }}</h4>
                                    <small class="text-muted">Total Credit</small>
                                </div>
                            </div>
                            <hr>
                            <div class="mt-2">
                                @if($journalEntry->isBalanced())
                                <span class="badge badge-success">
                                    <i class="fas fa-check mr-1"></i> Balanced
                                </span>
                                @else
                                <span class="badge badge-danger">
                                    <i class="fas fa-times mr-1"></i> Unbalanced
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <!-- Entry Items Card -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Entry Items</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Account</th>
                                            <th>Description</th>
                                            <th class="text-right">Debit</th>
                                            <th class="text-right">Credit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($journalEntry->items as $item)
                                        <tr>
                                            <td>
                                                <strong>{{ $item->chartOfAccount->code }}</strong><br>
                                                <small class="text-muted">{{ $item->chartOfAccount->name }}</small>
                                            </td>
                                            <td>
                                                @if($item->description)
                                                {{ $item->description }}
                                                @else
                                                <span class="text-muted">No description</span>
                                                @endif
                                            </td>
                                            <td class="text-right text-danger font-weight-bold">
                                                @if($item->debit > 0)
                                                {{ number_format($item->debit, 2) }}
                                                @else
                                                <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-right text-success font-weight-bold">
                                                @if($item->credit > 0)
                                                {{ number_format($item->credit, 2) }}
                                                @else
                                                <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="font-weight-bold">
                                        <tr>
                                            <td colspan="2" class="text-right">Totals:</td>
                                            <td class="text-right text-danger">{{ number_format($journalEntry->total_debit, 2) }}</td>
                                            <td class="text-right text-success">{{ number_format($journalEntry->total_credit, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    @if($journalEntry->status === 'draft')
                    <div class="card">
                        <div class="card-body text-center">
                            <form action="{{ route('accounting.journal-entries.post', $journalEntry) }}" 
                                  method="POST" 
                                  class="d-inline">
                                @csrf
                                <button type="submit" 
                                        class="btn btn-success mr-2"
                                        onclick="return confirm('Are you sure you want to post this journal entry?')">
                                    <i class="fas fa-check mr-1"></i> Post Entry
                                </button>
                            </form>
                            <form action="{{ route('accounting.journal-entries.cancel', $journalEntry) }}" 
                                  method="POST" 
                                  class="d-inline">
                                @csrf
                                <button type="submit" 
                                        class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to cancel this journal entry?')">
                                    <i class="fas fa-times mr-1"></i> Cancel Entry
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection