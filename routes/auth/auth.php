<?php

use App\Http\Controllers\AuthController;

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
Route::post('me', [AuthController::class, 'me'])->name('me');
