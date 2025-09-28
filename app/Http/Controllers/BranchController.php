<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\LoanProduct;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::withCount(['staff', 'borrowers', 'loans'])->get();
        return view('branches.index', compact('branches'));
    }

    public function create()
    {
        $loanProducts = LoanProduct::active()->get();
        $staff = Staff::active()->get();

        return view('branches.create', compact('loanProducts', 'staff'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_name' => 'required|string|max:255',
            'branch_open_date' => 'required|date',
            'account_settings_override' => 'boolean',
            'branch_country' => 'nullable|string|size:2',
            'branch_currency' => 'nullable|string|size:3',
            'branch_dateformat' => 'nullable|string',
            'branch_currency_in_words' => 'nullable|string|max:255',
            'branch_address' => 'nullable|string',
            'branch_city' => 'nullable|string|max:255',
            'branch_province' => 'nullable|string|max:255',
            'branch_zipcode' => 'nullable|string|max:20',
            'branch_landline' => 'nullable|string|max:20',
            'branch_mobile' => 'nullable|string|max:20',
            'branch_min_loan_amount' => 'nullable|numeric|min:0',
            'branch_max_loan_amount' => 'nullable|numeric|min:0',
            'branch_min_interest_rate' => 'nullable|numeric|min:0|max:100',
            'branch_max_interest_rate' => 'nullable|numeric|min:0|max:100',
            'borrower_num_placeholder' => 'nullable|string',
            'loan_num_placeholder' => 'nullable|string',
            'loan_products_ids' => 'nullable|array',
            'loan_officers_ids' => 'nullable|array',
            'repayment_collector_ids' => 'nullable|array',
        ]);

        DB::transaction(function () use ($validated, $request) {
            // Create branch
            $branch = Branch::create($validated);

            // Sync loan products
            if ($request->has('loan_products_ids')) {
                $branch->loanProducts()->sync($request->loan_products_ids);
            }

            // Sync loan officers
            if ($request->has('loan_officers_ids')) {
                $branch->loanOfficers()->sync($request->loan_officers_ids);
            }

            // Sync collectors
            if ($request->has('repayment_collector_ids')) {
                $branch->collectors()->sync($request->repayment_collector_ids);
            }
        });

        return redirect()->route('branches.index')
            ->with('success', 'Branch created successfully.');
    }

    public function show(Branch $branch)
    {
        $branch->load(['loanProducts', 'loanOfficers', 'collectors', 'staff', 'borrowers', 'loans']);
        return view('branches.show', compact('branch'));
    }

    public function edit(Branch $branch)
    {
        $loanProducts = LoanProduct::active()->get();
        $staff = Staff::active()->get();

        $branch->load(['loanProducts', 'loanOfficers', 'collectors']);

        return view('branches.edit', compact('branch', 'loanProducts', 'staff'));
    }

    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'branch_name' => 'required|string|max:255',
            'branch_open_date' => 'required|date',
            'account_settings_override' => 'boolean',
            'branch_country' => 'nullable|string|size:2',
            'branch_currency' => 'nullable|string|size:3',
            'branch_dateformat' => 'nullable|string',
            'branch_currency_in_words' => 'nullable|string|max:255',
            'branch_address' => 'nullable|string',
            'branch_city' => 'nullable|string|max:255',
            'branch_province' => 'nullable|string|max:255',
            'branch_zipcode' => 'nullable|string|max:20',
            'branch_landline' => 'nullable|string|max:20',
            'branch_mobile' => 'nullable|string|max:20',
            'branch_min_loan_amount' => 'nullable|numeric|min:0',
            'branch_max_loan_amount' => 'nullable|numeric|min:0',
            'branch_min_interest_rate' => 'nullable|numeric|min:0|max:100',
            'branch_max_interest_rate' => 'nullable|numeric|min:0|max:100',
            'borrower_num_placeholder' => 'nullable|string',
            'loan_num_placeholder' => 'nullable|string',
            'loan_products_ids' => 'nullable|array',
            'loan_officers_ids' => 'nullable|array',
            'repayment_collector_ids' => 'nullable|array',
        ]);

        DB::transaction(function () use ($branch, $validated, $request) {
            // Update branch
            $branch->update($validated);

            // Sync relationships
            $branch->loanProducts()->sync($request->loan_products_ids ?? []);
            $branch->loanOfficers()->sync($request->loan_officers_ids ?? []);
            $branch->collectors()->sync($request->repayment_collector_ids ?? []);
        });

        return redirect()->route('branches.index')
            ->with('success', 'Branch updated successfully.');
    }

    public function destroy(Branch $branch)
    {
        // Check if branch has related records
        if ($branch->staff()->exists() || $branch->borrowers()->exists() || $branch->loans()->exists()) {
            return redirect()->route('branches.index')
                ->with('error', 'Cannot delete branch. It has related records.');
        }

        $branch->delete();

        return redirect()->route('branches.index')
            ->with('success', 'Branch deleted successfully.');
    }
}
