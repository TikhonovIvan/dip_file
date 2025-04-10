@extends('layouts.default')

@section('title', 'Редактирование задачи')

@section('content')
    <div class="container py-2">
        <div class="row">
            <div class="col-6">
                <h3>Редактировать задачу</h3>
                <form class="row g-3" method="post" action="{{ route('tasks.update', $task->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="col-md-12">
                        <label for="name" class="form-label">Название задачи</label>
                        <input name="name" type="text" class="form-control" id="name" value="{{ old('name', $task->name) }}" required>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <textarea name="content" class="form-control" placeholder="Описание задачи" id="content" style="height: 100px" required>{{ old('content', $task->content) }}</textarea>
                            <label for="content">Описание задачи</label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label for="inputUsers" class="form-label">Выбрать исполнителя</label>
                        <select name="user_id" id="inputUsers" class="form-select" required>
                            <option selected disabled>Выбрать исполнителя</option>
                            @foreach($users as $user)
                                @if($user->role_id !== 1)
                                    <option value="{{ $user->id }}" {{ $user->id == $task->user_id ? 'selected' : '' }}>
                                        {{ $user->name }} {{ $user->surname }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label for="disabledTextInput" class="form-label">Сотрудник отдела</label>
                        <input type="text" id="disabledTextInput" class="form-control" value="{{ $task->user->department->name ?? '' }}" readonly>
                    </div>

                    <input type="hidden" name="department_id" id="hiddenDepartmentId" value="{{ $task->department_id }}">

                    <div class="col-12">
                        <label for="formFile" class="form-label">Добавить документ</label>
                        <input name="files[]" class="form-control" type="file" id="files" multiple>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Обновить задачу</button>
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
                        departmentInput.value = selectedUser.department.name; // Обновляем значение отдела
                        hiddenDepartmentInput.value = selectedUser.department.id; // Обновляем скрытое поле
                    } else {
                        departmentInput.value = ''; // Очищаем значение при отсутствии выбранного пользователя
                        hiddenDepartmentInput.value = '';
                    }
                });
            });
        </script>
    @endpush



@endsection
