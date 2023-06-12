@if ($service)
<div class='block bg-white mt-3 border-start border-4 border-{{ $status->color }}'>
    <div class="row">
        <div class="col-12 col-md-6">
            <span class='badge bg-{{ $status->color }}'>{{ $status->name }}</span><br>
            <small class='d-block mt-1 text-muted'>{{ date('Y-m-d H:i', strtotime($application->created_at)) }}</small>
            <h3>{{ $service->name }}</h3>
            <span>{{ $status->description }}</span>
        </div>
        <div class="col-12 col-md-6 ">
            <div class="d-flex flex-column-reverse  align-items-end gap-1 application-content">
                @foreach ($buttons as $button)
                <x-form.btn class='' color="{{ $button['color'] }}" link="{{ $button['link'] }}">{{ $button['text'] }}</x-form.btn>
                @endForeach
            </div>

        </div>
    </div>

</div>
@endif