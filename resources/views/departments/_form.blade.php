@php($department = $department ?? null)

<div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-card sm:p-6">
    <div class="space-y-4">
        <x-field name="name" :label="__('messages.departments.field.name')" :required="true">
            <input type="text" id="name" name="name" value="{{ old('name', $department?->name) }}" class="form-input" required>
        </x-field>
        <x-field name="code" :label="__('messages.departments.field.code')" :required="true">
            <input type="text" id="code" name="code" value="{{ old('code', $department?->code) }}" class="form-input uppercase" maxlength="12" required>
        </x-field>
        <x-field name="description" :label="__('messages.departments.field.description')">
            <textarea id="description" name="description" rows="3" class="form-textarea">{{ old('description', $department?->description) }}</textarea>
        </x-field>
    </div>
</div>

<div class="mt-6 flex items-center justify-end gap-3">
    <a href="{{ route('departments.index') }}" class="btn-secondary">{{ __('messages.action.cancel') }}</a>
    <button type="submit" class="btn-primary">
        <x-icon name="check" class="h-4 w-4" />
        {{ $department ? __('messages.action.save_changes') : __('messages.action.save') }}
    </button>
</div>
