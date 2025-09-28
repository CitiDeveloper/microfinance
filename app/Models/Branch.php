<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'branch_name',
        'branch_open_date',
        'account_settings_override',
        'branch_country',
        'branch_currency',
        'branch_dateformat',
        'branch_currency_in_words',
        'branch_address',
        'branch_city',
        'branch_province',
        'branch_zipcode',
        'branch_landline',
        'branch_mobile',
        'branch_min_loan_amount',
        'branch_max_loan_amount',
        'branch_min_interest_rate',
        'branch_max_interest_rate',
        'borrower_num_placeholder',
        'loan_num_placeholder',
        'is_active',
    ];

    protected $casts = [
        'branch_open_date' => 'date',
        'account_settings_override' => 'boolean',
        'is_active' => 'boolean',
        'branch_min_loan_amount' => 'decimal:2',
        'branch_max_loan_amount' => 'decimal:2',
        'branch_min_interest_rate' => 'decimal:2',
        'branch_max_interest_rate' => 'decimal:2',
    ];

    // Relationships
    public function staff()
    {
        return $this->hasMany(Staff::class);
    }

    public function borrowers()
    {
        return $this->hasMany(Borrower::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function savings()
    {
        return $this->hasMany(Saving::class);
    }

    public function loanProducts()
    {
        return $this->belongsToMany(LoanProduct::class, 'branch_loan_products');
    }

    public function loanOfficers()
    {
        return $this->belongsToMany(Staff::class, 'branch_loan_officers');
    }

    public function collectors()
    {
        return $this->belongsToMany(Staff::class, 'branch_collectors');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessors
    public function getFormattedOpenDateAttribute()
    {
        return $this->branch_open_date->format('d/m/Y');
    }

    public function getFullAddressAttribute()
    {
        $address = [];
        if ($this->branch_address) $address[] = $this->branch_address;
        if ($this->branch_city) $address[] = $this->branch_city;
        if ($this->branch_province) $address[] = $this->branch_province;
        if ($this->branch_zipcode) $address[] = $this->branch_zipcode;
        if ($this->branch_country) $address[] = $this->branch_country;

        return implode(', ', $address);
    }
}
