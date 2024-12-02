<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the user's tasks.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $tasks = auth()->user()->tasks;
        return response()->json($tasks);
    }

    /**
     * Store a newly created task in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|string',
        ]);

        $task = auth()->user()->tasks()->create([
            'task' => $request->task,
        ]);

        return response()->json($task);
    }

    /**
     * Remove the specified task from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $task = auth()->user()->tasks()->findOrFail($id);
        $task->delete();

        return response()->json(null, 204);
    }
}
