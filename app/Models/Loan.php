<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'loan_product_id',
        'borrower_id',
        'branch_id',
        'staff_id',
        'loan_application_id',
        'loan_title',
        'loan_description',
        'loan_principal_amount',
        'loan_disbursed_by_id',
        'loan_released_date',
        'loan_interest_method',
        'loan_interest_type',
        'loan_interest',
        'loan_interest_period',
        'loan_duration',
        'loan_duration_period',
        'loan_payment_scheme_id',
        'loan_num_of_repayments',
        'loan_decimal_places',
        'loan_decimal_places_adjust_each_interest',
        'loan_interest_start_date',
        'loan_first_repayment_date',
        'loan_first_repayment_pro_rata',
        'loan_fees_pro_rata',
        'loan_do_not_adjust_remaining_pro_rata',
        'first_repayment_amount',
        'last_repayment_amount',
        'loan_override_maturity_date',
        'override_each_repayment_amount',
        'loan_interest_each_repayment_pro_rata',
        'loan_interest_schedule',
        'loan_principal_schedule',
        'loan_balloon_repayment_amount',
        'loan_move_first_repayment_date_days',
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
        'after_maturity_apply_to_date',
        'loan_status_id',
        'dea_cash_bank_account'
    ];

    protected $casts = [
        'loan_principal_amount' => 'decimal:2',
        'loan_interest' => 'decimal:4',
        'loan_released_date' => 'date',
        'loan_interest_start_date' => 'date',
        'loan_first_repayment_date' => 'date',
        'loan_override_maturity_date' => 'date',
        'after_maturity_apply_to_date' => 'date',
        'first_repayment_amount' => 'decimal:2',
        'last_repayment_amount' => 'decimal:2',
        'override_each_repayment_amount' => 'decimal:2',
        'loan_balloon_repayment_amount' => 'decimal:2',
        'automatic_payments' => 'boolean',
        'after_maturity_extend_loan' => 'boolean',
        'after_maturity_include_fees' => 'boolean',
        'after_maturity_past_maturity_status' => 'boolean',
    ];

    // Relationships
    public function loanProduct()
    {
        return $this->belongsTo(LoanProduct::class);
    }

    public function borrower()
    {
        return $this->belongsTo(Borrower::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function disbursedBy()
    {
        return $this->belongsTo(DisbursementMethod::class, 'loan_disbursed_by_id');
    }

    public function paymentScheme()
    {
        return $this->belongsTo(RepaymentCycle::class, 'loan_payment_scheme_id');
    }

    public function loanStatus()
    {
        return $this->belongsTo(LoanStatus::class);
    }

    public function cashBankAccount()
    {
        return $this->belongsTo(BankAccount::class, 'dea_cash_bank_account');
    }

    public function automatedPaymentsBankAccount()
    {
        return $this->belongsTo(BankAccount::class, 'automated_payments_dea_cash_bank_account');
    }

    public function afterMaturityPaymentScheme()
    {
        return $this->belongsTo(RepaymentCycle::class, 'loan_payment_scheme_id');
    }

    public function guarantors()
    {
        return $this->belongsToMany(Guarantor::class, 'loan_guarantor');
    }

    public function repayments()
    {
        return $this->hasMany(Repayment::class);
    }

    public function collateral()
    {
        return $this->hasMany(CollateralRegister::class);
    }

    // Scopes
    public function scopePendingApproval($query)
    {
        return $query->where('loan_status_id', 8); // Processing status
    }

    public function scopeActive($query)
    {
        return $query->where('loan_status_id', 1); // Open status
    }

    public function scopeOverdue($query)
    {
        return $query->where('loan_status_id', 3); // Defaulted status
    }

    // Helper methods
    public function isPending()
    {
        return $this->loan_status_id === 8;
    }

    public function isActive()
    {
        return $this->loan_status_id === 1;
    }

    public function isOverdue()
    {
        return $this->loan_status_id === 3;
    }

    public function canBeApproved()
    {
        return $this->isPending();
    }

    public function canBeDisbursed()
    {
        return $this->isActive();
    }
}
