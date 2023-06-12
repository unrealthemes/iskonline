<?php
    $servicesDescription = array(
        1 => '3 минуты', //'застройщик', 
        2 => '5 минут', //брак'
        3 => '3 минуты', //'товар', 
        4 => '5 минут', //'подсудность'
        5 => '7 минут', //'калькулятор'
        8 => '10 минут', //'реквизиты',
        26 => '3 минуты', //'доверенность'
    );
?>

<a href='{{ route("services.show.$service->id") }}' class="services__item-content">
    <div class="services__item-title">{{ $service->name }}</div>
    <div class="services__item-note">{{ $servicesDescription[$service->id] }} / @if ($service->price > 0) {{ $service->price }}&nbsp;рублей @else Бесплатно @endif</div>
</a>