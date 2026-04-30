<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * List all stylists
     */
    public function index()
    {
        $employees = Employee::latest()->get();
        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Form to add a new stylist
     */
    public function create()
    {
        return view('admin.employees.form');
    }

    /**
     * Store a new stylist
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:20',
        ]);

        Employee::create($request->all());

        return redirect()->route('admin.employees.index')
            ->with('success', 'Stylist "' . $request->name . '" berhasil ditambahkan!');
    }

    /**
     * Form to edit a stylist
     */
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('admin.employees.form', compact('employee'));
    }

    /**
     * Update a stylist
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:20',
        ]);

        $employee->update($request->all());

        return redirect()->route('admin.employees.index')
            ->with('success', 'Stylist "' . $employee->name . '" berhasil diperbarui!');
    }

    /**
     * Delete a stylist
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $name = $employee->name;
        $employee->delete();

        return redirect()->route('admin.employees.index')
            ->with('success', 'Stylist "' . $name . '" berhasil dihapus.');
    }
}
