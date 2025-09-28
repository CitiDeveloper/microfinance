<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Example User factory
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Call your custom seeders
        $this->call([
            // LoanProductSeeder::class,  
            // AfterMaturityInterestOptionSeeder::class,
            // BorrowerSeeder::class,
            // BranchSeeder::class,
            // DisbursementMethodSeeder::class,
            // LoanPaymentSchemeSeeder::class,
            // LoanStatusSeeder::class,
            // RepaymentCycleSeeder::class,
            // RoleSeeder::class,
            // StaffSeeder::class,
            // BankAccountSeeder::class,
            // LoanSeeder::class,
            // PaymentMethodSeeder::class,
            // CollateralRegisterSeeder::class,
        ]);
    }
}
