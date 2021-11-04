<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\v1\TaskCategoriesController;
use App\Http\Controllers\Api\v1\TaskStatusController;
use App\Http\Controllers\Api\v1\UserTasksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tasks', UserTasksController::class);
    Route::get('task-categories/names', [TaskCategoriesController::class, "names"]);
    Route::apiResource('task-categories', TaskCategoriesController::class);
    Route::apiResource('task-statuses', TaskStatusController::class);
    Route::post('logout', function (Request $request) {
        $request->user()->tokens()->delete();

        return response(["message" => "Logged Out"], 204);
    });
});

// Auth
Route::post('/register', [RegisterController::class, 'store'])->name('user.register');
Route::post('/login', [LoginController::class, 'login'])->name('user.login');
