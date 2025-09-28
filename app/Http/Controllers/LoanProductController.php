<?php
// app/Http/Controllers/LoanProductController.php

namespace App\Http\Controllers;

use App\Models\LoanProduct;
use App\Models\Branch;
use App\Models\LoanStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanProductController extends Controller
{
    public function index()
    {
        $loanProducts = LoanProduct::with('branches')->latest()->get();
        return view('loan-products.index', compact('loanProducts'));
    }

    public function create()
    {
        $branches = Branch::where('is_active', true)->get();
        $loanStatuses = LoanStatus::all();
        $loanProduct = null; // For create view

        return view('loan-products.create', compact('branches', 'loanStatuses', 'loanProduct'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'loan_product_name' => 'required|string|max:255',
            'branches' => 'nullable|array',
            'loan_enable_parameters' => 'nullable|boolean',
            'default_loan_released_date' => 'nullable|in:0,1',
            'loan_disbursed_by_id' => 'nullable|array',
            'min_loan_principal_amount' => 'nullable|numeric|min:0',
            'default_loan_principal_amount' => 'nullable|numeric|min:0',
            'max_loan_principal_amount' => 'nullable|numeric|min:0',
            'loan_interest_method' => 'nullable|string',
            'loan_interest_type' => 'nullable|in:percentage,fixed',
            'loan_interest_period' => 'nullable|string',
            'min_loan_interest' => 'nullable|numeric|min:0',
            'default_loan_interest' => 'nullable|numeric|min:0',
            'max_loan_interest' => 'nullable|numeric|min:0',
            'loan_duration_period' => 'nullable|string',
            'min_loan_duration' => 'nullable|integer|min:1',
            'default_loan_duration' => 'nullable|integer|min:1',
            'max_loan_duration' => 'nullable|integer|min:1',
            'loan_payment_scheme_id' => 'nullable|array',
            'min_loan_num_of_repayments' => 'nullable|integer|min:1',
            'default_loan_num_of_repayments' => 'nullable|integer|min:1',
            'max_loan_num_of_repayments' => 'nullable|integer|min:1',
            'loan_decimal_places' => 'nullable|string',
            'loan_decimal_places_adjust_each_interest' => 'nullable|boolean',
            'repayment_order' => 'nullable|array',
            // Add validation for other fields as needed
        ]);

        // Convert arrays to JSON for storage
        $validated['loan_disbursed_by_id'] = isset($validated['loan_disbursed_by_id']) ? json_encode($validated['loan_disbursed_by_id']) : null;
        $validated['loan_payment_scheme_id'] = isset($validated['loan_payment_scheme_id']) ? json_encode($validated['loan_payment_scheme_id']) : null;
        $validated['repayment_order'] = isset($validated['repayment_order']) ? json_encode($validated['repayment_order']) : null;

        $loanProduct = LoanProduct::create($validated);

        // Sync branches
        if (isset($validated['branches'])) {
            $loanProduct->branches()->sync($validated['branches']);
        }

        return redirect()->route('loan-products.index')
            ->with('success', 'Loan product created successfully.');
    }

    public function edit(LoanProduct $loanProduct)
    {
        $branches = Branch::where('is_active', true)->get();
        $loanStatuses = LoanStatus::all();

        return view('loan-products.create', compact('branches', 'loanStatuses', 'loanProduct'));
    }

    public function update(Request $request, LoanProduct $loanProduct)
    {
        $validated = $request->validate([
            'loan_product_name' => 'required|string|max:255',
            'branches' => 'nullable|array',
            'loan_enable_parameters' => 'nullable|boolean',
            'default_loan_released_date' => 'nullable|in:0,1',
            'loan_disbursed_by_id' => 'nullable|array',
            'min_loan_principal_amount' => 'nullable|numeric|min:0',
            'default_loan_principal_amount' => 'nullable|numeric|min:0',
            'max_loan_principal_amount' => 'nullable|numeric|min:0',
            'loan_interest_method' => 'nullable|string',
            'loan_interest_type' => 'nullable|in:percentage,fixed',
            'loan_interest_period' => 'nullable|string',
            'min_loan_interest' => 'nullable|numeric|min:0',
            'default_loan_interest' => 'nullable|numeric|min:0',
            'max_loan_interest' => 'nullable|numeric|min:0',
            'loan_duration_period' => 'nullable|string',
            'min_loan_duration' => 'nullable|integer|min:1',
            'default_loan_duration' => 'nullable|integer|min:1',
            'max_loan_duration' => 'nullable|integer|min:1',
            'loan_payment_scheme_id' => 'nullable|array',
            'min_loan_num_of_repayments' => 'nullable|integer|min:1',
            'default_loan_num_of_repayments' => 'nullable|integer|min:1',
            'max_loan_num_of_repayments' => 'nullable|integer|min:1',
            'loan_decimal_places' => 'nullable|string',
            'loan_decimal_places_adjust_each_interest' => 'nullable|boolean',
            'repayment_order' => 'nullable|array',
        ]);

        // Convert arrays to JSON for storage (same as store method)
        $validated['loan_disbursed_by_id'] = isset($validated['loan_disbursed_by_id']) ? json_encode($validated['loan_disbursed_by_id']) : null;
        $validated['loan_payment_scheme_id'] = isset($validated['loan_payment_scheme_id']) ? json_encode($validated['loan_payment_scheme_id']) : null;
        $validated['repayment_order'] = isset($validated['repayment_order']) ? json_encode($validated['repayment_order']) : null;

        $loanProduct->update($validated);

        // Sync branches
        if (isset($validated['branches'])) {
            $loanProduct->branches()->sync($validated['branches']);
        }

        return redirect()->route('loan-products.index')
            ->with('success', 'Loan product updated successfully.');
    }

    public function show(LoanProduct $loanProduct)
    {
        $loanProduct->load('branches', 'loanStatus');
        return view('loan-products.show', compact('loanProduct'));
    }    

   

    public function destroy(LoanProduct $loanProduct)
    {
        // Check if loan product has associated loans
        if ($loanProduct->loans()->exists()) {
            return redirect()->route('loan-products.index')
                ->with('error', 'Cannot delete loan product with associated loans.');
        }

        $loanProduct->delete();

        return redirect()->route('loan-products.index')
            ->with('success', 'Loan product deleted successfully.');
    }
}
