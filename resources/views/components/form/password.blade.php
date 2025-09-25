@props(['name', 'label', 'required' => false])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <input 
        type="password" 
        class="form-control" 
        id="{{ $name }}" 
        name="{{ $name }}" 
        {{ $required ? 'required' : '' }}
        {{ $attributes }}
    >
    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>