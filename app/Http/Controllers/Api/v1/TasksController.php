<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return Task::where('user_id', $user->id)->with(["taskCategory"])->get();
    }
}
