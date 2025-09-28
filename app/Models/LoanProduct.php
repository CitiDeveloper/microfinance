<?php
// app/Models/LoanProduct.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_product_name',
        'loan_enable_parameters',
        'default_loan_released_date',
        'loan_disbursed_by_id',
        'min_loan_principal_amount',
        'default_loan_principal_amount',
        'max_loan_principal_amount',
        'loan_interest_method',
        'loan_interest_type',
        'loan_interest_period',
        'min_loan_interest',
        'default_loan_interest',
        'max_loan_interest',
        'loan_duration_period',
        'min_loan_duration',
        'default_loan_duration',
        'max_loan_duration',
        'loan_payment_scheme_id',
        'min_loan_num_of_repayments',
        'default_loan_num_of_repayments',
        'max_loan_num_of_repayments',
        'loan_decimal_places',
        'loan_decimal_places_adjust_each_interest',
        'repayment_order',
        'automatic_payments',
        'payment_posting_period',
        'automated_payments_dea_cash_bank_account',
        'after_maturity_extend_loan',
        'after_maturity_percentage_or_fixed',
        'after_maturity_calculate_interest_on',
        'after_maturity_loan_interest',
        'after_maturity_recurring_period_num',
        'after_maturity_recurring_period_payment_scheme_id',
        'after_maturity_num_of_repayments',
        'after_maturity_include_fees',
        'after_maturity_past_maturity_status',
        'first_repayment_amount',
        'last_repayment_amount',
        'override_each_repayment_amount',
        'loan_interest_each_repayment_pro_rata',
        'loan_interest_schedule',
        'loan_principal_schedule',
        'loan_balloon_repayment_amount',
        'loan_move_first_repayment_date_days',
        'loan_schedule_description',
        'loan_status_id',
        'dea_cash_bank_account',
        'stop_loan_duplicate_repayments',
        'is_active'
    ];

    protected $casts = [
        'loan_disbursed_by_id' => 'array',
        'loan_payment_scheme_id' => 'array',
        'repayment_order' => 'array',
        'automated_payments_dea_cash_bank_account' => 'array',
        'dea_cash_bank_account' => 'array',
        'min_loan_principal_amount' => 'decimal:2',
        'default_loan_principal_amount' => 'decimal:2',
        'max_loan_principal_amount' => 'decimal:2',
        'min_loan_interest' => 'decimal:4',
        'default_loan_interest' => 'decimal:4',
        'max_loan_interest' => 'decimal:4',
        'after_maturity_loan_interest' => 'decimal:4',
        'first_repayment_amount' => 'decimal:2',
        'last_repayment_amount' => 'decimal:2',
        'override_each_repayment_amount' => 'decimal:2',
        'loan_balloon_repayment_amount' => 'decimal:2',
        'loan_enable_parameters' => 'boolean',
        'default_loan_released_date' => 'boolean',
        'loan_decimal_places_adjust_each_interest' => 'boolean',
        'automatic_payments' => 'boolean',
        'after_maturity_extend_loan' => 'boolean',
        'after_maturity_include_fees' => 'boolean',
        'after_maturity_past_maturity_status' => 'boolean',
        'loan_interest_each_repayment_pro_rata' => 'boolean',
        'stop_loan_duplicate_repayments' => 'boolean',
        'is_active' => 'boolean'
    ];

    // Relationships
    
    public function branches()
    {
        return $this->belongsToMany(
            Branch::class,
            'branch_loan_product',   // pivot table name
            'loan_product_id',       // foreign key on pivot table pointing to LoanProduct
            'branch_id'              // foreign key on pivot table pointing to Branch
        );
    }


    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function loanStatus()
    {
        return $this->belongsTo(LoanStatus::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
