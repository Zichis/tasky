<?php

use App\Http\Controllers\Api\v1\TasksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('task', TasksController::class);

Route::middleware(['cors'])->get('/tasks', function (Request $request) {
    return [
        [
            "id" => 1,
            "details" => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam et excepturi vitae dolor assumenda",
            "category" => [
                "name" => "Management",
                "color" => "red"
            ]
        ],
        [
            "id" => 2,
            "details" => "perferendis a modi quod iusto quo repellat repudiandae tenetur commodi dicta doloribus inventore sunt",
            "category" => [
                "name" => "Sales",
                "color" => "yellow"
            ]
        ],
    ];
});
