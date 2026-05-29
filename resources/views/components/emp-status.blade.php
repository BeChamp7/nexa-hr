@props(['status'])

@php
    $map = [
        'active' => ['bg-emerald-50 text-emerald-700 ring-emerald-600/20', 'bg-emerald-500'],
        'on_leave' => ['bg-amber-50 text-amber-700 ring-amber-600/20', 'bg-amber-500'],
        'inactive' => ['bg-slate-100 text-slate-600 ring-slate-500/20', 'bg-slate-400'],
    ];
    [$classes, $dot] = $map[$status] ?? $map['inactive'];
@endphp

<span class="badge ring-1 ring-inset {{ $classes }}">
    <span class="h-1.5 w-1.5 rounded-full {{ $dot }}"></span>
    {{ __('messages.status.' . $status) }}
</span>
