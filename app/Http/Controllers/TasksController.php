<?php

namespace App\Http\Controllers;

use App\Http\Requests\TasksRequest;
use App\Models\Task;

class TasksController extends Controller
{
    protected static $model = Task::class;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tasks = self::$model::all();

            return response()->json($tasks, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Data could not be received', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TasksRequest $request)
    {
        try {
            $newTask = self::$model::create($request->all());
        
            return response()->json($newTask, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $task = self::$model::findOrFail($id);

            return response()->json($task, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Task not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TasksRequest $request, string $id)
    {
        try {
            $task = self::$model::findOrFail($id);
            $task->fill($request->all());

            if (!$task->save()) {
                throw new \Exception('Failed to save');
            }

            return response()->json($task, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Task not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed update', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $task = self::$model::findOrFail($id);
            $task->delete();

            return response()->json(['message' => 'The Task was successfully deleted'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Task not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Deletion failed', 'details' => $e->getMessage()], 500);
        }
    }
}
