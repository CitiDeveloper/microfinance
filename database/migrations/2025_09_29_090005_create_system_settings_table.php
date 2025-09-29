<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();

            // Company Settings
            $table->string('company_name')->default('SwiftLoans');
            $table->string('country', 3)->default('KE'); // ISO 3166-1 alpha-3
            $table->string('timezone')->default('Africa/Nairobi');
            $table->string('currency', 3)->default('KES');
            $table->string('currency_in_words')->nullable()->default('Kenya Shillings');
            $table->string('date_format')->default('dd/mm/yyyy');
            $table->enum('decimal_separator', ['dot', 'comma'])->default('dot');
            $table->enum('thousand_separator', ['comma', 'dot', 'space'])->default('comma');

            // Loan Settings
            $table->enum('monthly_repayment_cycle', [
                'Actual Days in a Month',
                'Same Day Every Month',
                '31',
                '30',
                '28'
            ])->default('Same Day Every Month');

            $table->enum('yearly_repayment_cycle', [
                'Actual Days in a Year',
                'Same Day Every Year',
                '365',
                '360'
            ])->default('Same Day Every Year');

            $table->enum('days_in_month_interest', ['31', '30', '28'])->default('30');
            $table->enum('days_in_year_interest', ['360', '365'])->default('360');

            // Invoice/Business Details
            $table->string('business_registration_number')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('zipcode')->nullable();

            // Logo
            $table->string('company_logo')->nullable();

            // Timestamps
            $table->timestamps();
        });

        // Insert default settings
        $this->insertDefaultSettings();
    }

    public function down()
    {
        Schema::dropIfExists('system_settings');
    }

    private function insertDefaultSettings()
    {
        DB::table('system_settings')->insert([
            'company_name' => 'SwiftLoans',
            'country' => 'KE',
            'timezone' => 'Africa/Nairobi',
            'currency' => 'KES',
            'currency_in_words' => 'Kenya Shillings',
            'date_format' => 'dd/mm/yyyy',
            'decimal_separator' => 'dot',
            'thousand_separator' => 'comma',
            'monthly_repayment_cycle' => 'Same Day Every Month',
            'yearly_repayment_cycle' => 'Same Day Every Year',
            'days_in_month_interest' => '30',
            'days_in_year_interest' => '360',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
};
