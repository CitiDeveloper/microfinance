<?php
// app/Http/Controllers/BorrowerController.php

namespace App\Http\Controllers;

use App\Models\Borrower;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BorrowerController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->get('search');

        $borrowers = Borrower::when($search, function ($query, $search) {
            return $query->search($search);
        })
            ->latest()
            ->paginate(20);

        return view('borrowers.index', compact('borrowers', 'search'));
    }

    public function create(): View
    {
        return view('borrowers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(Borrower::rules());

        // Ensure at least first name or business name is provided
        if (empty($validated['first_name']) && empty($validated['business_name'])) {
            return back()->withErrors([
                'first_name' => 'Either First Name or Business Name must be provided.',
                'business_name' => 'Either First Name or Business Name must be provided.'
            ])->withInput();
        }

        Borrower::create($validated);

        return redirect()->route('borrowers.index')
            ->with('success', 'Borrower created successfully.');
    }

    public function show(Borrower $borrower): View
    {
        // Eager load the loans relationship with related data
        $borrower->load([
            'loans.loanStatus',
            'loans.loanProduct',
            'loans.branch'
        ]);

        return view('borrowers.show', compact('borrower'));
    }

    public function edit(Borrower $borrower): View
    {
        return view('borrowers.edit', compact('borrower'));
    }

    public function update(Request $request, Borrower $borrower): RedirectResponse
    {
        $validated = $request->validate(Borrower::rules($borrower->id));

        // Ensure at least first name or business name is provided
        if (empty($validated['first_name']) && empty($validated['business_name'])) {
            return back()->withErrors([
                'first_name' => 'Either First Name or Business Name must be provided.',
                'business_name' => 'Either First Name or Business Name must be provided.'
            ])->withInput();
        }

        $borrower->update($validated);

        return redirect()->route('borrowers.index')
            ->with('success', 'Borrower updated successfully.');
    }

    public function destroy(Borrower $borrower): RedirectResponse
    {
        $borrower->delete();

        return redirect()->route('borrowers.index')
            ->with('success', 'Borrower deleted successfully.');
    }

    public function groups(): View
    {
        // This would typically fetch borrower groups
        return view('borrowers.groups');
    }
}
