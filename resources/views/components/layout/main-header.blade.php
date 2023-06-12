<x-layout.container>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid py-2">
            <a href="{{ route('home') }}">
                <div class="navbar-brand bg-primary text-light p-2 rounded d-flex align-items-center">

                    <img style="width: 60px" src="{{ asset('/images/logo.svg') }}" alt="Logo">
                    <div class="ms-3">
                        <div class="logo-description">
                            подать в суд
                        </div>
                        <div class="mt-2 logo-title">
                            онлайн
                        </div>
                    </div>

                </div>
            </a>
            <div class="w-100">
                Автоматизированный <br> программный комплекс
            </div>
            <div class="text-nowrap me-3">
                <i class="bi bi-geo-alt-fill"></i>Работаем по всей России
            </div>
            <ul class="navbar-nav d-flex">
                <x-menu.account-menu></x-menu.account-menu>
            </ul>
        </div>
    </nav>
</x-layout.container>