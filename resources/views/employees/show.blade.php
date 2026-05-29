<x-app-layout :title="$employee->full_name">

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <a href="{{ route('employees.index') }}" class="mb-3 inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700">
                <x-icon name="arrow-left" class="h-4 w-4 {{ app()->getLocale() === 'ur' ? 'rotate-180' : '' }}" />
                {{ __('messages.employees.title') }}
            </a>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('employees.edit', $employee) }}" class="btn-secondary">
                <x-icon name="edit" class="h-4 w-4" /> {{ __('messages.action.edit') }}
            </a>
            <form method="POST" action="{{ route('employees.destroy', $employee) }}"
                  onsubmit="return confirm('{{ __('messages.employees.delete_confirm', ['name' => $employee->full_name]) }}')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger">
                    <x-icon name="trash" class="h-4 w-4" /> {{ __('messages.action.delete') }}
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Profile card --}}
        <div class="lg:col-span-1">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 text-center shadow-card">
                <span class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-brand-100 text-2xl font-bold text-brand-700">
                    {{ $employee->initials }}
                </span>
                <h3 class="mt-4 text-lg font-bold text-slate-900">{{ $employee->full_name }}</h3>
                <p class="text-sm text-slate-500">{{ $employee->position }}</p>
                <div class="mt-3 flex justify-center"><x-emp-status :status="$employee->status" /></div>

                <dl class="mt-6 space-y-3 text-start">
                    <div class="flex items-center gap-3 text-sm">
                        <x-icon name="hash" class="h-4 w-4 shrink-0 text-slate-400" />
                        <span class="text-slate-600">{{ $employee->employee_code }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm">
                        <x-icon name="mail" class="h-4 w-4 shrink-0 text-slate-400" />
                        <a href="mailto:{{ $employee->email }}" class="truncate text-brand-600 hover:underline" dir="ltr">{{ $employee->email }}</a>
                    </div>
                    <div class="flex items-center gap-3 text-sm">
                        <x-icon name="phone" class="h-4 w-4 shrink-0 text-slate-400" />
                        <span class="text-slate-600" dir="ltr">{{ $employee->phone ?: __('messages.common.na') }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm">
                        <x-icon name="map-pin" class="h-4 w-4 shrink-0 text-slate-400" />
                        <span class="text-slate-600">{{ $employee->address ?: __('messages.common.na') }}</span>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Details + leave history --}}
        <div class="space-y-6 lg:col-span-2">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-card sm:p-6">
                <h3 class="mb-4 text-sm font-semibold text-slate-900">{{ __('messages.employees.sections.employment') }}</h3>
                <dl class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
                    @php
                        $tenure = $employee->hire_date->diffForHumans(['parts' => 2, 'short' => false, 'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE]);
                    @endphp
                    <div>
                        <dt class="text-xs uppercase tracking-wide text-slate-400">{{ __('messages.employees.field.department') }}</dt>
                        <dd class="mt-1 text-sm font-medium text-slate-900">{{ $employee->department->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-wide text-slate-400">{{ __('messages.employees.field.employment_type') }}</dt>
                        <dd class="mt-1 text-sm font-medium text-slate-900">{{ __('messages.employment.' . $employee->employment_type) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-wide text-slate-400">{{ __('messages.employees.field.hire_date') }}</dt>
                        <dd class="mt-1 text-sm font-medium text-slate-900">{{ $employee->hire_date->translatedFormat('d M Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-wide text-slate-400">{{ __('messages.employees.field.tenure') }}</dt>
                        <dd class="mt-1 text-sm font-medium text-slate-900">{{ $tenure }}</dd>
                    </div>
                    @if($employee->salary)
                        <div>
                            <dt class="text-xs uppercase tracking-wide text-slate-400">{{ __('messages.employees.field.salary') }}</dt>
                            <dd class="mt-1 text-sm font-medium text-slate-900">{{ __('messages.common.currency') }} {{ number_format($employee->salary) }} <span class="text-xs font-normal text-slate-400">{{ __('messages.common.per_month') }}</span></dd>
                        </div>
                    @endif
                </dl>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white shadow-card">
                <div class="border-b border-slate-100 px-5 py-4">
                    <h3 class="text-sm font-semibold text-slate-900">{{ __('messages.leaves.title') }}</h3>
                </div>
                @if($employee->leaveRequests->isEmpty())
                    <x-empty-state icon="calendar" :title="__('messages.leaves.empty')" />
                @else
                    <ul class="divide-y divide-slate-100">
                        @foreach($employee->leaveRequests as $leave)
                            <li>
                                <a href="{{ route('leaves.show', $leave) }}" class="flex items-center gap-3 px-5 py-3 hover:bg-slate-50">
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-500">
                                        <x-icon name="calendar" class="h-4 w-4" />
                                    </span>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-medium text-slate-900">{{ __('messages.leave_type.' . $leave->type) }}</p>
                                        <p class="text-xs text-slate-500">{{ $leave->start_date->translatedFormat('d M Y') }} – {{ $leave->end_date->translatedFormat('d M Y') }}</p>
                                    </div>
                                    <x-leave-status :status="$leave->status" />
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

</x-app-layout>
