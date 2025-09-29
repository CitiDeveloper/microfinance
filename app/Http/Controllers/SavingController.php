<?php

namespace App\Http\Controllers;

use App\Models\Saving;
use App\Models\SavingsProduct;
use App\Models\Borrower;
use App\Models\Branch;
use App\Models\SavingsTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SavingController extends Controller
{
    public function index()
    {
        $savings = Saving::with(['borrower', 'branch', 'savingsProduct'])
            ->latest()
            ->paginate(10);

        return view('savings.index', compact('savings'));
    }

    public function create()
    {
        $borrowers = Borrower::get();
        $branches = Branch::where('is_active', true)->get();
        $savingsProducts = SavingsProduct::where('is_active', true)->get();

        return view('savings.create', compact('borrowers', 'branches', 'savingsProducts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'borrower_id' => 'required|exists:borrowers,id',
            'branch_id' => 'required|exists:branches,id',
            'savings_product_id' => 'required|exists:savings_products,id',
            'opening_date' => 'required|date',
            'initial_deposit' => 'required|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $savingsProduct = SavingsProduct::findOrFail($request->savings_product_id);

            // Validate initial deposit
            if ($request->initial_deposit < $savingsProduct->minimum_deposit) {
                return back()->withErrors([
                    'initial_deposit' => "Initial deposit must be at least {$savingsProduct->minimum_deposit}"
                ])->withInput();
            }

            if ($savingsProduct->maximum_deposit && $request->initial_deposit > $savingsProduct->maximum_deposit) {
                return back()->withErrors([
                    'initial_deposit' => "Initial deposit cannot exceed {$savingsProduct->maximum_deposit}"
                ])->withInput();
            }

            $saving = Saving::create([
                'account_number' => $this->generateAccountNumber(),
                'borrower_id' => $request->borrower_id,
                'branch_id' => $request->branch_id,
                'savings_product_id' => $request->savings_product_id,
                'balance' => $request->initial_deposit,
                'minimum_balance' => $savingsProduct->minimum_balance,
                'status' => 'active',
                'opening_date' => $request->opening_date,
                'notes' => $request->notes
            ]);

            // Create initial deposit transaction
            if ($request->initial_deposit > 0) {
                SavingsTransaction::create([
                    'saving_id' => $saving->id,
                    'branch_id' => $request->branch_id,
                    'transaction_reference' => $this->generateTransactionReference(),
                    'type' => 'deposit',
                    'amount' => $request->initial_deposit,
                    'balance_before' => 0,
                    'balance_after' => $request->initial_deposit,
                    'transaction_date' => $request->opening_date,
                    'notes' => 'Initial deposit',
                    'receipt_number' => $this->generateReceiptNumber(),
                    'created_by' => auth()->id()
                ]);
            }

            DB::commit();

            return redirect()->route('savings.show', $saving)
                ->with('success', 'Savings account created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create savings account: ' . $e->getMessage());
        }
    }

    public function show(Saving $saving)
    {
        $saving->load(['borrower', 'branch', 'savingsProduct', 'transactions.creator']);
        $transactions = $saving->transactions()->latest()->paginate(10);

        return view('savings.show', compact('saving', 'transactions'));
    }

    public function edit(Saving $saving)
    {
        $saving->load(['borrower', 'savingsProduct']);
        $branches = Branch::where('is_active', true)->get();
        $savingsProducts = SavingsProduct::where('is_active', true)->get();

        return view('savings.edit', compact('saving', 'branches', 'savingsProducts'));
    }

    public function update(Request $request, Saving $saving)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'savings_product_id' => 'required|exists:savings_products,id',
            'status' => 'required|in:active,dormant,closed,frozen',
            'maturity_date' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);

        try {
            $saving->update($request->only([
                'branch_id',
                'savings_product_id',
                'status',
                'maturity_date',
                'notes'
            ]));

            return redirect()->route('savings.show', $saving)
                ->with('success', 'Savings account updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update savings account: ' . $e->getMessage());
        }
    }

    public function destroy(Saving $saving)
    {
        try {
            if ($saving->balance > 0) {
                return back()->with('error', 'Cannot delete savings account with balance. Please withdraw all funds first.');
            }

            $saving->delete();

            return redirect()->route('savings.index')
                ->with('success', 'Savings account deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete savings account: ' . $e->getMessage());
        }
    }

    public function deposit(Request $request, Saving $saving)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $balanceBefore = $saving->balance;
            $amount = $request->amount;
            $balanceAfter = $balanceBefore + $amount;

            // Create transaction
            SavingsTransaction::create([
                'saving_id' => $saving->id,
                'branch_id' => $saving->branch_id,
                'transaction_reference' => $this->generateTransactionReference(),
                'type' => 'deposit',
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'transaction_date' => $request->transaction_date,
                'notes' => $request->notes,
                'receipt_number' => $this->generateReceiptNumber(),
                'created_by' => auth()->id()
            ]);

            // Update savings balance
            $saving->update(['balance' => $balanceAfter]);

            DB::commit();

            return back()->with('success', 'Deposit completed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to process deposit: ' . $e->getMessage());
        }
    }

    public function withdraw(Request $request, Saving $saving)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $balanceBefore = $saving->balance;
            $amount = $request->amount;

            // Check if savings product allows withdrawals
            if (!$saving->savingsProduct->allow_withdrawals) {
                return back()->with('error', 'Withdrawals are not allowed for this savings product.');
            }

            // Check sufficient balance
            if ($amount > $balanceBefore) {
                return back()->with('error', 'Insufficient balance for withdrawal.');
            }

            // Check minimum balance requirement
            $balanceAfter = $balanceBefore - $amount;
            if ($balanceAfter < $saving->minimum_balance) {
                return back()->with('error', "Withdrawal would violate minimum balance requirement of {$saving->minimum_balance}");
            }

            // Create transaction
            SavingsTransaction::create([
                'saving_id' => $saving->id,
                'branch_id' => $saving->branch_id,
                'transaction_reference' => $this->generateTransactionReference(),
                'type' => 'withdrawal',
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'transaction_date' => $request->transaction_date,
                'notes' => $request->notes,
                'receipt_number' => $this->generateReceiptNumber(),
                'created_by' => auth()->id()
            ]);

            // Update savings balance
            $saving->update(['balance' => $balanceAfter]);

            DB::commit();

            return back()->with('success', 'Withdrawal completed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to process withdrawal: ' . $e->getMessage());
        }
    }

    private function generateAccountNumber()
    {
        do {
            $accountNumber = 'SAV' . date('Ymd') . Str::random(6);
        } while (Saving::where('account_number', $accountNumber)->exists());

        return $accountNumber;
    }

    private function generateTransactionReference()
    {
        do {
            $reference = 'TXN' . date('YmdHis') . Str::random(4);
        } while (SavingsTransaction::where('transaction_reference', $reference)->exists());

        return $reference;
    }

    private function generateReceiptNumber()
    {
        do {
            $receiptNumber = 'RCP' . date('Ymd') . Str::random(6);
        } while (SavingsTransaction::where('receipt_number', $receiptNumber)->exists());

        return $receiptNumber;
    }
}
