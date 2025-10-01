<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Repayment;
use App\Models\Borrower;
use App\Models\Saving;
use App\Models\SavingsTransaction;
use App\Models\CollectionSheet;
use App\Models\Branch;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // Loan Portfolio Report
    public function loanPortfolio(Request $request)
    {
        $query = Loan::with(['borrower', 'branch', 'loanProduct', 'loanStatus']);

        // Filters
        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->filled('loan_status_id')) {
            $query->where('loan_status_id', $request->loan_status_id);
        }

        if ($request->filled('date_from')) {
            $query->where('loan_released_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('loan_released_date', '<=', $request->date_to);
        }

        $loans = $query->get();
        $branches = Branch::all();
        $loanStatuses = \App\Models\LoanStatus::all();

        return view('reports.loan-portfolio', compact('loans', 'branches', 'loanStatuses'));
    }

    // Financial Report
    public function financial(Request $request)
    {
        $query = Repayment::with(['loan', 'borrower', 'branch'])->posted();

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->filled('date_from')) {
            $query->where('payment_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('payment_date', '<=', $request->date_to);
        }

        $repayments = $query->get();

        // Summary statistics
        $summary = [
            'total_principal' => $repayments->sum('principal_paid'),
            'total_interest' => $repayments->sum('interest_paid'),
            'total_fees' => $repayments->sum('fees_paid'),
            'total_penalty' => $repayments->sum('penalty_paid'),
            'total_collected' => $repayments->sum('amount')
        ];

        $branches = Branch::all();

        return view('reports.financial', compact('repayments', 'summary', 'branches'));
    }

    // Savings Report
    public function savings(Request $request)
    {
        $query = Saving::with(['borrower', 'branch', 'savingsProduct']);

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $savings = $query->get();

        // Transactions for period
        $transactionsQuery = SavingsTransaction::with(['account', 'branch']);

        if ($request->filled('date_from')) {
            $transactionsQuery->where('transaction_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $transactionsQuery->where('transaction_date', '<=', $request->date_to);
        }

        $transactions = $transactionsQuery->get();

        $summary = [
            'total_balance' => $savings->sum('balance'),
            'total_deposits' => $transactions->where('type', 'deposit')->sum('amount'),
            'total_withdrawals' => $transactions->where('type', 'withdrawal')->sum('amount'),
            'active_accounts' => $savings->where('status', 'active')->count()
        ];

        $branches = Branch::all();

        return view('reports.savings', compact('savings', 'transactions', 'summary', 'branches'));
    }

    // Collection Report
    public function collection(Request $request)
    {
        $query = CollectionSheet::with(['branch', 'staff', 'items.loan', 'items.borrower']);

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->filled('date_from')) {
            $query->where('collection_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('collection_date', '<=', $request->date_to);
        }

        $collectionSheets = $query->get();

        // Collection performance by staff
        $staffPerformance = DB::table('repayments')
            ->join('staff', 'repayments.collected_by', '=', 'staff.id')
            ->select(
                'staff.id',
                'staff.staff_firstname',
                'staff.staff_lastname',
                DB::raw('SUM(repayments.amount) as total_collected'),
                DB::raw('COUNT(repayments.id) as total_transactions')
            )
            ->where('repayments.status', 'posted')
            ->when($request->filled('date_from'), function ($q) use ($request) {
                return $q->where('repayments.payment_date', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function ($q) use ($request) {
                return $q->where('repayments.payment_date', '<=', $request->date_to);
            })
            ->groupBy('staff.id', 'staff.staff_firstname', 'staff.staff_lastname')
            ->get();

        $branches = Branch::all();

        return view('reports.collection', compact('collectionSheets', 'staffPerformance', 'branches'));
    }

    // Performance Report
    public function performance(Request $request)
    {
        // Loan performance metrics
        $loanPerformance = DB::table('loans')
            ->join('branches', 'loans.branch_id', '=', 'branches.id')
            ->join('loan_statuses', 'loans.loan_status_id', '=', 'loan_statuses.id')
            ->select(
                'branches.branch_name',
                'loan_statuses.name',
                DB::raw('COUNT(loans.id) as loan_count'),
                DB::raw('SUM(loans.loan_principal_amount) as total_principal'),
                DB::raw('AVG(loans.loan_principal_amount) as avg_loan_size')
            )
            ->when($request->filled('branch_id'), function ($q) use ($request) {
                return $q->where('loans.branch_id', $request->branch_id);
            })
            ->when($request->filled('date_from'), function ($q) use ($request) {
                return $q->where('loans.loan_released_date', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function ($q) use ($request) {
                return $q->where('loans.loan_released_date', '<=', $request->date_to);
            })
            ->groupBy('branches.branch_name', 'loan_statuses.name')
            ->get();

        // Portfolio at risk
        $portfolioAtRisk = DB::table('loans')
            ->join('branches', 'loans.branch_id', '=', 'branches.id')
            ->whereIn('loans.loan_status_id', [3, 4, 5]) // Defaulted, Written Off, etc.
            ->select(
                'branches.branch_name',
                DB::raw('COUNT(loans.id) as risky_loans'),
                DB::raw('SUM(loans.loan_principal_amount) as risky_amount')
            )
            ->when($request->filled('branch_id'), function ($q) use ($request) {
                return $q->where('loans.branch_id', $request->branch_id);
            })
            ->groupBy('branches.branch_name')
            ->get();

        // Collection efficiency
        $collectionEfficiency = DB::table('repayments')
            ->join('loans', 'repayments.loan_id', '=', 'loans.id')
            ->join('branches', 'loans.branch_id', '=', 'branches.id')
            ->select(
                'branches.branch_name',
                DB::raw('SUM(repayments.amount) as actual_collection'),
                DB::raw('COUNT(repayments.id) as transactions_count')
            )
            ->where('repayments.status', 'posted')
            ->when($request->filled('branch_id'), function ($q) use ($request) {
                return $q->where('loans.branch_id', $request->branch_id);
            })
            ->when($request->filled('date_from'), function ($q) use ($request) {
                return $q->where('repayments.payment_date', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function ($q) use ($request) {
                return $q->where('repayments.payment_date', '<=', $request->date_to);
            })
            ->groupBy('branches.branch_name')
            ->get();

        $branches = Branch::all();

        return view('reports.performance', compact('loanPerformance', 'portfolioAtRisk', 'collectionEfficiency', 'branches'));
    }

    // Export Report
    public function export($type, Request $request)
    {
        $data = [];

        switch ($type) {
            case 'loan-portfolio':
                $data = $this->getLoanPortfolioData($request);
                $filename = 'loan_portfolio_' . date('Y-m-d') . '.csv';
                break;
            case 'financial':
                $data = $this->getFinancialData($request);
                $filename = 'financial_report_' . date('Y-m-d') . '.csv';
                break;
            case 'savings':
                $data = $this->getSavingsData($request);
                $filename = 'savings_report_' . date('Y-m-d') . '.csv';
                break;
            case 'collection':
                $data = $this->getCollectionData($request);
                $filename = 'collection_report_' . date('Y-m-d') . '.csv';
                break;
            case 'performance':
                $data = $this->getPerformanceData($request);
                $filename = 'performance_report_' . date('Y-m-d') . '.csv';
                break;
            default:
                return redirect()->back()->with('error', 'Invalid report type');
        }

        return $this->exportToCsv($data, $filename);
    }

    private function getLoanPortfolioData($request)
    {
        $query = Loan::with(['borrower', 'branch', 'loanProduct', 'loanStatus']);

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->filled('loan_status_id')) {
            $query->where('loan_status_id', $request->loan_status_id);
        }

        $loans = $query->get();

        $data[] = ['Loan ID', 'Borrower', 'Branch', 'Product', 'Principal', 'Interest Rate', 'Status', 'Release Date'];

        foreach ($loans as $loan) {
            $data[] = [
                $loan->id,
                $loan->borrower->full_name ?? 'N/A',
                $loan->branch->branch_name ?? 'N/A',
                $loan->loanProduct->loan_product_name ?? 'N/A',
                number_format($loan->loan_principal_amount, 2),
                number_format($loan->loan_interest, 2) . '%',
                $loan->loanStatus->name ?? 'N/A',
                $loan->loan_released_date
            ];
        }

        return $data;
    }

    private function exportToCsv($data, $filename)
    {
        $handle = fopen('php://output', 'w');

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        foreach ($data as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);
        exit;
    }

    // Add other data methods similarly...
}
