<?php

use App\Http\Controllers\GameController;

Route::post('start', [GameController::class, 'start'])->name('Игра|Начать игру');
