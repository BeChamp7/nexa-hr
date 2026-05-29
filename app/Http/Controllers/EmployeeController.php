<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $employees = Employee::query()
            ->with('department')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search');
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('employee_code', 'like', "%{$search}%")
                        ->orWhere('position', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('department'), fn ($q) => $q->where('department_id', $request->integer('department')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->orderBy('first_name')
            ->paginate(10)
            ->withQueryString();

        $departments = Department::orderBy('name')->get();

        return view('employees.index', compact('employees', 'departments'));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();

        return view('employees.create', compact('departments'));
    }

    public function store(EmployeeRequest $request)
    {
        $data = $request->validated();
        $data['employee_code'] = $this->nextEmployeeCode();

        Employee::create($data);

        return redirect()->route('employees.index')
            ->with('success', __('messages.common.created'));
    }

    public function show(Employee $employee)
    {
        $employee->load(['department', 'leaveRequests' => fn ($q) => $q->latest()]);

        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $departments = Department::orderBy('name')->get();

        return view('employees.edit', compact('employee', 'departments'));
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->validated());

        return redirect()->route('employees.show', $employee)
            ->with('success', __('messages.common.updated'));
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', __('messages.common.deleted'));
    }

    private function nextEmployeeCode(): string
    {
        $last = Employee::orderByDesc('id')->value('employee_code');
        $number = $last ? ((int) Str::afterLast($last, '-')) + 1 : 1001;

        return 'EMP-' . str_pad((string) $number, 4, '0', STR_PAD_LEFT);
    }
}
