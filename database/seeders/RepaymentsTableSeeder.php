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
        $now = Carbon::now();

        // Get valid IDs
        $loanIds = DB::table('loans')->pluck('id')->toArray();
        $borrowerIds = DB::table('borrowers')->pluck('id')->toArray();
        $branchIds = DB::table('branches')->pluck('id')->toArray();
        $staffIds = DB::table('staff')->pluck('id')->toArray();
        $paymentMethodIds = DB::table('payment_methods')->pluck('id')->toArray();
        $bankAccountIds = DB::table('bank_accounts')->pluck('id')->toArray();

        if (
            empty($loanIds) ||
            empty($borrowerIds) ||
            empty($branchIds) ||
            empty($staffIds) ||
            empty($paymentMethodIds) ||
            empty($bankAccountIds)
        ) {
            $this->command->warn("⚠️ RepaymentsTableSeeder skipped because required data is missing.");
            return;
        }

        $repayments = [];

        for ($i = 1; $i <= 50; $i++) {
            $loanId = $loanIds[array_rand($loanIds)];
            $borrowerId = $borrowerIds[array_rand($borrowerIds)];
            $branchId = $branchIds[array_rand($branchIds)];
            $staffId = $staffIds[array_rand($staffIds)];
            $paymentMethodId = $paymentMethodIds[array_rand($paymentMethodIds)];
            $bankAccountId = $bankAccountIds[array_rand($bankAccountIds)];

            $amount = rand(1000, 5000);
            $principal = $amount * 0.9;
            $interest = $amount * 0.05;
            $fees = $amount * 0.03;
            $penalty = $amount * 0.02;

            $repayments[] = [
                'loan_id' => $loanId,
                'borrower_id' => $borrowerId,
                'branch_id' => $branchId,
                'collected_by' => $staffId,
                'repayment_number' => 1,
                'amount' => $amount,
                'principal_paid' => $principal,
                'interest_paid' => $interest,
                'fees_paid' => $fees,
                'penalty_paid' => $penalty,
                'waiver_amount' => 0,
                'payment_date' => $now->subDays(rand(1, 30)),
                'posted_at' => $now,
                'receipt_number' => strtoupper(Str::random(10)),
                'transaction_reference' => strtoupper(Str::random(12)),
                'payment_method_id' => $paymentMethodId,
                'dea_cash_bank_account' => $bankAccountId,
                'outstanding_balance' => 10000 - $amount,
                'exchange_rate' => 1,
                'status' => 'posted',
                'is_reconciled' => true,
                'reversed_by' => null,
                'reversed_at' => null,
                'reversal_reason' => null,
                'notes' => "Sample repayment {$i}",
                'metadata' => json_encode(['ip_address' => request()->ip() ?? '127.0.0.1']),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('repayments')->insert($repayments);

        $this->command->info("✅ RepaymentsTableSeeder: Inserted " . count($repayments) . " repayment records.");
    }
}
