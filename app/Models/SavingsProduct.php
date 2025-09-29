<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingsProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'interest_rate',
        'interest_calculation',
        'minimum_deposit',
        'maximum_deposit',
        'minimum_balance',
        'allow_withdrawals',
        'is_active'
    ];

    protected $casts = [
        'interest_rate' => 'decimal:2',
        'minimum_deposit' => 'decimal:2',
        'maximum_deposit' => 'decimal:2',
        'minimum_balance' => 'decimal:2',
        'allow_withdrawals' => 'boolean',
        'is_active' => 'boolean'
    ];

    public function savings()
    {
        return $this->hasMany(Saving::class);
    }
}
