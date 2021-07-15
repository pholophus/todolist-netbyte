<?php

namespace App\Http\Controllers;

use App\Models\Todolist;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function __construct() {
        $this->middleware(['auth:sanctum', 'verified']);
    }

    public function index(Request $request, Todolist $todolist)
    {
        // $data = Todolist::where('id', $todolist)->get();
        // dd($data);

        // dd($todolist->tasks);
        return Inertia::render('Tasks/TaskList', [
            'tasks' => $todolist->tasks,
            'todolist' => $todolist
        ]);
    }
}
