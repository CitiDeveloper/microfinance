<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('branch_name');
            $table->date('branch_open_date');
            $table->boolean('account_settings_override')->default(false);

            // Location Information
            $table->string('branch_country', 3)->nullable();
            $table->string('branch_currency', 5)->nullable();
            $table->string('branch_dateformat', 20)->nullable();
            $table->string('branch_currency_in_words')->nullable();

            // Address Information
            $table->text('branch_address')->nullable();
            $table->string('branch_city')->nullable();
            $table->string('branch_province')->nullable();
            $table->string('branch_zipcode')->nullable();
            $table->string('branch_landline')->nullable();
            $table->string('branch_mobile')->nullable();

            // Loan Restrictions
            $table->decimal('branch_min_loan_amount', 15, 2)->nullable();
            $table->decimal('branch_max_loan_amount', 15, 2)->nullable();
            $table->decimal('branch_min_interest_rate', 5, 2)->nullable();
            $table->decimal('branch_max_interest_rate', 5, 2)->nullable();

            // Unique Number Generation
            $table->string('borrower_num_placeholder')->nullable();
            $table->string('loan_num_placeholder')->nullable();

            // Status
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('branch_loan_officers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('branch_collectors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('staff_branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained()->onDelete('cascade');
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('branch_collectors');
        Schema::dropIfExists('branch_loan_officers');
        Schema::dropIfExists('staff_branches');
        Schema::dropIfExists('branches');
    }
};
