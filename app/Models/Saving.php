<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_number',
        'borrower_id',
        'branch_id',
        'savings_product_id',
        'balance',
        'minimum_balance',
        'status',
        'opening_date',
        'maturity_date',
        'notes'
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'minimum_balance' => 'decimal:2',
        'opening_date' => 'date',
        'maturity_date' => 'date',
    ];

    public function borrower()
    {
        return $this->belongsTo(Borrower::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function savingsProduct()
    {
        return $this->belongsTo(SavingsProduct::class);
    }

    public function transactions()
    {
        return $this->hasMany(SavingsTransaction::class, 'saving_id');
    }
}
