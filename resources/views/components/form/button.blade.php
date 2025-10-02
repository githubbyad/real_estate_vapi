@props(['type' => 'button', 'label', 'class' => 'btn-primary', 'rounded' => null, 'loadingText' => 'Processing...'])

<button 
    type="{{ $type }}" 
    class="btn {{ $class }} fw-semibold rounded-2"
    {{ $attributes }}
    onclick="if (this.type === 'submit' && this.closest('form').checkValidity()) { this.disabled = true; this.innerHTML = '<span class=\'spinner-border spinner-border-sm\' role=\'status\' aria-hidden=\'true\'></span> {{ $loadingText }}'; this.closest('form').submit(); }"
>
    {{ $label }}
</button>