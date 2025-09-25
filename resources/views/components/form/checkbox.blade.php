@props(['name', 'label', 'checked' => false, 'required' => false])

<div class="row mb-3">
    <div class="form-check">
        <input 
            class="form-check-input" 
            type="checkbox" 
            id="{{ $name }}" 
            name="{{ $name }}" 
            {{ $checked ? 'checked' : '' }}
            {{ $required ? 'required' : '' }}
            {{ $attributes }}
        >
        <label class="form-check-label" for="{{ $name }}">{{ $label }}</label>
    </div>
    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>