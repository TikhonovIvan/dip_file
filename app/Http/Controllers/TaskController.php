<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with(['user', 'department'])->get();
        return view('admin.tasks.index', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::with('department', 'role')->get();

        return view('admin.tasks.create',[
            'users' => $users,

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
            'files' => ['required', 'array'], // Обновляем для массива файлов
            'files.*' => [
                'file',
                'mimes:doc,docx,pdf,xls,xlsx,txt',
            ],
        ]);

        // Создание задачи
        $task = Task::create([
            'name' => $validated['name'],
            'content' => $validated['content'],
            'user_id' => $validated['user_id'],
            'department_id' => $validated['department_id'],
            'status' => 0,
        ]);

        // Сохранение всех файлов в таблицу task_files
        foreach ($request->file('files') as $file) {
            $filePath = $file->store('', 'public_files'); // Сохраняем файл

            // Создаем запись в таблице task_files
            $task->files()->create([
                'file' => 'assets/files/' . $filePath, // Сохраняем путь к файлу
                'original_name' => $file->getClientOriginalName(), // Сохраняем оригинальное имя файла
            ]);
        }

        return redirect()->route('tasks.index')->with('success', 'Задача успешно создана');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::with('files')->findOrFail($id);

        return view('admin.tasks.show', [
            'task' => $task,

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $users = User::with('department')->get(); // З

        $task = Task::with('files')->findOrFail($id);

        return view('admin.tasks.edit', [
            'task' => $task,
            'users' => $users,
        ]);
    }



    public function update(Request $request, string $id)
    {
        // Находим задачу по ID
        $task = Task::with('files')->findOrFail($id);

        // Валидация входящих данных
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'user_id' => ['required', 'exists:users,id'],
            'department_id' => ['required', 'exists:departments,id'],
            'files' => ['nullable', 'array'], // Массив файлов (может быть пустым)
            'files.*' => ['file', 'mimes:doc,docx,pdf,xls,xlsx,txt'],
        ]);

        // Обновление полей задачи
        $task->update([
            'name' => $validated['name'],
            'content' => $validated['content'],
            'user_id' => $validated['user_id'],
            'department_id' => $validated['department_id'],
            'status' => 0, // Изначально не выполнена (или какое значение нужно)
        ]);

        // Обработка загруженных файлов
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filePath = $file->store('', 'public_files'); // Сохраняем файл

                // Создаем запись в таблице task_files
                $task->files()->create([
                    'file' => 'assets/files/' . $filePath, // Путь к файлу
                    'original_name' => $file->getClientOriginalName(), // Оригинальное имя файла
                ]);
            }
        }

        return redirect()->route('tasks.index')->with('success', 'Задача успешно обновлена');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function fileUpdate(Request $request, string $id)
    {
        $task = Task::with('files')->findOrFail($id);

        // Валидация входящих данных
        $validated = $request->validate([
            'status' => ['boolean'], // Статус задачи
            'files' => ['nullable', 'array'], // Массив файлов (может быть пустым)
            'files.*' => [
                'file',
                'mimes:doc,docx,pdf,xls,xlsx,txt', // Допустимые форматы файлов
            ],
        ]);

        // Обновление статуса задачи
        $task->update([
            'status' => $request->has('status') ? 1 : 0, // Установка статуса как выполненного
        ]);

        // Обработка загруженных файлов
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filePath = $file->store('', 'public_files'); // Сохраняем файл

                // Создаем запись в таблице task_files
                $task->files()->create([
                    'file' => 'assets/files/' . $filePath, // Путь к файлу
                    'original_name' => $file->getClientOriginalName(), // Оригинальное имя файла
                ]);
            }
        }

        return redirect()->route('tasks.show', $task->id)->with('success', 'Новый файл добавлен и статус обновлён');
    }

}
