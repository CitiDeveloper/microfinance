<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_role_id',
        'staff_payroll_branch_id',
        'staff_firstname',
        'staff_lastname',
        'staff_email',
        'staff_gender',
        'staff_show_results',
        'staff_mobile',
        'staff_dob',
        'staff_address',
        'staff_city',
        'staff_province',
        'staff_zipcode',
        'staff_office_phone',
        'staff_teams',
        'staff_photo',

        // Login restrictions
        'restrict_login_from_time',
        'restrict_login_to_time',
        'restrict_ip_address',

        // Backdating/Postdating restrictions
        'restrict_backdating_loans',
        'restrict_postdating_loans',
        'restrict_backdating_loan_repayments',
        'restrict_postdating_loan_repayments',
        'restrict_backdating_savings_transactions',
        'restrict_postdating_savings_transactions',
        'restrict_backdating_investor_transactions',
        'restrict_postdating_investor_transactions',
        'restrict_backdating_expenses',
        'restrict_postdating_expenses',
        'restrict_backdating_other_income',
        'restrict_postdating_other_income',
        'restrict_backdating_manual_journals',
        'restrict_postdating_manual_journals',
        'restrict_backdating_payroll',
        'restrict_postdating_payroll',
        'restrict_backdating_inter_bank_transfers',
        'restrict_postdating_inter_bank_transfers',
        'restrict_backdating_branch_equity',
        'restrict_postdating_branch_equity',
        'restrict_backdating_collateral_register',
        'restrict_postdating_collateral_register',

        // Approval restrictions
        'restrict_add_repayments',
        'restrict_add_savings_transactions',
        'restrict_add_manual_journal',

        // JSON defaults
        'loan_view_all_loans_default_status_ids',
        'loan_view_all_repayments_default_status_ids',
        'view_all_savings_accounts_default_status_ids',
        'view_all_savings_transactions_default_status_ids',
    ];

    protected $casts = [
        'staff_dob' => 'date',
        'restrict_login_from_time' => 'datetime:H:i',
        'restrict_login_to_time' => 'datetime:H:i',

        // JSON fields
        'loan_view_all_loans_default_status_ids' => 'array',
        'loan_view_all_repayments_default_status_ids' => 'array',
        'view_all_savings_accounts_default_status_ids' => 'array',
        'view_all_savings_transactions_default_status_ids' => 'array',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'staff_role_id');
    }

    public function payrollBranch()
    {
        return $this->belongsTo(Branch::class, 'staff_payroll_branch_id');
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'staff_branches')
            ->withTimestamps();
    }


    public function getFullNameAttribute()
    {
        return "{$this->staff_firstname} {$this->staff_lastname}";
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
