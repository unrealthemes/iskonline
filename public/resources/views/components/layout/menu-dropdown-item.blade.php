@if ($hr != '1')
<li><a class="dropdown-item" href="{{ $link }}">{{ $slot }}</a></li>
@else
<li>
    <hr class="dropdown-divider">
</li>
@endif