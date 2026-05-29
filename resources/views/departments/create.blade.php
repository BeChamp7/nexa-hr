<x-app-layout :title="__('messages.departments.add')">

    <div class="mb-6">
        <a href="{{ route('departments.index') }}" class="mb-3 inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700">
            <x-icon name="arrow-left" class="h-4 w-4 {{ app()->getLocale() === 'ur' ? 'rotate-180' : '' }}" />
            {{ __('messages.departments.title') }}
        </a>
        <h2 class="text-xl font-bold text-slate-900 sm:text-2xl">{{ __('messages.departments.add') }}</h2>
    </div>

    <form method="POST" action="{{ route('departments.store') }}" class="mx-auto max-w-xl">
        @csrf
        @include('departments._form', ['department' => null])
    </form>

</x-app-layout>
