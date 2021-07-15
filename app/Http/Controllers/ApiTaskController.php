<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\Todolist;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ApiTaskController extends Controller
{
    public function __construct() {
        $this->middleware(['auth:sanctum', 'verified']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Todolist $todolist)
    {
        return TaskResource::collection($todolist->tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Todolist $todolist)
    {
        
        $validated = $request->validate([
            'title' => 'required|string'
        ]);

        $task = new Task();
        $task->identifier = Str::uuid();
        $task->title = $validated['title'];
        $todolist->tasks()->save($task);

        return back(303);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Task $task)
    {

        return new TaskResource($task, $todolist);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task, Todolist $todolist)
    {

        $validated = $request->validate([
            'is_completed' => 'required|boolean'
        ]);

        $task->is_completed = $validated['is_completed'];
        $task->save();

        return back(303);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {

        $task->delete();

        return back(303);
    }
}
