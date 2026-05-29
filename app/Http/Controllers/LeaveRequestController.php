<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveRequestStoreRequest;
use App\Models\Employee;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LeaveRequestController extends Controller
{
    public function index(Request $request)
    {
        $leaveRequests = LeaveRequest::query()
            ->with(['employee.department', 'reviewer'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->string('type')))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $counts = [
            'pending' => LeaveRequest::pending()->count(),
            'approved' => LeaveRequest::approved()->count(),
            'rejected' => LeaveRequest::rejected()->count(),
        ];

        return view('leaves.index', compact('leaveRequests', 'counts'));
    }

    public function create()
    {
        $employees = Employee::orderBy('first_name')->get();

        return view('leaves.create', compact('employees'));
    }

    public function store(LeaveRequestStoreRequest $request)
    {
        $data = $request->validated();

        $start = Carbon::parse($data['start_date']);
        $end = Carbon::parse($data['end_date']);
        $data['days'] = $start->diffInDays($end) + 1;
        $data['status'] = 'pending';

        LeaveRequest::create($data);

        return redirect()->route('leaves.index')
            ->with('success', __('messages.common.created'));
    }

    public function show(LeaveRequest $leave)
    {
        $leave->load(['employee.department', 'reviewer']);

        return view('leaves.show', compact('leave'));
    }

    public function approve(LeaveRequest $leave, Request $request)
    {
        $this->review($leave, 'approved', $request->input('review_note'));

        return back()->with('success', __('messages.leaves.approved_msg'));
    }

    public function reject(LeaveRequest $leave, Request $request)
    {
        $this->review($leave, 'rejected', $request->input('review_note'));

        return back()->with('success', __('messages.leaves.rejected_msg'));
    }

    public function destroy(LeaveRequest $leave)
    {
        $leave->delete();

        return redirect()->route('leaves.index')
            ->with('success', __('messages.common.deleted'));
    }

    private function review(LeaveRequest $leave, string $status, ?string $note): void
    {
        $leave->update([
            'status' => $status,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'review_note' => $note,
        ]);

        // Reflect the employee status when they are currently approved for leave.
        if ($status === 'approved'
            && $leave->start_date->isToday()
            && $leave->employee->status === 'active') {
            $leave->employee->update(['status' => 'on_leave']);
        }
    }
}
