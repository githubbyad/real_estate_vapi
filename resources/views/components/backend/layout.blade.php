@props(['title' => 'Admin Dashboard', 'icon' => 'bi bi-house'])
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard' }}{{ $settings->site_title ? ' | ' . $settings->site_title :  '' }}</title>
    {{-- favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ $settings->favicon ? asset($settings->favicon) : asset('images/favicon.ico') }}?v={{ filemtime(public_path($settings->favicon ? $settings->favicon : 'images/favicon.ico')) }}">
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" defer></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
    <!-- Custom CSS for Sidebar and Overlay -->
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

        @media (min-width: 768px) {
            #sidebar {
                position: static;
                left: 0;
                width: 250px;
                height: 100%;
                z-index: auto;
            }

            #overlay {
                display: none;
            }

            .main-content {
                margin-left: 250px;
            }
        }

        .nav-link {
            color: #333;
            /* Changed text color to dark gray */
        }

        .nav-link:hover {
            color: #000;
            /* Darker color on hover */
        }
    </style>
</head>

<body>
    <div class="d-flex vh-100 bg-light">
        <!-- Sidebar -->
        <aside id="sidebar" class="bg-theme border-end sidebar-visible shadow-sm" style="width: 250px; height: 100%;">
            <div class="p-3 bg-theme-dark text-white text-center fw-bold shadow-sm">Admin Panel</div>            
            <nav class="mt-3">
                <ul class="nav flex-column">
                    <x-backend.sidebar-li route="dashboard" icon="bi-grid" label="Dashboard" />
                    <x-backend.sidebar-li route="properties.index" icon="bi-building" label="Properties" />
                    <x-backend.sidebar-li route="agents.index" icon="bi-person" label="Agents" />
                    <x-backend.sidebar-li route="owners.index" icon="bi-people" label="Owners" />
                    <x-backend.sidebar-li route="inquiries.index" icon="bi-envelope" label="Inquiries" />
                    <x-backend.sidebar-li route="settings.edit" icon="bi-gear" label="Settings" />
                </ul>
                <hr class="text-secondary">                
                <ul class="nav flex-column mb-3">
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <div class="nav-link cursor-pointer d-flex gap-2 align-items-center text-white">
                                <i class="bi bi-box-arrow-right"></i><span>Logout</span>
                            </div>                    
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Overlay -->
        <div id="overlay" class="overlay-hidden"></div>

        <!-- Main Content -->
        <div id="main-content" class="flex-grow-1 overflow-auto">
            <header class="bg-white shadow-sm p-3 d-flex align-items-center">
                <button id="menu-toggle" class="btn btn-outline-primary me-3 d-md-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-list" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                                <path
                                    d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5z" />
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}"
                            class="nav-link d-flex gap-2 align-items-center {{ request()->routeIs('logout') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                                <path fill-rule="evenodd"
                                    d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                            </svg>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Overlay -->
        <div id="overlay" class="overlay-hidden"></div>

        <!-- Main Content -->
        <div id="main-content" class="flex-grow-1 overflow-auto">
            <header class="bg-white shadow-sm p-3 d-flex align-items-center">
                <button id="menu-toggle" class="btn btn-outline-primary me-3 d-md-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-list" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M2.5 12.5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-11zm0-5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-11zm0-5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-11z" />
                    </svg>
                </button>
                <h1 class="h5 mb-0"><i class="{{ $icon ?? 'bi bi-house' }}"></i> {{ $title ?? 'Admin Dashboard' }}</h1>
            </header>
            <main class="p-4">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}?v={{ filemtime(public_path('js/app.js')) }}" defer></script>
    <!-- Custom JS for Sidebar Toggle -->
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
