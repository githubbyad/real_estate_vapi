@props(
    [
        'route', 
        'icon', 
        'label'
    ]
) 
<li class="nav-item mb-2">
    <a 
        class="nav-link fw-semibold gap-2 text-white bg-theme-hover mx-2 rounded-2 {{ request()->routeIs($route) ? 'bg-theme-dark' : '' }}" 
        href="{{ route($route) }}"
    >
        <i class="bi {{ $icon }}"></i>
        {{ $label }}
    </a>
</li>