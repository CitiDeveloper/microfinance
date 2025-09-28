<?php
// database/migrations/YYYY_MM_DD_create_loan_products_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanProductsTable extends Migration
{
    public function up()
    {
        Schema::create('loan_products', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('loan_product_name');
            $table->boolean('loan_enable_parameters')->default(false);

            // Loan Release Date
            $table->boolean('default_loan_released_date')->default(false);

            // Principal Amount Settings
            $table->json('loan_disbursed_by_id')->nullable();
            $table->decimal('min_loan_principal_amount', 15, 2)->nullable();
            $table->decimal('default_loan_principal_amount', 15, 2)->nullable();
            $table->decimal('max_loan_principal_amount', 15, 2)->nullable();

            // Interest Settings
            $table->enum('loan_interest_method', [
                'flat_rate',
                'reducing_rate_equal_installments',
                'reducing_rate_equal_principal',
                'interest_only',
                'compound_interest_new',
                'compound_interest'
            ])->nullable();

            $table->enum('loan_interest_type', ['percentage', 'fixed'])->default('percentage');
            $table->enum('loan_interest_period', ['Day', 'Week', 'Month', 'Year', 'Loan'])->nullable();
            $table->decimal('min_loan_interest', 10, 4)->nullable();
            $table->decimal('default_loan_interest', 10, 4)->nullable();
            $table->decimal('max_loan_interest', 10, 4)->nullable();

            // Duration Settings
            $table->enum('loan_duration_period', ['Days', 'Weeks', 'Months', 'Years'])->nullable();
            $table->integer('min_loan_duration')->nullable();
            $table->integer('default_loan_duration')->nullable();
            $table->integer('max_loan_duration')->nullable();

            // Repayment Settings
            $table->json('loan_payment_scheme_id')->nullable();
            $table->integer('min_loan_num_of_repayments')->nullable();
            $table->integer('default_loan_num_of_repayments')->nullable();
            $table->integer('max_loan_num_of_repayments')->nullable();

            // Decimal Places
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
            ])->nullable();

            $table->boolean('loan_decimal_places_adjust_each_interest')->default(false);

            // Repayment Order
            $table->json('repayment_order')->nullable();

            // Automated Payments
            $table->boolean('automatic_payments')->default(false);
            $table->integer('payment_posting_period')->nullable();
            $table->json('automated_payments_dea_cash_bank_account')->nullable();

            // After Maturity Settings
            $table->boolean('after_maturity_extend_loan')->default(false);
            $table->enum('after_maturity_percentage_or_fixed', ['percentage', 'fixed'])->default('percentage');
            $table->integer('after_maturity_calculate_interest_on')->nullable();
            $table->decimal('after_maturity_loan_interest', 10, 4)->nullable();
            $table->integer('after_maturity_recurring_period_num')->nullable();
            $table->integer('after_maturity_recurring_period_payment_scheme_id')->nullable();
            $table->integer('after_maturity_num_of_repayments')->nullable();
            $table->boolean('after_maturity_include_fees')->default(false);
            $table->boolean('after_maturity_past_maturity_status')->default(false);

            // Advanced Settings
            $table->decimal('first_repayment_amount', 15, 2)->nullable();
            $table->decimal('last_repayment_amount', 15, 2)->nullable();
            $table->decimal('override_each_repayment_amount', 15, 2)->nullable();
            $table->boolean('loan_interest_each_repayment_pro_rata')->default(false);
            $table->string('loan_interest_schedule')->nullable();
            $table->string('loan_principal_schedule')->nullable();
            $table->decimal('loan_balloon_repayment_amount', 15, 2)->nullable();
            $table->integer('loan_move_first_repayment_date_days')->nullable();
            $table->string('loan_schedule_description')->nullable();

            // Loan Status
            $table->foreignId('loan_status_id')->nullable();

            // Accounting
            $table->json('dea_cash_bank_account')->nullable();

            // Duplicate Repayments
            $table->boolean('stop_loan_duplicate_repayments')->default(false);

            // Status
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });

        // Pivot table for branches
        Schema::create('branch_loan_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->foreignId('loan_product_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('branch_loan_product');
        Schema::dropIfExists('loan_products');
    }
}
