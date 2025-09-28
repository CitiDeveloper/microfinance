<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Branch;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::with(['role', 'payrollBranch'])->latest()->paginate(20);
        return view('staff.index', compact('staff'));
    }

    public function create()
    {
        $roles = Role::all();
        $branches = Branch::all();
        return view('staff.create', compact('roles', 'branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'staff_role_id' => 'required|exists:roles,id',
            'staff_payroll_branch_id' => 'required|exists:branches,id',
            'staff_firstname' => 'required|string|max:255',
            'staff_lastname' => 'required|string|max:255',
            'staff_email' => 'required|email|unique:staff,staff_email',
            'staff_gender' => 'required|in:Male,Female',
            'staff_show_results' => 'required|in:20,50,100,250,500',
            'staff_mobile' => 'nullable|string|max:20',
            'staff_dob' => 'nullable|date',
            'staff_address' => 'nullable|string',
            'staff_city' => 'nullable|string|max:255',
            'staff_province' => 'nullable|string|max:255',
            'staff_zipcode' => 'nullable|string|max:20',
            'staff_office_phone' => 'nullable|string|max:20',
            'staff_teams' => 'nullable|string|max:255',
            'access_branches' => 'required|array',
            'access_branches.*' => 'exists:branches,id',
        ]);

        $staff = Staff::create($validated);

        // Sync branches access
        $staff->branches()->sync($request->access_branches);

        return redirect()->route('staff.index')->with('success', 'Staff member created successfully.');
    }

    public function show(Staff $staff)
    {
        $staff->load(['role', 'payrollBranch', 'branches']);
        return view('staff.show', compact('staff'));
    }

    public function edit(Staff $staff)
    {
        $roles = Role::all();
        $branches = Branch::all();
        $staff->load('branches');
        return view('staff.edit', compact('staff', 'roles', 'branches'));
    }

    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'staff_role_id' => 'required|exists:roles,id',
            'staff_payroll_branch_id' => 'required|exists:branches,id',
            'staff_firstname' => 'required|string|max:255',
            'staff_lastname' => 'required|string|max:255',
            'staff_email' => 'required|email|unique:staff,staff_email,' . $staff->id,
            'staff_gender' => 'required|in:Male,Female',
            'staff_show_results' => 'required|in:20,50,100,250,500',
            'staff_mobile' => 'nullable|string|max:20',
            'staff_dob' => 'nullable|date',
            'staff_address' => 'nullable|string',
            'staff_city' => 'nullable|string|max:255',
            'staff_province' => 'nullable|string|max:255',
            'staff_zipcode' => 'nullable|string|max:20',
            'staff_office_phone' => 'nullable|string|max:20',
            'staff_teams' => 'nullable|string|max:255',
            'access_branches' => 'required|array',
            'access_branches.*' => 'exists:branches,id',
        ]);

        $staff->update($validated);
        $staff->branches()->sync($request->access_branches);

        return redirect()->route('staff.index')->with('success', 'Staff member updated successfully.');
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->route('staff.index')->with('success', 'Staff member deleted successfully.');
    }
}
