<div class="accordion-item">
    <h2 class="accordion-header" id="heading{{ $i }}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $i }}" aria-expanded="false" aria-controls="collapse{{ $i }}">
            {{ $text }}
        </button>
    </h2>
    <div id="collapse{{ $i }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $i }}" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            {{ $slot }}
        </div>
    </div>
</div>