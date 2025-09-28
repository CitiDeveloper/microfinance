<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\RepaymentCycle;
use App\Models\RepaymentDuration;
use App\Models\PaymentMethod;
use App\Models\LoanStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SystemSettingController extends Controller
{
    public function index()
    {
        return view('system-settings.index');
    }

    public function update(Request $request)
    {
        // General system settings update logic
        return redirect()->route('system-settings.index')->with('success', 'System settings updated successfully.');
    }

    public function backup()
    {
        // Backup logic
        return redirect()->route('system-settings.index')->with('success', 'Backup completed successfully.');
    }

    // Bank Accounts Methods
    public function bankAccounts()
    {
        $bankAccounts = BankAccount::all();
        return view('system-settings.bank-accounts', compact('bankAccounts'));
    }

    public function storeBankAccount(Request $request)
    {
        $request->validate([
            'coa_code' => 'required|string|max:50|unique:bank_accounts,coa_code',
            'coa_name' => 'required|string|max:255',
            'coa_default_categories' => 'nullable|array',
            'access_branches' => 'nullable|array',
        ]);

        BankAccount::create($request->all());

        return redirect()->route('system-settings.bank-accounts')->with('success', 'Bank account created successfully.');
    }

    public function updateBankAccount(Request $request, $id)
    {
        $request->validate([
            'coa_code' => 'required|string|max:50|unique:bank_accounts,coa_code,' . $id,
            'coa_name' => 'required|string|max:255',
            'coa_default_categories' => 'nullable|array',
            'access_branches' => 'nullable|array',
        ]);

        $bankAccount = BankAccount::findOrFail($id);
        $bankAccount->update($request->all());

        return redirect()->route('system-settings.bank-accounts')->with('success', 'Bank account updated successfully.');
    }

    public function destroyBankAccount($id)
    {
        $bankAccount = BankAccount::findOrFail($id);
        $bankAccount->delete();

        return redirect()->route('system-settings.bank-accounts')->with('success', 'Bank account deleted successfully.');
    }

    // Repayment Cycles Methods
    public function repaymentCycles()
    {
        $repaymentCycles = RepaymentCycle::all();
        return view('system-settings.repayment-cycles', compact('repaymentCycles'));
    }

    public function storeRepaymentCycle(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:repayment_cycles,code',
            'name' => 'required|string|max:255',
        ]);

        RepaymentCycle::create($request->all());

        return redirect()->route('system-settings.repayment-cycles')->with('success', 'Repayment cycle created successfully.');
    }

    public function updateRepaymentCycle(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:repayment_cycles,code,' . $id,
            'name' => 'required|string|max:255',
        ]);

        $repaymentCycle = RepaymentCycle::findOrFail($id);
        $repaymentCycle->update($request->all());

        return redirect()->route('system-settings.repayment-cycles')->with('success', 'Repayment cycle updated successfully.');
    }

    public function destroyRepaymentCycle($id)
    {
        $repaymentCycle = RepaymentCycle::findOrFail($id);
        $repaymentCycle->delete();

        return redirect()->route('system-settings.repayment-cycles')->with('success', 'Repayment cycle deleted successfully.');
    }

    // Repayment Durations Methods
    public function repaymentDurations()
    {
        $repaymentDurations = RepaymentDuration::all();
        return view('system-settings.repayment-durations', compact('repaymentDurations'));
    }

    public function storeRepaymentDuration(Request $request)
    {
        $request->validate([
            'months' => 'required|integer|min:1|unique:repayment_durations,months',
        ]);

        RepaymentDuration::create($request->all());

        return redirect()->route('system-settings.repayment-durations')->with('success', 'Repayment duration created successfully.');
    }

    public function updateRepaymentDuration(Request $request, $id)
    {
        $request->validate([
            'months' => 'required|integer|min:1|unique:repayment_durations,months,' . $id,
        ]);

        $repaymentDuration = RepaymentDuration::findOrFail($id);
        $repaymentDuration->update($request->all());

        return redirect()->route('system-settings.repayment-durations')->with('success', 'Repayment duration updated successfully.');
    }

    public function destroyRepaymentDuration($id)
    {
        $repaymentDuration = RepaymentDuration::findOrFail($id);
        $repaymentDuration->delete();

        return redirect()->route('system-settings.repayment-durations')->with('success', 'Repayment duration deleted successfully.');
    }

    // Payment Methods Methods
    public function paymentMethods()
    {
        $paymentMethods = PaymentMethod::all();
        return view('system-settings.payment-methods', compact('paymentMethods'));
    }

    public function storePaymentMethod(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:payment_methods,code',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        PaymentMethod::create($request->all());

        return redirect()->route('system-settings.payment-methods')->with('success', 'Payment method created successfully.');
    }

    public function updatePaymentMethod(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:payment_methods,code,' . $id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $paymentMethod = PaymentMethod::findOrFail($id);
        $paymentMethod->update($request->all());

        return redirect()->route('system-settings.payment-methods')->with('success', 'Payment method updated successfully.');
    }

    public function destroyPaymentMethod($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        $paymentMethod->delete();

        return redirect()->route('system-settings.payment-methods')->with('success', 'Payment method deleted successfully.');
    }

    // Loan Statuses Methods
    public function loanStatuses()
    {
        $loanStatuses = LoanStatus::all();
        return view('system-settings.loan-statuses', compact('loanStatuses'));
    }

    public function storeLoanStatus(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:loan_statuses,name',
            'is_default' => 'boolean',
        ]);

        LoanStatus::create($request->all());

        return redirect()->route('system-settings.loan-statuses')->with('success', 'Loan status created successfully.');
    }

    public function updateLoanStatus(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:loan_statuses,name,' . $id,
            'is_default' => 'boolean',
        ]);

        $loanStatus = LoanStatus::findOrFail($id);
        $loanStatus->update($request->all());

        return redirect()->route('system-settings.loan-statuses')->with('success', 'Loan status updated successfully.');
    }

    public function destroyLoanStatus($id)
    {
        $loanStatus = LoanStatus::findOrFail($id);
        $loanStatus->delete();

        return redirect()->route('system-settings.loan-statuses')->with('success', 'Loan status deleted successfully.');
    }
}
