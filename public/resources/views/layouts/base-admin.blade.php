<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>

    <link rel="icon" href="{{ url('images/favicon.png') }}">


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('DataTables/datatables.css') }}" />
    <script type="text/javascript" src="{{ asset('DataTables/datatables.min.js') }}"></script>

    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/app.js') }}" defer></script>
    <script src="{{ asset('/js/admin/admin.js') }}" defer></script>
    <script src="{{ asset('/ace/src-noconflict/ace.js') }}" type="text/javascript" charset="utf-8"></script>
</head>

<body>
    @yield('header')
    <div class="d-flex">
        @yield('sidebar')
        <div class="container-fluid">
            @yield('content')
        </div>

    </div>


    <!-- <script src="{{ asset('/js/app.js') }}"></script> -->
</body>

</html>