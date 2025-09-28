<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RepaymentsTableSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        // Loop through some loan IDs (1-500)
        for ($loanId = 1; $loanId <= 500; $loanId++) {

            // Randomly skip some loans (so not all have repayments)
            if (rand(0, 1) === 0) {
                continue;
            }

            // Random number of repayments per loan: 3-8
            $numRepayments = rand(3, 8);

            $outstandingBalance = $faker->randomFloat(2, 1000, 50000);

            for ($i = 1; $i <= $numRepayments; $i++) {
                $principalPaid = $faker->randomFloat(2, 100, 5000);
                $interestPaid = $faker->randomFloat(2, 10, 500);
                $feesPaid = $faker->randomFloat(2, 0, 100);
                $penaltyPaid = $faker->randomFloat(2, 0, 50);
                $waiverAmount = $faker->randomFloat(2, 0, 50);
                $totalAmount = $principalPaid + $interestPaid + $feesPaid + $penaltyPaid - $waiverAmount;
                $outstandingBalance -= $principalPaid;

                DB::table('repayments')->insert([
                    'loan_id' => $loanId,
                    'borrower_id' => rand(1, 20),
                    'branch_id' => rand(1, 3),
                    'collected_by' => rand(1, 20),
                    'repayment_number' => $i,
                    'amount' => $totalAmount,
                    'principal_paid' => $principalPaid,
                    'interest_paid' => $interestPaid,
                    'fees_paid' => $feesPaid,
                    'penalty_paid' => $penaltyPaid,
                    'waiver_amount' => $waiverAmount,
                    'payment_date' => Carbon::now()->subDays(rand(1, 100)),
                    'posted_at' => Carbon::now()->subDays(rand(0, 99)),
                    'receipt_number' => strtoupper(Str::random(10)),
                    'transaction_reference' => strtoupper(Str::random(12)),
                    'payment_method_id' => rand(1, 5),
                    'dea_cash_bank_account' => rand(1, 3),
                    'outstanding_balance' => max($outstandingBalance, 0),
                    'exchange_rate' => 1.0,
                    'status' => $faker->randomElement(['pending', 'posted', 'failed', 'reversed']),
                    'is_reconciled' => $faker->boolean(),
                    'reversed_by' => rand(1, 20),
                    'reversed_at' => $faker->optional()->dateTimeBetween('-1 month', 'now'),
                    'reversal_reason' => $faker->optional()->sentence(),
                    'notes' => $faker->optional()->sentence(),
                    'metadata' => json_encode([
                        'ip_address' => $faker->ipv4,
                        'user_agent' => $faker->userAgent,
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
