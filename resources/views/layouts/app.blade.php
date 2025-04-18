<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}} ">
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}" defer></script>
    <!-- Подключение иконок Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <title>@yield('title')</title>
</head>

{{--@stack('scripts')--}}
<body>
@include('layouts.header')


<main>
    @yield('content')

</main>


@yield('scripts')

</body>
</html>
