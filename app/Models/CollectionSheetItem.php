<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollectionSheetItem extends Model
{
    protected $fillable = [
        'collection_sheet_id',
        'loan_id',
        'borrower_id',
        'repayment_id',
        'expected_amount',
        'collected_amount',
        'collection_status', // pending, collected, partial, missed
        'collection_date',
        'notes',
    ];

    protected $casts = [
        'expected_amount' => 'decimal:2',
        'collected_amount' => 'decimal:2',
        'collection_date' => 'date',
    ];

    public function collectionSheet(): BelongsTo
    {
        return $this->belongsTo(CollectionSheet::class);
    }

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }

    public function borrower(): BelongsTo
    {
        return $this->belongsTo(Borrower::class);
    }

    public function repayment(): BelongsTo
    {
        return $this->belongsTo(Repayment::class, 'repayment_id');
    }
}
