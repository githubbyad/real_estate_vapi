<x-layout>
@section('content')
<div class="container">
    <h1>{{ $property->title }}</h1>

    <div id="propertyCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($property->images as $key => $image)
                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/'.$image->image_path) }}" class="d-block w-100" alt="Property Image">
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="mt-4">
        <h3>Description</h3>
        <p>{{ $property->description }}</p>

        <h3>Details</h3>
        <ul>
            <li>Price: ${{ number_format($property->price, 2) }}</li>
            <li>Address: {{ $property->address }}</li>
            <li>City: {{ $property->city }}</li>
            <li>State: {{ $property->state }}</li>
            <li>Country: {{ $property->country }}</li>
        </ul>
    </div>
</div>
@endsection
</x-layout>