<?php

namespace App\Http\Interfaces;

interface GameInterface
{
    const MAX_COUNT_BULLS = 4;

    public function startGame(string $numbers);
}
