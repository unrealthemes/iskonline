<div class="form-check">
    <input class="form-check-input" type="checkbox" id="{{ $name }}" name="{{ $name }}" {{ $checked ? 'checked' : '' }}>
    <label class="form-check-label" for="{{ $name }}">
        {{ $label }}
    </label>
</div>