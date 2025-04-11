<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Task;
use App\Models\TaskFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        // Если роль исполнителя (role_id = 3), показываем только его задачи
        if ($user->role_id == 3) {
            $tasks = Task::where('user_id', $user->id)
                ->with(['user', 'department'])
                ->latest()
                ->get();
        } else {
            // Иначе показываем все задачи
            $tasks = Task::with(['user', 'department'])
                ->latest()
                ->get();
        }
        return view('admin.tasks.index', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(auth()->user()->role_id == 3){
            abort(403);
        }

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
        if(auth()->user()->role_id == 3){
            abort(403);
        }
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
            'files' => ['required', 'array'], // Обновляем для массива файлов
            'files.*' => ['file', 'mimes:doc,docx,pdf,pptx,xls,xlsx,txt',],
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
            $filePath = $file->store('file', 'public_files'); // Сохраняем файл в папке 'file'

            // Создаем запись в таблице task_files
            $task->files()->create([
                'file' => $filePath, // Сохраняем путь к файлу
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
        if(auth()->user()->role_id == 3){
            abort(403);
        }
        $users = User::with('department')->get(); // З

        $task = Task::with('files')->findOrFail($id);

        return view('admin.tasks.edit', [
            'task' => $task,
            'users' => $users,
        ]);
    }



    public function update(Request $request, string $id)
    {
        if(auth()->user()->role_id == 3){
            abort(403);
        }
        // Находим задачу по ID
        $task = Task::with('files')->findOrFail($id);

        // Валидация входящих данных
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'user_id' => ['required', 'exists:users,id'],
            'department_id' => ['required', 'exists:departments,id'],
            'files' => ['nullable', 'array'], // Массив файлов (может быть пустым)
            'files.*' => ['file', 'mimes:doc,docx,pdf,pptx,xls,xlsx,txt'],
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
        if(auth()->user()->role_id == 3){
            abort(403);
        }
        $task = Task::query()->findOrFail($id);
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Задача удалена');
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
                'mimes:doc,docx,pdf,pptx,xls,xlsx,txt', // Допустимые форматы файлов
            ],
        ]);

        // Обновление статуса задачи
        $task->update([
            'status' => $request->has('status') ? 1 : 0, // Установка статуса как выполненного
        ]);

        // Обработка загруженных файлов
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                // Сохраняем файл
                $filePath = $file->store('file', 'public_files'); // Сохраняем в папке 'file'

                // Создаем запись в таблице task_files
                $task->files()->create([
                    'file' => $filePath, // Сохраняем путь к файлу
                    'original_name' => $file->getClientOriginalName(), // Сохраняем оригинальное имя файла
                ]);
            }
        }

        return redirect()->route('tasks.show', $task->id)->with('success', 'Новый файл добавлен и статус обновлён');
    }




    public function destroyFile(string $id)
    {
        // Найти файл по ID
        $file = TaskFile::findOrFail($id);

        // Удаление файла с диска
        if (Storage::disk('public_files')->exists($file->file)) {
            Storage::disk('public_files')->delete($file->file); // Удаляем файл
        } else {
            return back()->with('error', 'Файл не найден на диске'); // Если файл не найден, выводим ошибку
        }

        // Удаление записи из базы данных
        $file->delete();

        return redirect()->back()->with('success', 'Файл успешно удалён'); // Возврат с сообщением об успехе
    }


    public function fileDownload(string $id)
    {
        $file = TaskFile::findOrFail($id); // Получаем файл по ID

        // Проверяем, существует ли файл
        if (!Storage::disk('public_files')->exists($file->file)) {
            return back()->with('error', 'Файл не найден на диске');
        }

        // Скачиваем файл
        return Storage::disk('public_files')->download($file->file, $file->original_name);
    }




    //Список и форма поиска всех файлов

    public function allFiles(Request $request)
    {
        $query = TaskFile::query();

        if ($request->has('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('original_name', 'like', "%{$search}%")
                    ->orWhereDate('created_at', $search); // если ввели дату, например 2025-04-11
            });
        }

        $allFiles = $query->latest()->get();

        return view('admin.tasks.all-files', compact('allFiles'));

    }

    public function allFileDownload(string $id)
    {
        $file = TaskFile::findOrFail($id); // Получаем файл по ID

        // Проверяем, существует ли файл
        if (!Storage::disk('public_files')->exists($file->file)) {
            return back()->with('error', 'Файл не найден на диске');
        }

        // Скачиваем файл
        return Storage::disk('public_files')->download($file->file, $file->original_name);
    }






}
