@extends('layouts.default')

@section('title', 'Список задач')

@section('content')
    @cannot('create-edit-tasks')
        <div class="container py-2">
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">Создать задачу</a>
        </div>
    @endcannot
    <div class="container py-2">
        <div class="row">
            <div class="col-12">
                <h4 class="text-center pb-2 border-bottom">Список задач </h4>
                <div class="table-responsive">
                    <table class="table align-middle mb-0 bg-white table-striped ">
                        <thead class="bg-light">
                        <tr>
                            <th>Название задачи</th>
                            <th>Исполнитель</th>
                            <th>Отдел</th>
                            <th>Дата создания</th>
                            <th class="text-center">Статус</th>
                            <th class="text-end">Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($tasks as $task)
                                <tr>
                                    <td>
                                        <p class=" fw-normal mb-1 fw-bold" style="font-size: 18px;">{{ $task->name }}</p>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img
                                                src="{{asset("assets/images/{$task->user->avatar}")}}"
                                                alt=""
                                                style="width: 45px; height: 45px"
                                                class="rounded-circle"
                                            />
                                            <div class="ms-3">
                                                <p class="fw-bold mb-1">{{$task->user->name}}</p>
                                                <p class="text-muted mb-0">{{$task->user->email}}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <p class="fw-normal mb-1">{{ $task->department->name}}</p>
                                    </td>
                                    <td>
                                        <p class=" fw-normal mb-1">{{$task->created_at}}</p>
                                    </td>

                                    @if($task->status == 0)

                                        <td class="text-center">
                                            <input type="hidden" value="{{ $task->status }}">
                                            <p class=" fw-normal mb-1 bg-warning text-light rounded w-60">В процессе</p>
                                        </td>
                                    @else
                                        <td class="text-center">
                                            <input type="hidden" value="{{ $task->status }}">
                                            <p class=" fw-normal mb-1 bg-success text-light rounded w-60">Завершен</p>
                                        </td>
                                    @endif



                                    <td class="d-flex gap-1 py-3 align-items-center justify-content-end">
                                        <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                                                <path
                                                    d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                                            </svg>
                                        </a>
                                        @cannot('create-edit-tasks')
                                        <a href="{{route('tasks.edit', $task->id)}}" class="btn btn-success ">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                                            </svg>
                                        </a>

                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal-{{ $task->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                     class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                </svg>
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal-{{ $task->id }}" tabindex="-1" aria-labelledby="exampleModalLabel-{{ $task->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Внимание!</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Если вы удалить задачу, то все документы относящиеся к этой задачи будут удалены.
                                                            <br>
                                                            <br>
                                                            Внимательно ознакомьтесь с данным уведомлением.
                                                            <br>
                                                            <span class="">Название задачи: <strong> {{ $task->name }}</strong></span>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form method="post" action="{{ route('tasks.destroy', $task->id) }}" class="my-2">
                                                                @csrf
                                                                @method('DELETE')

                                                                <span id="countdownText-{{ $task->id }}" class="text-muted small">Ожидайте... 15 сек</span>
                                                                <button class="btn btn-danger" id="confirmDeleteBtn-{{ $task->id }}" disabled>
                                                                    Удалить задачу
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endcannot
                                    </td>
                                </tr>
                        @empty
                            <tr>

                                <td class="text-center" colspan="6">
                                    <p class="pt-2">Список задач пуст</p>
                                </td>

                            </tr>
                        @endforelse
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
