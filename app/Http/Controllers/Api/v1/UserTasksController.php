<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskCategory;
use App\Models\TaskStatus;
use Illuminate\Http\Request;

class UserTasksController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return Task::where('user_id', $user->id)->with(["taskCategory", "status"])->orderBy('created_at', 'DESC')->get();
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

        $category = TaskCategory::where([
            'name' => $request->get("category")["name"],
            'user_id' => $request->user()->id
        ])->first();

        if (is_null($category)) {
            $category = TaskCategory::create([
                'name' => $request->get("category")["name"],
                'user_id' => $request->user()->id,
                'color' => $request->get("color")
            ]);
        }

        $status = TaskStatus::where(["name" => $request->get("status")["name"]])->first();

        Task::create([
            "title" => $request->get("title"),
            "details" => $request->get("details"),
            "status_id" => $status->id,
            "task_category_id" => $category->id,
            "user_id" => $request->user()->id,
            "createdby_id" => $request->user()->id
        ]);

        return response([
            "tasks" => Task::where('user_id', request()->user()->id)
                ->with(["taskCategory", "status"])
                ->orderBy('created_at', 'DESC')
                ->get(),
            "categories" => TaskCategory::where("user_id", request()->user()->id)
                ->with("tasks")
                ->get()
        ]);
    }

    public function update(Request $request, Task $task)
    {
        if ($request->user()->cannot('update', $task)) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|max:50',
            'details' => 'required',
            'task_category.name' => 'required',
            'status' => 'required'
        ]);

        $currentTaskCategory = $task->taskCategory;

        $taskCategory = TaskCategory::where("name", $request->get("task_category")["name"])->first();

        $status = TaskStatus::where(["name" => $request->get("status")["name"]])->first();

        if ($currentTaskCategory->tasks->count() == 1 && $taskCategory->id != $currentTaskCategory->id) {
            $currentTaskCategory->delete();
        }

        $task->update([
            "title" => $request->get("title"),
            "details" => $request->get("details"),
            "task_category_id" => $taskCategory->id,
            "status_id" => $status->id
        ]);

        return response([
            "tasks" => Task::where('user_id', request()->user()->id)
                ->with(["taskCategory", "status"])
                ->orderBy('created_at', 'DESC')
                ->get(),
            "categories" => TaskCategory::where("user_id", request()->user()->id)
                ->with("tasks")
                ->get()
        ]);
    }

    public function destroy(Request $request, Task $task)
    {
        $category = $task->taskCategory;
        $task->delete();

        if ($category->tasks->count() < 1) {
            $category->delete();
        }

        return response([
            "tasks" => Task::where('user_id', request()->user()->id)
                ->with(["taskCategory", "status"])
                ->orderBy('created_at', 'DESC')
                ->get(),
            "categories" => TaskCategory::where("user_id", request()->user()->id)
                ->with("tasks")
                ->get()
        ]);
    }

    public function show(Request $request, Task $task)
    {
        if ($request->user()->cannot('view', $task)) {
            abort(403);
        }
        return $task->load('taskCategory', 'status');
    }
}
