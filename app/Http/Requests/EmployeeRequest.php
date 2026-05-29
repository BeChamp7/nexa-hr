<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $employeeId = $this->route('employee')?->id;

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('employees', 'email')->ignore($employeeId)],
            'phone' => ['nullable', 'string', 'max:40'],
            'department_id' => ['required', 'exists:departments,id'],
            'position' => ['required', 'string', 'max:255'],
            'employment_type' => ['required', Rule::in(['full_time', 'part_time', 'contract'])],
            'hire_date' => ['required', 'date'],
            'salary' => ['nullable', 'numeric', 'min:0', 'max:99999999'],
            'status' => ['required', Rule::in(['active', 'on_leave', 'inactive'])],
            'address' => ['nullable', 'string', 'max:255'],
        ];
    }
}
