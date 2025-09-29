<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LoanSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Fetch IDs from related tables
        $loanProductIds = DB::table('loan_products')->pluck('id')->toArray();
        $borrowerIds = DB::table('borrowers')->pluck('id')->toArray();
        $branchIds = DB::table('branches')->pluck('id')->toArray();
        $staffIds = DB::table('staff')->pluck('id')->toArray();
        $disbursementMethodIds = DB::table('disbursement_methods')->pluck('id')->toArray();
        $repaymentCycleIds = DB::table('repayment_cycles')->pluck('id')->toArray();
        $loanStatusIds = DB::table('loan_statuses')->pluck('id')->toArray();
        $bankAccountIds = DB::table('bank_accounts')->pluck('id')->toArray();

        if (
            empty($loanProductIds) ||
            empty($borrowerIds) ||
            empty($branchIds) ||
            empty($staffIds) ||
            empty($disbursementMethodIds) ||
            empty($repaymentCycleIds) ||
            empty($loanStatusIds) ||
            empty($bankAccountIds)
        ) {
            $this->command->warn("⚠️ LoanSeeder skipped because some required tables are empty.");
            return;
        }

        $loanIds = [];

        for ($i = 1; $i <= 500; $i++) {
            $loanProductId = $loanProductIds[array_rand($loanProductIds)];
            $borrowerId = $borrowerIds[array_rand($borrowerIds)];
            $branchId = $branchIds[array_rand($branchIds)];
            $staffId = $staffIds[array_rand($staffIds)];
            $disbursementMethodId = $disbursementMethodIds[array_rand($disbursementMethodIds)];
            $repaymentCycleId = $repaymentCycleIds[array_rand($repaymentCycleIds)];
            $loanStatusId = $loanStatusIds[array_rand($loanStatusIds)];
            $bankAccountId = $bankAccountIds[array_rand($bankAccountIds)];

            $principal = rand(50_000, 500_000); // random loan principal
            $duration = rand(6, 24);            // loan duration in months
            $interestRate = 12;                 // annual percentage
            $loanReleasedDate = $now->copy()->subDays(rand(0, 120))->toDateString();
            $loanId = DB::table('loans')->insertGetId([
                'loan_product_id' => $loanProductId,
                'borrower_id' => $borrowerId,
                'branch_id' => $branchId,
                'staff_id' => $staffId,

                'loan_application_id' => 'APP-' . strtoupper(uniqid()),
                'loan_title' => "Loan #{$i}",
                'loan_description' => "Auto-generated loan record #{$i}",

                'loan_principal_amount' => $principal,
                'loan_disbursed_by_id' => $disbursementMethodId,
                'loan_released_date' => $loanReleasedDate,

                'loan_interest_method' => 'reducing_rate_equal_installments',
                'loan_interest_type' => 'percentage',
                'loan_interest' => $interestRate,
                'loan_interest_period' => 'Month',

                'loan_duration' => $duration,
                'loan_duration_period' => 'Months',

                'loan_payment_scheme_id' => null,
                'repayment_cycle_id' => $repaymentCycleId,
                'loan_num_of_repayments' => $duration,

                'loan_decimal_places' => 'round_off_to_two_decimal',
                'loan_decimal_places_adjust_each_interest' => false,
                'loan_interest_start_date' => $now->toDateString(),
                'loan_due_date' => $now->copy()->addMonths($duration)->toDateString(),
                'grace_period_repayments' => 0,
                'loan_first_repayment_date' => $now->copy()->addMonth()->toDateString(),
                'loan_first_repayment_pro_rata' => false,
                'loan_fees_pro_rata' => false,
                'loan_do_not_adjust_remaining_pro_rata' => false,

                'loan_status_id' => $loanStatusId,
                'dea_cash_bank_account' => $bankAccountId,

                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $loanIds[] = $loanId;
        }

        // Store loan IDs in DB so LoanPaymentSchemeSeeder can access them
        DB::table('seeder_temp')->updateOrInsert(
            ['key' => 'loan_ids'],
            ['value' => json_encode($loanIds)]
        );

        $this->command->info("✅ LoanSeeder: Created 500 loans.");
    }
}
