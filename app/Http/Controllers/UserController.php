<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $users = User::with(['department', 'role'])->get();

        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Gate::denies('create-edit-user')){
            abort(403);
        }
        $roles = Role::all();
        $departments = Department::all();

        return view('admin.users.create',[
            'roles' => $roles,
            'departments' => $departments
        ]);
    }





    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Gate::denies('create-edit-user')){
            abort(403);
        }
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:25'],
            'surname' => ['required', 'string', 'max:25'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8' ],
            'role_id' => ['required'],
            'department_id' => ['required'],
            'avatar' => ['nullable','image', 'extensions:jpeg,jpg,png', 'max:15000'],
        ]);

        // Обработка файла аватара (если есть)
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public_uploads');
            $validated['avatar'] = $avatarPath;
        }

        // Хешируем пароль
        $validated['password'] = bcrypt($validated['password']);


        User::create($validated);
        return redirect()->route('users.index')->with('success', 'Новый сотрудник создан');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $authUser = auth()->user();

        // Если пользователь с role_id = 3 и пытается отредактировать не себя
        if ($authUser->role_id == 3 && $authUser->id != $id) {
            abort(403);
        }

        $roles = Role::all();
        $departments = Department::all();

        $user = User::query()->findOrFail($id);
        return view('admin.users.edit',[
            'user' => $user,
            'roles' => $roles,
            'departments' => $departments
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $user = User::query()->findOrFail($id);
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:25'],
            'surname' => ['required', 'string', 'max:25'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8' ],
            'role_id' => ['required'],
            'department_id' => ['required'],
            'avatar' => ['nullable','image', 'extensions:jpeg,jpg,png', 'max:15000'],
        ]);

//        // Определение роли
//        if (auth()->user()?->role?->name === 'Admin') {
//            $adminRole = Role::where('Admin')->first();
//            $roleId = $adminRole?->id;
//        } else {
//            $roleId = $request->input('role_id');
//        }
        // Если загружен новый аватар
        if ($request->hasFile('avatar')) {
            // Удалить старый, если он есть
            if ($user->avatar && Storage::disk('public_uploads')->exists($user->avatar)) {
                Storage::disk('public_uploads')->delete($user->avatar);
            }

            // Загрузить новый
            $avatarPath = $request->file('avatar')->store('avatars', 'public_uploads');
            $validated['avatar'] = $avatarPath;
        }

        // Хешируем пароль
        $validated['password'] = bcrypt($validated['password']);
        $user->update($validated);
        return redirect()->route('user.edit', ['id' => $user->id])->with('success', 'Данные пользователя обновлены');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Gate::denies('create-edit-user')){
            abort(403);
        }
        $user = User::query()->findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Сотрудник был удален');
    }

    //Странице с формой авторизации
    public function loginForm()
    {
        return view('login');

    }

    public function loginAuth(Request $request)
    {

        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($validated)) {
            $user = Auth::user();

            // Перенаправление по ролям
            if ($user->role_id == 3) {
                return redirect()->route('tasks.index')->with('success', 'Добро пожаловать');
            }

            return redirect()->route('users.index')->with('success', 'Добро пожаловать');
        }

        return back()->withErrors([
            'email' => 'Ошибка логин или пароль',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }




}
