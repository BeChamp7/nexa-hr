<x-app-layout :title="__('messages.employees.create_title')">

    <div class="mb-6">
        <a href="{{ route('employees.index') }}" class="mb-3 inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700">
            <x-icon name="arrow-left" class="h-4 w-4 {{ app()->getLocale() === 'ur' ? 'rotate-180' : '' }}" />
            {{ __('messages.employees.title') }}
        </a>
        <h2 class="text-xl font-bold text-slate-900 sm:text-2xl">{{ __('messages.employees.add') }}</h2>
    </div>

    <form method="POST" action="{{ route('employees.store') }}" class="mx-auto max-w-3xl">
        @csrf
        @include('employees._form', ['employee' => null])
    </form>

</x-app-layout>
