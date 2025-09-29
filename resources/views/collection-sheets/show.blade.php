@extends('layouts.app')

@section('title', 'Collection Sheet Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Collection Sheet #{{ $collectionSheet->id }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('collection-sheets.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Collection Date:</th>
                                    <td>{{ $collectionSheet->collection_date->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Branch:</th>
                                    <td>{{ $collectionSheet->branch->name }}</td>
                                </tr>
                                <tr>
                                    <th>Staff:</th>
                                    <td>{{ $collectionSheet->staff->full_name }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Sheet Type:</th>
                                    <td>
                                        <span class="badge badge-info text-capitalize">{{ $collectionSheet->sheet_type }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'draft' => 'secondary',
                                                'in_progress' => 'warning',
                                                'completed' => 'success',
                                                'cancelled' => 'danger'
                                            ];
                                        @endphp
                                        <span class="badge badge-{{ $statusColors[$collectionSheet->status] }} text-capitalize">
                                            {{ str_replace('_', ' ', $collectionSheet->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created By:</th>
                                    <td>{{ $collectionSheet->createdBy->name ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    @if($collectionSheet->notes)
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="callout callout-info">
                                    <h5>Notes</h5>
                                    <p>{{ $collectionSheet->notes }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Collection Items</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Borrower</th>
                                            <th>Loan ID</th>
                                            <th>Expected Amount</th>
                                            <th>Collected Amount</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($collectionSheet->items as $item)
                                            <tr>
                                                <td>{{ $item->borrower->full_name }}</td>
                                                <td>LOAN-{{ $item->loan_id }}</td>
                                                <td>{{ number_format($item->expected_amount, 2) }}</td>
                                                <td>{{ number_format($item->collected_amount, 2) }}</td>
                                                <td>
                                                    @php
                                                        $itemStatusColors = [
                                                            'pending' => 'secondary',
                                                            'collected' => 'success',
                                                            'partial' => 'warning',
                                                            'missed' => 'danger'
                                                        ];
                                                    @endphp
                                                    <span class="badge badge-{{ $itemStatusColors[$item->collection_status] }}">
                                                        {{ ucfirst($item->collection_status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($collectionSheet->status === 'draft')
                                                        <button class="btn btn-sm btn-primary update-collection-btn" 
                                                                data-item-id="{{ $item->id }}"
                                                                data-expected="{{ $item->expected_amount }}"
                                                                data-current="{{ $item->collected_amount }}"
                                                                data-status="{{ $item->collection_status }}">
                                                            <i class="fas fa-edit"></i> Update
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            @if($collectionSheet->status === 'draft')
                                <a href="{{ route('collection-sheets.edit', $collectionSheet) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit Sheet
                                </a>
                                <form action="{{ route('collection-sheets.destroy', $collectionSheet) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" 
                                            onclick="return confirm('Are you sure you want to delete this collection sheet?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                        <div class="col-md-6 text-right">
                            @if($collectionSheet->status === 'draft')
                                <form action="{{ route('collection-sheets.process-collection', $collectionSheet) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success" 
                                            onclick="return confirm('Are you sure you want to process this collection? This action cannot be undone.')">
                                        <i class="fas fa-check"></i> Process Collection
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('collection-sheets.export-pdf', $collectionSheet) }}" class="btn btn-secondary">
                                <i class="fas fa-file-pdf"></i> Export PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Collection Summary</h3>
                </div>
                <div class="card-body">
                    <div class="info-box bg-gradient-info">
                        <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Expected</span>
                            <span class="info-box-number">{{ number_format($summary['total_expected'], 2) }}</span>
                        </div>
                    </div>
                    
                    <div class="info-box bg-gradient-success">
                        <span class="info-box-icon"><i class="fas fa-cash-register"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Collected</span>
                            <span class="info-box-number">{{ number_format($summary['total_collected'], 2) }}</span>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-6">
                            <div class="small-box bg-secondary">
                                <div class="inner">
                                    <h3>{{ $summary['pending_count'] }}</h3>
                                    <p>Pending</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $summary['collected_count'] }}</h3>
                                    <p>Collected</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $summary['partial_count'] }}</h3>
                                    <p>Partial</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-exclamation"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>{{ $summary['missed_count'] }}</h3>
                                    <p>Missed</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-times"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Update Collection Modal -->
<div class="modal fade" id="updateCollectionModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Collection</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="updateCollectionForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="item_id" id="item_id">
                    <div class="form-group">
                        <label for="expected_amount">Expected Amount</label>
                        <input type="text" id="expected_amount" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="collected_amount">Collected Amount *</label>
                        <input type="number" name="collected_amount" id="collected_amount" 
                               class="form-control" step="0.01" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="collection_status">Collection Status *</label>
                        <select name="collection_status" id="collection_status" class="form-control" required>
                            <option value="pending">Pending</option>
                            <option value="collected">Collected</option>
                            <option value="partial">Partial</option>
                            <option value="missed">Missed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Collection</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.update-collection-btn').click(function() {
        const itemId = $(this).data('item-id');
        const expected = $(this).data('expected');
        const current = $(this).data('current');
        const status = $(this).data('status');
        
        $('#item_id').val(itemId);
        $('#expected_amount').val(expected);
        $('#collected_amount').val(current);
        $('#collection_status').val(status);
        
        $('#updateCollectionModal').modal('show');
    });
    
    $('#updateCollectionForm').submit(function(e) {
        e.preventDefault();
        
        const itemId = $('#item_id').val();
        const formData = $(this).serialize();
        
        $.ajax({
            url: `/collection-sheet-items/${itemId}/update-collection`,
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    $('#updateCollectionModal').modal('hide');
                    location.reload();
                }
            },
            error: function(xhr) {
                alert('Error updating collection: ' + xhr.responseJSON.message);
            }
        });
    });
});
</script>
@endpush