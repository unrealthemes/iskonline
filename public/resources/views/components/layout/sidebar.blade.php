<div class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-light border-end" style="width: 280px;">

    <ul class="nav nav-pills flex-column mb-auto">
        @foreach ($pages as $page)
        <x-menu.sidebar-link active='{{ isset($page[2]) ? "1" : "" }}' link='{{ route($page[1]) }}'>{{ $page[0] }}</x-menu.sidebar-link>
        @endForeach
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">

            <strong>{{ $user->name }}</strong>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
            <x-layout.menu-dropdown-item link='{{ route("home") }}'>На сайт</x-layout.menu-dropdown-item>
            <x-layout.menu-dropdown-item hr='1'></x-layout.menu-dropdown-item>
            <x-layout.menu-dropdown-item link='{{ route("logout") }}'>Выйти</x-layout.menu-dropdown-item>
        </ul>
    </div>
</div>