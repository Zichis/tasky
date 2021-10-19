<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\TaskCategory;
use Illuminate\Http\Request;

class TaskCategoriesController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // TODO: Get only user categories
        return TaskCategory::with("tasks")->where("user_id", $user->id)->get();
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function names(Request $request)
    {
        return TaskCategory::where("user_id", request()->user()->id)->pluck("name");
    }
}
