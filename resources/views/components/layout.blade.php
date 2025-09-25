<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Real Estate' }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-light py-3 mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="/">
                <img src="{{ $settings->logo ?? asset('logo.png') }}" alt="Logo" height="50">
            </a>
            <nav>
                <!-- Add navigation links here -->
            </nav>
        </div>
    </header>

    {{ $slot }}

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>