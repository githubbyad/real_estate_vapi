@props(['name', 'label', 'multiple' => false, 'existingImages' => []])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <input 
        type="file" 
        class="form-control" 
        id="{{ $name }}" 
        name="{{ $name }}{{ $multiple ? '[]' : '' }}" 
        {{ $multiple ? 'multiple' : '' }}
        {{ $attributes }}
    >

    <div class="mt-3" id="{{ $name }}-preview">
        @foreach ($existingImages as $image)
            <div class="image-preview-item">
                <img src="{{ asset('storage/' . $image) }}" alt="Image" class="img-thumbnail" style="max-width: 150px;">
                <button type="button" class="btn btn-danger btn-sm remove-image" data-image="{{ $image }}">Remove</button>
            </div>
        @endforeach
    </div>

    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('{{ $name }}');
        const previewContainer = document.getElementById('{{ $name }}-preview');

        fileInput.addEventListener('change', function () {
            previewContainer.innerHTML = '';
            Array.from(fileInput.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const previewItem = document.createElement('div');
                    previewItem.classList.add('image-preview-item');

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail');
                    img.style.maxWidth = '150px';

                    const removeButton = document.createElement('button');
                    removeButton.type = 'button';
                    removeButton.classList.add('btn', 'btn-danger', 'btn-sm', 'remove-image');
                    removeButton.textContent = 'Remove';

                    removeButton.addEventListener('click', function () {
                        previewItem.remove();
                    });

                    previewItem.appendChild(img);
                    previewItem.appendChild(removeButton);
                    previewContainer.appendChild(previewItem);
                };
                reader.readAsDataURL(file);
            });
        });
    });
</script>