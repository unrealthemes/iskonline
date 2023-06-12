<x-layout.section bg='{{ $bg }}'>
    <x-layout.container>
        {{-- <span class="d-block fs-4 fw-bold mb-3" id="service">Заполните форму</span> --}}

        {{-- <br> --}}

        @if (!$form)
        <div class="calculator" data-addr='{{ $addr }}' data-service-type='{{ $service->service_type_id }}' data-application='{{ $application ? $application->id : null }}'>

            <div class="block bg-white">
                <div class="calculator-header">
                    <h3 class="mb-3 calculator-title"></h3>
                    <b class="calculator-step-title"></b>
                </div>
                <x-form.form action="{{ route('services.service', $application ? ['service' => $service->id, 'order' => $order, 'application' => $application->id] : ['service' => $service->id, 'order' => $order]) }}">
                    <div class="row">
                        <div class="calculator-content mt-4 mb-4 col-12 col-md-8">

                        </div>
                        <div class="col-12 col-md-4 mt-4">
                            <div class="calculator-description">

                            </div>
                        </div>
                    </div>

                </x-form.form>

                <x-form.btn class='calculator-btn text-white'>Далее</x-form.btn>
                <!-- <span class="text-muted d-block mt-3">
                    * Нажимая на кнопку "Далее", Вы соглашаетесь с <a href="{{ route('license-agreement') }}" class="text-primary" target="_blank">Политикой сайта</a>. Мы не передаём третьим лицам Ваши персональные данные. Они находятся под надёжной защитой.
                </span> -->
            </div>
        </div>
        @else
        <div class="" data-init-form="{{ $form->id }}" data-application='{{ $application ? $application->id : null }}'>@csrf</div>
        @endif
    </x-layout.container>
</x-layout.section>