@props(['title', 'subtitle' => null])

<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-xl font-bold text-slate-900 sm:text-2xl">{{ $title }}</h2>
        @if($subtitle)
            <p class="mt-1 text-sm text-slate-500">{{ $subtitle }}</p>
        @endif
    </div>
    @isset($actions)
        <div class="flex items-center gap-2">
            {{ $actions }}
        </div>
    @endisset
</div>
