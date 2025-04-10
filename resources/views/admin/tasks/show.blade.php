@extends('layouts.default')

@section('title', 'Задача')

@section('content')

    <div class="container py-4">
        <div class="row">
            <div class="col-12">

                    <h4 class="text-center pb-2 border-bottom">{{ $task->name }}</h4>

                    <div class="col-8">
                        <h3>Условие задачи</h3>
                        <p>{{ $task->content }}</p>

                        <p>Дата создание задачи: {{$task->created_at}}</p>

                        <form method="post" action="{{ route('tasks.update.file', $task->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-check">
                                <input name="status" class="form-check-input" type="checkbox" value="{{$task->status}}" id="checkDefault"
                                    {{ $task->status ? 'checked' : '' }}>
                                <label class="form-check-label" for="checkDefault">
                                    Выполнено
                                </label>
                            </div>
                            <div class="col-12 py-3">
                                <label for="formFile" class="form-label">Добавить добавить файл</label>
                                <input name="files[]" class="form-control" type="file" id="files" multiple>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                            </div>
                        </form>
                    </div>


            </div>
        </div>

        <div class="col-12 pt-4">
            <h3 class="mb-4 pb-2 border-bottom">История файлов</h3>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                    <tr>
                        <th>Название</th>
                        <th>Дата создания</th>
                        <th class="text-end pe-5">Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($task->files as $result_file)
                        <tr>
                            <td>{{ $result_file->original_name }}</td>
                            <td>{{ $result_file->created_at }}</td>
                            <td class="text-end">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-download"></i> Скачать
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Удалить
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
