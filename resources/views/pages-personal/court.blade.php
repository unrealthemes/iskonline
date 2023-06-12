@extends('layouts.base')

@section('title', 'Результат')

@section('content')
 <style>	
body::before {

    border-radius: 0 0 100px 100px;
    content: "";
    height: 150px;
    top: 0;
    z-index: -2;

}
</style>
<section>
    <div class="container">
		<h1 class="fw-bold mb-3">Спасибо за оплату! Ваш документ готов</h1>
		<br/>
        <h2 class="fw-bold mt-3">Результат</h2>
        <br>
        <div class="mb-5">
		{!! $html !!}
		</div>
    </div>
</section>
@endSection