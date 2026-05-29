@props(['label', 'name', 'required' => false])

<div>
    <label for="{{ $name }}" class="form-label">
        {{ $label }}
        @if($required)<span class="text-rose-500">*</span>@endif
    </label>
    {{ $slot }}
    @error($name)
        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
    @enderror
</div>
