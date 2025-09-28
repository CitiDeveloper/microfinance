<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LoanPaymentScheme;

class LoanPaymentSchemeSeeder extends Seeder
{
    public function run(): void
    {
        $schemes = [
            ['code' => 6,    'name' => 'Daily'],
            ['code' => 4,    'name' => 'Weekly'],
            ['code' => 9,    'name' => 'Biweekly'],
            ['code' => 3,    'name' => 'Monthly'],
            ['code' => 12,   'name' => 'Bimonthly'],
            ['code' => 13,   'name' => 'Quarterly'],
            ['code' => 781,  'name' => 'Every 4 Months'],
            ['code' => 14,   'name' => 'Semi-Annual'],
            ['code' => 1943, 'name' => 'Every 9 Months'],
            ['code' => 11,   'name' => 'Yearly'],
            ['code' => 10,   'name' => 'Lump-Sum'],
        ];

        foreach ($schemes as $scheme) {
            LoanPaymentScheme::updateOrCreate(['code' => $scheme['code']], $scheme);
        }
    }
}
