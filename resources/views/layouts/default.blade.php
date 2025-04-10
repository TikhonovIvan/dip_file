<!doctype html>
<html lang="ru">
@include('header.head')

@stack('scripts')
<body>
@include('header.header')


<main>
    @yield('content')
</main>


</body>
</html>
