@props(['id', 'name', 'label', 'value', 'checked' => false, 'required' => false])

<div class="row mb-3">
    <div class="form-check">
        <input 
            class="form-check-input" 
            type="radio" 
            id="{{ $id }}" 
            name="{{ $name }}" 
            value="{{ $value }}" 
            {{ $checked ? 'checked' : '' }}
            {{ $required ? 'required' : '' }}
            {{ $attributes }}
        >
        <label class="form-check-label" for="{{ $id }}">{{ $label }}</label>
    </div>
    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>