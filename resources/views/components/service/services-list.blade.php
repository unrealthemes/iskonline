<h2>{{ !$showAll ? 'Сервисы' : 'Все сервисы' }}</h2>        
<ul class="services__list row">
    @foreach ($records as $record)
    <li class="services__item services__item--{{ $record->id }} col-lg-6">
        <x-service.service-component :service="$record"></x-service.service-component>
    </li>
    @endForeach
</div>