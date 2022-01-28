<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskPriorityResource;
use App\Models\TaskPriority;
use Illuminate\Http\Request;

class TaskPriorityController extends Controller
{
    public function index(Request $request)
    {
        return TaskPriorityResource::collection(TaskPriority::all());
    }
}
