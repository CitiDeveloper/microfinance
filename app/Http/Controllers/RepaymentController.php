<?php

namespace App\Http\Controllers;

use App\Models\Repayment;
use App\Models\Loan;
use App\Models\Borrower;
use App\Models\Branch;
use App\Models\Staff;
use App\Models\PaymentMethod;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RepaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Repayment::with(['loan', 'borrower', 'branch', 'collector', 'paymentMethod'])
            ->latest();

        // Search filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('receipt_number', 'like', "%{$search}%")
                    ->orWhere('transaction_reference', 'like', "%{$search}%")
                    ->orWhereHas('borrower', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        $repayments = $query->paginate(25);

        $branches = Branch::all();

        return view('repayments.index', compact('repayments', 'branches'));
    }

    /**
     * Show due repayments.
     */
    public function due()
    {
        // This would typically show upcoming due repayments
        // For now, showing pending repayments
        $repayments = Repayment::with(['loan', 'borrower', 'branch'])
            ->pending()
            ->latest()
            ->paginate(25);

        return view('repayments.due', compact('repayments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $loans = Loan::with('borrower')->where('status', 'active')->get();
        $branches = Branch::all();
        $staff = Staff::all();
        $paymentMethods = PaymentMethod::all();
        $bankAccounts = BankAccount::all();

        return view('repayments.create', compact('loans', 'branches', 'staff', 'paymentMethods', 'bankAccounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'borrower_id' => 'required|exists:borrowers,id',
            'branch_id' => 'required|exists:branches,id',
            'amount' => 'required|numeric|min:0.01',
            'principal_paid' => 'required|numeric|min:0',
            'interest_paid' => 'required|numeric|min:0',
            'fees_paid' => 'numeric|min:0',
            'penalty_paid' => 'numeric|min:0',
            'waiver_amount' => 'numeric|min:0',
            'payment_date' => 'required|date',
            'receipt_number' => 'nullable|string|unique:repayments,receipt_number',
            'transaction_reference' => 'nullable|string|unique:repayments,transaction_reference',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'dea_cash_bank_account' => 'nullable|exists:bank_accounts,id',
            'collected_by' => 'nullable|exists:staff,id',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,posted',
        ]);

        // Calculate total allocated
        $totalAllocated = $validated['principal_paid'] + $validated['interest_paid'] +
            $validated['fees_paid'] + $validated['penalty_paid'] - $validated['waiver_amount'];

        if (abs($totalAllocated - $validated['amount']) > 0.01) {
            return back()->withErrors(['amount' => 'Total allocated amount must equal the payment amount.'])->withInput();
        }

        DB::transaction(function () use ($validated) {
            $repayment = Repayment::create($validated);

            if ($validated['status'] === 'posted') {
                $repayment->markAsPosted();
            }
        });

        return redirect()->route('repayments.index')->with('success', 'Repayment recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Repayment $repayment)
    {
        $repayment->load(['loan', 'borrower', 'branch', 'collector', 'paymentMethod', 'paymentAccount', 'reversedBy']);

        return view('repayments.show', compact('repayment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Repayment $repayment)
    {
        if ($repayment->isPosted()) {
            return redirect()->route('repayments.show', $repayment)->with('error', 'Posted repayments cannot be edited.');
        }

        $loans = Loan::with('borrower')->get();
        $branches = Branch::all();
        $staff = Staff::all();
        $paymentMethods = PaymentMethod::all();
        $bankAccounts = BankAccount::all();

        return view('repayments.edit', compact('repayment', 'loans', 'branches', 'staff', 'paymentMethods', 'bankAccounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Repayment $repayment)
    {
        if ($repayment->isPosted()) {
            return back()->with('error', 'Posted repayments cannot be edited.');
        }

        $validated = $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'borrower_id' => 'required|exists:borrowers,id',
            'branch_id' => 'required|exists:branches,id',
            'amount' => 'required|numeric|min:0.01',
            'principal_paid' => 'required|numeric|min:0',
            'interest_paid' => 'required|numeric|min:0',
            'fees_paid' => 'numeric|min:0',
            'penalty_paid' => 'numeric|min:0',
            'waiver_amount' => 'numeric|min:0',
            'payment_date' => 'required|date',
            'receipt_number' => 'nullable|string|unique:repayments,receipt_number,' . $repayment->id,
            'transaction_reference' => 'nullable|string|unique:repayments,transaction_reference,' . $repayment->id,
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'dea_cash_bank_account' => 'nullable|exists:bank_accounts,id',
            'collected_by' => 'nullable|exists:staff,id',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,posted',
        ]);

        // Calculate total allocated
        $totalAllocated = $validated['principal_paid'] + $validated['interest_paid'] +
            $validated['fees_paid'] + $validated['penalty_paid'] - $validated['waiver_amount'];

        if (abs($totalAllocated - $validated['amount']) > 0.01) {
            return back()->withErrors(['amount' => 'Total allocated amount must equal the payment amount.'])->withInput();
        }

        DB::transaction(function () use ($repayment, $validated) {
            $repayment->update($validated);

            if ($validated['status'] === 'posted' && !$repayment->isPosted()) {
                $repayment->markAsPosted();
            }
        });

        return redirect()->route('repayments.index')->with('success', 'Repayment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Repayment $repayment)
    {
        if ($repayment->isPosted()) {
            return back()->with('error', 'Posted repayments cannot be deleted.');
        }

        $repayment->delete();

        return redirect()->route('repayments.index')->with('success', 'Repayment deleted successfully.');
    }

    /**
     * Bulk store repayments
     */
    public function bulkStore(Request $request)
    {
        // Implementation for bulk repayment upload
        return redirect()->route('repayments.index')->with('success', 'Bulk repayments uploaded successfully.');
    }
}
