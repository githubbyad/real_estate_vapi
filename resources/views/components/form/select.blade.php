@props(['id', 'name', 'label', 'options' => [], 'value' => old($name), 'required' => false])

<div class="row mb-3">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <select 
        class="form-select" 
        id="{{ $id }}" 
        name="{{ $name }}" 
        {{ $required ? 'required' : '' }}
        {{ $attributes }}
    >
        @foreach ($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" {{ $value == $optionValue ? 'selected' : '' }}>
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>
    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>