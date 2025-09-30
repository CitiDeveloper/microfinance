{{-- resources/views/accounting/journal-entries/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Create Journal Entry')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Create Journal Entry</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('accounting.journal-entries') }}">Journal Entries</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">New Journal Entry</h3>
                        </div>
                        <form action="{{ route('accounting.journal-entries.store') }}" method="POST" id="journalEntryForm">
                            @csrf
                            <div class="card-body">
                                <!-- Header Information -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="entry_date">Entry Date *</label>
                                            <input type="date" class="form-control @error('entry_date') is-invalid @enderror" 
                                                   id="entry_date" name="entry_date" 
                                                   value="{{ old('entry_date', date('Y-m-d')) }}" required>
                                            @error('entry_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="branch_id">Branch *</label>
                                            <select class="form-control select2 @error('branch_id') is-invalid @enderror" 
                                                    id="branch_id" name="branch_id" required>
                                                <option value="">Select Branch</option>
                                                @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                                    {{ $branch->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('branch_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="reference">Reference</label>
                                            <input type="text" class="form-control @error('reference') is-invalid @enderror" 
                                                   id="reference" name="reference" 
                                                   value="{{ old('reference') }}" 
                                                   placeholder="Optional reference number">
                                            @error('reference')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description">Description *</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="2" 
                                              placeholder="Enter journal entry description..." required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              id="notes" name="notes" rows="2" 
                                              placeholder="Optional notes...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Journal Entry Items -->
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <h5 class="mb-3">Journal Entry Items</h5>
                                        <div id="items-container">
                                            <!-- Items will be added here dynamically -->
                                        </div>
                                        <button type="button" class="btn btn-success btn-sm" id="add-item-btn">
                                            <i class="fas fa-plus mr-1"></i> Add Item
                                        </button>
                                    </div>
                                </div>

                                <!-- Totals Summary -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-box bg-light">
                                            <span class="info-box-icon bg-danger"><i class="fas fa-arrow-left"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Total Debit</span>
                                                <span class="info-box-number" id="total-debit">0.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-box bg-light">
                                            <span class="info-box-icon bg-success"><i class="fas fa-arrow-right"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Total Credit</span>
                                                <span class="info-box-number" id="total-credit">0.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Balance Status -->
                                <div class="alert" id="balance-alert" style="display: none;">
                                    <i class="icon fas fa-info-circle mr-2"></i>
                                    <span id="balance-message"></span>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="submit-btn">
                                    <i class="fas fa-save mr-1"></i> Create Journal Entry
                                </button>
                                <a href="{{ route('accounting.journal-entries') }}" class="btn btn-secondary float-right">
                                    <i class="fas fa-times mr-1"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    .item-row {
        border: 1px solid #e3e6f0;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 10px;
        background-color: #f8f9fc;
    }
    .remove-item {
        color: #dc3545;
        cursor: pointer;
    }
    .remove-item:hover {
        color: #bd2130;
    }
    .balance-balanced {
        background-color: #d4edda;
        color: #155724;
        border-color: #c3e6cb;
    }
    .balance-unbalanced {
        background-color: #f8d7da;
        color: #721c24;
        border-color: #f5c6cb;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({
            theme: 'bootstrap4'
        });

        let itemCounter = 0;

        // Add new item row
        $('#add-item-btn').click(function() {
            addItemRow();
        });

        // Add first two items by default
        addItemRow();
        addItemRow();

        function addItemRow() {
            const itemRow = `
                <div class="item-row" id="item-${itemCounter}">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Account *</label>
                                <select name="items[${itemCounter}][chart_of_account_id]" 
                                        class="form-control select2 account-select" required>
                                    <option value="">Select Account</option>
                                    @foreach($accounts as $account)
                                    <option value="{{ $account->id }}" 
                                            data-normal-balance="{{ $account->normal_balance }}"
                                            data-category="{{ $account->accountType->category }}">
                                        {{ $account->code }} - {{ $account->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Debit</label>
                                <input type="number" name="items[${itemCounter}][debit]" 
                                       class="form-control debit-input" 
                                       step="0.01" min="0" 
                                       placeholder="0.00">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Credit</label>
                                <input type="number" name="items[${itemCounter}][credit]" 
                                       class="form-control credit-input" 
                                       step="0.01" min="0" 
                                       placeholder="0.00">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" name="items[${itemCounter}][description]" 
                                       class="form-control" 
                                       placeholder="Item description">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="button" class="btn btn-danger btn-block remove-item" 
                                        data-item-id="${itemCounter}">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            $('#items-container').append(itemRow);
            
            // Initialize Select2 for the new row
            $(`#item-${itemCounter} .select2`).select2({
                theme: 'bootstrap4'
            });
            
            itemCounter++;
        }

        // Remove item row
        $(document).on('click', '.remove-item', function() {
            const itemId = $(this).data('item-id');
            $(`#item-${itemId}`).remove();
            calculateTotals();
        });

        // Calculate totals when debit/credit inputs change
        $(document).on('input', '.debit-input, .credit-input', function() {
            const row = $(this).closest('.item-row');
            const debitInput = row.find('.debit-input');
            const creditInput = row.find('.credit-input');
            
            // Ensure only one field has value
            if ($(this).hasClass('debit-input') && $(this).val() > 0) {
                creditInput.val('');
            } else if ($(this).hasClass('credit-input') && $(this).val() > 0) {
                debitInput.val('');
            }
            
            calculateTotals();
        });

        function calculateTotals() {
            let totalDebit = 0;
            let totalCredit = 0;

            $('.debit-input').each(function() {
                totalDebit += parseFloat($(this).val()) || 0;
            });

            $('.credit-input').each(function() {
                totalCredit += parseFloat($(this).val()) || 0;
            });

            $('#total-debit').text(totalDebit.toFixed(2));
            $('#total-credit').text(totalCredit.toFixed(2));

            // Update balance status
            const balanceAlert = $('#balance-alert');
            const balanceMessage = $('#balance-message');
            const submitBtn = $('#submit-btn');

            if (totalDebit === totalCredit && totalDebit > 0) {
                balanceAlert.removeClass('alert-danger balance-unbalanced').addClass('alert-success balance-balanced');
                balanceMessage.html('<strong>Balanced!</strong> Debit and credit totals are equal.');
                balanceAlert.show();
                submitBtn.prop('disabled', false);
            } else if (totalDebit > 0 || totalCredit > 0) {
                balanceAlert.removeClass('alert-success balance-balanced').addClass('alert-danger balance-unbalanced');
                const difference = Math.abs(totalDebit - totalCredit).toFixed(2);
                balanceMessage.html(`<strong>Unbalanced!</strong> Difference: ${difference}. Debit and credit totals must be equal.`);
                balanceAlert.show();
                submitBtn.prop('disabled', true);
            } else {
                balanceAlert.hide();
                submitBtn.prop('disabled', false);
            }
        }

        // Form validation
        $('#journalEntryForm').submit(function(e) {
            const totalDebit = parseFloat($('#total-debit').text());
            const totalCredit = parseFloat($('#total-credit').text());
            
            if (totalDebit !== totalCredit) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Unbalanced Entry',
                    text: 'Total debit and credit must be equal before submitting.',
                });
                return false;
            }

            // Check if we have at least 2 items with amounts
            const itemsWithAmounts = $('.item-row').filter(function() {
                const debit = parseFloat($(this).find('.debit-input').val()) || 0;
                const credit = parseFloat($(this).find('.credit-input').val()) || 0;
                return debit > 0 || credit > 0;
            }).length;

            if (itemsWithAmounts < 2) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Insufficient Items',
                    text: 'Please add at least two items with amounts.',
                });
                return false;
            }
        });

        // Auto-focus first description field
        $('#description').focus();
    });
</script>
@endpush