<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollectionSheetLog extends Model
{
    protected $fillable = [
        'collection_sheet_id',
        'action',
        'details',
        'performed_by',
        'performed_at'
    ];

    protected $casts = [
        'performed_at' => 'datetime',
    ];

    public function collectionSheet(): BelongsTo
    {
        return $this->belongsTo(CollectionSheet::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'performed_by');
    }
}
