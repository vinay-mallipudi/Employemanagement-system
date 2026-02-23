<?php
namespace App\Http\Controllers;

use App\Models\Announcements;
use App\Models\Attendance;
use App\Models\Departments;
use App\Models\Employees;
use App\Models\Leaves;
use App\Models\PayRolls;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $now  = Carbon::now();

        // Default values
        $totalEmployees    = 0;
        $totalDepartments  = 0;
        $pendingLeaves     = 0;
        $approvedLeaves    = 0;
        $presentToday      = 0;
        $monthlyAttendance = 0;
        $announcements     = 0;
        $pendingApprovals  = 0;
        $pendingPayrolls = 0;
        $recentAttendance  = collect();
        $recentLeaves      = collect();

        if ($user->isAdmin()) {

            $totalEmployees   = Employees::count();
            $totalDepartments = Departments::count();

            $pendingLeaves  = Leaves::where('status', 'pending')->count();
            $approvedLeaves = Leaves::where('status', 'approved')->count();

            $presentToday     = Attendance::whereDate('date', Carbon::today())->count();
            $pendingApprovals = Leaves::where('status', 'pending')
                ->whereDate('created_at', today())
                ->count();

            $pendingPayrolls = PayRolls::where('status', 'pending')
                ->count();

            $monthlyAttendance = Attendance::whereMonth('date', $now->month)
                ->whereYear('date', $now->year)
                ->count();

            $announcements = Announcements::count();

            $recentAttendance = Attendance::with('employee.department')
                ->latest()
                ->take(5)
                ->get();

            $recentLeaves = Leaves::with('employee')
                ->latest()
                ->take(5)
                ->get();
        } else {

            $employeeId = $user->employee?->id;

            if (! $employeeId) {
                abort(403, 'Employee record not found.');
            }

            $pendingLeaves = Leaves::where('employee_id', $employeeId)
                ->where('status', 'pending')
                ->count();

            $approvedLeaves = Leaves::where('employee_id', $employeeId)
                ->where('status', 'approved')
                ->count();

            $presentToday = Attendance::where('employee_id', $employeeId)
                ->whereDate('date', Carbon::today())
                ->count();

            $monthlyAttendance = Attendance::where('employee_id', $employeeId)
                ->whereMonth('date', $now->month)
                ->whereYear('date', $now->year)
                ->count();

            $announcements = Announcements::count();

            $recentAttendance = Attendance::where('employee_id', $employeeId)
                ->latest()
                ->take(5)
                ->get();

            $recentLeaves = Leaves::where('employee_id', $employeeId)
                ->latest()
                ->take(5)
                ->get();
        }

        return view('dashboard', compact(
            'totalEmployees',
            'totalDepartments',
            'announcements',
            'monthlyAttendance',
            'pendingLeaves',
            'approvedLeaves',
            'presentToday',
            'recentAttendance',
            'recentLeaves',
            'pendingApprovals',
            'pendingPayrolls'
        ));
    }
}
