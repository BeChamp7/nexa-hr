@php($employee = $employee ?? null)

<div class="space-y-6">
    {{-- Personal --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-card sm:p-6">
        <h3 class="mb-4 text-sm font-semibold text-slate-900">{{ __('messages.employees.sections.personal') }}</h3>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <x-field name="first_name" :label="__('messages.employees.field.first_name')" :required="true">
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $employee?->first_name) }}" class="form-input" required>
            </x-field>
            <x-field name="last_name" :label="__('messages.employees.field.last_name')" :required="true">
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $employee?->last_name) }}" class="form-input" required>
            </x-field>
            <x-field name="email" :label="__('messages.employees.field.email')" :required="true">
                <input type="email" id="email" name="email" value="{{ old('email', $employee?->email) }}" class="form-input" required>
            </x-field>
            <x-field name="phone" :label="__('messages.employees.field.phone')">
                <input type="text" id="phone" name="phone" value="{{ old('phone', $employee?->phone) }}" class="form-input" dir="ltr">
            </x-field>
        </div>
    </div>

    {{-- Employment --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-card sm:p-6">
        <h3 class="mb-4 text-sm font-semibold text-slate-900">{{ __('messages.employees.sections.employment') }}</h3>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <x-field name="department_id" :label="__('messages.employees.field.department')" :required="true">
                <select id="department_id" name="department_id" class="form-select" required>
                    <option value="">—</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" @selected(old('department_id', $employee?->department_id) == $dept->id)>{{ $dept->name }}</option>
                    @endforeach
                </select>
            </x-field>
            <x-field name="position" :label="__('messages.employees.field.position')" :required="true">
                <input type="text" id="position" name="position" value="{{ old('position', $employee?->position) }}" class="form-input" required>
            </x-field>
            <x-field name="employment_type" :label="__('messages.employees.field.employment_type')" :required="true">
                <select id="employment_type" name="employment_type" class="form-select" required>
                    @foreach(['full_time', 'part_time', 'contract'] as $type)
                        <option value="{{ $type }}" @selected(old('employment_type', $employee?->employment_type ?? 'full_time') === $type)>{{ __('messages.employment.' . $type) }}</option>
                    @endforeach
                </select>
            </x-field>
            <x-field name="hire_date" :label="__('messages.employees.field.hire_date')" :required="true">
                <input type="date" id="hire_date" name="hire_date" value="{{ old('hire_date', $employee?->hire_date?->format('Y-m-d')) }}" class="form-input" required>
            </x-field>
            <x-field name="salary" :label="__('messages.employees.field.salary')">
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 flex items-center text-xs text-slate-400 {{ app()->getLocale() === 'ur' ? 'end-3' : 'start-3' }}">{{ __('messages.common.currency') }}</span>
                    <input type="number" step="0.01" id="salary" name="salary" value="{{ old('salary', $employee?->salary) }}" class="form-input {{ app()->getLocale() === 'ur' ? 'pe-12' : 'ps-12' }}">
                </div>
            </x-field>
            <x-field name="status" :label="__('messages.employees.field.status')" :required="true">
                <select id="status" name="status" class="form-select" required>
                    @foreach(['active', 'on_leave', 'inactive'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $employee?->status ?? 'active') === $status)>{{ __('messages.status.' . $status) }}</option>
                    @endforeach
                </select>
            </x-field>
        </div>
    </div>

    {{-- Contact --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-card sm:p-6">
        <h3 class="mb-4 text-sm font-semibold text-slate-900">{{ __('messages.employees.sections.contact') }}</h3>
        <x-field name="address" :label="__('messages.employees.field.address')">
            <input type="text" id="address" name="address" value="{{ old('address', $employee?->address) }}" class="form-input">
        </x-field>
    </div>

    <div class="flex items-center justify-end gap-3">
        <a href="{{ $employee ? route('employees.show', $employee) : route('employees.index') }}" class="btn-secondary">{{ __('messages.action.cancel') }}</a>
        <button type="submit" class="btn-primary">
            <x-icon name="check" class="h-4 w-4" />
            {{ $employee ? __('messages.action.save_changes') : __('messages.action.save') }}
        </button>
    </div>
</div>
