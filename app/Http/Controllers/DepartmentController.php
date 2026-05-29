<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::withCount('employees')
            ->orderBy('name')
            ->get();

        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(DepartmentRequest $request)
    {
        $data = $request->validated();
        $data['code'] = strtoupper($data['code']);

        Department::create($data);

        return redirect()->route('departments.index')
            ->with('success', __('messages.common.created'));
    }

    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    public function update(DepartmentRequest $request, Department $department)
    {
        $data = $request->validated();
        $data['code'] = strtoupper($data['code']);

        $department->update($data);

        return redirect()->route('departments.index')
            ->with('success', __('messages.common.updated'));
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', __('messages.common.deleted'));
    }
}
