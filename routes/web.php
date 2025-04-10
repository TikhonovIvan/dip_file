<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RoleController;
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

    });
});



