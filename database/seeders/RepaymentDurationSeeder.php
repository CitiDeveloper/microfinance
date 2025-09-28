<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RepaymentDuration;

class RepaymentDurationSeeder extends Seeder
{
    public function run(): void
    {
        // Insert 1–360 months
        for ($i = 1; $i <= 360; $i++) {
            RepaymentDuration::create(['months' => $i]);
        }
    }
}
