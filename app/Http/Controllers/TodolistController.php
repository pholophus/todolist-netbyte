<?php

namespace App\Http\Controllers;

use App\Http\Resources\TodolistResource;
use App\Models\Todolist;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TodolistController extends Controller
{
    public function __construct() {
        $this->middleware(['auth:sanctum', 'verified']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TodolistResource::collection($request->user()->todolists);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Todolist::class);

        $validated = $request->validate([
            'title' => 'required|string'
        ]);

        $todolist = new Todolist();
        $todolist->identifier = Str::uuid();
        $todolist->title = $validated['title'];
        $request->user()->todolists()->save($todolist);

        return back(303);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todolist  $todolist
     * @return \Illuminate\Http\Response
     */
    public function show(Todolist $todolist)
    {
        $this->authorize('view', $todolist);

        return new TodolistResource($todolist);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todolist  $todolist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todolist $todolist)
    {
        $this->authorize('update', $todolist);

        $validated = $request->validate([
            'is_completed' => 'required|boolean'
        ]);

        $todolist->is_completed = $validated['is_completed'];
        $todolist->save();

        return back(303);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todolist  $todolist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todolist $todolist)
    {
        $this->authorize('delete', $todolist);

        $todolist->delete();

        return back(303);
    }
}
