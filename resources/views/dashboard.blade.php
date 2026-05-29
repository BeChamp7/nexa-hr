<x-app-layout :title="__('messages.dashboard.title')">

    <div class="mb-6">
        <h2 class="text-xl font-bold text-slate-900 sm:text-2xl">{{ __('messages.dashboard.welcome', ['name' => auth()->user()->name]) }}</h2>
        <p class="mt-1 text-sm text-slate-500">{{ __('messages.dashboard.subtitle') }}</p>
    </div>

    {{-- Stat cards --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="stat-card">
            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-50 text-brand-600">
                <x-icon name="users" class="h-5 w-5" />
            </span>
            <p class="mt-4 text-3xl font-bold text-slate-900">{{ $stats['total_employees'] }}</p>
            <p class="mt-1 text-sm text-slate-500">{{ __('messages.dashboard.total_employees') }}</p>
            <p class="mt-2 text-xs text-emerald-600">{{ $stats['active_employees'] }} {{ __('messages.status.active') }}</p>
        </div>

        <div class="stat-card">
            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                <x-icon name="clock" class="h-5 w-5" />
            </span>
            <p class="mt-4 text-3xl font-bold text-slate-900">{{ $stats['pending_leaves'] }}</p>
            <p class="mt-1 text-sm text-slate-500">{{ __('messages.dashboard.pending_leaves') }}</p>
            <p class="mt-2 text-xs text-amber-600">{{ __('messages.dashboard.awaiting_review') }}</p>
        </div>

        <div class="stat-card">
            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                <x-icon name="check-circle" class="h-5 w-5" />
            </span>
            <p class="mt-4 text-3xl font-bold text-slate-900">{{ $stats['approved_leaves'] }}</p>
            <p class="mt-1 text-sm text-slate-500">{{ __('messages.dashboard.approved_leaves') }}</p>
            <p class="mt-2 text-xs text-slate-400">{{ __('messages.dashboard.this_year') }}</p>
        </div>

        <div class="stat-card">
            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-violet-50 text-violet-600">
                <x-icon name="building" class="h-5 w-5" />
            </span>
            <p class="mt-4 text-3xl font-bold text-slate-900">{{ $stats['departments'] }}</p>
            <p class="mt-1 text-sm text-slate-500">{{ __('messages.dashboard.departments') }}</p>
            <p class="mt-2 text-xs text-slate-400">{{ __('messages.dashboard.across_company') }}</p>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-5">
        {{-- Headcount by department --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-card lg:col-span-2">
            <div class="mb-4 flex items-center gap-2">
                <x-icon name="trending-up" class="h-5 w-5 text-slate-400" />
                <h3 class="font-semibold text-slate-900">{{ __('messages.dashboard.headcount_by_dept') }}</h3>
            </div>
            <div class="space-y-4">
                @foreach($headcount as $dept)
                    <div>
                        <div class="mb-1 flex items-center justify-between text-sm">
                            <span class="font-medium text-slate-700">{{ $dept->name }}</span>
                            <span class="text-slate-500">{{ $dept->employees_count }}</span>
                        </div>
                        <div class="h-2 overflow-hidden rounded-full bg-slate-100">
                            <div class="h-full rounded-full bg-brand-500" style="width: {{ round(($dept->employees_count / $maxHeadcount) * 100) }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Recent leave requests --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-card lg:col-span-3">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                <h3 class="font-semibold text-slate-900">{{ __('messages.dashboard.recent_requests') }}</h3>
                <a href="{{ route('leaves.index') }}" class="text-sm font-medium text-brand-600 hover:text-brand-700">{{ __('messages.action.view_all') }}</a>
            </div>
            @if($recentRequests->isEmpty())
                <x-empty-state icon="inbox" :title="__('messages.dashboard.no_pending')" />
            @else
                <ul class="divide-y divide-slate-100">
                    @foreach($recentRequests as $req)
                        <li>
                            <a href="{{ route('leaves.show', $req) }}" class="flex items-center gap-3 px-5 py-3 transition-colors hover:bg-slate-50">
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-100 text-xs font-semibold text-brand-700">
                                    {{ $req->employee->initials }}
                                </span>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium text-slate-900">{{ $req->employee->full_name }}</p>
                                    <p class="truncate text-xs text-slate-500">{{ __('messages.leave_type.' . $req->type) }} · {{ trans_choice('messages.leaves.days_count', $req->days, ['count' => $req->days]) }}</p>
                                </div>
                                <x-leave-status :status="$req->status" />
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

</x-app-layout>
