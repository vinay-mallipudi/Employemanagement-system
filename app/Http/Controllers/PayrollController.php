<?php

namespace App\Http\Controllers;

use App\Models\PayRolls;
use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
             $payrolls = PayRolls::with('employee')->latest()->paginate(10);
        } else {
            $payrolls = PayRolls::where('employee_id', $user->employee->id)->with('employee')->latest()->paginate(10);
        }

        return view('admin.payroll.index', compact('payrolls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employees::where('status', 'active')->get();
        return view('admin.payroll.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'salary_amount' => 'required|numeric',
            'pay_period_start' => 'required|date',
            'pay_period_end' => 'required|date|after:pay_period_start',
        ]);
        
        // Prevent duplicate payroll for same period
         $exists = PayRolls::where('employee_id', $request->employee_id)
            ->where('pay_period_start', $request->pay_period_start)
            ->where('pay_period_end', $request->pay_period_end)
            ->exists();

        if ($exists) {
             return back()->withErrors(['pay_period_start' => 'Payroll for this employee and period already exists.']);
        }


        PayRolls::create($request->all());

        return redirect()->route('payroll.index')->with('success', 'Payroll created successfully.');
    }

     public function markAsPaid(PayRolls $payroll)
    {
        $payroll->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return back()->with('success', 'Payroll marked as paid.');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PayRolls $payroll)
    {
        $payroll->delete();
        return redirect()->route('payroll.index')->with('success', 'Payroll record deleted successfully.');
    }
}
