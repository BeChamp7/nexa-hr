@props(['status'])

@php
    $map = [
        'pending' => ['bg-amber-50 text-amber-700 ring-amber-600/20', 'clock'],
        'approved' => ['bg-emerald-50 text-emerald-700 ring-emerald-600/20', 'check-circle'],
        'rejected' => ['bg-rose-50 text-rose-700 ring-rose-600/20', 'x-circle'],
    ];
    [$classes, $icon] = $map[$status] ?? $map['pending'];
@endphp

<span class="badge ring-1 ring-inset {{ $classes }}">
    <x-icon :name="$icon" class="h-3.5 w-3.5" />
    {{ __('messages.leave_status.' . $status) }}
</span>
