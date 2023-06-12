@extends('layouts.base')

@section('meta')

@endSection

@section('title', "Калькулятор неустойки по ДДУ")

@section('content')

<div class="header-decor header-decor--calc"></div>

<section class='hero'>
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6">
                <h1>Калькулятор<br> неустойки по ДДУ</h1>
                <p class='hero-text'>Расчёт неустойки<br class="d-md-inline d-none"> за каждый день просрочки по ДДУ</p>                
            </div>
        </div>
    </div>
    <div class="header-decor-mob header-decor-mob--calc d-block d-lg-none"></div>
</section>

<section class="section-service-form" id="service">
    <div class="container">
        <div class="form-blue">
            <h2>Рассчёт суммы</h2>

            <h3>Введите параметры задолженности</h3>
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <label class='col-12 mb-2' for="sum">Цена договора (в рублях)</label>
                                <div class='col-12'><input type="number" id="sum" value="10000000" class="form-control"></div>                    
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <label class='col-12 mb-2' for="">Ваш статус:</label>
                                <div class='col-12'>
                                    <select name="person" id="person" class='form-select'>
                                        <option value="1">физическое лицо</option>
                                        <option value="2">юридическое лицо</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row">                                
                            <div class='col-12 col-md-6 mb-2'>
                                <label class="" for="date_start">Начало периода (Когда объект должны были сдать)</label>
                                <input type="date" value="{{ date('Y-m-01') }}" id="date_start" class="form-control">
                            </div>
                            <div class='col-12 col-md-6'>
                                <label class="" for="date_end">Конец периода (Дата фактической сдачи) / <span role="button" class="{{--text-primary--}}" id="today">сегодня</span></label>
                                <input type="date" value="{{ date('Y-m-d') }}" id="date_end" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">            
                        <div class="row">
                            <label class='col-12 mb-2' for="">Применять процентную ставку:</label>
                            <div class='col-12'>
                                <select name="refinancing_type" id="refinancing_type" class='form-select'>
                                    <option value="1">на дату сдачи по договору</option>
                                    <option value="2">на дату фактической сдачи</option>
                                    <option value="3">по периодам действия ставок *</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="col-md-4">
                    <div class="py-3">
                        @csrf
                        <div class="" id="errors"></div>
                        <div class="text-muted">Нажимая на кнопку «Рассчитать», Вы соглашаетесь с политикой сайта. Мы не передаём третьим лицам ваши персональные данные. Они находятся под надёжной защитой</div>
                        <button class="btn btn--black mt-1" id="action">Рассчитать</button>
                        <button class="btn btn-warning mt-1" id="clear">Очистить</button>
                    </div>                            
                </div>
                <div class="col-12">

                </div>
                
            </div>

            <div class="data mt-4 d-none">
                <h3>Данные</h3>
                <div class="row py-3 border-bottom mt-4">
                    <div class="col-12 col-md-2">
                        <b>Цена договора:</b>
                    </div>
                    <div class="col-12 col-md-4 mb-3" id="data_sum">
                        123 000, 00 руб.
                    </div>
                    <div class="col-12 col-md-2">
                        <b>Период просрочки:</b>
                    </div>
                    <div class="col-12 col-md-4" id="data_period">
                        с 01.09.2022 по 19.09.2022
                    </div>
                </div>

                <div class="row py-3">
                    <div class="col-12 col-md-2">
                        <b>Статус:</b>
                    </div>
                    <div class="col-12 col-md-4 mb-3" id="data_person">
                        физическое лицо
                    </div>
                    <div class="col-12 col-md-2">
                        <b>Расчёт ставки:</b>
                    </div>
                    <div class="col-12 col-md-4" id="data_refinancing">
                        на день фактического исполнения
                    </div>
                </div>
            </div>

            <div class="result mt-4 d-none">
                <h3>Результат</h3>

                <div class="row py-3 border-bottom mt-4">
                    <div class="col-12 col-md-6">
                        <b>Цена договора</b>
                    </div>
                    <div class="col-12 col-md-6" id="result_sum">
                        1 234, 00
                    </div>
                </div>

                <div class="row py-3 border-bottom">
                    <div class="col-12 col-md-6">
                        <b>Период просрочки, дней</b>
                    </div>
                    <div class="col-12 col-md-6" id="result_period">
                        117
                    </div>
                </div>

                <div class="row py-3 border-bottom">
                    <div class="col-12 col-md-6">
                        <b>Период просрочки, с которого считается неустойка, дней</b><br><small><a href="#laws" class="text-primary">Почему не совпадает с фактическим?</a></small>
                    </div>
                    <div class="col-12 col-md-6" id="result_actual_period">
                        16
                    </div>
                </div>

                <div class="row py-3 border-bottom">
                    <div class="col-12 col-md-6">
                        <b>Ставка рефинансирования</b><br>
                        <small><a href="https://cbr.ru/hd_base/KeyRate/" target="_blank" class="text-primary">Откуда берётся?</a></small>
                    </div>
                    <div class="col-12 col-md-6" id="result_refinancing">
                        8%
                    </div>
                </div>

                <div class="row py-3 border-bottom">
                    <div class="col-12 col-md-6">
                        <b>Формула</b>
                    </div>
                    <div class="col-12 col-md-6" id="result_formula">
                        1 234,00 × 12 × 2 × 1/300 × 8%
                    </div>
                </div>

                <div class="row py-3">
                    <div class="col-12 col-md-6">
                        <b>Размер неустойки</b>
                    </div>
                    <div class="col-12 col-md-6">
                        <h4><b id="result_forfeit">7,90 р.</b></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="about-service">
    <div class="container">

        <h2>О сервисе</h2>
        <div class="">
            <p>Если застройщик не выполняет условия сделки или исполняет обязанности ненадлежащим образом, то дольщик вправе взыскать с него неустойку. В соответствии с законодательством просрочка не учитывается за следующие периоды:</p>
            <ul id="laws">
                <li class='text-danger'>с 03.04.20 по 01.01.21 вследствие распространения коронавирусной инфекции; (Постановление Правительства РФ от 02.04.2020 N 423)</li>
                <li class='text-danger'>с 29.03.22 по 31.12.22 на основании действия Постановления Правительства РФ от 26.03.2022 N 479</li>
            </ul>
            <p>Для расчёта неустойки применяется следующая формула:</p>
            <p>Ц * Дпр * Ср * К = Н</p>
            <p>где: Ц – цена, Дпр – количество просроченных дней, Ср – ставка рефинансирования, действующая на момент передачи квартиры или подачи жалобы; К – коэффициент, равный 1/150, если дольщик – гражданин, или 1/300, если дольщик – юридическое лицо.</p>
            <p>При составлении претензии застройщику по ДДУ по неустойке с помощью нашего сервиса электронной генерации документов все расчеты будут произведены автоматически и точно.</p>
        </div>
    </div>
</section>

<script>
    const $ = (el, item = document) => item.querySelector(el);
    const $$ = (el, item = document) => item.querySelectorAll(el);

    // Получение полей ввода
    const fields = {
        sum: $('#sum'),
        date_start: $('#date_start'),
        date_end: $('#date_end'),
        person: $('#person'),
        refinancing: $('#refinancing_type'),
        today: $('#today'),
        action: $('#action'),
        clear: $('#clear'),
        errors: $('#errors')
    }

    // Получение полей данных
    const data = {
        block: $('.data'),
        period: $('#data_period'),
        sum: $('#data_sum'),
        person: $('#data_person'),
        refinancing: $('#data_refinancing'),
    }

    // Получение полей результата
    const result = {
        block: $('.result'),
        sum: $('#result_sum'),
        period: $('#result_period'),
        actual_period: $('#result_actual_period'),
        refinancing: $('#result_refinancing'),
        formula: $('#result_formula'),
        forfeit: $('#result_forfeit'),
    }

    const getRefincancing = async (from, to) => {

        let fd = new FormData();
        fd.append('from', from);
        fd.append('to', to);
        fd.append('_token', $('[name="_token"]').value);

        let r = await fetch(`ставка-рефинансирования`, {
            // mode: "no-cors",
            method: "POST",
            body: fd

        }).then(r => r.json());

        let percent = r.rate;

        return percent;
    }

    fields.date_start.oninput = _ => {
        fields.date_start.classList.remove('is-invalid');
    }

    fields.date_end.oninput = _ => {
        fields.date_end.classList.remove('is-invalid');
    }

    fields.sum.oninput = _ => {
        fields.sum.classList.remove('is-invalid');
    }

    // getRefincancing('19.09.2022', '19.09.2022');
    fields.clear.onclick = () => {
        data.block.classList.add('d-none');
        result.block.classList.add('d-none');

        fields.sum.value = '';
        fields.date_start.value = '';
        fields.date_end.value = '';
    }

    fields.today.onclick = () => {
        let now = new Date();
        let day = ("0" + now.getDate()).slice(-2);
        let month = ("0" + (now.getMonth() + 1)).slice(-2);
        let today = now.getFullYear() + "-" + (month) + "-" + (day);

        fields.date_end.value = today;
    }

    fields.action.onclick = async () => {

        data.block.classList.add('d-none');
        result.block.classList.add('d-none');

        fields.date_start.classList.remove('is-invalid');
        fields.date_end.classList.remove('is-invalid');
        fields.sum.classList.remove('is-invalid');

        let errors = "";
        let valid = true;

        fields.errors.innerHTML = "";

        if (fields.sum.value <= 0) {
            fields.sum.classList.add('is-invalid');
            valid = false;
        }

        if (fields.date_start.value == '') {
            fields.date_start.classList.add('is-invalid');
            valid = false;
        }

        if (fields.date_end.value == '') {
            fields.date_end.classList.add('is-invalid');
            valid = false;
        }

        // console.log(fields.date_start.value);
        let coeff = fields.person.value == 1 ? 2 : 1;

        let rate = 8;
        let sum = 0;

        let a = Date.parse(fields.date_start.value);
        let b = Date.parse(fields.date_end.value);

        let min = new Date('2004-12-30').getTime();
        let max = new Date().getTime();

        if (a > b) {
            valid = false;
            errors += "<div class='alert alert-danger mb-2 mt-2'>Начало периода должно быть раньше конца!</div>";

            fields.date_start.classList.add('is-invalid');
            fields.date_end.classList.add('is-invalid');
        }

        if (a < min) {
            valid = false;
            errors += "<div class='alert alert-danger mb-2 mt-2'>Период не может начинаться раньше 30 декабря 2004!</div>";

            fields.date_start.classList.add('is-invalid');
        }

        if (b > max) {
            valid = false;
            errors += "<div class='alert alert-danger mb-2 mt-2'>Конец периода должен быть не позже сегодняшнего дня!</div>";

            fields.date_end.classList.add('is-invalid');
        }

        if (!valid) {
            fields.errors.innerHTML = errors;
            return;
        }

        let personTypes = {
            1: "физическое лицо",
            2: "юридическое лицо",
        };

        let rateTypes = {
            1: "на день наступления обязательств",
            2: "на день фактического исполнения",
            3: "по периодам действия ставок",
        };

        // получаем количество дней между датами
        let days = Math.floor(Math.abs(b - a) / (1000 * 60 * 60 * 24));

        // Получаем промежуток действия ПП
        let lawStarted = new Date('2022-03-29').getTime() / 1000;
        let lawEnded = new Date('2022-12-31').getTime() / 1000;
        let periodStarted = a / 1000;
        let periodEnded = b / 1000;

        let intersectionStart = Math.max(lawStarted, periodStarted);
        let intersectionEnd = Math.min(lawEnded, periodEnded);


        let intersectionDays = 0;

        if (intersectionStart < intersectionEnd) {
            intersectionDays = intersectionEnd - intersectionStart;
        }


        let actualDays = days - intersectionDays / 60 / 60 / 24;

        if (fields.refinancing.value == 1) {
            rate = await getRefincancing(fields.date_start.value, fields.date_start.value);
            sum += fields.sum.value * coeff * 1 / 300 * rate / 100 * actualDays;
        } else if (fields.refinancing.value == 2) {
            rate = await getRefincancing(fields.date_end.value, fields.date_end.value);
            sum += fields.sum.value * coeff * 1 / 300 * rate / 100 * actualDays;
        } else {
            rate = await getRefincancing(fields.date_start.value, fields.date_end.value);
            rate = rate.toFixed(2);
            sum += fields.sum.value * coeff * 1 / 300 * rate / 100 * actualDays;
        }

        data.block.classList.remove('d-none');
        result.block.classList.remove('d-none');

        let strings1 = fields.date_start.value.split('-');
        let strings2 = fields.date_end.value.split('-');

        let string1 = [strings1[2], strings1[1], strings1[0]].join('.');
        let string2 = [strings2[2], strings2[1], strings2[0]].join('.');

        var formatter = new Intl.NumberFormat('ru-RU', {
            style: 'currency',
            currency: 'RUB',

            // These options are needed to round to whole numbers if that's what you want.
            //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
            //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
        });

        // Заполнение данных
        data.period.innerHTML = `С ${string1} по ${string2}`;
        data.person.innerHTML = personTypes[fields.person.value];
        data.refinancing.innerHTML = rateTypes[fields.refinancing.value];
        data.sum.innerHTML = formatter.format(fields.sum.value);

        // Заполнение результата
        result.sum.innerHTML = formatter.format(fields.sum.value);
        result.period.innerHTML = days;
        result.actual_period.innerHTML = actualDays;
        result.refinancing.innerHTML = `${rate}%`;
        result.formula.innerHTML = `${formatter.format(fields.sum.value)} × ${actualDays} × ${coeff} × 1/300 × ${rate}%`;
        result.forfeit.innerHTML = `${formatter.format(sum)}`;
    }
</script>
@endSection