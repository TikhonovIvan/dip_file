<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Вход в систему</title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

</head>
<body>

<main>
    <div class="container mt-5  ">
        <div class="row d-flex justify-content-center">
            <div class="col-6 text-center">


                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="list-unstyled">
                            @foreach ($errors->all() as $error)
                                <li> <strong>{{ $error }}</strong> </li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{session('success')}}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>

    </div>
    <div class="container d-flex justify-content-center align-items-center min-vh-50">
        <div class="row">
            <div class="col-6" style="width: 400px">
                <form method="post" action="{{ route('login.auth') }}" class="bg-light p-4 rounded shadow-sm">
                    @csrf
                    <h3 class="text-center mb-4">Вход в систему</h3>
                    <div class="mb-3">
                        <label for="email" class="form-label">Адрес электронной почты</label>
                        <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль</label>
                        <input name="password" type="password" class="form-control" id="password">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Войти</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
