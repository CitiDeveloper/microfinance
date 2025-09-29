<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LoanPaymentSchemeSeeder extends Seeder
{
    public function run(): void
    {
        // Get loan IDs saved by LoanSeeder
        $loanIds = DB::table('seeder_temp')->where('key', 'loan_ids')->value('value');
        $loanIds = $loanIds ? json_decode($loanIds, true) : [];

        if (empty($loanIds)) {
            $this->command->warn("⚠️ LoanPaymentSchemeSeeder skipped: No loans found.");
            return;
        }

        foreach ($loanIds as $loanId) {
            $loan = DB::table('loans')->where('id', $loanId)->first();

            if (!$loan) continue;

            $principal = $loan->loan_principal_amount;
            $numRepayments = $loan->loan_num_of_repayments ?? 12;
            $monthlyPrincipal = $principal / $numRepayments;
            $interestRate = ($loan->loan_interest ?? 12) / 100 / 12; // monthly rate
            $startDate = Carbon::parse($loan->loan_first_repayment_date);

            for ($i = 1; $i <= $numRepayments; $i++) {
                $dueDate = $startDate->copy()->addMonths($i - 1);
                $interestAmount = $principal * $interestRate;
                $totalAmount = $monthlyPrincipal + $interestAmount;

                DB::table('loan_payment_schemes')->insert([
                    'loan_id' => $loanId,
                    'installment_number' => $i,
                    'due_date' => $dueDate->toDateString(),
                    'principal_amount' => round($monthlyPrincipal, 2),
                    'interest_amount' => round($interestAmount, 2),
                    'total_amount' => round($totalAmount, 2),
                    'is_paid' => false,
                    'paid_date' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        $this->command->info("✅ LoanPaymentSchemeSeeder: Created repayment schedules for " . count($loanIds) . " loans.");
    }
}
