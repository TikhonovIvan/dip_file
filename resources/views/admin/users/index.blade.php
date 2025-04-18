@extends('layouts.app')

@section('title', 'Пользователи')

@section('content')
    @can('create-edit-user')
        <div class="container py-2">
            <a href="{{ route('users.create') }}" class="btn btn-primary">Создать пользователя</a>
        </div>
    @endcan

    <div class="container py-2">
        <div class="row">
            <div class="col-12">
                <h4 class="text-center pb-2 border-bottom">Список пользователей </h4>
                <div class="table-responsive">
                    <table class="table align-middle mb-0 bg-white table-striped ">
                        <thead class="bg-light">
                        <tr>
                            <th>ФИО / Email</th>
                            <th>Роль</th>
                            <th>Отдел</th>
                            @can('create-edit-user')
                                <th class="text-end">Действие</th>
                            @endcan
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            @if($user->role->name !== 'Admin')
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($user->avatar)
                                                <img
                                                        src="{{ asset("assets/images/{$user->avatar}") }}"
                                                        alt=""
                                                        style="width: 45px; height: 45px"
                                                        class="rounded-circle"
                                                />
                                            @else
                                                <img
                                                        src="{{ asset("no-avatar.jpg") }}"
                                                        alt=""
                                                        style="width: 45px; height: 45px"
                                                        class="rounded-circle"
                                                />
                                            @endif

                                            <div class="ms-3">
                                                <p class="fw-bold mb-1">{{ $user->name }} {{ $user->surname }}</p>
                                                <p class="text-muted mb-0">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="fw-normal mb-1">{{ $user->role->name }}</p>
                                    </td>
                                    <td>
                                        <p class="fw-normal mb-1">{{ $user->department->name }}</p>
                                    </td>
                                    @can('create-edit-user')

                                        <td class="d-flex gap-1 py-3 justify-content-end">
                                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-success ">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                    <path
                                                            d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                                                </svg>
                                            </a>
                                            <form method="post" action="{{ route('user.destroy', $user->id) }}">
                                                @csrf
                                                @method('DELETE')

                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal-{{$user->id}}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor"
                                                         class="bi bi-trash" viewBox="0 0 16 16">
                                                        <path
                                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                        <path
                                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                    </svg>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal-{{$user->id}}" tabindex="-1"
                                                     aria-labelledby="exampleModalLabel-{{$user->id}}"
                                                     aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                    Внимание!</h1>
                                                                <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Если удалить пользователя, то <strong>все
                                                                    задачи</strong>, относящиеся к этому пользователю
                                                                будут удалены.
                                                                <br>
                                                                <br>
                                                                Внимательно ознакомьтесь с данным пунктом.
                                                                <br>
                                                                <span class="">Пользователь:  <strong> {{ $user->name }} {{ $user->surname }}</strong></span>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form method="post"
                                                                      action="{{ route('user.destroy', $user->id) }}">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <span id="countdownText-{{$user->id}}"
                                                                          class="text-muted small">Ожидайте... 15 сек</span>
                                                                    <button class="btn btn-danger"
                                                                            id="confirmDeleteBtn-{{$user->id}}"
                                                                            disabled>
                                                                        Удалить пользователя
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>

                                    @endcan
                                </tr>
                            @endif

                        @endforeach


                        </tbody>
                    </table>
                </div>
            </div>

        </div>


    </div>

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/main.js') }}"></script>
@endsection
