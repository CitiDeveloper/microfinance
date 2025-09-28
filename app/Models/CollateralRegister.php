<?php
// app/Models/CollateralRegister.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollateralRegister extends Model
{
    use HasFactory;

    protected $table = 'collateral_registers';

    protected $fillable = [
        'loan_id',
        'collateral_type',
        'description',
        'estimated_value',
        'location',
        'condition',
        'serial_number',
        'registration_number',
        'acquisition_date',
        'last_valuation_date',
        'notes',
        'status',
        'document_path',
        'created_by',
    ];

    protected $casts = [
        'estimated_value' => 'decimal:2',
        'acquisition_date' => 'date',
        'last_valuation_date' => 'date',
    ];

    /**
     * Get the loan that owns the collateral.
     */
    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }

    /**
     * Get the staff member who created the collateral record.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'created_by');
    }

    /**
     * Scope a query to only include active collateral.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include collateral by type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('collateral_type', $type);
    }

    /**
     * Get formatted estimated value with currency.
     */
    public function getFormattedEstimatedValueAttribute()
    {
        return 'Ksh ' . number_format($this->estimated_value, 2);
    }

    /**
     * Check if collateral is active.
     */
    public function isActive()
    {
        return $this->status === 'active';
    }
}
