@extends('layouts.base')

@section('title', 'Результат')
 <style>	
body::before {

    border-radius: 0 0 100px 100px;
    content: "";
    height: 150px;
    top: 0;
    z-index: -2;

}
</style>

@section('content')
<section>
    <div class="container">
        <h1 class="fw-bold mb-3">Результат</h1>
        <br>
        <div class="mt-5">
		Увы, ничего не найдено, попробуйте еще раз
		</div>
    </div>
</section>
@endSection