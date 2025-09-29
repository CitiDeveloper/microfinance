<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CollectionSheet extends Model
{
    protected $fillable = [
        'branch_id',
        'staff_id',
        'collection_date',
        'sheet_type', // daily, weekly, custom
        'status',
        'total_expected',
        'total_collected',
        'notes',
        'created_by'
    ];

    protected $casts = [
        'collection_date' => 'date',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CollectionSheetItem::class);
    }
}
