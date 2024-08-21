<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class WebTasksController extends Controller
{
    public function taskPasswordIndex()
    {
        return Inertia::render('WebTasks/Password/Index');
    }
}
