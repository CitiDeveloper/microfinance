<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();

            // Basic loan information
            $table->foreignId('loan_product_id')->constrained()->onDelete('cascade');
            $table->foreignId('borrower_id')->constrained()->onDelete('cascade');
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->foreignId('staff_id')->constrained()->onDelete('cascade');

            // Loan identification
            $table->string('loan_application_id')->unique();
            $table->string('loan_title')->nullable();
            $table->text('loan_description')->nullable();

            // Principal information
            $table->decimal('loan_principal_amount', 15, 2);
            $table->foreignId('loan_disbursed_by_id')->constrained('disbursement_methods');
            $table->date('loan_released_date');

            // Interest information
            $table->enum('loan_interest_method', [
                'flat_rate',
                'reducing_rate_equal_installments',
                'reducing_rate_equal_principal',
                'interest_only',
                'compound_interest_new',
                'compound_interest'
            ]);
            $table->enum('loan_interest_type', ['percentage', 'fixed']);
            $table->decimal('loan_interest', 8, 4);
            $table->enum('loan_interest_period', ['Day', 'Week', 'Month', 'Year', 'Loan']);

            // Duration information
            $table->integer('loan_duration');
            $table->enum('loan_duration_period', ['Days', 'Weeks', 'Months', 'Years']);

            // Repayment information
            $table->integer('loan_payment_scheme_id')->nullable();
            $table->foreignId('repayment_cycle_id')->nullable()->constrained('repayment_cycles');
            $table->integer('loan_num_of_repayments');

            // Advanced settings
            $table->enum('loan_decimal_places', [
                'round_off_to_two_decimal',
                'round_off_to_integer',
                'round_down_to_integer',
                'round_up_to_integer',
                'round_off_to_one_decimal',
                'round_up_to_one_decimal',
                'round_up_to_five',
                'round_up_to_ten',
                'round_off_to_hundred'
            ])->default('round_off_to_two_decimal');
            $table->boolean('loan_decimal_places_adjust_each_interest')->default(false);
            $table->date('loan_interest_start_date')->nullable();
            $table->date('loan_due_date')->nullable();
            $table->unsignedInteger('grace_period_repayments')->default(0);
            $table->date('loan_first_repayment_date')->nullable();
            $table->boolean('loan_first_repayment_pro_rata')->default(false);
            $table->boolean('loan_fees_pro_rata')->default(false);
            $table->boolean('loan_do_not_adjust_remaining_pro_rata')->default(false);
            $table->decimal('first_repayment_amount', 15, 2)->nullable();
            $table->decimal('last_repayment_amount', 15, 2)->nullable();
            $table->date('loan_override_maturity_date')->nullable();
            $table->decimal('override_each_repayment_amount', 15, 2)->nullable();
            $table->boolean('loan_interest_each_repayment_pro_rata')->default(false);
            $table->string('loan_interest_schedule')->default('charge_interest_normally');
            $table->string('loan_principal_schedule')->default('charge_principal_normally');
            $table->decimal('loan_balloon_repayment_amount', 15, 2)->nullable();
            $table->integer('loan_move_first_repayment_date_days')->nullable();

            // Automated payments
            $table->boolean('automatic_payments')->default(false);
            $table->integer('payment_posting_period')->nullable();
            $table->foreignId('automated_payments_dea_cash_bank_account')->nullable()->constrained('bank_accounts');

            // Extended loan settings
            $table->boolean('after_maturity_extend_loan')->default(false);
            $table->enum('after_maturity_percentage_or_fixed', ['percentage', 'fixed'])->default('percentage');
            $table->string('after_maturity_calculate_interest_on')->nullable();
            $table->decimal('after_maturity_loan_interest', 8, 4)->nullable();
            $table->integer('after_maturity_recurring_period_num')->nullable();
            $table->foreignId('after_maturity_recurring_period_payment_scheme_id')
                ->nullable()
                ->constrained('loan_payment_schemes');
            $table->integer('after_maturity_num_of_repayments')->nullable();
            $table->boolean('after_maturity_include_fees')->default(false);
            $table->boolean('after_maturity_past_maturity_status')->default(false);
            $table->date('after_maturity_apply_to_date')->nullable();

            // Loan status and accounting
            $table->foreignId('loan_status_id')->constrained();
            $table->foreignId('dea_cash_bank_account')->constrained('bank_accounts');

            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        });

        // Pivot table for loan guarantors
        Schema::create('loan_guarantor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained()->onDelete('cascade');
            $table->foreignId('guarantor_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('loan_guarantor');
        Schema::dropIfExists('loans');
    }
};
