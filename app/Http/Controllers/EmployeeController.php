<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use App\Models\Employees;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employees::with('department')->latest()->paginate(10);
        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Departments::all();
        return view('admin.employees.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:255|unique:users,name',
            'password' => 'required|string|min:8|confirmed',
            'department_id' => 'nullable|exists:departments,id',
            'salary' => 'nullable|numeric',
            'contact_no'=>'required|numeric|digits:10',
            'birthday' => 'nullable|date',
            'experience_years' => 'nullable|integer',
            'status' => 'required|in:active,inactive,terminated',
            
        ]);

        // Create User
        $user = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'contact_no'=>$request->contact_no,
            'password' => Hash::make($request->password),
            'role' => 'employee', 
        ]);

        // Create Employee Profile
        Employees::create([
            'user_id' => $user->id,
            'department_id' => $request->department_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'contact_no' => $request->contact_no,
            'address' => $request->address,
            'birthday' => $request->birthday,
            'joining_date' => now(), // Default to today
            'salary' => $request->salary,
            'experience_years' => $request->experience_years,
            'status' => $request->status ?? 'active',
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employees $employee)
    {
        $departments = Departments::all();
        $employee->load('user'); // Load related user data
        return view('admin.employees.edit', compact('employee', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employees $employee)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($employee->user_id)],
            'department_id' => 'nullable|exists:departments,id',
            'salary' => 'nullable|numeric',
            'contact_no'=>'nullable|numeric|digits:10',
            'birthday' => 'nullable|date',
            'experience_years' => 'nullable|integer',
            'status' => 'required|in:active,inactive,terminated',
        ]);

        // Update User email if changed
        $employee->user->update([
            'email' => $request->email,
        ]);

        // Update Employee Profile
        $employee->update([
            'department_id' => $request->department_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'contact_no' => $request->contact_no,
            'address' => $request->address,
            'birthday' => $request->birthday,
            'salary' => $request->salary,
            'experience_years' => $request->experience_years,
            'status' => $request->status,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employees $employee)
    {
        // Delete user account (cascade will delete employee record if configured, but let's be safe)
        $employee->user->delete();
        // $employee->delete(); // Handled by cascade on user deletion if set up in DB

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
