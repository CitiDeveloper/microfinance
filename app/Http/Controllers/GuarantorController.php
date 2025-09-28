<?php

namespace App\Http\Controllers;

use App\Models\Guarantor;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GuarantorController extends Controller
{
    public function index()
    {
        $guarantors = Guarantor::with(['branch', 'creator'])
            ->latest()
            ->paginate(20);

        return view('guarantors.index', compact('guarantors'));
    }

    public function create()
    {
        $branches = Branch::all();
        return view('guarantors.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'business_name' => 'nullable|string|max:255',
            'unique_number' => 'nullable|string|max:255|unique:guarantors,unique_number',
            'gender' => 'nullable|in:Male,Female,Nonbinary,Other,Decline to state',
            'title' => 'nullable|in:Mr.,Mrs.,Miss,Ms.,Dr.,Prof.,Rev.',
            'mobile' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'zipcode' => 'nullable|string|max:20',
            'landline' => 'nullable|string|max:20',
            'working_status' => 'nullable|in:Employee,Government Employee,Private Sector Employee,Owner,Student,Overseas Worker,Pensioner,Unemployed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string|max:1000',
            'branch_id' => 'required|exists:branches,id',
        ]);

        // Handle file upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('guarantors/photos', 'public');
        }

        // Handle multiple files
        if ($request->hasFile('files')) {
            $filePaths = [];
            foreach ($request->file('files') as $file) {
                $filePaths[] = $file->store('guarantors/files', 'public');
            }
            $validated['files'] = $filePaths;
        }

        $validated['created_by'] = Auth::id();

        Guarantor::create($validated);

        return redirect()->route('guarantors.index')
            ->with('success', 'Guarantor created successfully.');
    }

    public function show(Guarantor $guarantor)
    {
        return view('guarantors.show', compact('guarantor'));
    }

    public function edit(Guarantor $guarantor)
    {
        $branches = Branch::all();
        return view('guarantors.edit', compact('guarantor', 'branches'));
    }

    public function update(Request $request, Guarantor $guarantor)
    {
        $validated = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'business_name' => 'nullable|string|max:255',
            'unique_number' => 'nullable|string|max:255|unique:guarantors,unique_number,' . $guarantor->id,
            'gender' => 'nullable|in:Male,Female,Nonbinary,Other,Decline to state',
            'title' => 'nullable|in:Mr.,Mrs.,Miss,Ms.,Dr.,Prof.,Rev.',
            'mobile' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'zipcode' => 'nullable|string|max:20',
            'landline' => 'nullable|string|max:20',
            'working_status' => 'nullable|in:Employee,Government Employee,Private Sector Employee,Owner,Student,Overseas Worker,Pensioner,Unemployed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string|max:1000',
            'branch_id' => 'required|exists:branches,id',
        ]);

        // Handle file upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($guarantor->photo) {
                Storage::disk('public')->delete($guarantor->photo);
            }
            $validated['photo'] = $request->file('photo')->store('guarantors/photos', 'public');
        }

        $guarantor->update($validated);

        return redirect()->route('guarantors.index')
            ->with('success', 'Guarantor updated successfully.');
    }

    public function destroy(Guarantor $guarantor)
    {
        $guarantor->delete();

        return redirect()->route('guarantors.index')
            ->with('success', 'Guarantor deleted successfully.');
    }
}
