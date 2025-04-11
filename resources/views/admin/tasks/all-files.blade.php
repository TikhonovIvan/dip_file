@extends('layouts.default')

@section('title', 'Все документы')

@section('content')
    <div class="container py-4">
        <div class="row mb-4">
            <div class="col-12 col-md-6 ">
                <form method="GET" action="{{ route('tasks.all.files') }}">
                    <div class="input-group">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Поиск по названию файла или дате...">
                        <button class="btn btn-primary" type="submit">Найти</button>
                    </div>
                </form>
            </div>
        </div>



        <div class="row">
            <div class="col-12">
                <h3 class="mb-4 pb-2 border-bottom">История файлов</h3>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                        <tr>
                            <th>Название</th>
                            <th class="text-center">Дата создания</th>
                            <th class="text-end ">Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($allFiles as $allFile)
                            <tr>
                                <td>{{$allFile->original_name}}</td>
                                <td class="text-center">{{$allFile->created_at}}</td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('tasks.all.files.download', $allFile->id) }}" type="button" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-download"></i> Скачать
                                        </a>

{{--                                        <button type="button" class="btn btn-sm btn-outline-danger">--}}
{{--                                            <i class="bi bi-trash"></i> Удалить--}}
{{--                                        </button>--}}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td></td>
                                <td class="text-center">Файлов нет</td>
                                <td>
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
