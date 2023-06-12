<div class="dropdown">
    @if ($btn)
    <button class="btn btn-small bg-ghost text-primary dropdown-toggle" type="button" id="dropDownMenu" data-bs-toggle="dropdown" aria-expanded="false">
        {{ $text }}
    </button>
    @else
    <a class="nav-link dropdown-toggle" type="button" id="dropDownMenu" data-bs-toggle="dropdown" aria-expanded="false">
        {{ $text }}
    </a>
    @endif

    <ul class="dropdown-menu" aria-labelledby="dropDownMenu">
        {{ $slot }}
    </ul>
</div>