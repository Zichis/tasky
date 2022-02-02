<?php

use App\Http\Controllers\Api\v1\TaskStatusController;
use App\Http\Controllers\Api\v1\UserTasksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('my-tasks', UserTasksController::class);
    Route::apiResource('task-statuses', TaskStatusController::class);
});*/
