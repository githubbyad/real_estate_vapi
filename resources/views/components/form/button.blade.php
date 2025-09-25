@props(['type' => 'button', 'label', 'class' => 'btn-primary'])

<button 
    type="{{ $type }}" 
    class="btn {{ $class }}"
    {{ $attributes }}
>
    {{ $label }}
</button>