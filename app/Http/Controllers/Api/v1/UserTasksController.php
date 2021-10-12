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
            ['name' => $request->get("category")["name"]],
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
}
