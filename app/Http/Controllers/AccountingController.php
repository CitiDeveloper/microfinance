<?php
// app/Http/Controllers/AccountingController.php

namespace App\Http\Controllers;


use App\Models\JournalEntry;
use App\Models\AccountType;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use App\Models\JournalEntryItem;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class AccountingController extends Controller
{
    // In your AccountingController.php
    public function chartOfAccounts()
    {
        $accounts = ChartOfAccount::with(['accountType', 'parent'])
            ->orderBy('code')
            ->paginate(20);

        $accountTypes = AccountType::where('is_active', true)->get();
        $parentAccounts = ChartOfAccount::where('is_active', true)
            ->whereNull('parent_id')
            ->get();

        // Statistics
        $totalAccounts = ChartOfAccount::count();
        $activeAccounts = ChartOfAccount::where('is_active', true)->count();
        $inactiveAccounts = ChartOfAccount::where('is_active', false)->count();
        $categoriesCount = AccountType::where('is_active', true)->count();

        return view('accounting.chart-of-accounts.index', compact(
            'accounts',
            'accountTypes',
            'parentAccounts',
            'totalAccounts',
            'activeAccounts',
            'inactiveAccounts',
            'categoriesCount'
        ));
    }

    public function createChartOfAccount()
    {
        $accountTypes = AccountType::where('is_active', true)->get();
        $parentAccounts = ChartOfAccount::where('is_active', true)->get();

        return view('accounting.chart-of-accounts.create', compact('accountTypes', 'parentAccounts'));
    }

    public function storeChartOfAccount(Request $request)
    {
        $request->validate([
            'account_type_id' => 'required|exists:account_types,id',
            'parent_id' => 'nullable|exists:chart_of_accounts,id',
            'code' => 'required|string|unique:chart_of_accounts,code',
            'name' => 'required|string|max:255',
            'normal_balance' => 'required|in:debit,credit',
            'description' => 'nullable|string',
        ]);

        ChartOfAccount::create($request->all());

        return redirect()->route('accounting.chart-of-accounts')
            ->with('success', 'Chart of account created successfully.');
    }

    public function showChartOfAccount(ChartOfAccount $chartOfAccount)
    {
        $chartOfAccount->load(['accountType', 'parent', 'children', 'journalEntryItems.journalEntry']);

        return view('accounting.chart-of-accounts.show', compact('chartOfAccount'));
    }

    public function editChartOfAccount(ChartOfAccount $chartOfAccount)
    {
        $accountTypes = AccountType::where('is_active', true)->get();
        $parentAccounts = ChartOfAccount::where('is_active', true)
            ->where('id', '!=', $chartOfAccount->id)
            ->get();

        return view('accounting.chart-of-accounts.edit', compact('chartOfAccount', 'accountTypes', 'parentAccounts'));
    }

    public function updateChartOfAccount(Request $request, ChartOfAccount $chartOfAccount)
    {
        $request->validate([
            'account_type_id' => 'required|exists:account_types,id',
            'parent_id' => 'nullable|exists:chart_of_accounts,id',
            'code' => 'required|string|unique:chart_of_accounts,code,' . $chartOfAccount->id,
            'name' => 'required|string|max:255',
            'normal_balance' => 'required|in:debit,credit',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $chartOfAccount->update($request->all());

        return redirect()->route('accounting.chart-of-accounts')
            ->with('success', 'Chart of account updated successfully.');
    }

    public function destroyChartOfAccount(ChartOfAccount $chartOfAccount)
    {
        if ($chartOfAccount->journalEntryItems()->exists()) {
            return redirect()->back()
                ->with('error', 'Cannot delete account with existing transactions.');
        }

        $chartOfAccount->delete();

        return redirect()->route('accounting.chart-of-accounts')
            ->with('success', 'Chart of account deleted successfully.');
    }

    public function toggleChartOfAccountStatus(ChartOfAccount $chartOfAccount)
    {
        $chartOfAccount->update([
            'is_active' => !$chartOfAccount->is_active
        ]);

        return redirect()->back()
            ->with('success', 'Account status updated successfully.');
    }

    // Journal Entries Methods
    public function createJournalEntry()
    {
        $accounts = ChartOfAccount::where('is_active', true)
            ->with('accountType')
            ->orderBy('code')
            ->get();

        $branches = Branch::where('is_active', true)->get();

        return view('accounting.journal-entries.create', compact('accounts', 'branches'));
    }

    public function editJournalEntry(JournalEntry $journalEntry)
    {
        if ($journalEntry->status !== 'draft') {
            return redirect()->route('accounting.journal-entries')
                ->with('error', 'Only draft journal entries can be edited.');
        }

        $accounts = ChartOfAccount::where('is_active', true)->get();
        $branches = Branch::where('is_active', true)->get();
        $journalEntry->load('items');

        return view('accounting.journal-entries.edit', compact('journalEntry', 'accounts', 'branches'));
    }

    public function updateJournalEntry(Request $request, JournalEntry $journalEntry)
    {
        if ($journalEntry->status !== 'draft') {
            return redirect()->back()
                ->with('error', 'Only draft journal entries can be updated.');
        }

        $request->validate([
            'entry_date' => 'required|date',
            'description' => 'required|string|max:500',
            'branch_id' => 'required|exists:branches,id',
            'items' => 'required|array|min:2',
            'items.*.chart_of_account_id' => 'required|exists:chart_of_accounts,id',
            'items.*.debit' => 'required_without:items.*.credit|numeric|min:0',
            'items.*.credit' => 'required_without:items.*.debit|numeric|min:0',
        ]);

        return DB::transaction(function () use ($request, $journalEntry) {
            $totalDebit = collect($request->items)->sum('debit');
            $totalCredit = collect($request->items)->sum('credit');

            if ($totalDebit !== $totalCredit) {
                return back()->withErrors(['items' => 'Total debit and credit must be equal.'])->withInput();
            }

            // Update journal entry
            $journalEntry->update([
                'entry_date' => $request->entry_date,
                'description' => $request->description,
                'branch_id' => $request->branch_id,
                'total_debit' => $totalDebit,
                'total_credit' => $totalCredit,
                'reference' => $request->reference,
                'notes' => $request->notes,
            ]);

            // Delete existing items and create new ones
            $journalEntry->items()->delete();

            foreach ($request->items as $item) {
                $journalEntry->items()->create([
                    'chart_of_account_id' => $item['chart_of_account_id'],
                    'debit' => $item['debit'] ?? 0,
                    'credit' => $item['credit'] ?? 0,
                    'description' => $item['description'] ?? null,
                ]);
            }

            return redirect()->route('accounting.journal-entries')
                ->with('success', 'Journal entry updated successfully.');
        });
    }

    public function postJournalEntry(JournalEntry $journalEntry)
    {
        if ($journalEntry->status !== 'draft') {
            return redirect()->back()
                ->with('error', 'Only draft journal entries can be posted.');
        }

        if (!$journalEntry->isBalanced()) {
            return redirect()->back()
                ->with('error', 'Journal entry must be balanced before posting.');
        }

        $journalEntry->update([
            'status' => 'posted',
            'posted_by' => auth()->id(),
            'posted_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Journal entry posted successfully.');
    }

    public function cancelJournalEntry(JournalEntry $journalEntry)
    {
        if ($journalEntry->status === 'posted') {
            return redirect()->back()
                ->with('error', 'Posted journal entries cannot be cancelled.');
        }

        $journalEntry->update([
            'status' => 'cancelled',
        ]);

        return redirect()->back()
            ->with('success', 'Journal entry cancelled successfully.');
    }

    // Account Types Management
    public function accountTypes()
    {
        $accountTypes = AccountType::withCount('chartOfAccounts')->get();

        // Statistics
        $totalTypes = AccountType::count();
        $activeTypes = AccountType::where('is_active', true)->count();
        $categoriesCount = AccountType::distinct('category')->count('category');
        $totalAccounts = \App\Models\ChartOfAccount::count();

        return view('accounting.account-types.index', compact(
            'accountTypes',
            'totalTypes',
            'activeTypes',
            'categoriesCount',
            'totalAccounts'
        ));
    }

    public function createAccountType()
    {
        return view('accounting.account-types.create');
    }

    public function storeAccountType(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:account_types,code',
            'category' => 'required|in:asset,liability,equity,income,expense',
            'description' => 'nullable|string',
        ]);

        AccountType::create($request->all());

        return redirect()->route('accounting.account-types.index')
            ->with('success', 'Account type created successfully.');
    }
    public function showAccountType(AccountType $accountType)
    {
        $accountType->load(['chartOfAccounts' => function ($query) {
            $query->orderBy('code');
        }]);

        return view('accounting.account-types.show', compact('accountType'));
    }
    public function editAccountType(AccountType $accountType)
    {
        return view('accounting.account-types.edit', compact('accountType'));
    }
    public function updateAccountType(Request $request, AccountType $accountType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:account_types,code,' . $accountType->id,
            'category' => 'required|in:asset,liability,equity,income,expense',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $accountType->update($request->all());

        return redirect()->route('accounting.account-types.index')
            ->with('success', 'Account type updated successfully.');
    }
    public function destroyAccountType(AccountType $accountType)
    {
        if ($accountType->chartOfAccounts()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete account type with linked accounts.');
        }

        $accountType->delete();

        return redirect()->route('accounting.account-types.index')
            ->with('success', 'Account type deleted successfully.');
    }
    // Report Methods
    // Add these methods to your AccountingController.php

    public function generalLedger(Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->format('Y-m-d');
        $accountId = $request->account_id;
        $branchId = $request->branch_id;

        $accounts = ChartOfAccount::where('is_active', true)->orderBy('code')->get();
        $branches = Branch::where('is_active', true)->get();

        if ($accountId) {
            // Single account ledger
            $selectedAccount = ChartOfAccount::findOrFail($accountId);

            $query = JournalEntryItem::with(['journalEntry.branch', 'journalEntry.createdBy'])
                ->where('chart_of_account_id', $accountId)
                ->whereHas('journalEntry', function ($query) use ($startDate, $endDate, $branchId) {
                    $query->where('status', 'posted')
                        ->whereBetween('entry_date', [$startDate, $endDate]);

                    if ($branchId) {
                        $query->where('branch_id', $branchId);
                    }
                });

            $transactions = $query->orderBy('journal_entries.entry_date')->get();

            $totalDebit = $transactions->sum('debit');
            $totalCredit = $transactions->sum('credit');
            $totalTransactions = $transactions->count();
            $uniqueAccounts = 1;

            return view('accounting.reports.general-ledger', compact(
                'transactions',
                'accounts',
                'branches',
                'totalDebit',
                'totalCredit',
                'totalTransactions',
                'uniqueAccounts',
                'selectedAccount',
                'startDate',
                'endDate'
            ));
        } else {
            // All accounts summary
            $accountSummaries = [];
            $totalDebit = 0;
            $totalCredit = 0;

            foreach ($accounts as $account) {
                $query = $account->journalEntryItems()
                    ->whereHas('journalEntry', function ($query) use ($startDate, $endDate, $branchId) {
                        $query->where('status', 'posted')
                            ->whereBetween('entry_date', [$startDate, $endDate]);

                        if ($branchId) {
                            $query->where('branch_id', $branchId);
                        }
                    });

                $debit = $query->sum('debit');
                $credit = $query->sum('credit');

                if ($debit > 0 || $credit > 0) {
                    $accountSummaries[] = [
                        'account' => $account,
                        'debit' => $debit,
                        'credit' => $credit,
                    ];

                    $totalDebit += $debit;
                    $totalCredit += $credit;
                }
            }

            $totalTransactions = array_sum(array_map(function ($summary) {
                return $summary['debit'] + $summary['credit'];
            }, $accountSummaries));

            $uniqueAccounts = count($accountSummaries);

            return view('accounting.reports.general-ledger', compact(
                'accountSummaries',
                'accounts',
                'branches',
                'totalDebit',
                'totalCredit',
                'totalTransactions',
                'uniqueAccounts',
                'startDate',
                'endDate'
            ));
        }
    }

    public function cashFlow(Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->format('Y-m-d');

        // This is a simplified cash flow calculation
        // In a real application, you would have more sophisticated logic

        // Operating Activities (simplified)
        $netIncome = 50000; // This would be calculated from income statement
        $operatingActivities = [
            ['description' => 'Depreciation Expense', 'amount' => 5000],
            ['description' => 'Increase in Accounts Receivable', 'amount' => -2000],
            ['description' => 'Decrease in Inventory', 'amount' => 3000],
        ];
        $cashFromOperations = $netIncome + array_sum(array_column($operatingActivities, 'amount'));

        // Investing Activities (example data)
        $investingActivities = [
            ['description' => 'Purchase of Equipment', 'amount' => -15000],
            ['description' => 'Sale of Investments', 'amount' => 8000],
        ];
        $cashFromInvesting = array_sum(array_column($investingActivities, 'amount'));

        // Financing Activities (example data)
        $financingActivities = [
            ['description' => 'Issuance of Common Stock', 'amount' => 20000],
            ['description' => 'Payment of Dividends', 'amount' => -5000],
            ['description' => 'Repayment of Long-term Debt', 'amount' => -10000],
        ];
        $cashFromFinancing = array_sum(array_column($financingActivities, 'amount'));

        return view('accounting.reports.cash-flow', compact(
            'netIncome',
            'operatingActivities',
            'investingActivities',
            'financingActivities',
            'cashFromOperations',
            'cashFromInvesting',
            'cashFromFinancing',
            'startDate',
            'endDate'
        ));
    }

    public function accountStatement(ChartOfAccount $account, Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->format('Y-m-d');

        $transactions = JournalEntryItem::with(['journalEntry.branch'])
            ->where('chart_of_account_id', $account->id)
            ->whereHas('journalEntry', function ($query) use ($startDate, $endDate) {
                $query->where('status', 'posted')
                    ->whereBetween('entry_date', [$startDate, $endDate]);
            })
            ->orderBy('journal_entries.entry_date')
            ->get();

        return view('accounting.reports.account-statement', compact(
            'account',
            'transactions',
            'startDate',
            'endDate'
        ));
    }

    // API Methods
    public function getChartOfAccounts()
    {
        $accounts = ChartOfAccount::where('is_active', true)
            ->with('accountType')
            ->get()
            ->map(function ($account) {
                return [
                    'id' => $account->id,
                    'code' => $account->code,
                    'name' => $account->name,
                    'full_name' => $account->code . ' - ' . $account->name,
                    'normal_balance' => $account->normal_balance,
                    'category' => $account->accountType->category,
                ];
            });

        return response()->json($accounts);
    }
    

    // public function journalEntries()
    // {
    //     $journalEntries = JournalEntry::with(['branch', 'createdBy'])->latest()->get();

    //     return view('accounting.journal-entries', compact('journalEntries'));
    // }

    public function storeJournalEntry(Request $request)
    {
        $request->validate([
            'entry_date' => 'required|date',
            'description' => 'required|string|max:500',
            'branch_id' => 'required|exists:branches,id',
            'items' => 'required|array|min:2',
            'items.*.chart_of_account_id' => 'required|exists:chart_of_accounts,id',
            'items.*.debit' => 'required_without:items.*.credit|numeric|min:0',
            'items.*.credit' => 'required_without:items.*.debit|numeric|min:0',
        ]);

        return DB::transaction(function () use ($request) {
            $totalDebit = collect($request->items)->sum('debit');
            $totalCredit = collect($request->items)->sum('credit');

            if ($totalDebit !== $totalCredit) {
                return back()->withErrors(['items' => 'Total debit and credit must be equal.'])->withInput();
            }

            $journalEntry = JournalEntry::create([
                'entry_date' => $request->entry_date,
                'description' => $request->description,
                'branch_id' => $request->branch_id,
                'created_by' => auth()->id(),
                'total_debit' => $totalDebit,
                'total_credit' => $totalCredit,
                'reference' => $request->reference,
                'notes' => $request->notes,
                'status' => 'posted',
                'posted_by' => auth()->id(),
                'posted_at' => now(),
            ]);

            foreach ($request->items as $item) {
                $journalEntry->items()->create([
                    'chart_of_account_id' => $item['chart_of_account_id'],
                    'debit' => $item['debit'] ?? 0,
                    'credit' => $item['credit'] ?? 0,
                    'description' => $item['description'] ?? null,
                ]);
            }

            return redirect()->route('accounting.journal-entries')->with('success', 'Journal entry created successfully.');
        });
    }
    // Update this method in your AccountingController.php

    public function journalEntries(Request $request)
    {
        $query = JournalEntry::with(['branch', 'createdBy']);

        // Apply filters
        if ($request->has('start_date') && $request->start_date) {
            $query->where('entry_date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->where('entry_date', '<=', $request->end_date);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $journalEntries = $query->latest()->paginate(20);

        // Statistics
        $totalEntries = JournalEntry::count();
        $postedEntries = JournalEntry::where('status', 'posted')->count();
        $draftEntries = JournalEntry::where('status', 'draft')->count();
        $totalAmount = JournalEntry::where('status', 'posted')->sum('total_debit');

        return view('accounting.journal-entries.index', compact(
            'journalEntries',
            'totalEntries',
            'postedEntries',
            'draftEntries',
            'totalAmount'
        ));
    }

    public function showJournalEntry(JournalEntry $journalEntry)
    {
        $journalEntry->load(['items.chartOfAccount', 'branch', 'createdBy', 'postedBy']);

        return view('accounting.journal-entries.show', compact('journalEntry'));
    }

    // Update the trialBalance method in AccountingController.php

    public function trialBalance(Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->format('Y-m-d');
        $branchId = $request->branch_id;

        // Get accounts with their balances for the period
        $query = ChartOfAccount::with(['accountType', 'journalEntryItems.journalEntry'])
            ->where('is_active', true);

        $accounts = $query->get()->map(function ($account) use ($startDate, $endDate, $branchId) {
            $journalEntryItems = $account->journalEntryItems()
                ->whereHas('journalEntry', function ($query) use ($startDate, $endDate, $branchId) {
                    $query->where('status', 'posted')
                        ->whereBetween('entry_date', [$startDate, $endDate]);

                    if ($branchId) {
                        $query->where('branch_id', $branchId);
                    }
                })
                ->get();

            $debit = $journalEntryItems->sum('debit');
            $credit = $journalEntryItems->sum('credit');

            return [
                'account' => $account,
                'debit' => $debit,
                'credit' => $credit,
                'balance' => $account->normal_balance === 'debit' ? $debit - $credit : $credit - $debit,
            ];
        });

        $totalDebit = $accounts->sum('debit');
        $totalCredit = $accounts->sum('credit');
        $totalAccounts = $accounts->count();

        $branches = Branch::where('is_active', true)->get();

        return view('accounting.trial-balance', compact(
            'accounts',
            'totalDebit',
            'totalCredit',
            'totalAccounts',
            'branches',
            'startDate',
            'endDate'
        ));
    }

    public function balanceSheet()
    {
        // Implement balance sheet logic
        $assets = $this->getAccountsByCategory('asset');
        $liabilities = $this->getAccountsByCategory('liability');
        $equity = $this->getAccountsByCategory('equity');

        $totalAssets = $assets->sum('balance');
        $totalLiabilities = $liabilities->sum('balance');
        $totalEquity = $equity->sum('balance');
        $branches = Branch::where('is_active', true)->get();

        return view('accounting.balance-sheet', compact('assets', 'branches', 'liabilities', 'equity', 'totalAssets', 'totalLiabilities', 'totalEquity'));
    }

    public function incomeStatement()
    {
        // Implement income statement logic
        $incomes = $this->getAccountsByCategory('income');
        $expenses = $this->getAccountsByCategory('expense');

        $totalIncome = $incomes->sum('balance');
        $totalExpenses = $expenses->sum('balance');
        $netIncome = $totalIncome - $totalExpenses;
        $branches = Branch::where('is_active', true)->get();

        return view('accounting.income-statement', compact('incomes', 'branches','expenses', 'totalIncome', 'totalExpenses', 'netIncome'));
    }

    private function getAccountsByCategory($category)
    {
        return ChartOfAccount::with(['accountType', 'journalEntryItems'])
            ->whereHas('accountType', function ($query) use ($category) {
                $query->where('category', $category);
            })
            ->where('is_active', true)
            ->get()
            ->map(function ($account) {
                $debit = $account->journalEntryItems->sum('debit');
                $credit = $account->journalEntryItems->sum('credit');

                return [
                    'account' => $account,
                    'balance' => $account->normal_balance === 'debit' ? $debit - $credit : $credit - $debit,
                ];
            });
    }
}
