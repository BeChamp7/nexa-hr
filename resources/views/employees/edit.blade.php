<x-app-layout :title="__('messages.employees.edit')">

    <div class="mb-6">
        <a href="{{ route('employees.show', $employee) }}" class="mb-3 inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700">
            <x-icon name="arrow-left" class="h-4 w-4 {{ app()->getLocale() === 'ur' ? 'rotate-180' : '' }}" />
            {{ $employee->full_name }}
        </a>
        <h2 class="text-xl font-bold text-slate-900 sm:text-2xl">{{ __('messages.employees.edit') }}</h2>
    </div>

    <form method="POST" action="{{ route('employees.update', $employee) }}" class="mx-auto max-w-3xl">
        @csrf @method('PUT')
        @include('employees._form', ['employee' => $employee])
    </form>

</x-app-layout>
