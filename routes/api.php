<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\v1\TaskCategoriesController;
use App\Http\Controllers\Api\v1\TasksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('tasks', TasksController::class);
    Route::resource('task-categories', TaskCategoriesController::class);
    Route::delete('logout', function (Request $request) {
        $request->user()->tokens()->delete();

        return response(["message" => "Logged Out"], 204);
    });
});

// Auth
Route::post('/register', [RegisterController::class, 'store'])->name('user.register');
Route::post('/login', [LoginController::class, 'login'])->name('user.login');
