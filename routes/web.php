<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

const TASK_WEB_BASIC = '/task-web-basic';

Route::get('/', function () {
    return Inertia::render('Welcome');
});

Route::prefix('/')->name('task-web-basic')->group(function () {
    Route::get(TASK_WEB_BASIC, function () {
        header('X-Glaf-Part-1: VzNiLQ==');
        abort(404);
    });

    Route::patch(TASK_WEB_BASIC, function () {
        header('X-Glaf-Part-2: 0KLRg9GCINGC0L7Rh9C90L4g0L/Rg9GB0YLQvg==');
        abort(500);
    });

    Route::put(TASK_WEB_BASIC, function () {
        setcookie('TASK-TOKEN', 'K-Synt-Cneg-3: gN$x', time() + 3600 * 24);
        return redirect('/task-web-basic');
    });

    Route::post(TASK_WEB_BASIC, function () {
        header('X-Glaf-Part-2: ');
        abort(500);
    });
});

Route::get('/task-password', [\App\Http\Controllers\WebTasksController::class, 'taskPasswordIndex'])
    ->name('task-password');

Route::get('/task-bypass', [\App\Http\Controllers\WebTasksController::class, 'taskBypassIndex'])
    ->name('task-bypass');
Route::post('/task-bypass', [\App\Http\Controllers\WebTasksController::class, 'taskBypassCheckPassword'])
    ->name('task-bypass-check-password');

require __DIR__ . '/auth.php';
