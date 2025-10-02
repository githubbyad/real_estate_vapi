@props(['name', 'label', 'required' => false])
<!-- Add eye icon toggle password view -->
<div class="mb-3">
    <label for="{{ $name }}" class="form-label fw-semibold fs-7 text-theme">{{ $label }}</label>
    <div class="position-relative">
        <input 
            type="password" 
            class="form-control border-dark px-3 rounded-2" 
            id="{{ $name }}" 
            name="{{ $name }}" 
            placeholder="Type your {{ strtolower($label) }} here"
            {{ $required ? 'required' : '' }}
            {{ $attributes }}
        >
        <span class="position-absolute end-0 me-1 bottom-0 p-2 cursor-pointer" id="toggle-password-{{ $name }}">
            <i class="bi bi-eye text-gray" id="toggle-password-icon-{{ $name }}"></i>
        </span>
    </div>
    @error($name)
        <div class="text-danger fs-7 fw-semibold">{{ $message }}</div>
    @enderror
</div>
<script>
    document.getElementById('toggle-password-{{ $name }}').addEventListener('click', function () {
        const passwordInput = document.getElementById('{{ $name }}');
        const icon = document.getElementById('toggle-password-icon-{{ $name }}');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });
</script>