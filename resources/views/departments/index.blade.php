<x-app-layout :title="__('messages.departments.title')">

    <x-page-header :title="__('messages.departments.title')" :subtitle="__('messages.departments.subtitle')">
        <x-slot name="actions">
            <a href="{{ route('departments.create') }}" class="btn-primary">
                <x-icon name="plus" class="h-4 w-4" />
                {{ __('messages.departments.add') }}
            </a>
        </x-slot>
    </x-page-header>

    @if($departments->isEmpty())
        <div class="rounded-2xl border border-slate-200 bg-white shadow-card">
            <x-empty-state icon="building" :title="__('messages.departments.empty')">
                <x-slot name="action">
                    <a href="{{ route('departments.create') }}" class="btn-primary">
                        <x-icon name="plus" class="h-4 w-4" /> {{ __('messages.departments.add') }}
                    </a>
                </x-slot>
            </x-empty-state>
        </div>
    @else
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
            @foreach($departments as $department)
                <div class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-card transition-shadow hover:shadow-card-md">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-600">
                                <x-icon name="building" class="h-5 w-5" />
                            </span>
                            <div>
                                <h3 class="font-semibold text-slate-900">{{ $department->name }}</h3>
                                <span class="badge bg-slate-100 text-slate-600">{{ $department->code }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 opacity-0 transition-opacity group-hover:opacity-100">
                            <a href="{{ route('departments.edit', $department) }}" class="rounded-md p-1.5 text-slate-400 hover:bg-slate-100 hover:text-brand-600">
                                <x-icon name="edit" class="h-4 w-4" />
                            </a>
                            <form method="POST" action="{{ route('departments.destroy', $department) }}"
                                  onsubmit="return confirm('{{ __('messages.departments.delete_confirm', ['name' => $department->name]) }}')">
                                @csrf @method('DELETE')
                                <button type="submit" class="rounded-md p-1.5 text-slate-400 hover:bg-rose-50 hover:text-rose-600">
                                    <x-icon name="trash" class="h-4 w-4" />
                                </button>
                            </form>
                        </div>
                    </div>

                    @if($department->description)
                        <p class="mt-4 text-sm text-slate-500">{{ $department->description }}</p>
                    @endif

                    <div class="mt-4 flex items-center gap-2 border-t border-slate-100 pt-4 text-sm text-slate-600">
                        <x-icon name="users" class="h-4 w-4 text-slate-400" />
                        {{ trans_choice('messages.departments.count', $department->employees_count, ['count' => $department->employees_count]) }}
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</x-app-layout>
