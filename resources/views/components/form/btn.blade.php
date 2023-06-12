@if ($link == '')
@if ($role == 'button')
<input type='button' {{ $disabled ? 'disabled' : '' }} class="btn btn-{{ $color }} {{ $class }}" value="{{ $slot }}"></input>
@else
<button {{ $disabled ? 'disabled' : '' }} class="btn btn-{{ $color }} {{ $class }}" role="{{ $role }}">{{ $slot }}</button>
@endif
@else
<a data-confirm-text="{{ $confirmText }}" class="btn btn-{{ $color }} {{ $class }}" href="{{ $link }}">{{ $slot }}</a>
@endif