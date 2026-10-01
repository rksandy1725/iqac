<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with('hod')->withCount('users')->get();
        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        $users = User::where('role', 'faculty')->orderBy('name')->get();
        return view('admin.departments.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
            'code' => 'required|string|max:20|unique:departments,code',
            'description' => 'nullable|string',
            'hod_id' => 'nullable|exists:users,id',
        ]);

        Department::create($validated);

        return redirect()->route('admin.departments.index')->with('success', 'Department created successfully.');
    }

    public function edit(Department $department)
    {
        $users = User::orderBy('name')->get();
        return view('admin.departments.edit', compact('department', 'users'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
            'code' => 'required|string|max:20|unique:departments,code,' . $department->id,
            'description' => 'nullable|string',
            'hod_id' => 'nullable|exists:users,id',
        ]);

        $department->update($validated);

        return redirect()->route('admin.departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('admin.departments.index')->with('success', 'Department deleted successfully.');
    }
}
