<?php

namespace App\Http\Controllers;

use App\Models\Saving;
use App\Models\SavingsTransaction;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SavingsTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SavingsTransaction::with(['account.borrower', 'branch', 'creator'])
            ->latest();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('transaction_reference', 'like', "%{$search}%")
                    ->orWhere('receipt_number', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhereHas('account.borrower', function ($q) use ($search) {
                        $q->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('account', function ($q) use ($search) {
                        $q->where('account_number', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by type
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        // Filter by branch
        if ($request->has('branch_id') && $request->branch_id != '') {
            $query->where('branch_id', $request->branch_id);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('transaction_date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('transaction_date', '<=', $request->date_to);
        }

        $transactions = $query->paginate(25);
        $branches = Branch::all();
        $totalAmount = $query->sum('amount');

        return view('savings-transactions.index', compact('transactions', 'branches', 'totalAmount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $savingsAccounts = Saving::with('borrower')
            ->where('status', 'active')
            ->get();
        $branches = Branch::all();

        return view('savings-transactions.create', compact('savingsAccounts', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'saving_id' => 'required|exists:savings,id',
            'type' => 'required|in:deposit,withdrawal',
            'amount' => 'required|numeric|min:0.01',
            'transaction_date' => 'required|date',
            'branch_id' => 'required|exists:branches,id',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $saving = Saving::findOrFail($request->saving_id);

                // Validate withdrawal against available balance
                if ($request->type === 'withdrawal') {
                    if ($saving->balance < $request->amount) {
                        throw new \Exception('Insufficient balance for withdrawal');
                    }

                    // Check if withdrawals are allowed for this savings product
                    if (!$saving->savingsProduct->allow_withdrawals) {
                        throw new \Exception('Withdrawals are not allowed for this savings product');
                    }
                }

                $balanceBefore = $saving->balance;

                if ($request->type === 'deposit') {
                    $saving->balance += $request->amount;
                } else {
                    $saving->balance -= $request->amount;
                }

                $saving->save();

                // Create transaction record
                $transaction = SavingsTransaction::create([
                    'saving_id' => $saving->id,
                    'branch_id' => $request->branch_id,
                    'transaction_reference' => 'STR' . Str::random(8),
                    'type' => $request->type,
                    'amount' => $request->amount,
                    'balance_before' => $balanceBefore,
                    'balance_after' => $saving->balance,
                    'transaction_date' => $request->transaction_date,
                    'notes' => $request->notes,
                    'receipt_number' => 'RCP' . time() . Str::random(4),
                    'created_by' => auth()->id(),
                ]);

                // Store transaction reference in session for receipt display
                session()->flash('transaction_reference', $transaction->transaction_reference);
                session()->flash('receipt_number', $transaction->receipt_number);
            });

            return redirect()->route('savings-transactions.index')
                ->with('success', 'Transaction completed successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Transaction failed: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SavingsTransaction $savingsTransaction)
    {
        $savingsTransaction->load(['account.borrower', 'branch', 'creator']);

        return view('savings-transactions.show', compact('savingsTransaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SavingsTransaction $savingsTransaction)
    {
        $savingsTransaction->load(['account.borrower', 'branch']);
        $branches = Branch::all();

        return view('savings-transactions.edit', compact('savingsTransaction', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SavingsTransaction $savingsTransaction)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'branch_id' => 'required|exists:branches,id',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $savingsTransaction->update([
                'transaction_date' => $request->transaction_date,
                'branch_id' => $request->branch_id,
                'notes' => $request->notes,
            ]);

            return redirect()->route('savings-transactions.show', $savingsTransaction)
                ->with('success', 'Transaction updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update transaction: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SavingsTransaction $savingsTransaction)
    {
        try {
            DB::transaction(function () use ($savingsTransaction) {
                $saving = $savingsTransaction->account;

                // Reverse the transaction effect on balance
                if ($savingsTransaction->type === 'deposit') {
                    $saving->balance -= $savingsTransaction->amount;
                } else {
                    $saving->balance += $savingsTransaction->amount;
                }

                $saving->save();
                $savingsTransaction->delete();
            });

            return redirect()->route('savings-transactions.index')
                ->with('success', 'Transaction deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete transaction: ' . $e->getMessage());
        }
    }

    /**
     * Print transaction receipt
     */
    public function printReceipt(SavingsTransaction $savingTransaction)
    {
        $savingTransaction->load(['account.borrower', 'branch', 'creator']);

        return view('savings-transactions.receipt', compact('savingsTransaction'));
    }
}
