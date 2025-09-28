<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Repayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'loan_id',
        'borrower_id',
        'branch_id',
        'collected_by',
        'repayment_number',
        'amount',
        'principal_paid',
        'interest_paid',
        'fees_paid',
        'penalty_paid',
        'waiver_amount',
        'payment_date',
        'posted_at',
        'receipt_number',
        'transaction_reference',
        'payment_method_id',
        'dea_cash_bank_account',
        'outstanding_balance',
        'exchange_rate',
        'status',
        'is_reconciled',
        'notes',
        'metadata',
        'reversed_by',
        'reversed_at',
        'reversal_reason',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'principal_paid' => 'decimal:2',
        'interest_paid' => 'decimal:2',
        'fees_paid' => 'decimal:2',
        'penalty_paid' => 'decimal:2',
        'waiver_amount' => 'decimal:2',
        'outstanding_balance' => 'decimal:2',
        'exchange_rate' => 'decimal:8',
        'payment_date' => 'date',
        'posted_at' => 'datetime',
        'is_reconciled' => 'boolean',
        'metadata' => 'array',
        'reversed_at' => 'datetime',
    ];

    protected $appends = [
        'total_allocated'
    ];

    /* ---------------------------
       Relations
       --------------------------- */
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function borrower()
    {
        return $this->belongsTo(Borrower::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function collector()
    {
        return $this->belongsTo(Staff::class, 'collected_by');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function paymentAccount()
    {
        return $this->belongsTo(BankAccount::class, 'dea_cash_bank_account');
    }

    public function reversedBy()
    {
        return $this->belongsTo(Staff::class, 'reversed_by');
    }

    /* ---------------------------
       Accessors & helpers
       --------------------------- */

    /**
     * Total allocated to principal + interest + fees + penalty - waivers
     */
    public function getTotalAllocatedAttribute(): float
    {
        return round(
            ($this->principal_paid ?? 0)
                + ($this->interest_paid ?? 0)
                + ($this->fees_paid ?? 0)
                + ($this->penalty_paid ?? 0)
                - ($this->waiver_amount ?? 0),
            2
        );
    }

    public function isPosted(): bool
    {
        return $this->status === 'posted';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /* ---------------------------
       Scopes
       --------------------------- */

    public function scopePosted($query)
    {
        return $query->where('status', 'posted');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeForLoan($query, $loanId)
    {
        return $query->where('loan_id', $loanId);
    }

    /* ---------------------------
       Actions
       --------------------------- */

    /**
     * Mark this repayment as posted (and set posted_at).
     */
    public function markAsPosted(?\DateTimeInterface $postedAt = null): void
    {
        $this->status = 'posted';
        $this->posted_at = $postedAt ?? now();
        $this->save();
    }

    /**
     * Reverse this repayment (audit reversal).
     */
    public function reverse(int $reversedByStaffId = null, string $reason = null): void
    {
        $this->status = 'reversed';
        $this->reversed_at = now();
        $this->reversed_by = $reversedByStaffId;
        $this->reversal_reason = $reason;
        $this->save();
    }
}
