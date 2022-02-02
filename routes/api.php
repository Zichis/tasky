<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\OrganizationRegisterController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\v1\TaskPriorityController;
use App\Http\Controllers\Api\v1\TaskStatusController;
use App\Http\Controllers\Api\v1\UserTasksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth
Route::post('/register', [RegisterController::class, 'store'])->name('user.register');
Route::post('/register-organization', [OrganizationRegisterController::class, 'store'])->name('company.register');
Route::post('/login', [LoginController::class, 'login'])->name('user.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tasks', UserTasksController::class);
    Route::apiResource('task-statuses', TaskStatusController::class);
    Route::apiResource('task-priorities', TaskPriorityController::class);
    Route::post('logout', function (Request $request) {
        $request->user()->tokens()->delete();

        return response(['message' => 'Logged Out'], 204);
    });
});
