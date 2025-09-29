<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Borrower;
use App\Models\Loan;
use App\Models\LoanProduct;
use App\Models\Repayment;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get dashboard statistics
        $stats = $this->getDashboardStats();

        return view('home', $stats);
    }

    /**
     * Get all dashboard statistics
     */
    private function getDashboardStats()
    {
        // Basic counts
        $activeBranchesCount = Branch::active()->count();
        $totalBorrowersCount = Borrower::count();
        $activeBorrowersCount = Borrower::has('loans')->count();

        // Loan statistics
        $totalLoansCount = Loan::count();
        $activeLoansCount = Loan::active()->count();
        $pendingLoansCount = Loan::pendingApproval()->count();
        $overdueLoansCount = Loan::overdue()->count();

        // Financial statistics
        $weeklyDisbursements = Loan::whereBetween(
            'loan_released_date',
            [Carbon::now()->subWeek(), Carbon::now()]
        )
            ->sum('loan_principal_amount');

        $weeklyRepayments = Repayment::whereBetween(
            'payment_date',
            [Carbon::now()->subWeek(), Carbon::now()]
        )
            ->sum('amount');

        $totalPortfolioValue = Loan::active()->sum('loan_principal_amount');
        $overdueAmount = Loan::overdue()->sum('loan_principal_amount');

        // Growth calculations (simplified - in real app, compare with previous period)
        $disbursementGrowth = 12; // Example growth percentage
        $repaymentGrowth = 8; // Example growth percentage
        $portfolioGrowth = 5; // Example growth percentage
        $borrowerGrowth = 3; // Example growth percentage

        // Loan status distribution
        $totalLoans = $totalLoansCount ?: 1; // Avoid division by zero
        $loanStatusDistribution = [
            'active' => ($activeLoansCount / $totalLoans) * 100,
            'pending' => ($pendingLoansCount / $totalLoans) * 100,
            'overdue' => ($overdueLoansCount / $totalLoans) * 100,
            'closed' => (($totalLoansCount - $activeLoansCount - $pendingLoansCount - $overdueLoansCount) / $totalLoans) * 100,
            'other' => 0
        ];

        // Loan products
        $activeLoanProductsCount = LoanProduct::active()->count();
        $mostPopularProduct = LoanProduct::withCount('loans')
            ->active()
            ->orderBy('loans_count', 'desc')
            ->first();

        // Top branches
        $topBranches = Branch::withCount(['loans as total_portfolio' => function ($query) {
            $query->select(DB::raw('COALESCE(SUM(loan_principal_amount), 0)'));
        }])->orderBy('total_portfolio', 'desc')
            ->limit(5)
            ->get();

        // Recent loans
        $recentLoans = Loan::with(['borrower', 'loanProduct', 'loanStatus'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Loan disbursement data for chart (last 30 days)
        $loanDisbursementData = $this->getLoanDisbursementChartData();
        //dd($loanDisbursementData);

        return [
            'activeBranchesCount' => $activeBranchesCount,
            'totalBorrowersCount' => $totalBorrowersCount,
            'activeBorrowersCount' => $activeBorrowersCount,
            'totalLoansCount' => $totalLoansCount,
            'activeLoansCount' => $activeLoansCount,
            'pendingLoansCount' => $pendingLoansCount,
            'overdueLoansCount' => $overdueLoansCount,
            'weeklyDisbursements' => $weeklyDisbursements,
            'weeklyRepayments' => $weeklyRepayments,
            'totalPortfolioValue' => $totalPortfolioValue,
            'overdueAmount' => $overdueAmount,
            'disbursementGrowth' => $disbursementGrowth,
            'repaymentGrowth' => $repaymentGrowth,
            'portfolioGrowth' => $portfolioGrowth,
            'borrowerGrowth' => $borrowerGrowth,
            'loanStatusDistribution' => $loanStatusDistribution,
            'activeLoanProductsCount' => $activeLoanProductsCount,
            'mostPopularProduct' => $mostPopularProduct,
            'topBranches' => $topBranches,
            'recentLoans' => $recentLoans,
            'loanDisbursementData' => $loanDisbursementData,
        ];
    }

    /**
     * Get loan disbursement data for the last 30 days
     */
    private function getLoanDisbursementChartData()
    {
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();

        // Get daily disbursements for the last 30 days
        $dailyDisbursements = Loan::whereBetween('loan_released_date', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(loan_released_date) as date'),
                DB::raw('SUM(loan_principal_amount) as total_amount'),
                DB::raw('COUNT(*) as loan_count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Create complete date range for the last 30 days
        $dateRange = [];
        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            $dateRange[$currentDate->format('Y-m-d')] = [
                'date' => $currentDate->format('Y-m-d'),
                'total_amount' => 0,
                'loan_count' => 0
            ];
            $currentDate->addDay();
        }

        // Merge actual data with date range
        foreach ($dailyDisbursements as $disbursement) {
            $dateRange[$disbursement->date] = [
                'date' => $disbursement->date,
                'total_amount' => (float) $disbursement->total_amount,
                'loan_count' => (int) $disbursement->loan_count
            ];
        }

        // Prepare data for chart
        $categories = [];
        $data = [];

        foreach ($dateRange as $day) {
            $categories[] = $day['date'];
            $data[] = $day['total_amount'];
        }

        return [
            'categories' => $categories,
            'data' => $data,
            'total_disbursements' => array_sum($data),
            'average_daily' => array_sum($data) / count($data),
            'max_daily' => max($data),
            'total_loans' => array_sum(array_column($dateRange, 'loan_count'))
        ];
    }
}
