<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function index()
    {
        $bankAccounts = BankAccount::latest()->paginate(10);
        return view('bank_accounts.index', compact('bankAccounts'));
    }

    public function create()
    {
        return view('bank_accounts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'coa_code' => 'required|string|min:4|max:4|unique:bank_accounts,coa_code',
            'coa_name' => 'required|string|max:255',
            'coa_default_categories' => 'nullable|array',
            'access_branches' => 'required|array',
        ]);

        BankAccount::create($validated);

        return redirect()->route('bank_accounts.index')->with('success', 'Bank Account created successfully.');
    }

    public function show(BankAccount $bankAccount)
    {
        return view('bank_accounts.show', compact('bankAccount'));
    }

    public function edit(BankAccount $bankAccount)
    {
        return view('bank_accounts.edit', compact('bankAccount'));
    }

    public function update(Request $request, BankAccount $bankAccount)
    {
        $validated = $request->validate([
            'coa_code' => 'required|string|min:4|max:4|unique:bank_accounts,coa_code,' . $bankAccount->id,
            'coa_name' => 'required|string|max:255',
            'coa_default_categories' => 'nullable|array',
            'access_branches' => 'required|array',
        ]);

        $bankAccount->update($validated);

        return redirect()->route('bank_accounts.index')->with('success', 'Bank Account updated successfully.');
    }

    public function destroy(BankAccount $bankAccount)
    {
        $bankAccount->delete();
        return redirect()->route('bank_accounts.index')->with('success', 'Bank Account deleted successfully.');
    }
}
