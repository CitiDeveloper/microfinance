<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanProduct;
use App\Models\Borrower;
use App\Models\Branch;
use App\Models\Staff;
use App\Models\DisbursementMethod;
use App\Models\RepaymentCycle;
use App\Models\LoanStatus;
use App\Models\BankAccount;
use App\Models\Guarantor;
use App\Models\LoanPaymentScheme;
use App\Models\SystemSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['borrower', 'loanProduct', 'loanStatus'])
            ->latest()
            ->paginate(20);

        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $loanProducts = LoanProduct::all();
        $borrowers = Borrower::all();
        $branches = Branch::all();
        $staff = Staff::all();
        $disbursementMethods = DisbursementMethod::all();
        $repaymentCycles = RepaymentCycle::all();
        $loanStatuses = LoanStatus::all();
        $bankAccounts = BankAccount::all();
        $guarantors = Guarantor::all();

        return view('loans.create', compact(
            'loanProducts',
            'borrowers',
            'branches',
            'staff',
            'disbursementMethods',
            'repaymentCycles',
            'loanStatuses',
            'bankAccounts',
            'guarantors'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'loan_product_id' => 'required|exists:loan_products,id',
            'borrower_id' => 'required|exists:borrowers,id',
            'branch_id' => 'required|exists:branches,id',
            'staff_id' => 'required|exists:staff,id',
            'loan_application_id' => 'required|unique:loans,loan_application_id',
            'loan_principal_amount' => 'required|numeric|min:0',
            'loan_disbursed_by_id' => 'required|exists:disbursement_methods,id',
            'loan_released_date' => 'required|date',
            'loan_interest_method' => 'required|in:flat_rate,reducing_rate_equal_installments,reducing_rate_equal_principal,interest_only,compound_interest_new,compound_interest',
            'loan_interest_type' => 'required|in:percentage,fixed',
            'loan_interest' => 'required|numeric|min:0',
            'loan_interest_period' => 'required|in:Day,Week,Month,Year,Loan',
            'loan_duration' => 'required|integer|min:1',
            'loan_duration_period' => 'required|in:Days,Weeks,Months,Years',
            'loan_payment_scheme_id' => 'required|exists:repayment_cycles,id',
            'loan_num_of_repayments' => 'required|integer|min:1',
            'loan_status_id' => 'required|exists:loan_statuses,id',
            'grace_period_repayments' => 'required|integer|min:0',
            'dea_cash_bank_account' => 'required|exists:bank_accounts,id',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $settings = SystemSetting::getSettings();

            
            if (empty($validated['loan_application_id'])) {
                $validated['loan_application_id'] = $settings->generateLoanId();
            }
            $loan = Loan::create($validated);

            // Sync guarantors if provided
            if ($request->has('guarantors')) {
                $loan->guarantors()->sync($request->guarantors);
            }

            // Create initial loan schedule
            $this->createLoanSchedule($loan);
        });

        return redirect()->route('loans.index')
            ->with('success', 'Loan created successfully.');
    }

    public function show(Loan $loan)
    {
        $loan->load([
            'borrower',
            'loanProduct',
            'branch',
            'staff',
            'disbursedBy',
            'paymentScheme',
            'loanStatus',
            'cashBankAccount',
            'guarantors',
            'repayments',
            'collaterals',
            'paymentSchedules', // Add this line
            'afterMaturityPaymentScheme' // Add this line
        ]);

        return view('loans.show', compact('loan'));
    }

    public function edit(Loan $loan)
    {
        $loanProducts = LoanProduct::all();
        $borrowers = Borrower::all();
        $branches = Branch::all();
        $staff = Staff::all();
        $disbursementMethods = DisbursementMethod::all();
        $repaymentCycles = RepaymentCycle::all();
        $loanStatuses = LoanStatus::all();
        $bankAccounts = BankAccount::all();
        $guarantors = Guarantor::all();

        return view('loans.edit', compact(
            'loan',
            'loanProducts',
            'borrowers',
            'branches',
            'staff',
            'disbursementMethods',
            'repaymentCycles',
            'loanStatuses',
            'bankAccounts',
            'guarantors'
        ));
    }

    public function update(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'loan_product_id' => 'required|exists:loan_products,id',
            'borrower_id' => 'required|exists:borrowers,id',
            'branch_id' => 'required|exists:branches,id',
            'staff_id' => 'required|exists:staff,id',
            'loan_application_id' => 'required|unique:loans,loan_application_id,' . $loan->id,
            'loan_principal_amount' => 'required|numeric|min:0',
            'loan_disbursed_by_id' => 'required|exists:disbursement_methods,id',
            'loan_released_date' => 'required|date',
            'loan_interest_method' => 'required|in:flat_rate,reducing_rate_equal_installments,reducing_rate_equal_principal,interest_only,compound_interest_new,compound_interest',
            'loan_interest_type' => 'required|in:percentage,fixed',
            'loan_interest' => 'required|numeric|min:0',
            'loan_interest_period' => 'required|in:Day,Week,Month,Year,Loan',
            'loan_duration' => 'required|integer|min:1',
            'loan_duration_period' => 'required|in:Days,Weeks,Months,Years',
            'loan_payment_scheme_id' => 'required|exists:repayment_cycles,id',
            'loan_num_of_repayments' => 'required|integer|min:1',
            'grace_period_repayments' => 'required|integer|min:0',
            'loan_status_id' => 'required|exists:loan_statuses,id',
            'dea_cash_bank_account' => 'required|exists:bank_accounts,id',
        ]);

        DB::transaction(function () use ($loan, $validated, $request) {
            $loan->update($validated);

            // Sync guarantors if provided
            if ($request->has('guarantors')) {
                $loan->guarantors()->sync($request->guarantors);
            }
        });

        return redirect()->route('loans.index')
            ->with('success', 'Loan updated successfully.');
    }

    public function destroy(Loan $loan)
    {
        DB::transaction(function () use ($loan) {
            $loan->guarantors()->detach();
            $loan->delete();
        });

        return redirect()->route('loans.index')
            ->with('success', 'Loan deleted successfully.');
    }

    public function pending()
    {
        $loans = Loan::pendingApproval()
            ->with(['borrower', 'loanProduct'])
            ->latest()
            ->paginate(20);

        return view('loans.pending', compact('loans'));
    }

    public function active()
    {
        $loans = Loan::active()
            ->with(['borrower', 'loanProduct'])
            ->latest()
            ->paginate(20);

        return view('loans.active', compact('loans'));
    }

    public function overdue()
    {
        $loans = Loan::overdue()
            ->with(['borrower', 'loanProduct'])
            ->latest()
            ->paginate(20);

        return view('loans.overdue', compact('loans'));
    }

    public function approve(Loan $loan)
    {
        if (!$loan->canBeApproved()) {
            return redirect()->back()->with('error', 'Loan cannot be approved in its current status.');
        }

        $loan->update(['loan_status_id' => 1]); // Open status

        return redirect()->route('loans.pending')
            ->with('success', 'Loan approved successfully.');
    }

    public function reject(Loan $loan)
    {
        if (!$loan->canBeApproved()) {
            return redirect()->back()->with('error', 'Loan cannot be rejected in its current status.');
        }

        $loan->update(['loan_status_id' => 9]); // Denied status

        return redirect()->route('loans.pending')
            ->with('success', 'Loan rejected successfully.');
    }

    public function disburse(Loan $loan)
    {
        if (!$loan->canBeDisbursed()) {
            return redirect()->back()->with('error', 'Loan cannot be disbursed in its current status.');
        }

        // Here you would typically create accounting entries
        // and update loan status to disbursed

        return redirect()->route('loans.show', $loan)
            ->with('success', 'Loan disbursed successfully.');
    }

    private function createLoanSchedule(Loan $loan)
    {
        $loanProduct   = $loan->loanProduct; // relation Loan -> LoanProduct
        $principal     = $loan->loan_principal_amount;
        $numRepayments = $loan->loan_num_of_repayments;
        $releasedDate  = Carbon::parse($loan->loan_released_date);

        $interestRate   = $loan->loan_interest ?? $loanProduct->default_loan_interest;
        $interestType   = strtolower($loanProduct->loan_interest_type);   // percentage | fixed
        $interestMethod = strtolower($loanProduct->loan_interest_method); // flat | reducing | interest-only
        $interestPeriod = strtolower($loanProduct->loan_interest_period); // per month | per year
        $durationPeriod = strtolower($loan->loan_duration_period);

        // --- Adjust first repayment date ---
        $firstRepaymentDate = $releasedDate->copy();
        if (!empty($loanProduct->loan_move_first_repayment_date_days)) {
            $firstRepaymentDate->addDays($loanProduct->loan_move_first_repayment_date_days);
        }

        // --- Normalize interest ---
        if ($interestType === 'percentage') {
            $ratePerPeriod = match ($interestPeriod) {
                'year', 'annually', 'per year' => $interestRate / 12,  // monthly rate
                'month', 'monthly', 'per month' => $interestRate,      // already monthly
                default => $interestRate,
            };
        } else {
            $ratePerPeriod = 0; // handled separately for fixed
        }

        // --- Grace Period (optional) ---
        $graceRepayments = $loan->grace_period_repayments ?? 0;
        // You may want this as a column in `loans` table or default from LoanProduct

        for ($i = 1; $i <= $numRepayments; $i++) {
            // due date calculation
            $dueDate = match ($durationPeriod) {
                'days'   => $firstRepaymentDate->copy()->addDays($i * $loan->loan_duration),
                'weeks'  => $firstRepaymentDate->copy()->addWeeks($i * $loan->loan_duration),
                'months' => $firstRepaymentDate->copy()->addMonths($i * $loan->loan_duration),
                'years'  => $firstRepaymentDate->copy()->addYears($i * $loan->loan_duration),
                default  => $firstRepaymentDate->copy()->addMonths($i),
            };

            $principalDue = 0;
            $interestDue  = 0;

            // --- Grace Period Handling ---
            if ($i <= $graceRepayments) {
                // Grace = only interest during this period
                if ($interestType === 'percentage') {
                    $interestDue = ($principal * $ratePerPeriod) / 100;
                } else {
                    $interestDue = $interestRate / $numRepayments;
                }
            } else {
                // --- Regular repayment rules ---
                switch ($interestMethod) {
                    case 'flat':
                        $principalDue = $principal / $numRepayments;
                        $interestDue  = ($interestType === 'percentage')
                            ? ($principal * $ratePerPeriod) / 100
                            : $interestRate / $numRepayments;
                        break;

                    case 'reducing':
                        $principalDue = $principal / $numRepayments;
                        $outstanding  = $principal - ($principalDue * ($i - 1));
                        $interestDue  = ($interestType === 'percentage')
                            ? ($outstanding * $ratePerPeriod) / 100
                            : $interestRate / $numRepayments;
                        break;

                    case 'interest-only':
                        $principalDue = ($i === $numRepayments) ? $principal : 0;
                        $interestDue  = ($interestType === 'percentage')
                            ? ($principal * $ratePerPeriod) / 100
                            : $interestRate / $numRepayments;
                        break;

                    default:
                        $principalDue = $principal / $numRepayments;
                        $interestDue  = ($principal * $ratePerPeriod) / 100;
                }
            }

            LoanPaymentScheme::create([
                'loan_id'            => $loan->id,
                'installment_number' => $i,
                'due_date'           => $dueDate,
                'principal_amount'   => round($principalDue, 2),
                'interest_amount'    => round($interestDue, 2),
                'total_amount'       => round($principalDue + $interestDue, 2),
            ]);
        }
    }
}
