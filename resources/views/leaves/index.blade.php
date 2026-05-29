<x-app-layout :title="__('messages.leaves.title')">

    <x-page-header :title="__('messages.leaves.title')" :subtitle="__('messages.leaves.subtitle')">
        <x-slot name="actions">
            <a href="{{ route('leaves.create') }}" class="btn-primary">
                <x-icon name="plus" class="h-4 w-4" />
                {{ __('messages.leaves.add') }}
            </a>
        </x-slot>
    </x-page-header>

    {{-- Status filter tabs --}}
    @php $current = request('status'); @endphp
    <div class="mb-4 flex flex-wrap items-center gap-2">
        <a href="{{ route('leaves.index') }}"
           class="rounded-lg border px-3 py-1.5 text-sm font-medium {{ !$current ? 'border-brand-600 bg-brand-50 text-brand-700' : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50' }}">
            {{ __('messages.common.all') }}
        </a>
        @php
            $countBadge = [
                'pending' => 'bg-amber-100 text-amber-700',
                'approved' => 'bg-emerald-100 text-emerald-700',
                'rejected' => 'bg-rose-100 text-rose-700',
            ];
        @endphp
        @foreach(['pending', 'approved', 'rejected'] as $status)
            <a href="{{ route('leaves.index', ['status' => $status]) }}"
               class="flex items-center gap-2 rounded-lg border px-3 py-1.5 text-sm font-medium {{ $current === $status ? 'border-brand-600 bg-brand-50 text-brand-700' : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50' }}">
                {{ __('messages.leave_status.' . $status) }}
                <span class="rounded-full px-1.5 text-xs {{ $countBadge[$status] }}">{{ $counts[$status] }}</span>
            </a>
        @endforeach
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white shadow-card">
        @if($leaveRequests->isEmpty())
            <x-empty-state icon="calendar" :title="__('messages.leaves.empty')" />
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-start text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 text-xs uppercase tracking-wide text-slate-500">
                            <th class="px-5 py-3 text-start font-medium">{{ __('messages.leaves.field.employee') }}</th>
                            <th class="px-5 py-3 text-start font-medium">{{ __('messages.leaves.field.type') }}</th>
                            <th class="hidden px-5 py-3 text-start font-medium md:table-cell">{{ __('messages.leaves.field.duration') }}</th>
                            <th class="px-5 py-3 text-start font-medium">{{ __('messages.leaves.field.status') }}</th>
                            <th class="px-5 py-3 text-end font-medium">{{ __('messages.action.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($leaveRequests as $leave)
                            <tr class="transition-colors hover:bg-slate-50/70">
                                <td class="px-5 py-3">
                                    <a href="{{ route('leaves.show', $leave) }}" class="flex items-center gap-3">
                                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-100 text-xs font-semibold text-brand-700">
                                            {{ $leave->employee->initials }}
                                        </span>
                                        <div class="min-w-0">
                                            <p class="truncate font-medium text-slate-900">{{ $leave->employee->full_name }}</p>
                                            <p class="truncate text-xs text-slate-500">{{ $leave->employee->department->name }}</p>
                                        </div>
                                    </a>
                                </td>
                                <td class="px-5 py-3">
                                    <p class="text-slate-700">{{ __('messages.leave_type.' . $leave->type) }}</p>
                                    <p class="text-xs text-slate-400 md:hidden">{{ trans_choice('messages.leaves.days_count', $leave->days, ['count' => $leave->days]) }}</p>
                                </td>
                                <td class="hidden px-5 py-3 md:table-cell">
                                    <p class="text-slate-700" dir="ltr">{{ $leave->start_date->translatedFormat('d M') }} – {{ $leave->end_date->translatedFormat('d M Y') }}</p>
                                    <p class="text-xs text-slate-400">{{ trans_choice('messages.leaves.days_count', $leave->days, ['count' => $leave->days]) }}</p>
                                </td>
                                <td class="px-5 py-3"><x-leave-status :status="$leave->status" /></td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center justify-end gap-1">
                                        @if($leave->isPending())
                                            <form method="POST" action="{{ route('leaves.approve', $leave) }}"
                                                  onsubmit="return confirm('{{ __('messages.leaves.approve_confirm') }}')">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="rounded-md p-1.5 text-slate-400 hover:bg-emerald-50 hover:text-emerald-600" title="{{ __('messages.action.approve') }}">
                                                    <x-icon name="check-circle" class="h-4 w-4" />
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('leaves.reject', $leave) }}"
                                                  onsubmit="return confirm('{{ __('messages.leaves.reject_confirm') }}')">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="rounded-md p-1.5 text-slate-400 hover:bg-rose-50 hover:text-rose-600" title="{{ __('messages.action.reject') }}">
                                                    <x-icon name="x-circle" class="h-4 w-4" />
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('leaves.show', $leave) }}" class="rounded-md p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-700" title="{{ __('messages.action.view') }}">
                                            <x-icon name="eye" class="h-4 w-4" />
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-100 px-5 py-3">
                {{ $leaveRequests->links() }}
            </div>
        @endif
    </div>

</x-app-layout>
