<x-app-layout :title="__('messages.leaves.create_title')">

    <div class="mb-6">
        <a href="{{ route('leaves.index') }}" class="mb-3 inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700">
            <x-icon name="arrow-left" class="h-4 w-4 {{ app()->getLocale() === 'ur' ? 'rotate-180' : '' }}" />
            {{ __('messages.leaves.title') }}
        </a>
        <h2 class="text-xl font-bold text-slate-900 sm:text-2xl">{{ __('messages.leaves.create_title') }}</h2>
    </div>

    <form method="POST" action="{{ route('leaves.store') }}" class="mx-auto max-w-2xl">
        @csrf
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-card sm:p-6">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <x-field name="employee_id" :label="__('messages.leaves.field.employee')" :required="true">
                        <select id="employee_id" name="employee_id" class="form-select" required>
                            <option value="">—</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}" @selected(old('employee_id') == $emp->id)>{{ $emp->full_name }} ({{ $emp->employee_code }})</option>
                            @endforeach
                        </select>
                    </x-field>
                </div>
                <div class="sm:col-span-2">
                    <x-field name="type" :label="__('messages.leaves.field.type')" :required="true">
                        <select id="type" name="type" class="form-select" required>
                            @foreach(['annual', 'sick', 'casual', 'unpaid'] as $type)
                                <option value="{{ $type }}" @selected(old('type') === $type)>{{ __('messages.leave_type.' . $type) }}</option>
                            @endforeach
                        </select>
                    </x-field>
                </div>
                <x-field name="start_date" :label="__('messages.leaves.field.start_date')" :required="true">
                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" class="form-input" required>
                </x-field>
                <x-field name="end_date" :label="__('messages.leaves.field.end_date')" :required="true">
                    <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" class="form-input" required>
                </x-field>
                <div class="sm:col-span-2">
                    <x-field name="reason" :label="__('messages.leaves.field.reason')">
                        <textarea id="reason" name="reason" rows="3" class="form-textarea" placeholder="{{ __('messages.leaves.reason_placeholder') }}">{{ old('reason') }}</textarea>
                    </x-field>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-3">
            <a href="{{ route('leaves.index') }}" class="btn-secondary">{{ __('messages.action.cancel') }}</a>
            <button type="submit" class="btn-primary">
                <x-icon name="check" class="h-4 w-4" />
                {{ __('messages.action.save') }}
            </button>
        </div>
    </form>

</x-app-layout>
