<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemSettingsSeeder extends Seeder
{
    public function run()
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
}
