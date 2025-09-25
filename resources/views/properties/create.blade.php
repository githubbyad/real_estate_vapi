@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Property</h1>
    <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Other property fields here -->

        <div class="mb-3">
            <label class="form-label">Property Images</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple>
            <div id="preview" class="d-flex flex-wrap mt-2"></div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
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