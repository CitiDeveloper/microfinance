<?php

use App\Http\Controllers\{
    HomeController,
    DashboardController,
    BranchController,
    StaffController,
    LoanProductController,
    BorrowerController,
    LoanController,
    RepaymentController,
    CollateralRegisterController,
    CalendarController,
    CollectionSheetController,
    GuarantorController,
    SavingController,
    SavingTransactionController,
    BankAccountController,
    InvestorController,
    PayrollController,
    ExpenseController,
    OtherIncomeController,
    AssetController,
    ReportController,
    AccountingController,
    
    SystemSettingController,
    ProfileController
};

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Organization Management
    Route::prefix('branches')->group(function () {
        Route::get('/', [BranchController::class, 'index'])->name('branches.index');
        Route::get('/create', [BranchController::class, 'create'])->name('branches.create');
        Route::post('/', [BranchController::class, 'store'])->name('branches.store');
        Route::get('/{branch}', [BranchController::class, 'show'])->name('branches.show');
        Route::get('/{branch}/edit', [BranchController::class, 'edit'])->name('branches.edit');
        Route::put('/{branch}', [BranchController::class, 'update'])->name('branches.update');
        Route::delete('/{branch}', [BranchController::class, 'destroy'])->name('branches.destroy');
    });

    // Staff Management
    Route::prefix('staff')->group(function () {
        Route::get('/', [StaffController::class, 'index'])->name('staff.index');
        Route::get('/create', [StaffController::class, 'create'])->name('staff.create');
        Route::post('/', [StaffController::class, 'store'])->name('staff.store');
        Route::get('/{staff}', [StaffController::class, 'show'])->name('staff.show');
        Route::get('/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
        Route::put('/{staff}', [StaffController::class, 'update'])->name('staff.update');
        Route::delete('/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');
    });
    // Loan Products 

    Route::prefix('loan-products')->group(function () {
        Route::get('/', [LoanProductController::class, 'index'])->name('loan-products.index');
        Route::get('/create', [LoanProductController::class, 'create'])->name('loan-products.create');
        Route::post('/', [LoanProductController::class, 'store'])->name('loan-products.store');
        Route::get('/{loanProduct}', [LoanProductController::class, 'show'])->name('loan-products.show');
        Route::get('/{loanProduct}/edit', [LoanProductController::class, 'edit'])->name('loan-products.edit');
        Route::put('/{loanProduct}', [LoanProductController::class, 'update'])->name('loan-products.update');
        Route::delete('/{loanProduct}', [LoanProductController::class, 'destroy'])->name('loan-products.destroy');
    });

    // Borrowers
    Route::prefix('borrowers')->group(function () {
        Route::get('/', [BorrowerController::class, 'index'])->name('borrowers.index');
        Route::get('/create', [BorrowerController::class, 'create'])->name('borrowers.create');
        Route::post('/', [BorrowerController::class, 'store'])->name('borrowers.store');
        Route::get('/{borrower}', [BorrowerController::class, 'show'])->name('borrowers.show');
        Route::get('/{borrower}/edit', [BorrowerController::class, 'edit'])->name('borrowers.edit');
        Route::put('/{borrower}', [BorrowerController::class, 'update'])->name('borrowers.update');
        Route::delete('/{borrower}', [BorrowerController::class, 'destroy'])->name('borrowers.destroy');
        Route::get('/groups/list', [BorrowerController::class, 'groups'])->name('borrowers.groups');
    });

    // Loans
    Route::prefix('loans')->group(function () {
        Route::get('/', [LoanController::class, 'index'])->name('loans.index');
        Route::get('/create', [LoanController::class, 'create'])->name('loans.create');
        Route::post('/', [LoanController::class, 'store'])->name('loans.store');
        Route::get('/{loan}', [LoanController::class, 'show'])->name('loans.show');
        Route::get('/{loan}/edit', [LoanController::class, 'edit'])->name('loans.edit');
        Route::put('/{loan}', [LoanController::class, 'update'])->name('loans.update');
        Route::delete('/{loan}', [LoanController::class, 'destroy'])->name('loans.destroy');
        Route::get('/pending/approval', [LoanController::class, 'pending'])->name('loans.pending');
        Route::get('/active', [LoanController::class, 'active'])->name('loans.active');
        Route::get('/overdue', [LoanController::class, 'overdue'])->name('loans.overdue');
        Route::post('/{loan}/approve', [LoanController::class, 'approve'])->name('loans.approve');
        Route::post('/{loan}/reject', [LoanController::class, 'reject'])->name('loans.reject');
        Route::post('/{loan}/disburse', [LoanController::class, 'disburse'])->name('loans.disburse');
    });

    // Repayments
    Route::prefix('repayments')->group(function () {
        Route::get('/', [RepaymentController::class, 'index'])->name('repayments.index');
        Route::get('/due', [RepaymentController::class, 'due'])->name('repayments.due');
        Route::get('/create', [RepaymentController::class, 'create'])->name('repayments.create');
        Route::post('/', [RepaymentController::class, 'store'])->name('repayments.store');
        Route::get('/{repayment}', [RepaymentController::class, 'show'])->name('repayments.show');
        Route::get('/{repayment}/edit', [RepaymentController::class, 'edit'])->name('repayments.edit');
        Route::put('/{repayment}', [RepaymentController::class, 'update'])->name('repayments.update');
        Route::delete('/{repayment}', [RepaymentController::class, 'destroy'])->name('repayments.destroy');
        Route::post('/bulk', [RepaymentController::class, 'bulkStore'])->name('repayments.bulk');
    });

    // Collateral Register
    Route::prefix('collateral')->group(function () {
        Route::get('/', [CollateralRegisterController::class, 'index'])->name('collateral.index');
        Route::get('/create', [CollateralRegisterController::class, 'create'])->name('collateral.create');
        Route::post('/', [CollateralRegisterController::class, 'store'])->name('collateral.store');
        Route::get('/{collateral}', [CollateralRegisterController::class, 'show'])->name('collateral.show');
        Route::get('/{collateral}/edit', [CollateralRegisterController::class, 'edit'])->name('collateral.edit');
        Route::put('/{collateral}', [CollateralRegisterController::class, 'update'])->name('collateral.update');
        Route::delete('/{collateral}', [CollateralRegisterController::class, 'destroy'])->name('collateral.destroy');
    });

    // Calendar
    Route::prefix('calendar')->group(function () {
        Route::get('/', [CalendarController::class, 'index'])->name('calendar.index');
        Route::post('/events', [CalendarController::class, 'storeEvent'])->name('calendar.events.store');
        Route::get('/events/{event}', [CalendarController::class, 'showEvent'])->name('calendar.events.show');
        Route::put('/events/{event}', [CalendarController::class, 'updateEvent'])->name('calendar.events.update');
        Route::delete('/events/{event}', [CalendarController::class, 'destroyEvent'])->name('calendar.events.destroy');
    });

    // Collection Sheets
    Route::prefix('collection-sheets')->group(function () {
        Route::get('/', [CollectionSheetController::class, 'index'])->name('collection-sheets.index');
        Route::get('/create', [CollectionSheetController::class, 'create'])->name('collection-sheets.create');
        Route::post('/', [CollectionSheetController::class, 'store'])->name('collection-sheets.store');
        Route::get('/{collectionSheet}', [CollectionSheetController::class, 'show'])->name('collection-sheets.show');
        Route::get('/{collectionSheet}/edit', [CollectionSheetController::class, 'edit'])->name('collection-sheets.edit');
        Route::put('/{collectionSheet}', [CollectionSheetController::class, 'update'])->name('collection-sheets.update');
        Route::delete('/{collectionSheet}', [CollectionSheetController::class, 'destroy'])->name('collection-sheets.destroy');

        // Additional routes for specific types
        Route::get('/daily', [CollectionSheetController::class, 'daily'])->name('collection-sheets.daily');
        Route::get('/missed', [CollectionSheetController::class, 'missed'])->name('collection-sheets.missed');
        Route::get('/past-maturity', [CollectionSheetController::class, 'pastMaturity'])->name('collection-sheets.past-maturity');

        // Collection actions
        Route::post('/{collectionSheet}/collect', [CollectionSheetController::class, 'processCollection'])->name('collection-sheets.collect');
        Route::post('/items/{item}/update-collection', [CollectionSheetController::class, 'updateCollection'])->name('collection-sheets.update-collection');
    });

    // Savings
    Route::prefix('savings')->group(function () {
        Route::get('/', [SavingController::class, 'index'])->name('savings.index');
        Route::get('/create', [SavingController::class, 'create'])->name('savings.create');
        Route::post('/', [SavingController::class, 'store'])->name('savings.store');
        Route::get('/{saving}', [SavingController::class, 'show'])->name('savings.show');
        Route::get('/{saving}/edit', [SavingController::class, 'edit'])->name('savings.edit');
        Route::put('/{saving}', [SavingController::class, 'update'])->name('savings.update');
        Route::delete('/{saving}', [SavingController::class, 'destroy'])->name('savings.destroy');
        Route::post('/{saving}/deposit', [SavingController::class, 'deposit'])->name('savings.deposit');
        Route::post('/{saving}/withdraw', [SavingController::class, 'withdraw'])->name('savings.withdraw');
    });

    // Savings Transactions
    Route::prefix('savings-transactions')->group(function () {
        Route::get('/', [SavingTransactionController::class, 'index'])->name('savings-transactions.index');
        Route::get('/create', [SavingTransactionController::class, 'create'])->name('savings-transactions.create');
        Route::post('/', [SavingTransactionController::class, 'store'])->name('savings-transactions.store');
        Route::get('/{savingTransaction}', [SavingTransactionController::class, 'show'])->name('savings-transactions.show');
        Route::get('/{savingTransaction}/edit', [SavingTransactionController::class, 'edit'])->name('savings-transactions.edit');
        Route::put('/{savingTransaction}', [SavingTransactionController::class, 'update'])->name('savings-transactions.update');
        Route::delete('/{savingTransaction}', [SavingTransactionController::class, 'destroy'])->name('savings-transactions.destroy');
    });

    // Investors
    Route::prefix('investors')->group(function () {
        Route::get('/', [InvestorController::class, 'index'])->name('investors.index');
        Route::get('/create', [InvestorController::class, 'create'])->name('investors.create');
        Route::post('/', [InvestorController::class, 'store'])->name('investors.store');
        Route::get('/{investor}', [InvestorController::class, 'show'])->name('investors.show');
        Route::get('/{investor}/edit', [InvestorController::class, 'edit'])->name('investors.edit');
        Route::put('/{investor}', [InvestorController::class, 'update'])->name('investors.update');
        Route::delete('/{investor}', [InvestorController::class, 'destroy'])->name('investors.destroy');
    });

    // Payroll
    Route::prefix('payroll')->group(function () {
        Route::get('/', [PayrollController::class, 'index'])->name('payroll.index');
        Route::get('/create', [PayrollController::class, 'create'])->name('payroll.create');
        Route::post('/', [PayrollController::class, 'store'])->name('payroll.store');
        Route::get('/{payroll}', [PayrollController::class, 'show'])->name('payroll.show');
        Route::get('/{payroll}/edit', [PayrollController::class, 'edit'])->name('payroll.edit');
        Route::put('/{payroll}', [PayrollController::class, 'update'])->name('payroll.update');
        Route::delete('/{payroll}', [PayrollController::class, 'destroy'])->name('payroll.destroy');
        Route::post('/{payroll}/process', [PayrollController::class, 'process'])->name('payroll.process');
    });

    // Expenses
    Route::prefix('expenses')->group(function () {
        Route::get('/', [ExpenseController::class, 'index'])->name('expenses.index');
        Route::get('/create', [ExpenseController::class, 'create'])->name('expenses.create');
        Route::post('/', [ExpenseController::class, 'store'])->name('expenses.store');
        Route::get('/{expense}', [ExpenseController::class, 'show'])->name('expenses.show');
        Route::get('/{expense}/edit', [ExpenseController::class, 'edit'])->name('expenses.edit');
        Route::put('/{expense}', [ExpenseController::class, 'update'])->name('expenses.update');
        Route::delete('/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
        Route::get('/categories', [ExpenseController::class, 'categories'])->name('expenses.categories');
        Route::post('/categories', [ExpenseController::class, 'storeCategory'])->name('expenses.categories.store');
    });

    // Other Income
    Route::prefix('other-income')->group(function () {
        Route::get('/', [OtherIncomeController::class, 'index'])->name('other-income.index');
        Route::get('/create', [OtherIncomeController::class, 'create'])->name('other-income.create');
        Route::post('/', [OtherIncomeController::class, 'store'])->name('other-income.store');
        Route::get('/{otherIncome}', [OtherIncomeController::class, 'show'])->name('other-income.show');
        Route::get('/{otherIncome}/edit', [OtherIncomeController::class, 'edit'])->name('other-income.edit');
        Route::put('/{otherIncome}', [OtherIncomeController::class, 'update'])->name('other-income.update');
        Route::delete('/{otherIncome}', [OtherIncomeController::class, 'destroy'])->name('other-income.destroy');
    });

    // Asset Management
    Route::prefix('assets')->group(function () {
        Route::get('/', [AssetController::class, 'index'])->name('assets.index');
        Route::get('/create', [AssetController::class, 'create'])->name('assets.create');
        Route::post('/', [AssetController::class, 'store'])->name('assets.store');
        Route::get('/{asset}', [AssetController::class, 'show'])->name('assets.show');
        Route::get('/{asset}/edit', [AssetController::class, 'edit'])->name('assets.edit');
        Route::put('/{asset}', [AssetController::class, 'update'])->name('assets.update');
        Route::delete('/{asset}', [AssetController::class, 'destroy'])->name('assets.destroy');
        Route::post('/{asset}/depreciate', [AssetController::class, 'depreciate'])->name('assets.depreciate');
    });

    // Reports
    Route::prefix('reports')->group(function () {
        Route::get('/loan-portfolio', [ReportController::class, 'loanPortfolio'])->name('reports.loan-portfolio');
        Route::get('/financial', [ReportController::class, 'financial'])->name('reports.financial');
        Route::get('/savings', [ReportController::class, 'savings'])->name('reports.savings');
        Route::get('/collection', [ReportController::class, 'collection'])->name('reports.collection');
        Route::get('/performance', [ReportController::class, 'performance'])->name('reports.performance');
        Route::post('/export/{type}', [ReportController::class, 'export'])->name('reports.export');
    });
    Route::resource('bank_accounts', BankAccountController::class);
    Route::resource('guarantors', GuarantorController::class);
    // Accounting
    Route::prefix('accounting')->group(function () {
        Route::get('/chart-of-accounts', [AccountingController::class, 'chartOfAccounts'])->name('accounting.chart-of-accounts');
        Route::get('/journal-entries', [AccountingController::class, 'journalEntries'])->name('accounting.journal-entries');
        Route::get('/trial-balance', [AccountingController::class, 'trialBalance'])->name('accounting.trial-balance');
        Route::get('/balance-sheet', [AccountingController::class, 'balanceSheet'])->name('accounting.balance-sheet');
        Route::get('/income-statement', [AccountingController::class, 'incomeStatement'])->name('accounting.income-statement');

        // Journal Entries CRUD
        Route::post('/journal-entries', [AccountingController::class, 'storeJournalEntry'])->name('accounting.journal-entries.store');
        Route::get('/journal-entries/{journalEntry}', [AccountingController::class, 'showJournalEntry'])->name('accounting.journal-entries.show');
        Route::put('/journal-entries/{journalEntry}', [AccountingController::class, 'updateJournalEntry'])->name('accounting.journal-entries.update');
        Route::delete('/journal-entries/{journalEntry}', [AccountingController::class, 'destroyJournalEntry'])->name('accounting.journal-entries.destroy');
    });

    // System Settings
    Route::prefix('system-settings')->group(function () {
        Route::get('/', [SystemSettingController::class, 'index'])->name('system-settings.index');
        Route::put('/', [SystemSettingController::class, 'update'])->name('system-settings.update');
        Route::post('/backup', [SystemSettingController::class, 'backup'])->name('system-settings.backup');
        Route::get('/system', [SystemSettingController::class, 'system'])->name('system');

        // Bank Accounts Routes
        Route::prefix('bank-accounts')->group(function () {
            Route::get('/', [SystemSettingController::class, 'bankAccounts'])->name('system-settings.bank-accounts');
            Route::post('/store', [SystemSettingController::class, 'storeBankAccount'])->name('system-settings.bank-accounts.store');
            Route::put('/{id}', [SystemSettingController::class, 'updateBankAccount'])->name('system-settings.bank-accounts.update');
            Route::delete('/{id}', [SystemSettingController::class, 'destroyBankAccount'])->name('system-settings.bank-accounts.destroy');
        });

        // Repayment Cycles Routes
        Route::prefix('repayment-cycles')->group(function () {
            Route::get('/', [SystemSettingController::class, 'repaymentCycles'])->name('system-settings.repayment-cycles');
            Route::post('/store', [SystemSettingController::class, 'storeRepaymentCycle'])->name('system-settings.repayment-cycles.store');
            Route::put('/{id}', [SystemSettingController::class, 'updateRepaymentCycle'])->name('system-settings.repayment-cycles.update');
            Route::delete('/{id}', [SystemSettingController::class, 'destroyRepaymentCycle'])->name('system-settings.repayment-cycles.destroy');
        });

        // Repayment Durations Routes
        Route::prefix('repayment-durations')->group(function () {
            Route::get('/', [SystemSettingController::class, 'repaymentDurations'])->name('system-settings.repayment-durations');
            Route::post('/store', [SystemSettingController::class, 'storeRepaymentDuration'])->name('system-settings.repayment-durations.store');
            Route::put('/{id}', [SystemSettingController::class, 'updateRepaymentDuration'])->name('system-settings.repayment-durations.update');
            Route::delete('/{id}', [SystemSettingController::class, 'destroyRepaymentDuration'])->name('system-settings.repayment-durations.destroy');
        });

        // Payment Methods Routes
        Route::prefix('payment-methods')->group(function () {
            Route::get('/', [SystemSettingController::class, 'paymentMethods'])->name('system-settings.payment-methods');
            Route::post('/store', [SystemSettingController::class, 'storePaymentMethod'])->name('system-settings.payment-methods.store');
            Route::put('/{id}', [SystemSettingController::class, 'updatePaymentMethod'])->name('system-settings.payment-methods.update');
            Route::delete('/{id}', [SystemSettingController::class, 'destroyPaymentMethod'])->name('system-settings.payment-methods.destroy');
        });

        // Loan Statuses Routes
        Route::prefix('loan-statuses')->group(function () {
            Route::get('/', [SystemSettingController::class, 'loanStatuses'])->name('system-settings.loan-statuses');
            Route::post('/store', [SystemSettingController::class, 'storeLoanStatus'])->name('system-settings.loan-statuses.store');
            Route::put('/{id}', [SystemSettingController::class, 'updateLoanStatus'])->name('system-settings.loan-statuses.update');
            Route::delete('/{id}', [SystemSettingController::class, 'destroyLoanStatus'])->name('system-settings.loan-statuses.destroy');
        });
    });

    // User Profile
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
        Route::put('/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    });

    // Settings
    Route::get('/settings', function () {
        return view('settings');
    })->name('settings');

    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');
});
