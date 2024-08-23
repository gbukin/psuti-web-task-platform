<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
});

Route::get('/task-web-basic', function () {
    header('X-Glaf-Part-1: VzNiLQ==');
    abort(404);
})->name('task-web-basic-get');

Route::patch('/task-web-basic', function () {
    header('X-Glaf-Part-2: 0KLRg9GCINGC0L7Rh9C90L4g0L/Rg9GB0YLQvg==');
    abort(500);
})->name('task-web-basic-patch');

Route::put('/task-web-basic', function () {
    setcookie('TASK-TOKEN', 'K-Synt-Cneg-3: gN$x', time() + 3600 * 24);
    return redirect('/task-web-basic');
})->name('task-web-basic-put');

Route::post('/task-web-basic', function () {
    header('X-Glaf-Part-2: ');
    abort(500);
})->name('task-web-basic-post');

Route::get('/task-password', [\App\Http\Controllers\WebTasksController::class, 'taskPasswordIndex'])
    ->name('task-password');

Route::get('/task-bypass', [\App\Http\Controllers\WebTasksController::class, 'taskBypassIndex'])
    ->name('task-bypass');
Route::post('/task-bypass', [\App\Http\Controllers\WebTasksController::class, 'taskBypassCheckPassword'])
    ->name('task-bypass-check-password');

Route::get('/task-shop', [\App\Http\Controllers\WebTasksController::class, 'taskShopIndex'])
    ->name('task-shop');
Route::post('/task-shop-create-account', [\App\Http\Controllers\WebTasksController::class, 'taskShopCreateAccount'])
    ->name('task-shop-create-account');
Route::post('/task-shop-redeem-certificate', [\App\Http\Controllers\WebTasksController::class, 'taskShopRedeemCertificate'])
    ->name('task-shop-redeem-certificate');
Route::post('/task-shop-refund-certificate', [\App\Http\Controllers\WebTasksController::class, 'taskShopRefundCertificate'])
    ->name('task-shop-refund-certificate');
Route::post('/task-shop-buy-flag', [\App\Http\Controllers\WebTasksController::class, 'taskShopBuyFlag'])
    ->name('task-shop-buy-flag');
