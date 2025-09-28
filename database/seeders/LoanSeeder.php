<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing IDs for relationships
        $loanProductIds = DB::table('loan_products')->pluck('id')->toArray();
        $borrowerIds = DB::table('borrowers')->pluck('id')->toArray();
        $branchIds = DB::table('branches')->pluck('id')->toArray();
        $staffIds = DB::table('staff')->pluck('id')->toArray();
        $disbursementMethodIds = DB::table('disbursement_methods')->pluck('id')->toArray();
        $paymentSchemeIds = DB::table('loan_payment_schemes')->pluck('id')->toArray();
        $loanStatusIds = DB::table('loan_statuses')->pluck('id')->toArray();

        // Get bank account IDs if they exist
        $bankAccountIds = DB::table('bank_accounts')->pluck('id')->toArray();
        $defaultBankAccountId = !empty($bankAccountIds) ? $bankAccountIds[0] : null;

        $loans = [];
        $interestMethods = ['flat_rate', 'reducing_rate_equal_installments', 'reducing_rate_equal_principal', 'interest_only'];
        $interestTypes = ['percentage', 'fixed'];
        $interestPeriods = ['Day', 'Week', 'Month', 'Year', 'Loan'];
        $durationPeriods = ['Days', 'Weeks', 'Months', 'Years'];
        $decimalPlaces = [
            'round_off_to_two_decimal',
            'round_off_to_integer',
            'round_down_to_integer',
            'round_up_to_integer',
            'round_off_to_one_decimal'
        ];
        $afterMaturityTypes = ['percentage', 'fixed'];

        for ($i = 1; $i <= 500; $i++) {
            $principalAmount = mt_rand(10000, 1000000) + (mt_rand(0, 99) / 100);
            $interestRate = mt_rand(5, 250) / 10; // 0.5% to 25%
            $duration = mt_rand(1, 60); // 1 to 60 periods
            $numRepayments = mt_rand(1, 36); // 1 to 36 repayments

            $releasedDate = Carbon::now()->subDays(mt_rand(0, 365));
            $firstRepaymentDate = $releasedDate->copy()->addDays(mt_rand(7, 30));
            $interestStartDate = $releasedDate->copy()->addDays(mt_rand(0, 7));

            // Randomly decide if loan has after maturity settings (about 20% of loans)
            $hasAfterMaturity = mt_rand(1, 5) === 1;

            $loan = [
                'loan_product_id' => $loanProductIds[array_rand($loanProductIds)],
                'borrower_id' => $borrowerIds[array_rand($borrowerIds)],
                'branch_id' => $branchIds[array_rand($branchIds)],
                'staff_id' => $staffIds[array_rand($staffIds)],
                'loan_application_id' => 'LN' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'loan_title' => 'Loan ' . $i . ' - ' . fake()->words(2, true),
                'loan_description' => mt_rand(1, 3) === 1 ? fake()->sentence() : null,
                'loan_principal_amount' => $principalAmount,
                'loan_disbursed_by_id' => $disbursementMethodIds[array_rand($disbursementMethodIds)],
                'loan_released_date' => $releasedDate->format('Y-m-d'),
                'loan_interest_method' => $interestMethods[array_rand($interestMethods)],
                'loan_interest_type' => $interestTypes[array_rand($interestTypes)],
                'loan_interest' => $interestRate,
                'loan_interest_period' => $interestPeriods[array_rand($interestPeriods)],
                'loan_duration' => $duration,
                'loan_duration_period' => $durationPeriods[array_rand($durationPeriods)],
                'loan_payment_scheme_id' => $paymentSchemeIds[array_rand($paymentSchemeIds)],
                'loan_num_of_repayments' => $numRepayments,
                'loan_decimal_places' => $decimalPlaces[array_rand($decimalPlaces)],
                'loan_decimal_places_adjust_each_interest' => mt_rand(0, 1),
                'loan_interest_start_date' => $interestStartDate->format('Y-m-d'),
                'loan_first_repayment_date' => $firstRepaymentDate->format('Y-m-d'),
                'loan_first_repayment_pro_rata' => mt_rand(0, 1),
                'loan_fees_pro_rata' => mt_rand(0, 1),
                'loan_do_not_adjust_remaining_pro_rata' => mt_rand(0, 1),
                'first_repayment_amount' => mt_rand(1, 3) === 1 ? mt_rand(100, 5000) + (mt_rand(0, 99) / 100) : null,
                'last_repayment_amount' => mt_rand(1, 4) === 1 ? mt_rand(100, 5000) + (mt_rand(0, 99) / 100) : null,
                'loan_override_maturity_date' => mt_rand(1, 5) === 1 ? $firstRepaymentDate->copy()->addDays(mt_rand(30, 180))->format('Y-m-d') : null,
                'override_each_repayment_amount' => mt_rand(1, 10) === 1 ? mt_rand(500, 10000) + (mt_rand(0, 99) / 100) : null,
                'loan_interest_each_repayment_pro_rata' => mt_rand(0, 1),
                'loan_interest_schedule' => 'charge_interest_normally',
                'loan_principal_schedule' => 'charge_principal_normally',
                'loan_balloon_repayment_amount' => mt_rand(1, 8) === 1 ? mt_rand(1000, 20000) + (mt_rand(0, 99) / 100) : null,
                'loan_move_first_repayment_date_days' => mt_rand(1, 10) === 1 ? mt_rand(1, 14) : null,
                'automatic_payments' => mt_rand(0, 1),
                'payment_posting_period' => mt_rand(1, 5) === 1 ? mt_rand(1, 30) : null,
                'automated_payments_dea_cash_bank_account' => $defaultBankAccountId,
                'after_maturity_extend_loan' => $hasAfterMaturity ? mt_rand(0, 1) : 0,
                'after_maturity_percentage_or_fixed' => $hasAfterMaturity ? $afterMaturityTypes[array_rand($afterMaturityTypes)] : 'percentage',
                'after_maturity_calculate_interest_on' => $hasAfterMaturity ? mt_rand(1, 15) : null,
                'after_maturity_loan_interest' => $hasAfterMaturity ? mt_rand(10, 500) / 10 : null,
                'after_maturity_recurring_period_num' => $hasAfterMaturity ? mt_rand(1, 12) : null,
                'after_maturity_recurring_period_payment_scheme_id' => $hasAfterMaturity ? $paymentSchemeIds[array_rand($paymentSchemeIds)] : null,
                'after_maturity_num_of_repayments' => $hasAfterMaturity ? mt_rand(1, 12) : null,
                'after_maturity_include_fees' => $hasAfterMaturity ? mt_rand(0, 1) : 0,
                'after_maturity_past_maturity_status' => $hasAfterMaturity ? mt_rand(0, 1) : 0,
                'after_maturity_apply_to_date' => $hasAfterMaturity ? $firstRepaymentDate->copy()->addDays(mt_rand(30, 365))->format('Y-m-d') : null,
                'loan_status_id' => $loanStatusIds[array_rand($loanStatusIds)],
                'dea_cash_bank_account' => $defaultBankAccountId ?? 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $loans[] = $loan;

            // Insert in batches of 50 to avoid memory issues
            if ($i % 50 === 0) {
                DB::table('loans')->insert($loans);
                $loans = [];
            }
        }

        // Insert any remaining loans
        if (!empty($loans)) {
            DB::table('loans')->insert($loans);
        }
    }
}
