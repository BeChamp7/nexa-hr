<x-app-layout :title="__('messages.employees.title')">

    <x-page-header :title="__('messages.employees.title')" :subtitle="__('messages.employees.subtitle')">
        <x-slot name="actions">
            <a href="{{ route('employees.create') }}" class="btn-primary">
                <x-icon name="plus" class="h-4 w-4" />
                {{ __('messages.employees.add') }}
            </a>
        </x-slot>
    </x-page-header>

    <div class="rounded-2xl border border-slate-200 bg-white shadow-card">
        {{-- Filters --}}
        <form method="GET" class="flex flex-col gap-3 border-b border-slate-100 p-4 sm:flex-row sm:items-center">
            <div class="relative flex-1">
                <span class="pointer-events-none absolute inset-y-0 flex items-center text-slate-400 {{ app()->getLocale() === 'ur' ? 'end-3' : 'start-3' }}">
                    <x-icon name="search" class="h-4 w-4" />
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="{{ __('messages.employees.search_placeholder') }}"
                       class="form-input {{ app()->getLocale() === 'ur' ? 'pe-9' : 'ps-9' }}">
            </div>
            <select name="department" class="form-select sm:w-48" onchange="this.form.submit()">
                <option value="">{{ __('messages.employees.all_departments') }}</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" @selected(request('department') == $dept->id)>{{ $dept->name }}</option>
                @endforeach
            </select>
            <select name="status" class="form-select sm:w-40" onchange="this.form.submit()">
                <option value="">{{ __('messages.employees.all_statuses') }}</option>
                @foreach(['active', 'on_leave', 'inactive'] as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ __('messages.status.' . $status) }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-secondary">{{ __('messages.action.search') }}</button>
            @if(request()->hasAny(['search', 'department', 'status']))
                <a href="{{ route('employees.index') }}" class="btn-secondary">{{ __('messages.action.reset') }}</a>
            @endif
        </form>

        @if($employees->isEmpty())
            <x-empty-state icon="users" :title="__('messages.employees.empty')" :message="__('messages.employees.empty_cta')">
                <x-slot name="action">
                    <a href="{{ route('employees.create') }}" class="btn-primary">
                        <x-icon name="plus" class="h-4 w-4" /> {{ __('messages.employees.add') }}
                    </a>
                </x-slot>
            </x-empty-state>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-start text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 text-xs uppercase tracking-wide text-slate-500">
                            <th class="px-5 py-3 text-start font-medium">{{ __('messages.employees.field.name') }}</th>
                            <th class="px-5 py-3 text-start font-medium">{{ __('messages.employees.field.department') }}</th>
                            <th class="px-5 py-3 text-start font-medium">{{ __('messages.employees.field.position') }}</th>
                            <th class="hidden px-5 py-3 text-start font-medium lg:table-cell">{{ __('messages.employees.field.employment_type') }}</th>
                            <th class="px-5 py-3 text-start font-medium">{{ __('messages.employees.field.status') }}</th>
                            <th class="px-5 py-3 text-end font-medium">{{ __('messages.action.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($employees as $employee)
                            <tr class="transition-colors hover:bg-slate-50/70">
                                <td class="px-5 py-3">
                                    <a href="{{ route('employees.show', $employee) }}" class="flex items-center gap-3">
                                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-100 text-xs font-semibold text-brand-700">
                                            {{ $employee->initials }}
                                        </span>
                                        <div class="min-w-0">
                                            <p class="truncate font-medium text-slate-900">{{ $employee->full_name }}</p>
                                            <p class="truncate text-xs text-slate-500">{{ $employee->employee_code }}</p>
                                        </div>
                                    </a>
                                </td>
                                <td class="px-5 py-3 text-slate-600">{{ $employee->department->name }}</td>
                                <td class="px-5 py-3 text-slate-600">{{ $employee->position }}</td>
                                <td class="hidden px-5 py-3 text-slate-600 lg:table-cell">{{ __('messages.employment.' . $employee->employment_type) }}</td>
                                <td class="px-5 py-3"><x-emp-status :status="$employee->status" /></td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('employees.show', $employee) }}" class="rounded-md p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-700" title="{{ __('messages.action.view') }}">
                                            <x-icon name="eye" class="h-4 w-4" />
                                        </a>
                                        <a href="{{ route('employees.edit', $employee) }}" class="rounded-md p-1.5 text-slate-400 hover:bg-slate-100 hover:text-brand-600" title="{{ __('messages.action.edit') }}">
                                            <x-icon name="edit" class="h-4 w-4" />
                                        </a>
                                        <form method="POST" action="{{ route('employees.destroy', $employee) }}"
                                              onsubmit="return confirm('{{ __('messages.employees.delete_confirm', ['name' => $employee->full_name]) }}')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="rounded-md p-1.5 text-slate-400 hover:bg-rose-50 hover:text-rose-600" title="{{ __('messages.action.delete') }}">
                                                <x-icon name="trash" class="h-4 w-4" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-100 px-5 py-3">
                {{ $employees->links() }}
            </div>
        @endif
    </div>

</x-app-layout>
