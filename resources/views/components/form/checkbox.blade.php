@props(['name', 'label', 'checked' => false, 'required' => false])

<div class="mb-3">
    <div class="form-check d-flex gap-2">
        <input 
            class="form-check-input border-theme border-2 cursor-pointer" 
            type="checkbox" 
            id="{{ $name }}" 
            name="{{ $name }}" 
            {{ $checked ? 'checked' : '' }}
            {{ $required ? 'required' : '' }}
            {{ $attributes }}
        >
        <label class="form-check-label user-select-none fs-7 fw-semibold text-theme cursor-pointer" for="{{ $name }}">{{ $label }}</label>
    </div>
    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>