@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Property</h1>
    <form action="{{ route('properties.update', $property->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- Other property fields here -->

        <div class="mb-3">
            <label class="form-label">Existing Images (Drag to Reorder)</label>
            <ul id="sortableImages" class="list-unstyled d-flex flex-wrap">
                @foreach($property->images as $image)
                <li class="m-2 position-relative" data-id="{{ $image->id }}" style="cursor: grab; width:120px;">
                    <img src="{{ asset('storage/'.$image->image_path) }}" 
                         class="img-thumbnail" style="height:100px;object-fit:cover;">
                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0"
                            onclick="removeExistingImage({{ $image->id }}, this)">&times;</button>
                </li>
                @endforeach
            </ul>
            <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="saveOrder()">Save Order</button>
        </div>

        <div class="mb-3">
            <label class="form-label">Add New Images</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple>
            <div id="preview" class="d-flex flex-wrap mt-2"></div>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    new Sortable(document.getElementById('sortableImages'), {
        animation: 150,
        ghostClass: 'bg-light'
    });
});

function saveOrder() {
    let order = [];
    document.querySelectorAll('#sortableImages li').forEach((el, index) => {
        order.push({ id: el.dataset.id, sort_order: index });
    });

    fetch("{{ route('property-images.reorder') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ order: order })
    }).then(res => res.json())
      .then(data => {
        if (data.success) {
            alert("Image order updated!");
        }
    });
}

function removeExistingImage(id, el) {
    if (!confirm("Are you sure?")) return;
    fetch(`/property-images/${id}`, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        }
    }).then(res => res.json())
      .then(data => {
        if (data.success) {
            el.parentElement.remove();
        }
    });
}

document.getElementById('images').addEventListener('change', function(e) {
    let preview = document.getElementById('preview');
    preview.innerHTML = "";
    Array.from(e.target.files).forEach((file, index) => {
        let reader = new FileReader();
        reader.onload = function(ev) {
            let div = document.createElement("div");
            div.classList.add("m-2", "position-relative");
            div.style.width = "120px";
            div.innerHTML = `
                <img src="${ev.target.result}" class="img-thumbnail" style="height:100px;object-fit:cover;">
                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0"
                    onclick="removeImage(${index})">&times;</button>`;
            preview.appendChild(div);
        }
        reader.readAsDataURL(file);
    });
});

function removeImage(index) {
    let dt = new DataTransfer();
    let input = document.getElementById('images');
    let { files } = input;
    Array.from(files).forEach((file, i) => {
        if (i !== index) dt.items.add(file);
    });
    input.files = dt.files;
    input.dispatchEvent(new Event('change'));
}
</script>
@endsection