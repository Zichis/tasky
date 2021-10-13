<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskCategory;
use Illuminate\Http\Request;

class UserTasksController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return Task::where('user_id', $user->id)->with(["taskCategory"])->orderBy('created_at', 'DESC')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'details' => 'required',
            'category' => 'required',
            // TODO: Add color here. This depends on if category is a new category.
            // Color should be red, blue, yellow or green
        ]);

        $category = TaskCategory::firstOrCreate(
            // $request->get("category") can be a string or array
            // TODO: Use a better implementation
            ['name' => $request->get("category")["name"] ?? $request->get("category")],
            ['color' => $request->get("color")]
        );

        Task::create([
            "title" => $request->get("title"),
            "details" => $request->get("details"),
            "task_category_id" => $category->id,
            "user_id" => $request->user()->id,
            "createdby_id" => $request->user()->id
        ]);

        return response(["message" => "Success"], 200);
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|max:50',
            'details' => 'required',
            'task_category.name' => 'required',
        ]);

        $taskCategory = TaskCategory::where("name", $request->get("task_category")["name"])->first();

        $task->update([
            "title" => $request->get("title"),
            "details" => $request->get("details"),
            "task_category_id" => $taskCategory->id,
        ]);

        return response(["message" => "Success"], 200);
    }

    public function show(Request $request, Task $task)
    {
        return $task->load('taskCategory');
    }
}
