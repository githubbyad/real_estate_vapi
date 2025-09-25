@props(['id', 'name', 'label', 'value' => old($name), 'required' => false])

<div class="row mb-3">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <textarea 
        class="form-control" 
        id="{{ $id }}" 
        name="{{ $name }}" 
        {{ $required ? 'required' : '' }}
        {{ $attributes }}
    >{{ old($name, $value) }}</textarea>
    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>