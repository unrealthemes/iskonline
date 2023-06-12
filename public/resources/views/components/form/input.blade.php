<div class="mb-2 {{ $formFloating ? 'form-floating' : '' }}">
    @if (!$formFloating)
    <label for="{{ $name }}">{{ $label }}</label>
    @endif

    @if ($type == "textarea")
    <textarea {{ $required ? 'required' : '' }} style="height: {{ $rows * 20 }}px" name="{{ $name }}" id="{{ $name }}" cols="30" rows="6" class="form-control">{{ $value }}</textarea>
    @elseif ($type == "select")
    <select {{ $required ? 'required' : '' }} name="{{ $name }}" id="{{ $name }}" class="form-select">
        {{ $slot }}
    </select>
    @else
    @if ($multiple == "1")
    <input {{ $required ? 'required' : '' }} type="{{ $type }}" multiple name="{{ $name }}" id="{{ $name }}" value="{{ $value }}" class="form-control">
    @else
    <input {{ $required ? 'required' : '' }} data-suggestions='{{ $suggestions }}' type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}" placeholder="{{ $label }}" class="form-control {{ $class }}">
    <div class="datalist shadow rounded overflow-hidden"></div>
    @endif
    @endif

    @if ($formFloating)
    <label for="{{ $name }}">{{ $label }}</label>
    @endif
</div>