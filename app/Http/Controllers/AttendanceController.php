<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employees;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->isAdmin()) {
            $attendances = Attendance::with('employee')->latest()->paginate(10);
        } else {
             $attendances = Attendance::where('employee_id', $user->employee->id)->with('employee')->latest()->paginate(10);
        }
        return view('admin.attendance.index', compact('attendances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employees::where('status', 'active')->get();
        return view('admin.attendance.create', compact('employees'));
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
            'date' => 'required|date',
            'clock_in' => 'nullable|date_format:H:i',
            'clock_out' => 'nullable|date_format:H:i|after:clock_in',
        ]);

        // Check if attendance already exists for this employee on this date
        $exists = Attendance::where('employee_id', $request->employee_id)
            ->where('date', $request->date)
            ->exists();
            
        if ($exists) {
            return back()->withErrors(['date' => 'Attendance for this date already exists.']);
        }

        $attendance = Attendance::create($request->all());
        $attendance->calculateTotalHours();
        $attendance->save();

        return redirect()->route('attendance.index')->with('success', 'Attendance recorded successfully.');
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
    public function edit(Attendance $attendance)
    {
        $employees = Employees::where('status', 'active')->get();
        return view('admin.attendance.edit', compact('attendance', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
         $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'clock_in' => 'nullable|date_format:H:i:s', // Allows H:i:s
            'clock_out' => 'nullable|date_format:H:i:s|after:clock_in', // Allows H:i:s
        ]);

        $attendance->update($request->all());

        return redirect()->route('attendance.index')->with('success', 'Attendance updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('attendance.index')->with('success', 'Attendance record deleted successfully.');
    }
}
