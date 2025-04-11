@extends('layouts.default')

@section('title', 'Личный кабинет')

@section('content')

    <div class="container py-5">
        <div class="row">
            <div class="col-12 col-md-6 ">
                <h3>Аккаунт пользователя</h3>

                <form class="row g-3" method="post" action="{{route('user.update', $user->id)}}"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="col-md-6">
                        <label for="name" class="form-label">Имя</label>
                        <input name="name" type="text" class="form-control" id="name" value="{{ $user->name }}">
                    </div>
                    <div class="col-md-6">
                        <label for="surname" class="form-label">Фамилия</label>
                        <input name="surname" type="text" class="form-control" id="surname"
                               value="{{ $user->surname }}">
                    </div>
                    <div class="col-12">
                        <label for="email" class="form-label">Email</label>
                        <input name="email" type="email" class="form-control" id="email"
                               placeholder="test@gmail.com" value="{{ $user->email }}">
                    </div>
                    <div class="col-12">
                        <label for="password" class="form-label">Пароль</label>
                        <input name="password" type="password" class="form-control" id="password"
                               placeholder="password">
                    </div>
                    <div class="col-md-6">
                        <label for="department" class="form-label">Отдел</label>
                        <select name="department_id" id="department" class="form-select">

                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{$department->name}}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-6">
                        <label for="role" class="form-label">Роль</label>
                        <select name="role_id" id="role" class="form-select">
                            @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{$role->name}}</option>
                            @endforeach

                        </select>
                    </div>


                    @if($user->avatar)
                        <div class="col-12 d-block d-sm-none ">
                            <img src="{{ asset("assets/images/{$user->avatar}") }}" alt="" style="max-width: 300px; max-height: 300px">
                        </div>
                    @else
                        <div class="col-12 d-block d-sm-none ">
                            <img src="{{ asset("no-avatar.jpg")}}" alt="" style="width: 300px">
                        </div>
                    @endif


                    <div class="col-12">
                        <label for="formFile" class="form-label">Добавить аватарку</label>
                        <input name="avatar" class="form-control" type="file" id="formFile">
                    </div>


                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Изменить</button>
                    </div>
                </form>

            </div>

            @if($user->avatar)
                <div class="col-md-6 mt-5 pt-4 d-none d-sm-block">
                    <img src="{{ asset("assets/images/{$user->avatar}") }}" alt="" style="width: 300px">
                </div>
            @else
                <div class="col-md-6 mt-5 pt-4 d-none d-sm-block">
                    <img src="{{ asset("no-avatar.jpg")}}" alt="" style="width: 300px">
                </div>
            @endif


        </div>

    </div>
@endsection
