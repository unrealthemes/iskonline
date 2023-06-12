<div class="carousel-item {{ $active ? 'active' : '' }}" data-bs-interval='{{ $period ? $period : 3000 }}'>
    {{ $slot }}
</div>