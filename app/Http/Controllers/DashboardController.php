<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Departments;
use App\Models\Employees;
use App\Models\Leaves;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $totalEmployees = Employees::count();
            $totalDepartments = Departments::count();
            $pendingLeaves = Leaves::where('status', 'pending')->count();
            $presentToday = Attendance::whereDate('date', Carbon::today())->count();
            
            $recentAttendance = Attendance::with('employee.department')->latest()->take(5)->get();
            $recentLeaves = Leaves::with('employee')->latest()->take(5)->get();
        } else {
            // Employee Stats
            $employeeId = $user->employee->id??null;
            $totalEmployees = 0; // Not relevant
            $totalDepartments = 0; // Not relevant, maybe show something else?
            
            // Re-purposing variables closely or creating new ones
            // Let's keep it simple for now, maybe just hide some cards in view
            $pendingLeaves = Leaves::where('employee_id', $employeeId)->where('status', 'pending')->count();
            $presentToday = Attendance::where('employee_id', $employeeId)->whereDate('date', Carbon::today())->count(); // 1 if present, 0 if not
            
            $recentAttendance = Attendance::where('employee_id', $employeeId)->latest()->take(5)->get();
            $recentLeaves = Leaves::where('employee_id', $employeeId)->latest()->take(5)->get();
        }

        return view('dashboard', compact('totalEmployees', 'totalDepartments', 'pendingLeaves', 'presentToday', 'recentAttendance', 'recentLeaves'));
    }
}
