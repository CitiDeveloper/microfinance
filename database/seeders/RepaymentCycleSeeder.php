<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RepaymentCycle;

class RepaymentCycleSeeder extends Seeder
{
    public function run(): void
    {
        $schemes = [
            ['code' => 1,  'name' => 'Daily'],
            ['code' => 2,  'name' => 'Weekly'],
            ['code' => 3,  'name' => 'Biweekly'],
            ['code' => 4,  'name' => 'Monthly'],
            ['code' => 5,  'name' => 'Bimonthly'],
            ['code' => 6,  'name' => 'Quarterly'],
            ['code' => 7,  'name' => 'Every 4 Months'],
            ['code' => 8,  'name' => 'Semi-Annual'],
            ['code' => 9,  'name' => 'Every 9 Months'],
            ['code' => 10, 'name' => 'Yearly'],
            ['code' => 11, 'name' => 'Lump-Sum'],
        ];

        foreach ($schemes as $scheme) {
            RepaymentCycle::firstOrCreate(
                ['code' => $scheme['code']],
                ['name' => $scheme['name']]
            );
        }
    }
}
