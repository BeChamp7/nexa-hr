<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\LeaveRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_employees' => Employee::count(),
            'active_employees' => Employee::where('status', 'active')->count(),
            'pending_leaves' => LeaveRequest::pending()->count(),
            'approved_leaves' => LeaveRequest::approved()
                ->whereYear('start_date', now()->year)
                ->count(),
            'departments' => Department::count(),
        ];

        $headcount = Department::withCount('employees')
            ->orderByDesc('employees_count')
            ->get();

        $maxHeadcount = max($headcount->max('employees_count') ?? 0, 1);

        $recentRequests = LeaveRequest::with('employee.department')
            ->latest()
            ->take(6)
            ->get();

        return view('dashboard', compact('stats', 'headcount', 'maxHeadcount', 'recentRequests'));
    }
}
