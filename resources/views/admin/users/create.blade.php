@extends('layouts.default')

@section('title', 'Создание пользователя')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-12 col-md-6">
                <h3>Создание пользователя</h3>
                <form class="row g-3" method="post" action="{{ route('users.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-6">
                        <label for="name" class="form-label">Имя</label>
                        <input name="name" type="text" class="form-control" id="name">
                    </div>
                    <div class="col-md-6">
                        <label for="surname" class="form-label">Фамилия</label>
                        <input name="surname" type="text" class="form-control" id="surname">
                    </div>

                    <div class="col-12">
                        <label for="formFile" class="form-label">Добавить аватарку</label>
                        <input name="avatar" class="form-control" type="file" id="formFile">
                    </div>
                    <div class="col-md-6">
                        <label for="department" class="form-label">Отдел</label>
                        <select name="department_id" id="department" class="form-select">
                            <option selected>Выберите отдел</option>
                            @foreach($departments as $department)
                                <option  value="{{ $department->id }}">{{$department->name}}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-6">
                        <label for="role" class="form-label">Роль</label>
                        <select name="role_id" id="role" class="form-select">
                            <option selected>Выберите роль </option>
                            @foreach($roles as $role)
                                @if($role->name !== 'Admin')
                                    <option value="{{ $role->id }}">{{$role->name}}</option>
                                @endif
                            @endforeach

                        </select>
                    </div>

                    <div class="col-6">
                        <label for="email" class="form-label">Email</label>
                        <input name="email" type="email" class="form-control" id="email"
                               placeholder="test@gmail.com">
                    </div>
                    <div class="col-6">
                        <label for="password" class="form-label">Пароль</label>
                        <input name="password" type="password" class="form-control" id="password"
                               placeholder="password">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Создать</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection

