@extends('layouts.default')

@section('title', 'Создать задачу')

@section('content')


    <div class="container py-2">
        <div class="row">
            <div class="col-6 ">
                <h3>Создать новую задачу</h3>
                <form class="row g-3" method="post" action="{{ route('tasks.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12">
                        <label for="name" class="form-label">Название задачи</label>
                        <input name="name" type="text" class="form-control" id="name">
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <textarea name="content" class="form-control" placeholder="Leave a comment here" id="content" style="height: 100px"></textarea>
                            <label for="content">Описание задачи</label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label for="inputUsers" class="form-label">Выбрать исполнителя </label>
                        <select name="user_id" id="inputUsers" class="form-select">
                            <option selected>Выбрать исполнителя </option>
                            @foreach($users as $user)
                                @if($user->role_id !== 1)
                                <option value="{{ $user->id }}">{{$user->name}} {{$user->surname}}</option>
                                @endif
                            @endforeach

                        </select>
                    </div>

                    <fieldset disabled>
                        <div class="col-md-12">
                            <label for="disabledTextInput" class="form-label">Сотрудник отдела</label>
                            <input  type="text" id="disabledTextInput" class="form-control" >
                        </div>
                    </fieldset>

                    <input type="hidden" name="department_id" id="hiddenDepartmentId" value="{{ $user->department_id }}">


                    <div class="col-12">
                        <label for="formFile" class="form-label"><strong>Внимание!</strong> <br> Файл должен иметь следующие расширения: <strong>doc,docx,pdf,pptx,xls,xlsx,txt'</strong>></label>
                        <input name="files[]" class="form-control" type="file" id="files" multiple>
                    </div>


                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Создать задачу</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            const users = @json($users);

            document.addEventListener('DOMContentLoaded', function () {
                const userSelect = document.getElementById('inputUsers');
                const departmentInput = document.getElementById('disabledTextInput');
                const hiddenDepartmentInput = document.getElementById('hiddenDepartmentId');

                userSelect.addEventListener('change', function () {
                    const selectedUserId = this.value;
                    const selectedUser = users.find(user => user.id == selectedUserId);

                    if (selectedUser && selectedUser.department) {
                        departmentInput.value = selectedUser.department.name;
                        hiddenDepartmentInput.value = selectedUser.department.id;
                    } else {
                        departmentInput.value = '';
                        hiddenDepartmentInput.value = '';
                    }
                });
            });
        </script>
    @endpush


@endsection
