<?php

namespace App\Http\Controllers;

use App\Models\CollectionSheet;
use App\Models\CollectionSheetItem;
use App\Models\Loan;
use App\Models\Borrower;
use App\Models\Branch;
use App\Models\CollectionSheetLog;
use App\Models\Staff;
use App\Models\Repayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CollectionSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $collectionSheets = CollectionSheet::with(['branch', 'staff', 'items'])
            ->orderBy('collection_date', 'desc')
            ->paginate(20);

        return view('collection-sheets.index', compact('collectionSheets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::all();
        $staff = Staff::all();

        return view('collection-sheets.create', compact('branches', 'staff'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'staff_id' => 'required|exists:staff,id',
            'collection_date' => 'required|date',
            'sheet_type' => 'required|in:daily,weekly,custom',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $collectionSheet = CollectionSheet::create([
                'branch_id' => $validated['branch_id'],
                'staff_id' => $validated['staff_id'],
                'collection_date' => $validated['collection_date'],
                'sheet_type' => $validated['sheet_type'],
                'notes' => $validated['notes'],
                'status' => 'draft',
                'created_by' => auth()->id(),
            ]);

            // Generate collection sheet items based on due repayments
            $this->generateCollectionItems($collectionSheet);

            DB::commit();

            return redirect()->route('collection-sheets.show', $collectionSheet)
                ->with('success', 'Collection sheet created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create collection sheet: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CollectionSheet $collectionSheet)
    {
        $collectionSheet->load(['branch', 'staff', 'items.loan.borrower', 'items.repayment']);

        $summary = [
            'total_expected' => $collectionSheet->items->sum('expected_amount'),
            'total_collected' => $collectionSheet->items->sum('collected_amount'),
            'pending_count' => $collectionSheet->items->where('collection_status', 'pending')->count(),
            'collected_count' => $collectionSheet->items->where('collection_status', 'collected')->count(),
            'partial_count' => $collectionSheet->items->where('collection_status', 'partial')->count(),
            'missed_count' => $collectionSheet->items->where('collection_status', 'missed')->count(),
        ];

        return view('collection-sheets.show', compact('collectionSheet', 'summary'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CollectionSheet $collectionSheet)
    {
        if ($collectionSheet->status !== 'draft') {
            return redirect()->route('collection-sheets.show', $collectionSheet)
                ->with('error', 'Cannot edit a collection sheet that is not in draft status.');
        }

        $collectionSheet->load(['items.loan.borrower']);
        $branches = Branch::all();
        $staff = Staff::all();

        return view('collection-sheets.edit', compact('collectionSheet', 'branches', 'staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CollectionSheet $collectionSheet)
    {
        if ($collectionSheet->status !== 'draft') {
            return redirect()->route('collection-sheets.show', $collectionSheet)
                ->with('error', 'Cannot update a collection sheet that is not in draft status.');
        }

        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'staff_id' => 'required|exists:staff,id',
            'collection_date' => 'required|date',
            'sheet_type' => 'required|in:daily,weekly,custom',
            'notes' => 'nullable|string',
        ]);

        $collectionSheet->update($validated);

        return redirect()->route('collection-sheets.show', $collectionSheet)
            ->with('success', 'Collection sheet updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CollectionSheet $collectionSheet)
    {
        if ($collectionSheet->status !== 'draft') {
            return redirect()->route('collection-sheets.show', $collectionSheet)
                ->with('error', 'Cannot delete a collection sheet that is not in draft status.');
        }

        $collectionSheet->delete();

        return redirect()->route('collection-sheets.index')
            ->with('success', 'Collection sheet deleted successfully.');
    }

    /**
     * Display daily collection sheet
     */
    public function daily()
    {
        $today = Carbon::today();
        $branchId = auth()->user()->branch_id ?? null; // fallback

        $dueRepayments = Loan::when($branchId, fn($q) => $q->where('branch_id', $branchId))
            ->active() // uses scopeActive() on Loan model
            ->whereHas('repaymentSchedule', function ($query) use ($today) {
                // Repayment model uses payment_date and status
                $query->where('payment_date', $today->toDateString())
                    ->where('status', 'pending');
            })
            ->with(['borrower', 'repaymentSchedule' => function ($query) use ($today) {
                $query->where('payment_date', $today->toDateString())
                    ->where('status', 'pending');
            }])
            ->get();

        $summary = [
            'total_expected' => $dueRepayments->sum(function ($loan) {
                return $loan->repaymentSchedule->sum('amount'); // repayment.amount
            }),
            'total_borrowers' => $dueRepayments->count(),
        ];

        return view('collection-sheets.daily', compact('dueRepayments', 'today', 'summary'));
    }


    /**
     * Display missed repayment sheet
     */
    public function missed()
    {
        $branchId = auth()->user()->branch_id ?? null;

        $missedRepayments = Loan::when($branchId, fn($q) => $q->where('branch_id', $branchId))
            ->active()
            ->whereHas('repaymentSchedule', function ($query) {
                $query->where('payment_date', '<', Carbon::today()->toDateString())
                    ->where('status', 'pending');
            })
            ->with(['borrower', 'repaymentSchedule' => function ($query) {
                $query->where('payment_date', '<', Carbon::today()->toDateString())
                    ->where('status', 'pending')
                    ->orderBy('payment_date');
            }])
            ->get();

        $summary = [
            'total_overdue' => $missedRepayments->sum(function ($loan) {
                return $loan->repaymentSchedule->sum('amount');
            }),
            'total_borrowers' => $missedRepayments->count(),
            'oldest_overdue' => $missedRepayments->flatMap->repaymentSchedule->min('payment_date'),
        ];

        return view('collection-sheets.missed', compact('missedRepayments', 'summary'));
    }


    /**
     * Display past maturity date loans
     */
    public function pastMaturity()
    {
        $branchId = 1;

        $pastMaturityLoans = Loan::where('branch_id', $branchId)
            ->where('loan_due_date', '<', Carbon::today())
            ->with(['borrower', 'loanProduct'])
            ->orderBy('loan_due_date')
            ->get();

        $summary = [
            'total_outstanding' => $pastMaturityLoans->sum('outstanding_balance'),
            'total_loans' => $pastMaturityLoans->count(),
            'oldest_maturity' => $pastMaturityLoans->min('loan_due_date'),
        ];

        return view('collection-sheets.past-maturity', compact('pastMaturityLoans', 'summary'));
    }

    /**
     * Process collection for a sheet
     */
    public function processCollection(Request $request, CollectionSheet $collectionSheet)
    {
        $validated = $request->validate([
            'collection_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // recalc total_collected from items (fresh)
            $collectionSheet->refresh();
            $totalCollected = $collectionSheet->items()->sum('collected_amount');

            $collectionSheet->update([
                'status' => 'completed',
                'collection_date' => $validated['collection_date'],
                'total_collected' => $totalCollected,
            ]);

            // Process each collected item
            foreach ($collectionSheet->items as $item) {
                if ($item->collection_status === 'collected' && $item->repayment_id) {
                    $repayment = Repayment::find($item->repayment_id);
                    if ($repayment) {
                        $repayment->update([
                            'status' => 'posted', // or 'paid' depending on your system convention
                            'posted_at' => $validated['collection_date'],
                            'amount' => $item->collected_amount,
                            'payment_date' => $validated['collection_date'],
                        ]);
                    }
                }
            }

            // Log the collection
            CollectionSheetLog::create([
                'collection_sheet_id' => $collectionSheet->id,
                'action' => 'collection_processed',
                'details' => 'Collection sheet processed and marked as completed',
                'performed_by' => auth()->id(),
                'performed_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('collection-sheets.show', $collectionSheet)
                ->with('success', 'Collection processed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to process collection: ' . $e->getMessage());
        }
    }

    /**
     * Update individual collection item
     */
    public function updateCollection(Request $request, CollectionSheetItem $item)
    {
        $validated = $request->validate([
            'collected_amount' => 'required|numeric|min:0',
            'collection_status' => 'required|in:pending,collected,partial,missed',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $item->update($validated);

            // Log the update
            CollectionSheetLog::create([
                'collection_sheet_id' => $item->collection_sheet_id,
                'action' => 'item_updated',
                'details' => "Updated collection for loan {$item->loan_id}: {$validated['collection_status']} - {$validated['collected_amount']}",
                'performed_by' => auth()->id(),
                'performed_at' => now(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Collection updated successfully.',
                'item' => $item->fresh()
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update collection: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate collection items for a sheet
     */
    private function generateCollectionItems(CollectionSheet $collectionSheet)
    {
        // Only create items if they don't already exist for this sheet+date
        $existingCount = $collectionSheet->items()->count();
        if ($existingCount > 0) {
            return;
        }

        $dueLoans = Loan::where('branch_id', $collectionSheet->branch_id)
            ->active()
            ->whereHas('repaymentSchedule', function ($query) use ($collectionSheet) {
                // use payment_date (Repayment model)
                $query->where('payment_date', $collectionSheet->collection_date)
                    ->where('status', 'pending');
            })
            ->with(['repaymentSchedule' => function ($query) use ($collectionSheet) {
                $query->where('payment_date', $collectionSheet->collection_date)
                    ->where('status', 'pending');
            }])
            ->get();

        foreach ($dueLoans as $loan) {
            foreach ($loan->repaymentSchedule as $repayment) {
                CollectionSheetItem::create([
                    'collection_sheet_id' => $collectionSheet->id,
                    'loan_id' => $loan->id,
                    'borrower_id' => $loan->borrower_id,
                    'expected_amount' => $repayment->amount,      // use amount column
                    'collected_amount' => 0,
                    'collection_status' => 'pending',
                    'collection_date' => $collectionSheet->collection_date,
                    'repayment_id' => $repayment->id,
                ]);
            }
        }
    }

    /**
     * Export collection sheet to PDF
     */
    public function exportPdf(CollectionSheet $collectionSheet)
    {
        $collectionSheet->load(['branch', 'staff', 'items.loan.borrower']);

        // You would typically use a PDF library like dompdf or barryvdh/laravel-dompdf
        // This is a placeholder for PDF generation logic

        return response()->streamDownload(function () use ($collectionSheet) {
            echo view('collection-sheets.pdf', compact('collectionSheet'))->render();
        }, "collection-sheet-{$collectionSheet->id}.pdf");
    }
}
