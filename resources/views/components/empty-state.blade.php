@props(['icon' => 'inbox', 'title', 'message' => null])

<div class="flex flex-col items-center justify-center px-6 py-16 text-center">
    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-400">
        <x-icon :name="$icon" class="h-7 w-7" />
    </div>
    <h3 class="mt-4 text-sm font-semibold text-slate-900">{{ $title }}</h3>
    @if($message)
        <p class="mt-1 text-sm text-slate-500">{{ $message }}</p>
    @endif
    @isset($action)
        <div class="mt-5">{{ $action }}</div>
    @endisset
</div>
