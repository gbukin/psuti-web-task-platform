<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
});

Route::get('/task-password', [\App\Http\Controllers\WebTasksController::class, 'taskPasswordIndex']);

require __DIR__.'/auth.php';
