<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return TaskCollection
     */
    public function index()
    {
        // return TaskResource::collection(Task::all());

        // return new TaskCollection(Task::all());

        return response()->json(new TaskCollection(Task::all()), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return TaskResource
     */
    public function store(Request $request)
    {
        $task = Task::create($request->only([
            'title',
            'description'
        ]));

        return new TaskResource($task);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return TaskResource
     */
    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return TaskResource
     */
    public function update(Request $request, Task $task)
    {
        // Consider adding some authentication that makes sure you have the right to update this specific task
        
        $task->update($request->only([
            'title',
            'description',
            'completed'
        ]));
        
        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        // return response()->json(null, 204);

        return response()->json(['code' => 200, 'message' => 'The specified task was deleted successfully', 'task' => $task], 200);
    }
}
