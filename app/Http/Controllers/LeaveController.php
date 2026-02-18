<?php

namespace App\Http\Controllers;

use App\Models\Leaves;
use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $leaves = Leaves::with('employee')->latest()->paginate(10);
        } else {
            $leaves = Leaves::where('employee_id', $user->employee->id)->with('employee')->latest()->paginate(10);
        }
        
        return view('admin.leaves.index', compact('leaves'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employees::where('status', 'active')->get();
        return view('admin.leaves.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            $request->merge(['employee_id' => $user->employee->id]);
        }

        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type' => 'required|string',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'reason' => 'required|string',
        ]);

        Leaves::create($request->all());

        return redirect()->route('leaves.index')->with('success', 'Leave request submitted successfully.');
    }


    public function updateStatus(Request $request, Leaves $leave)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending',
        ]);

        $leave->update([
            'status' => $request->status,
            'approved_by' => Auth::id(),
        ]);

        return back()->with('success', 'Leave status updated successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leaves $leave)
    {
          $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type' => 'required|string',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'reason' => 'required|string',
             'status' => 'required|in:approved,rejected,pending',
        ]);

         $leave->update([
            'employee_id' => $request->employee_id,
            'leave_type' => $request->leave_type,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'reason' => $request->reason,
            'status' => $request->status,
            'approved_by' => Auth::id(),
        ]);

        return redirect()->route('leaves.index')->with('success', 'Leave updated successfully.');
    }

      /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leaves $leave)
    {
        $employees = Employees::where('status', 'active')->get();
        
        return view('admin.leaves.edit', compact('leave', 'employees'));
    }

    public function destroy(Leaves $leave)
    {
        $leave->delete();
        return redirect()->route('leaves.index')->with('success', 'Leave request deleted successfully.');
    }
}
