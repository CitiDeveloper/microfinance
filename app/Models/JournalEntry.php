<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JournalEntry extends Model
{
    protected $fillable = [
        'entry_number',
        'entry_date',
        'description',
        'status',
        'branch_id',
        'created_by',
        'posted_by',
        'posted_at',
        'total_debit',
        'total_credit',
        'reference',
        'notes'
    ];

    protected $casts = [
        'entry_date' => 'date',
        'posted_at' => 'datetime',
        'total_debit' => 'decimal:2',
        'total_credit' => 'decimal:2'
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function postedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(JournalEntryItem::class);
    }

    public function isBalanced(): bool
    {
        return $this->total_debit === $this->total_credit;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($journalEntry) {
            $journalEntry->entry_number = static::generateEntryNumber();
        });
    }

    protected static function generateEntryNumber(): string
    {
        $prefix = 'JE';
        $date = now()->format('Ymd');
        $lastEntry = static::where('entry_number', 'like', "{$prefix}{$date}%")->latest()->first();

        $sequence = $lastEntry ? (int)substr($lastEntry->entry_number, -4) + 1 : 1;

        return "{$prefix}{$date}" . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
}