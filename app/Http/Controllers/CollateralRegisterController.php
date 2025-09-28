<?php
// app/Http/Controllers/CollateralRegisterController.php

namespace App\Http\Controllers;

use App\Models\CollateralRegister;
use App\Models\Loan;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CollateralRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $collaterals = CollateralRegister::with(['loan', 'creator'])
            ->latest()
            ->paginate(15);

        return view('collateral.index', compact('collaterals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $loans = Loan::where('status', 'active')->get();
        $collateralTypes = [
            'Land' => 'Land',
            'Building' => 'Building',
            'Vehicle' => 'Vehicle',
            'Equipment' => 'Equipment',
            'Jewelry' => 'Jewelry',
            'Electronics' => 'Electronics',
            'Livestock' => 'Livestock',
            'Crops' => 'Crops',
            'Savings' => 'Savings',
            'Guarantor' => 'Guarantor',
            'Other' => 'Other'
        ];

        return view('collateral.create', compact('loans', 'collateralTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'collateral_type' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'estimated_value' => 'required|numeric|min:0',
            'location' => 'nullable|string|max:500',
            'condition' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'registration_number' => 'nullable|string|max:255',
            'acquisition_date' => 'nullable|date',
            'last_valuation_date' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);

        $documentPath = null;
        if ($request->hasFile('document')) {
            $documentPath = $request->file('document')->store('collateral-documents', 'public');
        }

        CollateralRegister::create([
            ...$validated,
            'document_path' => $documentPath,
            'created_by' => Auth::id(),
            'status' => 'active',
        ]);

        return redirect()->route('collateral.index')
            ->with('success', 'Collateral registered successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CollateralRegister $collateral)
    {
        $collateral->load(['loan.borrower', 'creator']);
        return view('collateral.show', compact('collateral'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CollateralRegister $collateral)
    {
        $loans = Loan::where('status', 'active')->get();
        $collateralTypes = [
            'Land' => 'Land',
            'Building' => 'Building',
            'Vehicle' => 'Vehicle',
            'Equipment' => 'Equipment',
            'Jewelry' => 'Jewelry',
            'Electronics' => 'Electronics',
            'Livestock' => 'Livestock',
            'Crops' => 'Crops',
            'Savings' => 'Savings',
            'Guarantor' => 'Guarantor',
            'Other' => 'Other'
        ];

        return view('collateral.edit', compact('collateral', 'loans', 'collateralTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CollateralRegister $collateral)
    {
        $validated = $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'collateral_type' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'estimated_value' => 'required|numeric|min:0',
            'location' => 'nullable|string|max:500',
            'condition' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'registration_number' => 'nullable|string|max:255',
            'acquisition_date' => 'nullable|date',
            'last_valuation_date' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
            'status' => 'required|in:active,released,seized,sold',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);

        if ($request->hasFile('document')) {
            // Delete old document if exists
            if ($collateral->document_path) {
                Storage::disk('public')->delete($collateral->document_path);
            }
            $documentPath = $request->file('document')->store('collateral-documents', 'public');
            $validated['document_path'] = $documentPath;
        }

        $collateral->update($validated);

        return redirect()->route('collateral.index')
            ->with('success', 'Collateral updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CollateralRegister $collateral)
    {
        // Delete associated document
        if ($collateral->document_path) {
            Storage::disk('public')->delete($collateral->document_path);
        }

        $collateral->delete();

        return redirect()->route('collateral.index')
            ->with('success', 'Collateral deleted successfully!');
    }

    /**
     * Download collateral document
     */
    public function downloadDocument(CollateralRegister $collateral)
    {
        if (!$collateral->document_path || !Storage::disk('public')->exists($collateral->document_path)) {
            return redirect()->back()->with('error', 'Document not found.');
        }

        return Storage::disk('public')->download($collateral->document_path);
    }
}
