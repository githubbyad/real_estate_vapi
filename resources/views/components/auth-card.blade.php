@props(['background' => ''])
<div class="card shadow-sm rounded-4">
    <div class="card-header text-center rounded-top-4" style="background-color: {{ $background }};">
        {{ $logo ?? '' }}
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
</div>