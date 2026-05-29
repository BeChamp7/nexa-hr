<x-app-layout :title="__('messages.leaves.details')">

    <div class="mb-6">
        <a href="{{ route('leaves.index') }}" class="mb-3 inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700">
            <x-icon name="arrow-left" class="h-4 w-4 {{ app()->getLocale() === 'ur' ? 'rotate-180' : '' }}" />
            {{ __('messages.leaves.title') }}
        </a>
        <div class="flex items-center gap-3">
            <h2 class="text-xl font-bold text-slate-900 sm:text-2xl">{{ __('messages.leaves.details') }}</h2>
            <x-leave-status :status="$leave->status" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            {{-- Employee --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-card sm:p-6">
                <a href="{{ route('employees.show', $leave->employee) }}" class="flex items-center gap-4">
                    <span class="flex h-12 w-12 items-center justify-center rounded-full bg-brand-100 text-base font-bold text-brand-700">
                        {{ $leave->employee->initials }}
                    </span>
                    <div>
                        <p class="font-semibold text-slate-900">{{ $leave->employee->full_name }}</p>
                        <p class="text-sm text-slate-500">{{ $leave->employee->position }} · {{ $leave->employee->department->name }}</p>
                    </div>
                </a>
            </div>

            {{-- Request details --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-card sm:p-6">
                <h3 class="mb-4 text-sm font-semibold text-slate-900">{{ __('messages.leaves.details') }}</h3>
                <dl class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs uppercase tracking-wide text-slate-400">{{ __('messages.leaves.field.type') }}</dt>
                        <dd class="mt-1 text-sm font-medium text-slate-900">{{ __('messages.leave_type.' . $leave->type) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-wide text-slate-400">{{ __('messages.leaves.field.duration') }}</dt>
                        <dd class="mt-1 text-sm font-medium text-slate-900">{{ trans_choice('messages.leaves.days_count', $leave->days, ['count' => $leave->days]) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-wide text-slate-400">{{ __('messages.leaves.field.start_date') }}</dt>
                        <dd class="mt-1 text-sm font-medium text-slate-900">{{ $leave->start_date->translatedFormat('d M Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-wide text-slate-400">{{ __('messages.leaves.field.end_date') }}</dt>
                        <dd class="mt-1 text-sm font-medium text-slate-900">{{ $leave->end_date->translatedFormat('d M Y') }}</dd>
                    </div>
                    @if($leave->reason)
                        <div class="sm:col-span-2">
                            <dt class="text-xs uppercase tracking-wide text-slate-400">{{ __('messages.leaves.field.reason') }}</dt>
                            <dd class="mt-1 text-sm text-slate-700">{{ $leave->reason }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            @if($leave->review_note)
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5 sm:p-6">
                    <dt class="text-xs uppercase tracking-wide text-slate-400">{{ __('messages.leaves.field.review_note') }}</dt>
                    <dd class="mt-1 text-sm text-slate-700">{{ $leave->review_note }}</dd>
                </div>
            @endif
        </div>

        {{-- Side panel: action / status --}}
        <div class="lg:col-span-1">
            @if($leave->isPending())
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-card sm:p-6">
                    <div class="mb-4 flex items-center gap-2 text-amber-700">
                        <x-icon name="clock" class="h-5 w-5" />
                        <p class="text-sm font-medium">{{ __('messages.leaves.awaiting') }}</p>
                    </div>

                    <form method="POST" action="{{ route('leaves.approve', $leave) }}" class="space-y-3">
                        @csrf @method('PATCH')
                        <textarea name="review_note" rows="2" class="form-textarea text-sm" placeholder="{{ __('messages.leaves.note_placeholder') }}"></textarea>
                        <button type="submit" class="btn-primary w-full" onclick="return confirm('{{ __('messages.leaves.approve_confirm') }}')">
                            <x-icon name="check-circle" class="h-4 w-4" />
                            {{ __('messages.action.approve') }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('leaves.reject', $leave) }}" class="mt-2">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn-secondary w-full text-rose-600 hover:bg-rose-50" onclick="return confirm('{{ __('messages.leaves.reject_confirm') }}')">
                            <x-icon name="x-circle" class="h-4 w-4" />
                            {{ __('messages.action.reject') }}
                        </button>
                    </form>
                </div>
            @else
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-card sm:p-6">
                    <h3 class="mb-4 text-sm font-semibold text-slate-900">{{ __('messages.leaves.field.status') }}</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">{{ __('messages.leaves.field.status') }}</span>
                            <x-leave-status :status="$leave->status" />
                        </div>
                        @if($leave->reviewer)
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500">{{ __('messages.leaves.field.reviewed_by') }}</span>
                                <span class="font-medium text-slate-900">{{ $leave->reviewer->name }}</span>
                            </div>
                        @endif
                        @if($leave->reviewed_at)
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500">{{ __('messages.leaves.field.reviewed_at') }}</span>
                                <span class="font-medium text-slate-900">{{ $leave->reviewed_at->translatedFormat('d M Y') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <div class="mt-4 text-center">
                <form method="POST" action="{{ route('leaves.destroy', $leave) }}" onsubmit="return confirm('{{ __('messages.common.delete_confirm') }}')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-sm text-slate-400 hover:text-rose-600">{{ __('messages.action.delete') }}</button>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
