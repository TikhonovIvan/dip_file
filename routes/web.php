<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


//Неавторизованный пользователь
Route::middleware('guest')->group(function () {
    Route::get('/', [UserController::class, 'loginForm'])->name('login');
    Route::post('/', [UserController::class, 'loginAuth'])->name('login.auth');
});


//Если пользователь авторизован, то имеет доступ к этим маршрутам
Route::middleware('auth')->group(function () {

    Route::get('/logout', [UserController::class, 'logout'])->name('logout');

    Route::prefix('admin')->group(function () {

        // Users
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('users.index');
            Route::get('/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/create', [UserController::class, 'store'])->name('users.store');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
            Route::put('/{id}', [UserController::class, 'update'])->name('user.update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('user.destroy');

        });

        // Roles
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');

        // Departments
        Route::prefix('departments')->group(function () {
            Route::get('/', [DepartmentController::class, 'index'])->name('departments.index');
            Route::get('/create', [DepartmentController::class, 'create'])->name('departments.create');
            Route::post('/create', [DepartmentController::class, 'store'])->name('departments.store');
            Route::get('/{id}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');
            Route::put('/{id}', [DepartmentController::class, 'update'])->name('departments.update');
            Route::delete('/{id}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
        });

        Route::prefix('tasks')->group(function () {
            Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
            Route::get('/create', [TaskController::class, 'create'])->name('tasks.create');
            Route::post('/create', [TaskController::class, 'store'])->name('tasks.store');

            Route::get('/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');

            Route::get('/show/{id}', [TaskController::class, 'show'])->name('tasks.show');

            Route::put('/{id}', [TaskController::class, 'update'])->name('tasks.update');
            Route::put('/{id}/update-file', [TaskController::class, 'fileUpdate'])->name('tasks.update.file');

            Route::delete('/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
            Route::delete('/{id}/destroy-file', [TaskController::class, 'destroyFile'])->name('tasks.destroy.file');

            Route::get('/download-file/{id}', [TaskController::class, 'fileDownload'])->name('tasks.download.file');

            //Все документы
            Route::get('/all-files', [TaskController::class, 'allFiles'])->name('tasks.all.files');
            Route::get('/all-files/download-file/{id}', [TaskController::class, 'allFileDownload'])->name('tasks.all.files.download');
            Route::get('/all-files', [TaskController::class, 'allFiles'])->name('tasks.all.files');

            Route::get('/autocomplete-files', [TaskController::class, 'autocompleteFiles'])->name('files.autocomplete');







        });


    });
});



