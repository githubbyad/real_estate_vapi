<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard' }}</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" defer></script>
    <style>
        .sidebar-hidden {
            position: fixed;
            left: -250px;
            transition: left 0.3s ease;
        }
        .sidebar-visible {
            position: fixed;
            left: 0;
            transition: left 0.3s ease;
        }
        .overlay-hidden {
            display: none;
        }
        .overlay-visible {
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 998;
        }
    </style>
</head>
<body>
    <div class="d-flex vh-100 bg-light">
        <!-- Sidebar -->
        <aside id="sidebar" class="bg-white border-end sidebar-hidden" style="width: 250px; height: 100%; z-index: 999;">
            <div class="p-3 text-center fw-bold border-bottom">Admin Panel</div>
            <nav class="mt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="/dashboard" class="nav-link d-flex align-items-center">
                            <svg class="bi me-2" width="16" height="16" fill="currentColor">
                                <use xlink:href="#speedometer2" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <!-- Add more sidebar items here -->
                </ul>
            </nav>
        </aside>

        <!-- Overlay -->
        <div id="overlay" class="overlay-hidden"></div>

        <!-- Main Content -->
        <div id="main-content" class="flex-grow-1 overflow-auto">
            <header class="bg-white shadow-sm p-3 d-flex align-items-center">
                <button id="menu-toggle" class="btn btn-outline-primary me-3 d-md-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2.5 12.5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-11zm0-5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-11zm0-5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-11z"/>
                    </svg>
                </button>
                <h1 class="h5 mb-0">{{ $title ?? 'Admin Dashboard' }}</h1>
            </header>
            <main class="p-4">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        function toggleSidebar() {
            if (sidebar.classList.contains('sidebar-visible')) {
                sidebar.classList.remove('sidebar-visible');
                sidebar.classList.add('sidebar-hidden');
                overlay.classList.remove('overlay-visible');
                overlay.classList.add('overlay-hidden');
            } else {
                sidebar.classList.remove('sidebar-hidden');
                sidebar.classList.add('sidebar-visible');
                overlay.classList.remove('overlay-hidden');
                overlay.classList.add('overlay-visible');
            }
        }

        menuToggle.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
    </script>
</body>
</html>