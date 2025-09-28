<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_role_id')->nullable();
            $table->unsignedBigInteger('staff_payroll_branch_id')->nullable();
            $table->string('staff_firstname');
            $table->string('staff_lastname');
            $table->string('staff_email')->unique();
            $table->enum('staff_gender', ['Male', 'Female']);
            $table->integer('staff_show_results')->default(20);
            $table->string('staff_mobile')->nullable();
            $table->date('staff_dob')->nullable();
            $table->text('staff_address')->nullable();
            $table->string('staff_city')->nullable();
            $table->string('staff_province')->nullable();
            $table->string('staff_zipcode')->nullable();
            $table->string('staff_office_phone')->nullable();
            $table->string('staff_teams')->nullable();
            $table->string('staff_photo')->nullable();

            // Login restrictions
            $table->time('restrict_login_from_time')->nullable();
            $table->time('restrict_login_to_time')->nullable();
            $table->string('restrict_ip_address')->nullable();

            // Backdating/Postdating restrictions
            $table->enum('restrict_backdating_loans', ['Yes', 'No'])->default('No');
            $table->enum('restrict_postdating_loans', ['Yes', 'No'])->default('No');
            $table->enum('restrict_backdating_loan_repayments', ['Yes', 'No'])->default('No');
            $table->enum('restrict_postdating_loan_repayments', ['Yes', 'No'])->default('No');
            $table->enum('restrict_backdating_savings_transactions', ['Yes', 'No'])->default('No');
            $table->enum('restrict_postdating_savings_transactions', ['Yes', 'No'])->default('No');
            $table->enum('restrict_backdating_investor_transactions', ['Yes', 'No'])->default('No');
            $table->enum('restrict_postdating_investor_transactions', ['Yes', 'No'])->default('No');
            $table->enum('restrict_backdating_expenses', ['Yes', 'No'])->default('No');
            $table->enum('restrict_postdating_expenses', ['Yes', 'No'])->default('No');
            $table->enum('restrict_backdating_other_income', ['Yes', 'No'])->default('No');
            $table->enum('restrict_postdating_other_income', ['Yes', 'No'])->default('No');
            $table->enum('restrict_backdating_manual_journals', ['Yes', 'No'])->default('No');
            $table->enum('restrict_postdating_manual_journals', ['Yes', 'No'])->default('No');
            $table->enum('restrict_backdating_payroll', ['Yes', 'No'])->default('No');
            $table->enum('restrict_postdating_payroll', ['Yes', 'No'])->default('No');
            $table->enum('restrict_backdating_inter_bank_transfers', ['Yes', 'No'])->default('No');
            $table->enum('restrict_postdating_inter_bank_transfers', ['Yes', 'No'])->default('No');
            $table->enum('restrict_backdating_branch_equity', ['Yes', 'No'])->default('No');
            $table->enum('restrict_postdating_branch_equity', ['Yes', 'No'])->default('No');
            $table->enum('restrict_backdating_collateral_register', ['Yes', 'No'])->default('No');
            $table->enum('restrict_postdating_collateral_register', ['Yes', 'No'])->default('No');

            // Approval restrictions
            $table->enum('restrict_add_repayments', ['Yes', 'No'])->default('No');
            $table->enum('restrict_add_savings_transactions', ['Yes', 'No'])->default('No');
            $table->enum('restrict_add_manual_journal', ['Yes', 'No'])->default('No');

            $table->json('loan_view_all_loans_default_status_ids')->nullable();
            $table->json('loan_view_all_repayments_default_status_ids')->nullable();
            $table->json('view_all_savings_accounts_default_status_ids')->nullable();
            $table->json('view_all_savings_transactions_default_status_ids')->nullable();

            $table->timestamps();
        });

        // Pivot table for staff branches access
        
    }

    public function down()
    {
       
        Schema::dropIfExists('staff');
    }
};
