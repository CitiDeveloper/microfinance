<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CollateralRegisterSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Get available loan IDs
        $loanIds = DB::table('loans')->pluck('id')->toArray();

        if (empty($loanIds)) {
            $this->command->warn("⚠️ CollateralRegisterSeeder skipped because no loans exist.");
            return;
        }

        $collateralTypes = ['Property', 'Vehicle', 'Stock', 'Jewelry', 'Building', 'Land', 'Equipment', 'Machinery'];
        $conditions = ['Excellent', 'Good', 'Fair', 'Poor'];
        $statuses = ['active', 'seized', 'released', 'sold'];

        $collaterals = [];

        for ($i = 1; $i <= 50; $i++) {
            $collaterals[] = [
                'loan_id' => $loanIds[array_rand($loanIds)], // ✅ Always valid loan ID
                'collateral_type' => $collateralTypes[array_rand($collateralTypes)],
                'description' => "Collateral item {$i}",
                'estimated_value' => rand(100000, 5000000),
                'acquisition_date' => Carbon::now()->subYears(rand(0, 5))->subMonths(rand(0, 12))->toDateString(),
                'last_valuation_date' => Carbon::now()->subMonths(rand(0, 12))->toDateString(),
                'condition' => $conditions[array_rand($conditions)],
                'registration_number' => 'REG' . rand(1000, 9999),
                'serial_number' => 'SN' . rand(1000, 9999),
                'location' => 'Location ' . rand(1, 50),
                'status' => $statuses[array_rand($statuses)],
                'notes' => 'Sample notes for collateral',
                'document_path' => null,
                'created_by' => rand(1, 20),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('collateral_registers')->insert($collaterals);

        $this->command->info("✅ CollateralRegisterSeeder: Inserted " . count($collaterals) . " collateral records.");
    }
}
