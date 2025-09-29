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
        
        $this->call([
            UserSeeder::class,
            LoanProductSeeder::class,
            AfterMaturityInterestOptionSeeder::class,
            BorrowerSeeder::class,
            BranchSeeder::class,
            DisbursementMethodSeeder::class,
            LoanStatusSeeder::class,
            RepaymentCycleSeeder::class,
            RoleSeeder::class,
            StaffSeeder::class,
            BankAccountSeeder::class,
            LoanSeeder::class,
            LoanPaymentSchemeSeeder::class,
            PaymentMethodSeeder::class,
            CollateralRegisterSeeder::class,
            RepaymentsTableSeeder::class,
            SystemSettingsSeeder::class,
        ]);
    }
}
