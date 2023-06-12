@extends('layouts.base')

@section('meta')
@foreach(explode(';', $service->meta) as $meta)
    <meta name="{{ explode('=', $meta)[0] }}" content="{{ explode('=', $meta)[1] }}">
@endForeach
@endSection

@section('title', $service->title)

@section('content')


@php
    $alterHeaders = array(
        1 => 'Составить досудебную претензию (заявление)<br class="d-md-inline d-none"> о взыскании неустойки с&nbsp;застройщика по ДДУ', //застройщик,
        2 => 'Исковое заявление<br>о&nbsp;расторжении брака<br> (с&nbsp;детьми и&nbsp;без)', //брак
        3 => 'Написать претензию<br class="d-md-inline d-none"> на некачественный<br class="d-md-inline d-none"> товар онлайн', //товар,
        4 => 'Территориальная подсудность<br class="d-none d-lg-inline"> мировых и&nbsp;районных судов<br> по&nbsp;всей России', //подсудность
        //5 => 'Калькулятор<br> неустойки по ДДУ', //калькулятор
        8 => 'Определение реквизитов суда для оплаты госпошлины', //реквизиты,
        //26 => 'Проверка <br /> доверенности', //доверенность,
        29 => 'Взыскание алиментов', //'Взыскание алиментов',
        34 => '3 минуты', //'Исковое заявление к застройщику',
    );
@endphp

<div class="header-decor header-decor--{{ $service->id }} header-decor--service"></div>
<section class='hero'>
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <h1>{!! $alterHeaders[$service->id] !!}</h1>

                {{-- <h1>{{ $service->h1 }}</h1> --}}
                <p class='hero-text'>{{ $service->description }}</p>
            </div>
        </div>
    </div>

    <div class="header-decor-mob header-decor-mob--{{ $service->id }} d-block d-lg-none"></div>
</section>

@if ( $service->id == 4 )
<style>
	.yvideo {
			height:670px;
		}

	.adr-item {
		padding:20px;
		font-size:16px;
	}
	
	.adr-item:hover {
		background-color:rgba(3, 157, 223, .1);
	}
	
						ol, ul {
					  padding-left: 1rem;
					  margin-bottom:20px;
					}
					
					li {
						margin-bottom:20px;
					}
					
					li::marker {
						color: #039DDF;
					}
					p {
						font-size: 16px;
						line-height: 140%;
						margin-bottom:20px;
						color: #222222;
						2opacity: 0.8;
						
					}
	
	@media (max-width: 479px) {
		.yvideo {
			height:190px;
		}
		
	.about-list__row {
		padding-right:0px;
		padding-top: 0px;
	}
	
	.about-list .col-lg-4 {
		padding-left: 20px;
		}
		
	.about-list__row h3 {
		margin-top:20px;
	  margin-bottom: 20px;
	  padding-top: 0px;
	}
	
	.btnmt {
		margin-bottom:20px;
	}
	
	}
	



</style>
<section class="section-service-form">
    <x-layout.container>
		<div class="" >
        <div class="form-blue" style="padding-top: 40px;
													padding-right: 50px;
													padding-bottom: 0px;
													padding-left: 50px;" >
            <h2>Определение подсудности всего за 49 рублей!</h2>
            <!--div class="mt-3 d-flex align-items-center gap-2"-->
			<div class="row">
                <div class="col-12 col-md-12 mb-3" >
					<div class="w-100 form-floating">
						<input data-name="null" type="string" class="form-control" id="basic-adr" name="address-address" placeholder="Ваш адрес" value="" onkeyup='data_address()'>
						<label for="address-address">Введите нужный адрес <span class="d-flex-inline align-items-center text-danger">*</span></label>
						<div class="feedback"></div>
						<div id="adr_content" class="datalist shadow rounded overflow-hidden d-none"></div>
					</div>
				</div>
			</div>			
            <div class="row mt-3">
				<div class="col-12 col-md-6 " >
					<div class="row">
						<div class="col-12 col-md-4 " >
							<div class="">
								<a onclick="lets_button_click()" id="serv_4_link" ><button class="btn btn--black btnmt" >Оплатить</button>  </a>      

							</div>
						</div>
						<div class="col-12 col-md-8 " >
							<div class="">
								<p style="font-family: 'Golos'; font-weight: 400; font-size: 13px; line-height: 140%; color: #FFFFFF; opacity: 0.8;" >Нажимая на&nbsp;кнопку «Оплатить»,&nbsp; Вы&nbsp;соглашаетесь с&nbsp;<a href="{{ env('APP_URL') }}правовая-информация" target="_blank" style="color:#fff;" >политикой сайта</a>. Мы&nbsp;не&nbsp;передаём третьим лицам ваши персональные данные. Они&nbsp;находятся под&nbsp;надёжной защитой</p>           

							</div>
						</div>
					</div>
					<div class="col-12 mt-5 mb-5" >
						<div style="background: rgba(34, 34, 34, 0.1);border-radius: 30px;padding:30px;">
							<p style="font-family: 'Golos';
font-style: normal;
font-weight: 400;
font-size: 16px;
line-height: 140%;color:#fff;">
								Иск.Онлайн — фактически единственный сервис, позволяющий быстро и точно установить территориальную подсудность районных и мировых судов
							</p>
						</div>
					</div>
                </div>
				<div class="col-12 col-md-6 mt-3" >
					<div class="" >
						<img src="{{ ENV('APP_URL') }}/img/sud_doc_blocked.png" class="img-fluid" />
					</div>
                </div>
            </div>

            
        </div>
        </div>

    </x-layout.container>
</section>
<script src="{{ asset('/lib/jquery-3.6.1.min.js') }}" ></script>
<script>
	
	function data_address() {
	i=$('#basic-adr').val();
	console.log(i);
		$.get( "{{ ENV('APP_URL') }}data_api/address", { address: i } )
	  .done(function( data ) {
		  
		 // $('#inn-auto').show();		 
		  //console.log(JSON.parse(data));
		 //console.log(data);
		$('#adr_content').removeClass('d-none');
		$('#adr_content').html(data);
	  });
	}
	
	function adr_click(adr) {
		console.log('clicked adr');
		console.log(adr);
		$('#adr_content').addClass('d-none');
		$('#adr_content').empty();
		
		$('#basic-adr').val(adr);
		
		$('#basic-adr').removeClass('is-invalid');

		$('#serv_4_link').attr("href","{{ ENV('APP_URL') }}{{$service->id}}/pay?address-address="+adr);		
		
	}
	
	function lets_button_click() {
		i=$('#basic-adr').val();
		if(i.lenght>0) {
			console.log(i);
		}
		else{
			$('#basic-adr').addClass('is-invalid');
			return false
		}
	}
	/*
	$(document).on('click','.adr-item2',function(){
		console.log('clicked adr');
		console.log($(this).attr('adr'));
		$('#adr_content').addClass('d-none');
		$('#adr_content').empty();
		
		$('#basic-adr').val($(this).attr('adr'));	
		
		
	});*/
	function payment() {
		
	}
	
	jQuery(document).ready(function() {
		console.log('lets start');
		window.onclick = function(event) {
			 console.log('its click');
		   if (event.target.id != "adr_content") {
			  console.log('mimo');
			  $('#adr_content').addClass('d-none');
			  $('#adr_content').empty();
		   }
		}
	});
</script>
@endif
@if ( $service->id != 4 )
<x-service.service-form-section :service="$service"></x-service.service-form-section>
@endif
@if ( $service->id == 4 )
<section class="steps">
    <div class="container">
        <h2>Как мы работаем</h2>
        <ol class="steps__list row">
            <li class="steps__item col-md-4">
                <div class="steps__item-content">
                    <span class="steps__counter">1,</span>
                    Введите адрес Ответчика
                    <span class="steps__text-small">(в отдельных случаях Истца)</span>
                </div>
            </li>
            <li class="steps__item col-md-4">
                <div class="steps__item-content">
                    <span class="steps__counter">2,</span>
                    Оплатите
                    <span class="steps__text-small">
                    Заполните форму за 15 секунд,
                    <br> и оплатите <span style="color: var(--color-theme);">{{ $service->price }} рублей</span></span>
                </div>
            </li>
            <li class="steps__item col-md-4">
                <div class="steps__item-content">
                    <span class="steps__counter">3.</span>
                    Получите наименование<br class="d-md-inline d-none">
                    и реквизиты<br class="d-md-inline d-none"> нужного суда!
                </div>
            </li>
        </ol>
    </div>
</section>

<section>
    <div class="container">
        <h2>Видео о сервисе</h2>
        <br>
        <div class="row">
			<div class="col-12" >
			<iframe class="yvideo" style="max-height:670px;border-radius:25px;" width="100%" src="https://www.youtube.com/embed/DG5-HDol6jw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
			</div>
		</div>
	</div>
</section>
<?php /*
<x-layout.section>
    <x-layout.container>
        <h2 class="text-center">Видео о сервисе</h2>
        <br>
        <x-layout.row>
            @foreach(explode(";", $service->videos) as $video)
            <x-layout.column6>
                <iframe class="rounded shadow" width="100%" height="315" src="{{ $video }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </x-layout.column6>
            @endforeach

        </x-layout.row>
    </x-layout.container>
</x-layout.section> -->
*/ ?>
@endif

<section class="about-list" id="service">
    <div class="container">
        <h2>О сервисе</h2>

        {{-- <div class=""> --}}
            <div class="row">
                <div class="col-12">
                @if ($service->id == 2)
                    <div class="row about-list__row shadow-top">
                        <div class="col-lg-4">
                            <h3>Бракоразводный процесс</h3>
                        </div>
                        <div class="col-lg-8">
                            <p>Бракоразводный процесс – процедура, регулируемая гражданским процессуальным законодательством. Исковое заявление о расторжении брака супруги могут подать как совместно, так и по отдельности. Длительность процесса и способы подачи зависят от взаимности желания расторгнуть брачные отношения, а также от наличия детей и общего имущества.</p>
                        </div>
                    </div>

                    <div class="row about-list__row shadow-top">
                        <div class="col-lg-4">
                            <h3>Законные способы</h3>
                        </div>
                        <div class="col-lg-8">
                            <p>Есть два варианта завершить брак. Через ЗАГС или суд.</p>
                        </div>
                    </div>

                    <div class="row about-list__row shadow-top">
                        <div class="col-lg-4">
                            <h3>Через ЗАГС</h3>
                        </div>
                        <div class="col-lg-8">
                            <p>Для расторжения союза через ЗАГС нужно обратиться с заявлением по месту регистрации брака или жительства. Сотрудники не станут выяснять основания прекращения брачных отношений и распределять имущество.</p>
                            <p>Обратиться можно:</p>
                            <ul>
                                <li>самостоятельно;</li>
                                <li>через доверенное лицо (потребуется нотариальное заверение);</li>
                                <li>Госуслуги;</li>
                                <li>МФЦ.</li>
                            </ul>
                            <p>Условия:</p>
                            <ol>
                                <li>Нет общих несовершеннолетних детей.</li>
                                <li>Отсутствие спора об общем имуществе.</li>
                                <li>Обоюдное желание обеих сторон.</li>
                            </ol>
                            <p>Согласие одного из супругов не требуются, если он недееспособен, признан безвестно отсутствующим или находятся в местах лишения свободы.</p>
                        </div>
                    </div>

                    <div class="row about-list__row shadow-top">
                        <div class="col-lg-4">
                            <h3>Через суд</h3>
                        </div>
                        <div class="col-lg-8">
                            <p>Брак расторгают, если:</p>
                            <ol>
                                <li>Один из супругов не согласен на развод.</li>
                                <li>Есть дети до 18 лет.</li>
                                <li>Есть разногласия об имуществе.</li>
                            </ol>
                            <p>Наличие даже одного из этих критериев обязывает подать на развод через суд.</p>
                            <p>Заявление следует правильно написать, для этого можно скачать готовый бланк. Иначе суд может его отклонить.</p>
                        </div>
                    </div>

                    <div class="row about-list__row shadow-top">
                        <div class="col-lg-4">
                            <h3>Составление иска</h3>
                        </div>
                        <div class="col-lg-8">
                            <p>Исковое заявление составляется по общим правилам статьи 131 ГПК РФ.</p>
                            <p>Иск должен содержать все необходимые по закону реквизиты. Его можно составить самостоятельно, но лучше воспользоваться готовой формой заявления. Это особенно важно, если есть дети. Тогда рекомендуется использовать образец заявления на развод с детьми.</p>
                            <p>В шапке документа указывают:</p>
                            <ol>
                                <li>Наименование суда/ФИО судьи.</li>
                                <li>Персональные данные истца и ответчика (ФИО, адрес, номер телефона).</li>
                            </ol>
                            <p>Если место проживания не совпадает с адресом регистрации, необходимо указать оба адреса.</p>
                            <p>К мировому судье подают иск, если нет разногласий или при имущественных спорах до 50 000 руб. По всем остальным вопросам обращаются в районный суд.</p>
                            <p>Основная часть заявления:</p>
                            <ol>
                                <li>Сведения о месте, дате и ЗАГСе, в котором был зарегистрирован брачный союз.</li>
                                <li>Причины развода.</li>
                            </ol>
                            <p>В этой части важно не переходить на эмоции и писать в сдержанном деловом стиле. Иногда сложно написать реальную причину распада, не все хотят разглашать истинные причины. Юристы рекомендуют указывать нейтральные формулировки, по которым можно понять чёткое намерение обеих сторон. Например, «невозможность примирения и дальнейшего сохранения семейных отношений», «разные взгляды на жизнь», «раздельное проживание».</p>
                            <ol>
                                <li>Сведения об обоюдном согласии. Если муж или жена против – это следует указать.</li>
                                <li>Информация о наличии детей до 18 лет и договорённости об их проживании с одним из родителей.</li>
                                <li>Информация о наличии имущества и договорённостей б его распределении после развода.</li>
                                <li>Ссылка на статью. Достаточно указать статьи 21-23 СК РФ.</li>
                                <li>Заявленные требования.</li>
                                <li>Список приложенных документов.</li>
                            </ol>
                            <p>Подать исковое заявление можно с предъявления дополнительных требований. Например, раздел собственности или определение/решение вопросов, связанных с детьми до 18 лет.</p>
                            <p>Но тогда сам процесс займет больше времени. Если развестись необходимо быстро, следует подать заявление только на прекращение брака. Все имущественные и алиментные споры можно решить после. Для этого законом выделен срок до трёх лет.</p>
                        </div>
                    </div>

                    <div class="row about-list__row shadow-top">
                        <div class="col-lg-4">
                            <h3>Документы</h3>
                        </div>
                        <div class="col-lg-8">
                            <p>Перечень делится на две категории:</p>
                            <ul>
                                <li>обязательные;</li>
                                <li>дополнительные.</li>
                            </ul>
                            <p>К обязательным относятся:</p>
                            <ol>
                                <li>Паспорт.</li>
                                <li>Ксерокопия свидетельства о браке.</li>
                                <li>При наличии: копия свидетельства о рождении детей.</li>
                                <li>Квитанция об оплате госпошлины.</li>
                            </ol>
                            <p>Копии нужно делать в трёх экземплярах, одна будет оставлена в суде, вторая положена истцу, а третья – ответчику.</p>
                            <p>Дополнительно могут понадобиться:</p>
                            <ol>
                                <li>Справки о зарплате.</li>
                                <li>Медицинские справки (в случае нетрудоспособности, беременности жены и т. д.).</li>
                                <li>Документы на собственность.</li>
                                <li>При наличии: брачный договор.</li>
                                <li>По дополнительному запросу: заключение органов опеки, характеристики от работодателя и другие.</li>
                            </ol>
                            <p>Предоставленные документы влияют на ход рассмотрения дела, а в некоторых случаях – на его исход.</p>
                            <p>В иске не должно быть помарок и исправлений. Подойдет как печатный, так и рукописный вариант.</p>
                            <p>Чтобы избежать ошибок, можно скачать готовый образец на нашем сайте. Это минимизирует возможные риски и позволит составить документ правильно.</p>
                        </div>
                    </div>
                @elseif ($service->id == 3)
                    <p>Нередко купленный товар не соответствует заявленным характеристикам. Чтобы решить проблему, может хватить одного документа – претензии. В ней можно предъявлять продавцу различные требования: замена товара, возврат денег, оплата ремонта и др. На нашем сайте можно изучить образец претензии на некачественный товар. Однако оформлять жалобу самостоятельно не стоит. Чтобы документ был составлен правильно, можно воспользоваться нашим сервисом.</p>
                    <div class="about-list__row shadow-top row">
                        <div class="col-lg-4">
                            <h3>Что вправе потребовать покупатель от продавца</h3>
                        </div>
                        <div class="col-lg-8">
                            <p>В правовом поле претензия – документ, направляемый продавцу и содержащий недовольство покупателя качеством исполнения обязательств или их невыполнением. Она составляется письменно и выступает доказательством в суде. При этом устная жалоба не защищается на законодательном уровне.</p>
                            <p>В соответствии со статьей 18 Закона «О защите прав потребителей», недовольный покупатель вправе выдвигать в претензии продавцу одно из следующих требований:</p>
                            <ul>
                                <li>исправления дефекта за счет магазина;</li>
                                <li>обмена некачественного товара на аналогичный новый (при отсутствии такого же изделия допускается заменить его на другое с перерасчетом стоимости);</li>
                                <li>покрытие расходов потребителя, связанных с осуществлением ремонта за свой счет;</li>
                                <li>снижение цены на брак пропорционально значимости недостатка;</li>
                                <li>расторжение сделки и возврат уплаченных средств.</li>
                            </ul>
                            <p>Помимо какого-либо из этих требований, покупатель также имеет право на компенсацию морального вреда. Однако факт получения нефизического ущерба нужно доказать.</p>
                            <p>Так, претензия, направленная в письменном виде, – наиболее правильный способ решения правового конфликта. Как правило, продавцы реагируют на жалобы и идут навстречу потребителю. Магазинам невыгодно принимать участие в судебных тяжбах и портить репутацию. Более того, подача претензии обязательна для лиц, которые намерены обратиться в суд с исковым заявлением. Если покупателем не будет соблюден досудебный порядок урегулирования разногласий, то иск не примут.</p>
                        </div>
                    </div>
                    <div class="about-list__row shadow-top row">
                        <div class="col-lg-4">
                            <h3>Правила оформления претензии</h3>
                        </div>
                        <div class="col-lg-8">
                            <p>Претензия в магазин на некачественный товар в обязательном порядке составляется в письменном виде. Ее можно написать от руки либо напечатать. Устное выражение недовольства не принимает доказательную юридическую силу. При этом на законодательном уровне не закрепляется конкретный шаблон. Напротив, предусматривается составление претензии в свободной форме.</p>
                            <p>Но законодатель предъявляет к содержанию документа некоторые требования. При их несоблюдении претензия будет недействительна. Так, в жалобе должны конкретно определяться заявитель и получатель документа, а также суть конфликта и требования потребителя.</p>
                            <p>Заявитель должен указать в претензии на приобретенный товар ненадлежащего качества:</p>
                            <ul>
                                <li>свои паспортные данные и адрес проживания;</li>
                                <li>контактные данные для обратной связи;</li>
                                <li>сведения о лице, которому адресуется жалоба (реквизиты организации или ИП, местонахождение, контакты);</li>
                                <li>место и дата покупки;</li>
                                <li>полное название купленного изделия или полученной услуги;</li>
                                <li>описание дефекта;</li>
                                <li>выдвигаемое требование и сроки его исполнения;</li>
                                <li>список прилагаемых документов (например, чек, гарантийный талон);</li>
                                <li>подпись заявителя и дата.</li>
                            </ul>
                            <p>Чтобы лучше понять примерную структуру документа, на нашем сайте можно изучить образец претензии на возврат товара ненадлежащего качества. Однако не рекомендуется самостоятельно на основе примера составлять претензию. Каждый случай имеет свои обстоятельства, которые следует принимать во внимание.</p>
                            <p>С помощью нашего сервиса электронной генерации и подачи документов можно без обращения к юристу получить готовую претензию. Для этого нужно заполнить поля формы и оплатить услугу.</p>
                        </div>
                    </div>
                    <div class="about-list__row shadow-top row">
                        <div class="col-lg-4">
                            <h3>Как и куда подавать претензию</h3>
                        </div>
                        <div class="col-lg-8">
                            <p>Недостаточно грамотно сформулировать требования в претензии. Документ требуется еще и правильно направить поставщику, в магазин или другому лицу, выступающему продавцом. Существует несколько способов, как это сделать:</p>
                            <ul>
                                <li>Вручить лично. При этом важно учесть, что экземпляров должно быть два – для продавца и покупателя. Каждая жалоба подписывается обоими участниками спора, а также требуется печать организации или ИП, принимающего письменное обращение. Если продавец отказывается принимать документ или ставить подпись, то необходимо найти свидетелей и при них поставить отметки в бланках об отказе принять претензию к рассмотрению.</li>
                                <li>Отправить по почте заказным письмом с описью вложения. Направив претензию таким образом, у потребителя будут доказательства отправки. Для суда следует сохранить документ, выданный на почте. Если адресат будет игнорировать почтовое отправление, требуется обращаться в орган правосудия. Претензионный (досудебный) порядок будет считаться выполненным.</li>
                            </ul>
                            <p>Направить жалобу вправе как потребитель, так и его представитель, действующий в рамках нотариально заверенной доверенности.</p>
                        </div>
                    </div>
                    <div class="about-list__row shadow-top row">
                        <div class="col-lg-4">
                            <h3>Срок предъявления претензии</h3>
                        </div>
                        <div class="col-lg-8">
                            <p>В законодательстве устанавливаются различные сроки для подачи жалобы продавцу. Длительность периода, когда допускается пожаловаться на качество оказанной услуги или купленной продукции, зависит от категории товара или вида услуги, а также от предъявляемых требований:</p>
                            <ul>
                                <li>если потребитель намерен оформить возврат, то на это законом выделяется 14 дней;</li>
                                <li>если товар имеет срок службы, то претензия подается в течение установленного времени;</li>
                                <li>если на продукте не указан срок службы, то по общему правилу пожаловаться на качество можно в течение 10 лет со дня покупки;</li>
                                <li>если у товара был выявлен недостаток, но гарантийный срок истек либо изначально не был установлен, срок подачи претензии составляет 2 года;</li>
                                <li>если во время эксплуатации обнаружится серьезный дефект, то жалоба может быть оформлена в период всего срока службы изделия;</li>
                                <li>если вследствие применения товара по назначению был причинен вред здоровью или имуществу, то требовать компенсацию можно в любой момент.</li>
                            </ul>
                            <p>Договором могут быть предусмотрены и другие сроки. Однако участники сделки не вправе установить для подачи претензии период меньше, чем указан в законе. Если уладить конфликт мирным путем не удается, покупателю следует обращаться в судебный орган.</p>
                            <p>Составить претензию на некачественный товар и иск в суд можно с помощью нашего сервиса. Документы составляются правильно и с учетом конкретных обстоятельств. Это эффективнее самостоятельного составления, но дешевле обращения к юристам.</p>
                        </div>
                    </div>
                @elseif ($service->id == 4)
                    <div class="about-list__row shadow-top row">
                        <div class="col-lg-4">
                            <h3>Основное</h3>
                        </div>
                        <div class="col-lg-8">
                            <p>Для того, чтобы ваше исковое заявление рассмотрели и вынесли по нему решение, важно, соблюсти правила о подсудности. Для того, чтобы обычному человеку или его адвокату определить, в какой районный суд или мировой судебный участок подать исковое заявление, потребуется много времени.</p>
                            <p>Именно суды общей юрисдикции (мировые судьи, районные суды) уполномочены рассматривать дела с участием граждан.</p>
                            <p>Споры между компаниями, предпринимателями по поводу ведения бизнеса, исполнения договоров разрешают арбитражные суды.</p>
                        </div>
                    </div>
                    <div class="about-list__row shadow-top row">
                        <div class="col-lg-4">
                            <h3>Какой суд общей юрисдикции выбрать</h3>
                        </div>
                        <div class="col-lg-8">
                            <p>Затруднительно разрешить вопрос о территориальной подсудности гражданского спора. 90 % исков предъявляются в районный или мировой суд по месту жительства ответчика. Иск к организации &mdash; по ее юридическому адресу. Реже, например, иски по трудовым, потребительским спорам, подаются в суд по месту регистрации самого истца.</p>
							<p>Но, даже зная нужный адрес, выяснить, к какому именно суду соответствующего уровня он относится, непросто. В Москве особая путаница возникает при распределении дел между участками мировых судей.</p>
                        </div>
                    </div>
                    <div class="about-list__row shadow-top row">
                        <div class="col-lg-4">
                            <h3>Компетенция мировых судей</h3>
                        </div>
                        <div class="col-lg-8">
                            <p>У мирового судьи рассматриваются более &laquo;простые&raquo; дела. Они часто имеют бесспорный характер и требуют минимум доказательной базы.</p>
							<p>К компетенции мирового суда относят следующие категории гражданских дел:</p>
							<ul>
								<li>о выдаче судебного приказа;</li>
								<li>о расторжении брака, если между супругами отсутствует спор о детях;</li>
								<li>о разделе совместного имущества при цене иска, не более 50 тыс. руб.;</li>
								<li>по имущественным спорам, возникающим в сфере защиты прав потребителей, при цене иска, не более 100 тыс. руб. и др.</li>
							</ul>
                        </div>
                    </div>
                    <div class="about-list__row shadow-top row">
                        <div class="col-lg-4">
                            <h3>Подсудность районных судов</h3>
                        </div>
                        <div class="col-lg-8">
							<p>Если первый вариант не подходит, можно обратиться в другую судебную инстанцию &mdash; районный суд. Здесь решают более сложные дела или с большей суммой денежных требований.</p>
                        </div>
                    </div>
					<div class="about-list__row shadow-top row">
                        <div class="col-lg-4">
                            <h3>Как найти</h3>
                        </div>
                        <div class="col-lg-8">
							<p>Для подачи иска гражданину потребуется определить конкретный суд общей юрисдикции с учетом административно-территориального деления города и знанием адреса ответчика (редко: используя свой адрес), куда будет направлено исковое заявление.</p>
                        </div>
                    </div>
                    <div class="about-list__row shadow-top shadow-bottom row">
                        <div class="col-lg-4">
                            <h3>Онлайн-форма</h4>
							
							<div class="d-none d-lg-block" style="margin-top: 210px;">
								<div class="" style="font-weight: 600;
font-size: 20px;
line-height: 140%;" >Поделиться</div>
                            <ul class="social-list">
								<script src="https://yastatic.net/share2/share.js"></script>
<div class="ya-share2" data-curtain data-size="l" data-shape="round" data-services="vkontakte,odnoklassniki,telegram"></div>

                               <?php /* <div class="social-list__item">
                                    <a href="#" class="social-list__link social-list__link--ok">
                                        <svg class="social-list__item-icon">
                                            <use xlink:href="{{ ENV('APP_URL') }}img/sprite-social.svg#ok"></use>
                                        </svg>
                                        <svg class="social-list__item-icon social-list__item-icon--hover">
                                            <use xlink:href="{{ ENV('APP_URL') }}img/sprite-social.svg#ok--dark"></use>
                                        </svg>
                                        Одноклассники
                                    </a>

                                </div>
                                <div class="social-list__item">
                                    <a href="#" class="social-list__link">
                                        <svg class="social-list__item-icon">
                                            <use xlink:href="{{ ENV('APP_URL') }}img/sprite-social.svg#vk"></use>
                                        </svg>
                                        <svg class="social-list__item-icon social-list__item-icon--hover">
                                            <use xlink:href="{{ ENV('APP_URL') }}img/sprite-social.svg#vk--dark"></use>
                                        </svg>
                                        Вконтакте
                                    </a>
                                </div>
                                <div class="social-list__item">
                                    <a href="#" class="social-list__link">
                                        <svg class="social-list__item-icon">
                                            <use xlink:href="{{ ENV('APP_URL') }}img/sprite-social.svg#tg"></use>
                                        </svg>
                                        <svg class="social-list__item-icon social-list__item-icon--hover">
                                            <use xlink:href="{{ ENV('APP_URL') }}img/sprite-social.svg#tg--dark"></use>
                                        </svg>
                                        Телеграм
                                    </a>
                                </div>*/?>
                            </ul>
							</div>
                        </div>
                        <div class="col-lg-8">
                            <p>Онлайн форма поможет обычному человеку (потенциальному истцу) или адвокату по гражданским делам быстро решить проблему с определением территориальной подсудности.</p>
							<p>Потребуется только ввести в предложенное поле адрес ответчика (в отдельных случаях истца) и внести минимальную плату.</p>
							<p>Через несколько секунд система автоматически найдет и предоставит наименования, адреса, контакты судов общей юрисдикции: участок мирового судьи и районный суд.</p>
							<p>Кроме того, сервис предоставит реквизиты суда, которые понадобятся для оплаты госпошлины.</p>
							<div class="row d-lg-none d-xs-block" >
								<div class="col-4" style="font-weight: 600;
font-size: 20px;
line-height: 140%;margin-top: 15px;" >Поделиться</div>

<div class="col-8">
                            <ul class="social-list">
								<script src="https://yastatic.net/share2/share.js"></script>
<div class="ya-share2" data-curtain data-size="l" data-shape="round" data-services="vkontakte,odnoklassniki,telegram"></div>

    
                            </ul>
							</div>
							</div>
                        </div>
                    </div>
					
					<div class="about-list__row row">
                        <div class="col-lg-4">
                            <h3 style="font-weight: 600;
font-size: 40px;
line-height: 48px;" >Отзывы</h3>
                        </div>
                        <div class="col-lg-8">
                            <!-- <img src="{{ ENV('APP_URL') }}images/otzivi.png" class="img-fluid" />-->
							<div style="width:100%;height:800px;overflow:hidden;position:relative;"><iframe style="width:100%;height:100%;border:1px solid #e6e6e6;border-radius:8px;box-sizing:border-box" src="https://yandex.ru/maps-reviews-widget/184616354139?comments"></iframe><a href="https://yandex.ru/maps/org/isk_onlayn/184616354139/" target="_blank" style="box-sizing:border-box;text-decoration:none;color:#b3b3b3;font-size:10px;font-family:YS Text,sans-serif;padding:0 20px;position:absolute;bottom:8px;width:100%;text-align:center;left:0;overflow:hidden;text-overflow:ellipsis;display:block;max-height:14px;white-space:nowrap;padding:0 16px;box-sizing:border-box">Иск. онлайн на карте Москвы — Яндекс Карты</a></div>
                        </div>
                    </div>
					
					<?php /*
					<div class="row">
                        <div class="col-lg-12 mt-5" style="text-align:justify;">
                            <?php foreach($cities as $city) { ?>
								<a class="my-3" href="{{ env('APP_URL') }}определение-подсудности-<?php echo mb_strtolower($city); ?>" alt="определение-подсудности-{{ $city }}" title="определение-подсудности-{{ $city }}" ><?php echo ucfirst($city); ?></a>
								
							<?php } ?>
                        </div>
                    </div>
					*/ ?>
						<?php /*
                    <div class="about-list__row shadow-top row">
                        <div class="col-lg-4">
                            <h3>Подсудность районных судов</h4>
                        </div>
                        <div class="col-lg-8">
                            <p>Если первый вариант не подходит, можно обратиться в другую судебную инстанцию. Здесь решают более сложные дела, в том числе:</p>
                            <ul>
                                <li>о неоднозначных спорных ситуациях;</li>
                                <li>где требуется несколько заседаний, как минимум два;</li>
                                <li>сумма иска превышает 50 т. р.;</li>
                                <li>нужно определить наследников;</li>
                                <li>распределение имущества, которое не входит в рамки рассмотрения предыдущей инстанции;</li>
                                <li>другие, которые не подходят под упрощенный порядок.</li>
                            </ul>
                            <p>Это основные причины обращения граждан. Могут быть и иные.</p>
                        </div>
                    </div>
				
                    <div class="about-list__row shadow-top row">
                        <div class="col-lg-4">
                            <h3>Критерии</h3>
                        </div>
                        <div class="col-lg-8">
                            <p>Чтобы верно узнать модуль территориальной подсудности стоит:</p>
                            <ul>
                                <li>Указать предмет разногласий. Возможно, не удастся отразить все в одном заявлении.</li>
                                <li>Выяснить наличие спора. В некоторых случаях присутствие ответчика необязательно.</li>
                            </ul>
                            <p>Важно. Если второй участник дела должен присутствовать и есть спор, иск подают по месту его жительства. Это базовое правило для определения места разбирательства.</p>
                            <p>Чтобы узнать территориальную подсудность по адресу, рекомендуют ответить на три главных вопроса:</p>
                            <ul>
                                <li>«Сложность» дела.</li>
                                <li>Наличие разногласий между сторонами.</li>
                                <li>Цена требований.</li>
                            </ul>
                            <p>Тут также учитывается возможность решения делать без оппонента. Если спора нет – то нужно идти в мировой суд.</p>
                            <p>Далее можно определить подсудность по территориальности онлайн.</p>
                        </div>
                    </div>
                    <div class="about-list__row shadow-top row">
                        <div class="col-lg-4">
                            <h3>Онлайн-форма</h3>
                        </div>
                        <div class="col-lg-8">
                            <p>Онлайн форма помогает быстро решить проблему с определением подсудности. </p>
                            <p>Для этого нужно:</p>
                            <ul>
                                <li>Определить требования.</li>
                                <li>Выбрать вид участка.</li>
                                <li>Заполнить поля на сайте, указав адрес.</li>
                            </ul>
                            <p>После этого система найдет нужный участок.</p>
                            <p>Онлайн-поиск полезен, когда нет определенности, куда точно обращаться. Например, гражданину нужно подать заявление в московский городской суд. Но он не знает в какой.</p>
                            <p>Сервис на сайте поможет узнать нужный участок быстро и правильно.</p>
                        </div>
                    </div>
					*/?>

                @else
                    {!! $service->text !!}
                @endif
                </div>
            </div>
        {{-- </div> --}}
    </div>
</section>

{{--
<!-- <x-layout.section>
    <x-layout.container>
        <h2 class="text-center">Видео о сервисе</h2>
        <br>
        <x-layout.row>
            @foreach(explode(";", $service->videos) as $video)
            <x-layout.column6>
                <iframe class="rounded shadow" width="100%" height="315" src="{{ $video }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </x-layout.column6>
            @endforeach

        </x-layout.row>
    </x-layout.container>
</x-layout.section> -->
--}}

<section class="blog">
    <div class="container">
        <h2>Блог по теме</h2>
        <a href="{{ route('blog') }}" class="blog__more btn--white">Все статьи</a>

        <div class="blog__slider-wrapper">
          <x-blog.blog-list limit="-1"></x-blog.blog-list>
        </div>
    </div>
</section>

@endSection
