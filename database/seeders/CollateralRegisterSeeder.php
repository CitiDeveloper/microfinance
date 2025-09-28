<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CollateralRegisterSeeder extends Seeder
{
    public function run(): void
    {
        $collateralTypes = ['Vehicle', 'Land', 'Building', 'Machinery', 'Equipment', 'Jewelry', 'Stock', 'Property'];
        $conditions = ['Excellent', 'Good', 'Fair', 'Poor'];
        $statuses = ['active', 'released', 'seized', 'sold'];

        $collaterals = [];

        for ($i = 1; $i <= 1000; $i++) { // Generate 1000 collateral items
            $loanId = rand(1, 500); // Random loan ID between 1-500
            $collateralCount = rand(1, 3); // Each loan can have 1-3 collateral items

            for ($j = 0; $j < $collateralCount; $j++) {
                $collaterals[] = [
                    'loan_id' => $loanId,
                    'collateral_type' => $collateralTypes[array_rand($collateralTypes)],
                    'description' => 'Collateral item ' . $i . '-' . ($j + 1),
                    'estimated_value' => rand(10000, 5000000),
                    'location' => 'Location ' . rand(1, 50),
                    'condition' => $conditions[array_rand($conditions)],
                    'serial_number' => 'SN' . rand(1000, 9999),
                    'registration_number' => 'REG' . rand(1000, 9999),
                    'acquisition_date' => Carbon::now()->subDays(rand(0, 1000))->format('Y-m-d'),
                    'last_valuation_date' => Carbon::now()->subDays(rand(0, 500))->format('Y-m-d'),
                    'notes' => 'Sample notes for collateral',
                    'status' => $statuses[array_rand($statuses)],
                    'document_path' => null,
                    'created_by' => rand(1, 20), // assuming staff IDs between 1-20
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert in chunks to avoid memory issues
        foreach (array_chunk($collaterals, 50) as $chunk) {
            DB::table('collateral_registers')->insert($chunk);
        }
    }
}
