<?php

namespace App\Http\Controllers;

use App\Models\Todolist;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware(['auth:sanctum', 'verified']);
    }

    public function dashboard(Request $request)
    {
        return Inertia::render('Dashboard', [
            'todolists' => $request->user()->todolists,
        ]);
    }
}
