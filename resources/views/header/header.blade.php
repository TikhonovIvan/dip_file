<header class="bg-dark">
    <nav class="container navbar navbar-expand-lg  border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('users.index') }}">Logo</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Переключатель навигации">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @auth()

                    @else

                    @endauth

                    <li class="nav-item">
                        <a class="nav-link active " aria-current="page" role="button" href="{{ route('users.index') }}">Пользователи</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('roles.index') }}">Роли</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page"
                           href="{{ route('departments.index') }}">Отделы</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="admin/tasks.html">Список задач</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="admin/all_files.html">Все документы</a>
                    </li>
                </ul>

                <div class="btn-group mr-auto">
                    <button class="btn btn-light btn-md " type="button">
                        Добро пожаловать: {{ auth()->user()->name }}
                    </button>
                    <button type="button" class="btn btn-md btn-primary  dropdown-toggle dropdown-toggle-split "
                            data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('user.edit', auth()->user()->id) }}">Аккаунт</a></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Выйти</a></li>
                    </ul>
                </div>


            </div>
        </div>
    </nav>
</header>


<div class="container py-2">
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
