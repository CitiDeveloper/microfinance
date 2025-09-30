<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChartOfAccount extends Model
{
    protected $fillable = [
        'account_type_id',
        'parent_id',
        'code',
        'name',
        'normal_balance',
        'description',
        'is_active',
        'is_system_account'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_system_account' => 'boolean'
    ];

    public function accountType(): BelongsTo
    {
        return $this->belongsTo(AccountType::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ChartOfAccount::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(ChartOfAccount::class, 'parent_id');
    }

    public function journalEntryItems(): HasMany
    {
        return $this->hasMany(JournalEntryItem::class);
    }

    public function getBalanceAttribute()
    {
        $debit = $this->journalEntryItems()->sum('debit');
        $credit = $this->journalEntryItems()->sum('credit');

        return $this->normal_balance === 'debit' ? $debit - $credit : $credit - $debit;
    }
}