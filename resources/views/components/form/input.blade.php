@props(['name', 'type' => 'text', 'label' => null, 'value' => null, 'required' => false])

<div class="row mb-3">
    @if ($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif
    <input type="{{ $type }}" class="form-control @error($name) is-invalid @enderror" id="{{ $name }}"
        name="{{ $name }}" value="{{ $value ?? old($name) }}" autocomplete="{{ $name }}"
        {{ $required ? 'required' : '' }} {{ $attributes }}>
    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
