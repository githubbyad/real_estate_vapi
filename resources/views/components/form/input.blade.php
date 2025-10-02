@props(['name', 'type' => 'text', 'label' => null, 'value' => null, 'required' => false])

<div class="mb-3">
    @if ($label)
        <label for="{{ $name }}" class="form-label fw-semibold fs-7 text-theme">{{ $label }}</label>
    @endif
    <input type="{{ $type }}"
        class="form-control border-theme px-3 rounded-2 @error($name) is-invalid @enderror"
        id="{{ $name }}" name="{{ $name }}" value="{{ $value ?? old($name) }}"
        placeholder="Type your {{ strtolower($label) }} here"
        autocomplete="{{ $name }}" {{ $required ? 'required' : '' }} {{ $attributes }}>
    @error($name)
        <div class="text-danger fs-7 fw-semibold">{{ $message }}</div>
    @enderror
</div>
