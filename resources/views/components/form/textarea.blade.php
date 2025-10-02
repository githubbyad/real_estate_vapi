@props(['name', 'label', 'value' => old($name), 'required' => false])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label fw-semibold fs-7 text-theme">{{ $label }}</label>
    <textarea class="form-control border-theme px-3 rounded-2 @error($name) is-invalid @enderror" id="{{ $name }}" name="{{ $name }}" rows="4"
        placeholder="Type your {{ strtolower($label) }} here" {{ $required ? 'required' : '' }} {{ $attributes }}>{{ old($name, $value) }}</textarea>
    @error($name)
        <div class="text-danger fw-semibold fs-7">{{ $message }}</div>
    @enderror
</div>
