<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingsTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'saving_id',
        'branch_id',
        'transaction_reference',
        'type',
        'amount',
        'balance_before',
        'balance_after',
        'transaction_date',
        'notes',
        'receipt_number',
        'created_by'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_before' => 'decimal:2',
        'balance_after' => 'decimal:2',
        'transaction_date' => 'date'
    ];

    public function account()
    {
        return $this->belongsTo(Saving::class, 'saving_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
