<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskPriority;
use App\Models\TaskStatus;
use Illuminate\Http\Request;

class UserTasksController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return Task::where('user_id', $user->id)->with(['priority', 'status'])->orderBy('created_at', 'DESC')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'details' => 'required|max:255',
            'priority' => 'required'
        ]);

        $status = TaskStatus::where(['name' => $request->get('status')['name']])->first();
        $priority = TaskPriority::where(['name' => $request->get('priority')['name']])->first();

        Task::create([
            'title' => $request->get('title'),
            'details' => $request->get('details'),
            'status_id' => $status->id,
            'priority_id' => $priority->id,
            'user_id' => $request->user()->id,
            'createdby_id' => $request->user()->id,
        ]);

        return response([
            'tasks' => Task::where('user_id', request()->user()->id)
                ->with(['priority', 'status'])
                ->orderBy('created_at', 'DESC')
                ->get(),
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
            'status' => 'required',
            'priority' => 'required'
        ]);

        $status = TaskStatus::where(['name' => $request->get('status')['name']])->first();
        $priority = TaskPriority::where(['name' => $request->get('priority')['name']])->first();

        $task->update([
            'title' => $request->get('title'),
            'details' => $request->get('details'),
            'status_id' => $status->id,
            'priority_id' => $priority->id,
        ]);

        return response([
            'tasks' => Task::where('user_id', request()->user()->id)
                ->with(['priority', 'status'])
                ->orderBy('created_at', 'DESC')
                ->get(),
        ]);
    }

    public function destroy(Request $request, Task $task)
    {
        $task->delete();

        return response([
            'tasks' => Task::where('user_id', request()->user()->id)
                ->with(['priority', 'status'])
                ->orderBy('created_at', 'DESC')
                ->get(),
        ]);
    }

    public function show(Request $request, Task $task)
    {
        if ($request->user()->cannot('view', $task)) {
            abort(403);
        }

        return $task->load('priority', 'status');
    }
}
