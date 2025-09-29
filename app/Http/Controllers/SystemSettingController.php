<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\RepaymentCycle;
use App\Models\RepaymentDuration;
use App\Models\PaymentMethod;
use App\Models\LoanStatus;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SystemSettingController extends Controller
{
    public function index()
    {
        return view('system-settings.index');
    }
    public function system()
    {
        $settings = SystemSetting::getSettings();
        $countries = $this->getCountries();
        $timezones = $this->getTimezones();
        $currencies = $this->getCurrencies();
        return view('system-settings.system', compact('settings', 'countries', 'timezones', 'currencies'));
    }

    // public function update(Request $request)
    // {
    //     // General system settings update logic
    //     return redirect()->route('system-settings.index')->with('success', 'System settings updated successfully.');
    // }

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


    public function update(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'country' => 'required|string|size:2',
            'timezone' => 'required|string',
            'currency' => 'required|string|size:3',
            'currency_in_words' => 'nullable|string|max:255',
            'date_format' => 'required|in:dd/mm/yyyy,mm/dd/yyyy,yyyy/mm/dd',
            'decimal_separator' => 'required|in:dot,comma',
            'thousand_separator' => 'required|in:comma,dot,space',
            'monthly_repayment_cycle' => 'required|in:Actual Days in a Month,Same Day Every Month,31,30,28',
            'yearly_repayment_cycle' => 'required|in:Actual Days in a Year,Same Day Every Year,365,360',
            'days_in_month_interest' => 'required|in:31,30,28',
            'days_in_year_interest' => 'required|in:360,365',
            'business_registration_number' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'zipcode' => 'nullable|string|max:20',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $settings = SystemSetting::getSettings();

        // Handle logo upload
        if ($request->hasFile('company_logo')) {
            // Delete old logo if exists
            if ($settings->company_logo && Storage::exists($settings->company_logo)) {
                Storage::delete($settings->company_logo);
            }

            $logoPath = $request->file('company_logo')->store('company-logos', 'public');
            $validated['company_logo'] = $logoPath;
        }

        $settings->update($validated);

        return redirect()->route('system')
            ->with('success', 'System settings updated successfully.');
    }

    private function getCountries()
    {
        return [
            'AF' => 'Afghanistan',
            'AL' => 'Albania',
            'DZ' => 'Algeria',
            'KE' => 'Kenya',
            'UG' => 'Uganda',
            'TZ' => 'Tanzania',
            'ZW' => 'Zimbabwe',
        ];
    }

    private function getTimezones()
    {
        return \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);
    }

    private function getCurrencies()
    {
        return [
            'AED' => 'AED - د.إ',
            'KES' => 'KES - KSh',
            'USD' => 'USD - $',
            'EUR' => 'EUR - €',
            'GBP' => 'GBP - £',
        ];
    }
}
